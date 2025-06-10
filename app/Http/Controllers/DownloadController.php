<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Services\RepositoryService;
use Illuminate\Support\Facades\Response;

class DownloadController extends Controller
{

    protected RepositoryService $repository;

    public function __construct(RepositoryService $repository)
    {
        $this->repository = $repository;
    }

    public function download(string $filename)
    {
        if (!$this->repository->exists($filename)) {
            abort(404, 'Archivo no encontrado');
        }

        $stream = $this->repository->getStream($filename);

        if (!is_resource($stream)) {
            abort(500, 'No se pudo leer el archivo');
        }

        $mime = $this->repository->getMimeType($filename) ?? 'application/octet-stream';

        return Response::stream(function () use ($stream) {
            fpassthru($stream);
            fclose($stream);
        }, 200, [
            'Content-Type' => $mime,
            'Content-Disposition' => "inline; filename=\"{$filename}\"",
            'Cache-Control' => 'no-cache',
        ]);
    }
}
