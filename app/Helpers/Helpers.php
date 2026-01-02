<?php

namespace App\Helpers;

use App\Models\MultimediaModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Helpers
{
    public static function getImage(string $url = null, string $defaultPath = 'assets/images/no-image.jpg'): ?string
    {
        $imagePath = null;
        if ($url) {
            // Verifica si la URL apunta a un archivo almacenado en Laravel Storage
            $imagePath = 'public/' . $url;
        } elseif ($defaultPath) {
            // Usa la ruta predeterminada
            $imagePath = public_path($defaultPath);
        }
        if (!$imagePath) {
            return null; // No se proporcionó una URL o ruta válida
        }

        // Valida que el archivo exista y sea accesible
        // if (!Storage::exists($url) && !file_exists($imagePath)) {
        $extension = pathinfo($imagePath, PATHINFO_EXTENSION);
        try {
            // Lee el contenido del archivo de forma segura usando Storage::get()
            $imageData = $imagePath ? Storage::get($imagePath) : file_get_contents($imagePath);
        } catch (\Exception $e) {
            throw new \RuntimeException("Error al leer la imagen: " . $e->getMessage());
        }
        return 'data:image/' . $extension . ';base64,' . base64_encode($imageData);
    }
    public static function __fileUpload(Request $request, $name, $file, $id = null)
    {
        if ($request->hasFile($name)) {
            $imagen = $request->file($name);
            $carpetaAlmacenamiento = $file;
            $nameFile =  $imagen->getClientOriginalName();
            $nameFileSave = time() . '_' . $imagen->getClientOriginalName();
            // $url =  Storage::putFileAs($carpetaAlmacenamiento, $imagen, $nameFileSave);

            $url = $imagen->storeAs($file, $nameFileSave, 'public');
            $size = $imagen->getSize();

            if ($id == null) {
                $id = MultimediaModel::insertGetId([
                    'nombre_archivo' => $nameFile,
                    'ruta_archivo' => $url,
                    'size' => $size,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                self::deleteImage($id);
                DB::table('multimedia')
                    ->where('id_multimedia', $id)
                    ->update([
                        'nombre_archivo' => $nameFile,
                        'ruta_archivo' => $url,
                        'size' => $size,
                        'updated_at' => now(),
                    ]);
            }
            return $id;
        }
        return 0;
    }
    public static function deleteImage($id)
    {
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
