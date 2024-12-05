<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Los comandos Artisan registrados.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\LoadExamData::class,
    ];

    /**
     * Define las tareas programadas de la aplicación.
     */
    protected function schedule(Schedule $schedule)
    {
        // Definir tareas programadas aquí si es necesario
    }

    /**
     * Cargar los comandos de Artisan.
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
