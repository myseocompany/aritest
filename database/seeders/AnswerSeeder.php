<?php

// database/seeders/AnswerSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Answer;
use App\Models\Question;

class AnswerSeeder extends Seeder
{
    public function run()
    {
        // Respuestas para la pregunta "¿Cuál es el resultado de 2 + 2?"
        $question = Question::where('question_text', '¿Cuál es el resultado de 2 + 2?')->first();
        
        Answer::create([
            'question_id' => $question->id,
            'answer_text' => '3',
            'is_correct' => false,
        ]);

        Answer::create([
            'question_id' => $question->id,
            'answer_text' => '4',
            'is_correct' => true,  // Respuesta correcta
        ]);

        Answer::create([
            'question_id' => $question->id,
            'answer_text' => '5',
            'is_correct' => false,
        ]);

        // Respuestas para la pregunta "¿Cuál es el área de un círculo con radio 3?"
        $question = Question::where('question_text', '¿Cuál es el área de un círculo con radio 3?')->first();

        Answer::create([
            'question_id' => $question->id,
            'answer_text' => '12.57',
            'is_correct' => false,
        ]);

        Answer::create([
            'question_id' => $question->id,
            'answer_text' => '28.27',
            'is_correct' => true,  // Respuesta correcta
        ]);

        Answer::create([
            'question_id' => $question->id,
            'answer_text' => '50.24',
            'is_correct' => false,
        ]);

        // Respuestas para la pregunta "¿Cuáles son los tipos de partículas subatómicas?"
        $question = Question::where('question_text', '¿Cuáles son los tipos de partículas subatómicas?')->first();

        Answer::create([
            'question_id' => $question->id,
            'answer_text' => 'Protones',
            'is_correct' => true,  // Respuesta correcta
        ]);

        Answer::create([
            'question_id' => $question->id,
            'answer_text' => 'Neutrones',
            'is_correct' => true,  // Respuesta correcta
        ]);

        Answer::create([
            'question_id' => $question->id,
            'answer_text' => 'Electrones',
            'is_correct' => true,  // Respuesta correcta
        ]);
    }
}
