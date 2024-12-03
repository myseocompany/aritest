<?php
namespace App\Http\Controllers;

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Answer;     // Importa esta clase
 

class TestController extends Controller
{
    public function start(Request $request)
    {
        // Obtener todas las preguntas
        $questions = Question::all();

        // Obtener el índice de la pregunta actual
        $currentQuestionIndex = $request->get('question', 0);

        // Verificar si el índice es válido y no supera el total de preguntas
        if ($currentQuestionIndex >= count($questions)) {
            return redirect()->route('test.submit');  // Redirigir a submit si ya se respondieron todas las preguntas
        }

        // Obtener la pregunta actual
        $question = $questions[$currentQuestionIndex];

        return view('test.start', [
            'question' => $question,
            'currentQuestionIndex' => $currentQuestionIndex,
            'totalQuestions' => count($questions),
        ]);
    }

    // Método para procesar las respuestas y mostrar el resultado
    public function submit(Request $request)
    {
        // Obtener todas las preguntas
        $questions = Question::all();
        $totalQuestions = count($questions);
        $correctAnswers = 0;

        // Obtener las respuestas enviadas desde el formulario
        $answers = $request->input('answers');

        // Verificar si 'answers' está presente y no es null
        if (!$answers || !is_array($answers)) {
            // Si no hay respuestas válidas, redirigir con un mensaje de error
            return redirect()->route('test.start')->with('error', 'Por favor, responde todas las preguntas.');
        }

        // Iterar sobre las respuestas enviadas
        foreach ($answers as $questionId => $answerIds) {
            foreach ($answerIds as $answerId) {
                $answer = Answer::find($answerId);

                // Si la respuesta es correcta, sumamos el contador
                if ($answer && $answer->is_correct) {
                    $correctAnswers++;
                }
            }
        }

        // Calcular el puntaje
        $score = ($correctAnswers / $totalQuestions) * 100;

        // Verificar si el usuario ha respondido todas las preguntas
        $currentQuestionIndex = $request->input('currentQuestionIndex', 0);

        if ($currentQuestionIndex + 1 < $totalQuestions) {
            // Si aún hay preguntas por responder, redirigir a la siguiente pregunta
            return redirect()->route('test.start', ['question' => $currentQuestionIndex + 1]);
        }

        // Si todas las preguntas han sido respondidas, mostrar los resultados
        return redirect()->route('test.result')->with('score', $score);
    }

    // Método para mostrar los resultados del test
    public function result()
    {
        // Recuperar el puntaje de la sesión
        $score = session('score');
        
        return view('test.result', compact('score'));
    }

}
