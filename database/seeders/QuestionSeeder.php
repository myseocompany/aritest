<?php

// database/seeders/QuestionSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;

class QuestionSeeder extends Seeder
{
    public function run()
    {
        // Crear preguntas de prueba
        Question::create([
            'question_text' => '¿Cuál es el resultado de 2 + 2?',
            'question_type' => 'single',
            'explanation' => 'La suma de 2 + 2 es 4.',
        ]);

        Question::create([
            'question_text' => '¿Cuál es el área de un círculo con radio 3?',
            'question_type' => 'single',
            'explanation' => 'El área de un círculo es A = π * r^2.',
        ]);
        
        Question::create([
            'question_text' => '¿Cuáles son los tipos de partículas subatómicas?',
            'question_type' => 'multiple',
            'explanation' => 'Los tipos básicos de partículas subatómicas son protones, neutrones y electrones.',
        ]);
    }
}
