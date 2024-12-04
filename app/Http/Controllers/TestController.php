<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Subset;
use App\Models\Exam;
use Illuminate\Support\Facades\Auth; 



class TestController extends Controller
{
    // Método para mostrar la pregunta actual
    public function start(Request $request)
    {
        
        // creo el examen
        $exam = new Exam;
        $exam->user_id = Auth::id();
        
        // Obtener el set de preguntas
        $subset_id = $request->subset;
        if(isset($subset_id) && ($subset_id!=""))
            $subset = Subset::find($subset_id);
        
        // Obtener todas las preguntas
        $questions = $subset->questions;

        // Obtener el índice de la pregunta actual
        $currentQuestionIndex = $request->get('question', 0);

        // Verificar si el índice es válido y no supera el total de preguntas
        if ($currentQuestionIndex >= count($questions)) {
            // Redirigir al submit si ya se respondieron todas las preguntas
            return redirect()->route('test.submit');
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
    public function saveAnswer(Request $request)
    {
        // Obtener todas las preguntas
        $questions = Question::all();
        $totalQuestions = count($questions);
        $correctAnswers = 0;

        // Obtener las respuestas enviadas desde el formulario
        $answers = $request->input('answers');

        // Verificar si 'answers' está presente y es un array
        if (!$answers || !is_array($answers)) {
            // Si no hay respuestas válidas, redirigir con un mensaje de error
            return redirect()->route('test.start')->with('error', 'Por favor, responde todas las preguntas.');
        }


        // Iterar sobre las respuestas enviadas
        foreach ($answers as $questionId => $answerId) {
            // Buscar la respuesta en la base de datos
            $answer = Answer::find($answerId);

            // Si la respuesta es correcta, sumamos el contador
            if ($answer && $answer->is_correct) {
                $correctAnswers++;
            }
        }


        // Calcular el puntaje
        $score = ($correctAnswers / $totalQuestions) * 100;

        // Guardar el puntaje en la sesión
        session(['score' => $score]);
        // Verificar si hay más preguntas
        $currentQuestionIndex = $request->input('question', 0);

        if ($currentQuestionIndex + 1 < $totalQuestions) {
            // Si hay más preguntas, redirigir a la siguiente pregunta
            return redirect()->route('test.start', ['question' => $currentQuestionIndex + 1]);

        } else {
            // Si ya no hay más preguntas, redirigir a los resultados
            return redirect()->route('test.result');
        }

    }

    // Método para mostrar los resultados del test
    public function result()
    {
        // Recuperar el puntaje de la sesión
        $score = session('score');

        return view('test.result', compact('score'));
    }
}
