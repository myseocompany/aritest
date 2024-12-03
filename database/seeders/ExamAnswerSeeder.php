<?php

// database/seeders/ExamAnswerSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ExamAnswer;
use App\Models\Exam;
use App\Models\Answer;
use App\Models\Question;

class ExamAnswerSeeder extends Seeder
{
    public function run()
    {
// Suponiendo que ya tenemos un examen, tomamos el primer examen disponible
$exam = Exam::first();  // Asume que existe al menos un examen

// Tomamos todas las preguntas asociadas al examen
$questions = Question::all();

foreach ($questions as $question) {
    // Tomamos las respuestas asociadas a esta pregunta
    $answers = Answer::where('question_id', $question->id)->get();

    // Seleccionamos una respuesta aleatoria (esto puede cambiar dependiendo de la lógica que prefieras)
    $randomAnswer = $answers->random();

    // Creamos el registro en la tabla `exam_answers` para cada pregunta
    ExamAnswer::create([
        'exam_id' => $exam->id,
        'question_id' => $question->id,
        'answer_id' => $randomAnswer->id,
        'is_correct' => $randomAnswer->is_correct, // Asignamos si la respuesta es correcta o no
    ]);
}
    }
}
