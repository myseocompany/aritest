<?php

// database/seeders/ExamSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\Subset;
use App\Models\Answer;
use App\Models\Topic;

class ExamSeeder extends Seeder
{
    public function run()
    {
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

        // Subset global para todas las preguntas
        $globalSubset = Subset::firstOrCreate([
            'name' => 'Todas las preguntas',
            'description' => 'Un subset que contiene todas las preguntas cargadas.',
        ]);

        foreach ($data as $item) {
            // Crear o asociar el subset (utilizado como topic también)
            $subset = Subset::firstOrCreate(
                ['name' => $item['subset']],
                ['description' => $item['subset'] . ' description']
            );

            // Crear o asociar el topic basado en el subset
            $topic = Topic::firstOrCreate(
                ['name' => $subset->name],
                ['description' => $subset->description]
            );

            // Determinar el tipo de pregunta (multiple o single)
            $questionType = is_array($item['correct_answer']) ? 'multiple' : 'single';

            // Crear una nueva pregunta
            $question = Question::create([
                'question_text' => $item['question'],
                'question_type' => $questionType, // Usar el tipo determinado
                'explanation' => $item['explanation'] ?? null, // Guardar la explicación si existe
                'topic_id' => $topic->id, // Asociar el topic a la pregunta
            ]);

            // Asociar la pregunta al subset correspondiente
            $question->subsets()->attach($subset->id);

            // Asociar la pregunta al subset global
            $question->subsets()->attach($globalSubset->id);

            // Crear las respuestas asociadas
            foreach ($item['options'] as $option) {
                // Si la respuesta es correcta, verificar si es parte de las respuestas correctas (en el caso de preguntas múltiples)
                $isCorrect = is_array($item['correct_answer']) 
                    ? in_array($option, $item['correct_answer']) // Para preguntas múltiples
                    : $option === $item['correct_answer']; // Para preguntas simples

                Answer::create([
                    'question_id' => $question->id,
                    'answer_text' => $option,
                    'is_correct' => $isCorrect, // Marcar la respuesta correcta
                ]);
            }
        }

        $this->command->info('Datos cargados exitosamente desde el archivo JSON.');
    }
}
