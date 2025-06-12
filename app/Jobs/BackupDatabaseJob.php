<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class BackupDatabaseJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    public function handle()
    {
        try {
            Log::info('🔁 Job iniciado: Generando backup...');

            $filename = 'backup_' . now()->format('Y-m-d_H-i-s') . '.sql';
            $filepath = storage_path("app/backups/{$filename}");

            // Reemplaza esta ruta con la ruta de tu mysqldump
            $mysqldump = '"C:\\xampp\\mysql\\bin\\mysqldump.exe"';

            $password = config('database.connections.mysql.password');
            if ($password === '') {
                $passwordPart = '-p'; // mysqldump espera contraseña vacía, no ponemos nada
            } else {
                $passwordPart = '-p' . $password;
            }

            $command = sprintf(
                '%s -u%s %s -h%s %s > "%s"',
                $mysqldump,
                config('database.connections.mysql.username'),
                $passwordPart,
                config('database.connections.mysql.host'),
                config('database.connections.mysql.database'),
                $filepath
            );

            exec($command, $output, $returnVar);

            if ($returnVar !== 0) {
                Log::error('❌ Error ejecutando mysqldump', ['output' => $output]);
            } else {
                Log::info('✅ Backup generado con éxito en: ' . $filepath);
            }
        } catch (\Throwable $e) {
            Log::error('❗ Excepción en el Job de backup', ['error' => $e->getMessage()]);
        }
    }
}
