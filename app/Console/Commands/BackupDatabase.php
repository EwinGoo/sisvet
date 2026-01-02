<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Log;

class BackupDatabase extends Command
{
    protected $signature = 'backup:database';
    protected $description = 'Backup de la base de datos MySQL';

    public function handle()
    {
        $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
        $filepath = storage_path('app/backups/' . $filename);

        $db = config('database.connections.mysql');

        $command = [
            'C:\xampp\mysql\bin\mysqldump.exe',
            '-u' . $db['username'],
            '-p' . $db['password'],
            '-h' . $db['host'],
            $db['database'],
        ];

        Log::info('Ejecutando mysqldump...');

        $process = new Process($command);
        $process->run();

        if (!$process->isSuccessful()) {
            Log::error('Error en mysqldump:', [
                'error_output' => $process->getErrorOutput(),
                'command' => implode(' ', $command),
            ]);
            return;
        }

        file_put_contents($filepath, $process->getOutput());

        Log::info('Backup guardado en: ' . $filepath);
    }
}
