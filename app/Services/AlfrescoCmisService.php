<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use SimpleXMLElement;

class AlfrescoCmisService
{
    protected Client $client;
    protected string $atomPubUrl;
    protected string $username;
    protected string $password;

    public function __construct()
    {
        $this->atomPubUrl = config('services.alfresco.atompub_url');
        $this->username = config('services.alfresco.username');
        $this->password = config('services.alfresco.password');

        $this->client = new Client([
            'auth' => [$this->username, $this->password],
        ]);
    }

    public function resolveFolderByType(string $docType): string
    {
        $targetName = match (strtolower($docType)) {
            'anexos' => 'Documentos_Anexos',
            'binarios' => 'Documentos_Binarios',
            'electronicos' => 'Documentos_Electronicos',
            default => throw new \InvalidArgumentException("Tipo de documento no válido: $docType"),
        };
        workspace://SpacesStore/8ab47d55-42bf-437e-b99a-9721b4a1a153
        $userHomes = $this->findChildFolderByName($this->atomPubUrl . '/workspace://SpacesStore/8ab47d55-42bf-437e-b99a-9721b4a1a153', 'User Homes');
        $exedoc = $this->findChildFolderByName($userHomes, 'exedoc');
        return $this->findChildFolderByName($exedoc, $targetName);
    }

    private function findChildFolderByName(string $folderUrl, string $name): string
    {
        $res = $this->client->get($folderUrl, ['headers' => ['Accept' => 'application/atom+xml']]);
        $xml = new SimpleXMLElement($res->getBody());

        foreach ($xml->entry as $entry) {
            $title = (string)$entry->title;
            $type = (string)$entry->content['type'];
            $href = (string)$entry->link['href'];

            if (strcasecmp($title, $name) === 0 && str_contains($type, 'feed')) {
                return $href;
            }
        }

        throw new \RuntimeException("No se encontró la carpeta: $name");
    }

    public function uploadFile(UploadedFile $file, string $docType): array
    {
        $folderUrl = $this->resolveFolderByType($docType);
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

        $entryXml = <<<XML
<entry xmlns="http://www.w3.org/2005/Atom"
       xmlns:cmisra="http://docs.oasis-open.org/ns/cmis/restatom/200908/"
       xmlns:cmis="http://docs.oasis-open.org/ns/cmis/core/200908/">
  <title>{$filename}</title>
  <summary></summary>
  <cmisra:object>
    <cmis:properties>
      <cmis:propertyId propertyDefinitionId="cmis:objectTypeId">
        <cmis:value>cmis:document</cmis:value>
      </cmis:propertyId>
      <cmis:propertyString propertyDefinitionId="cmis:name">
        <cmis:value>{$filename}</cmis:value>
      </cmis:propertyString>
    </cmis:properties>
  </cmisra:object>
</entry>
XML;

        $res = $this->client->post($folderUrl, [
            'headers' => [
                'Content-Type' => 'multipart/related; type="application/atom+xml"; boundary=boundary123',
            ],
            'body' => $this->buildMultipartRequest($entryXml, $file),
        ]);

        if ($res->getStatusCode() !== 201) {
            throw new \Exception('Error al subir el archivo');
        }

        return [
            'name' => $filename,
            'original' => $file->getClientOriginalName(),
            'mime' => $file->getMimeType(),
            'size' => $file->getSize(),
        ];
    }

    private function buildMultipartRequest(string $entryXml, UploadedFile $file): string
    {
        $boundary = 'boundary123';
        $fileContent = $file->getContent();
        $mime = $file->getMimeType();

        return "--$boundary\r\n" .
            "Content-Type: application/atom+xml;type=entry\r\n\r\n" .
            "$entryXml\r\n" .
            "--$boundary\r\n" .
            "Content-Type: $mime\r\n" .
            "Content-Disposition: attachment; filename=\"{$file->getClientOriginalName()}\"\r\n\r\n" .
            "$fileContent\r\n" .
            "--$boundary--\r\n";
    }
}
