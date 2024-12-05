<?php

// database/seeders/ExamSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\User;
use App\Models\Subset;
use App\Models\Answer;

class ExamSeeder extends Seeder
{
    public function run()
    {
        // Crear exámenes para usuarios
        $user = User::first();  // Asume que hay al menos un usuario
        $subset = Subset::first();  // Asume que hay al menos un subset

        /*

        Exam::create([
            'user_id' => $user->id,
            'subset_id' => $subset->id,
            'score' => 85.5,
            'total_questions' => 5,
            'correct_answers' => 4,
            'time_taken' => 30,
        ]);
        */
        // Ruta al archivo JSON
        $jsonPath = storage_path('app/data/exam_data.json');

        if (!file_exists($jsonPath)) {
            $this->command->error("Archivo JSON no encontrado en: {$jsonPath}");
            return;
        }

        // Leer y decodificar el archivo JSON
        $data = json_decode(file_get_contents($jsonPath), true);

        if (!$data) {
            $this->command->error('Error al decodificar el archivo JSON.');
            return;
        }

        foreach ($data as $item) {
            // Crear una nueva pregunta
            $question = Question::create([
                'question_text' => $item['question'],
                'question_type' => count($item['options']) > 1 ? 'multiple' : 'single',
                'explanation' => null, // Actualiza si hay explicaciones en el JSON
            ]);

            // Crear las respuestas asociadas
            foreach ($item['options'] as $option) {
                Answer::create([
                    'question_id' => $question->id,
                    'answer_text' => $option,
                    'is_correct' => false, // Ajusta según los datos del JSON si hay respuestas correctas
                ]);
            }
        }

        $this->command->info('Datos cargados exitosamente desde el archivo JSON.');
    }
}
