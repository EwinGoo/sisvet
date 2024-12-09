<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TestController extends BaseController
{
    public function index($id = 12){
        $reg = DB::table('multimedia')->where('id_multimedia', $id)->first();
        if ($reg && $reg->ruta_archivo) {
            // Construye la ruta relativa
            $filePath = str_replace('storage/', '', 'public/' . $reg->ruta_archivo);
            if (Storage::exists($filePath)) {
                Storage::delete($filePath); // Elimina el archivo
            }
        }
    }
}
