<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Question;
use App\Models\Answer;

class LoadExamData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exam:load-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load exam data from a JSON file into the database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Archivo JSON encontrado.');
        $this->info('Datos decodificados correctamente.');
        $this->info('Insertando preguntas y respuestas...');

        // Ruta al archivo JSON
        $jsonPath = storage_path('app/data/exam_data.json');
        
        if (!file_exists($jsonPath)) {
            $this->error("Archivo JSON no encontrado en: {$jsonPath}");
            return 1;
        }

        $this->info("Cargando datos desde: {$jsonPath}");

        // Leer y decodificar el archivo JSON
        $data = json_decode(file_get_contents($jsonPath), true);

        if (!$data) {
            $this->error('Error al decodificar el archivo JSON.');
            return 1;
        }

        foreach ($data as $item) {
            // Crear una nueva pregunta
            $question = Question::create([
                'question_text' => $item['question'],
                'question_type' => count($item['options']) > 1 ? 'multiple' : 'single',
                'explanation' => null, // Si el JSON tiene explicaciones, puedes agregar esta clave
            ]);

            // Crear las respuestas asociadas
            foreach ($item['options'] as $option) {
                Answer::create([
                    'question_id' => $question->id,
                    'answer_text' => $option,
                    'is_correct' => false, // Actualiza esto según los datos del JSON si hay respuestas correctas
                ]);
            }
        }

        $this->info('Datos cargados exitosamente.');
        return 0;
    }
}
