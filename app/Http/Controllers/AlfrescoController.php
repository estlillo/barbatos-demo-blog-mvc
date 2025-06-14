<?php

namespace App\Http\Controllers;
use App\Services\AlfrescoCmisService;
use AWS\CRT\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AlfrescoController extends Controller
{

    protected AlfrescoCmisService $alfresco;

    public function __construct(AlfrescoCmisService $alfresco)
    {
        $this->alfresco = $alfresco;
    }

    public function upload(Request $request)
    {

        $request->validate([
            'archivo' => 'required|file'
        ]);

        $data = $this->alfresco->uploadFile($request->file('archivo'), 'binarios');

        return response()->json(['message' => 'Archivo subido con éxito', 'data' => $data]);

    }
}
