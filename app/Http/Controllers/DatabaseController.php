<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class DatabaseController extends Controller
{
    public function backup()
    {
        // Configuración de la base de datos
        $dbHost = env('DB_HOST');
        $dbPort = env('DB_PORT');
        $dbName = env('DB_DATABASE');
        $dbUser = env('DB_USERNAME');
        $dbPassword = env('DB_PASSWORD');
        $backupFile = storage_path("app/backups/{$dbName}_" . date('Y-m-d_H-i-s') . ".sql");

        // Comando para generar el dump
        $command = [
            'mysqldump',
            '--host=' . $dbHost,
            '--port=' . $dbPort,
            '--user=' . $dbUser,
            '--password=' . $dbPassword,
            $dbName,
            '--result-file=' . $backupFile,
        ];

        $process = new Process($command);

        try {
            $process->mustRun();
            return response()->download($backupFile)->deleteFileAfterSend(true);
        } catch (ProcessFailedException $exception) {
            return response()->json(['error' => 'Error al generar la copia de la base de datos: ' . $exception->getMessage()], 500);
        }
    }
}
