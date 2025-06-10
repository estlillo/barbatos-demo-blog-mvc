<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class RepositoryService
{
    protected $disk;

    public function __construct()
    {
        $this->disk = Storage::disk('s3');
    }

    /**
     * Guarda un archivo con contenido binario.
     */
    public function uploadContent(string $filename, string $content): bool
    {
        return $this->disk->put($filename, $content);
    }

    public function upload($path, $content, $options = [])
    {
        return $this->disk->put($path, $content, $options);
    }

    public function download($path)
    {
        return $this->disk->get($path);
    }

    public function delete($path)
    {
        return $this->disk->delete($path);
    }

    public function exists($path)
    {
        return $this->disk->exists($path);
    }

    public function url($path)
    {
        return $this->disk->url($path);
    }

    /**
     * Obtiene un stream de lectura del archivo.
     */
    public function getStream(string $ruta)
    {
        if ($this->exists($ruta)) {
            return $this->disk->readStream($ruta); // <--- usar $this->disk directamente
        }
        return null;
    }


    /**
     * Obtiene el tipo MIME del archivo.
     */
    public function getMimeType(string $ruta): ?string
    {
        if ($this->exists($ruta)) {
            return $this->disk->mimeType($ruta); // <--- igual aquí
        }
        return null;
    }
}
