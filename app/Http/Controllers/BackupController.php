<?php

namespace App\Http\Controllers;

use App\Jobs\BackupDatabaseJob;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{

    public function __construct()
    {
        $this->title = 'Usuarios';
        $this->page = 'admin-db';
        $this->area = 'Administración';
    }
    public function index()
    {
        // Obtener lista de archivos en storage/app/backups
        $files = Storage::files('backups');

        // Filtrar solo archivos .sql y obtener nombre + fecha legible
        $this->data['backups'] = collect($files)->filter(function ($file) {
            return str_ends_with($file, '.sql');
        })->map(function ($file) {
            return [
                'path' => $file,
                'name' => basename($file),
                'date' => date("d/m/Y H:i:s", Storage::lastModified($file)),
                'size' => round(Storage::size($file) / 1024, 2), // KB
            ];
        })->sortByDesc('date');

        /* init::Listar Mascotas */
        return $this->render("backup");
    }

    public function backup()
    {
        $job = new \App\Jobs\BackupDatabaseJob();
        $job->handle();

        return redirect()->route('admin-db.index')->with('success', 'Backup generado con éxito.');
    }
    public function download($filename)
    {
        $filePath = "backups/{$filename}";

        if (!Storage::exists($filePath)) {
            abort(404, "Archivo no encontrado: {$filename}");
        }

        return Storage::download($filePath, $filename, [
            'Content-Type' => 'application/sql',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0'
        ]);
    }
}
