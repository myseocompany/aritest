<?php

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

        // Crear el subset global
        $globalSubset = $this->createGlobalSubset();

        // Crear un nuevo subset para "Una pregunta de cada categoría"
        $singleCategorySubset = $this->createSingleCategorySubset();

        // Crear preguntas y asociarlas con el subset adecuado
        $processedCategories = $this->processQuestions($data, $globalSubset, $singleCategorySubset);

        $this->command->info('Datos cargados exitosamente desde el archivo JSON.');
    }

    // Crear el subset global
    private function createGlobalSubset()
    {
        return Subset::firstOrCreate([
            'name' => 'Todas las preguntas',
            'description' => 'Un subset que contiene todas las preguntas cargadas.',
        ]);
    }

    // Crear el subset para "Una pregunta de cada categoría"
    private function createSingleCategorySubset()
    {
        return Subset::create([
            'name' => 'Una pregunta de cada categoría',
            'description' => 'Este subset contiene una pregunta de cada categoría o tipo de pregunta.',
        ]);
    }

    // Procesar preguntas desde el JSON y asociarlas con los subsets
    private function processQuestions($data, $globalSubset, $singleCategorySubset)
    {
        $processedCategories = [];
        
        foreach ($data as $item) {
            // Crear o asociar el subset y topic
            $subset = $this->createOrAssociateSubset($item);
            $topic = $this->createOrAssociateTopic($subset);

            // Determinar el tipo de la pregunta
            $questionType = is_array($item['correct_answer']) ? 'multiple' : 'single';

            // Crear la pregunta
            $question = $this->createQuestion($item, $questionType, $topic);

            // Asociar la pregunta con los subsets
            $this->associateQuestionWithSubsets($question, $subset, $globalSubset);

            // Crear las respuestas para la pregunta
            $this->createAnswers($item, $question);

            // Asociar una pregunta de cada categoría al subset "Una pregunta de cada categoría"
            if (!in_array($topic->id, $processedCategories)) {
                $question->subsets()->attach($singleCategorySubset->id);
                $processedCategories[] = $topic->id;
            }
        }

        return $processedCategories;
    }

    // Crear o asociar un subset
    private function createOrAssociateSubset($item)
    {
        return Subset::firstOrCreate(
            ['name' => $item['subset']],
            ['description' => $item['subset'] . ' description']
        );
    }

    // Crear o asociar un topic
    private function createOrAssociateTopic($subset)
    {
        return Topic::firstOrCreate(
            ['name' => $subset->name],
            ['description' => $subset->description]
        );
    }

    // Crear la pregunta
    private function createQuestion($item, $questionType, $topic)
    {
        return Question::create([
            'question_text' => $item['question'],
            'question_type' => $questionType,
            'explanation' => $item['explanation'] ?? null,
            'topic_id' => $topic->id,
        ]);
    }

    // Asociar la pregunta con los subsets
    private function associateQuestionWithSubsets($question, $subset, $globalSubset)
    {
        $question->subsets()->attach($subset->id);
        $question->subsets()->attach($globalSubset->id);
    }

    // Crear las respuestas para la pregunta
    private function createAnswers($item, $question)
    {
        foreach ($item['options'] as $option) {
            // Determinar si la respuesta es correcta
            $isCorrect = is_array($item['correct_answer'])
                ? in_array($option, $item['correct_answer']) 
                : $option === $item['correct_answer'];

            Answer::create([
                'question_id' => $question->id,
                'answer_text' => $option,
                'is_correct' => $isCorrect,
            ]);
        }
    }
}
