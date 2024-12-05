<?php
namespace App\Services;

use App\Models\Exam;
use App\Models\ExamAnswer;
use App\Models\Question;
use App\Models\Subset;
use Illuminate\Support\Facades\Auth;

class ExamService
{

    public function createExam(Subset $subset)
    {
        // Obtener el usuario actual
        $user = Auth::user();

        // Crear un nuevo examen
        $exam = Exam::create([
            'user_id' => $user->id,
            'subset_id' => $subset->id,
            'total_questions' => $subset->questions->count(),
            'correct_answers' => 0, 
            'score' => 0.00, 
            'time_taken' => 0, 
        ]);

        return $exam;
    }

    public function getNextQuestion(Exam $exam)
    {
        // Obtener todas las preguntas del subconjunto del examen
        $subsetQuestions = $exam->subset->questions;
        
        // Obtener el índice de la pregunta actual
        $answeredQuestions = $exam->examAnswers->pluck('question_id')->toArray();
        
        // Filtrar preguntas respondidas
        $unansweredQuestions = $subsetQuestions->whereNotIn('id', $answeredQuestions);
        
        // Si no hay preguntas sin responder, devolver null
        if ($unansweredQuestions->isEmpty()) {
            return null;
        }
    
        // Retornar la siguiente pregunta según el índice
        $nextQuestion = $unansweredQuestions->first();
    
        return $nextQuestion;
    }
    

    public function saveAnswer(Exam $exam, Question $question, $answerId)
{
    // Verificar si la respuesta es correcta
    if (is_array($answerId)) {
        // Si es una respuesta múltiple, iterar sobre las respuestas seleccionadas
        foreach ($answerId as $id) {
            // Verificar si la respuesta es correcta
            $isCorrect = $question->answers()->where('id', $id)->where('is_correct', true)->exists();

            // Guardar la respuesta del usuario
            ExamAnswer::create([
                'exam_id' => $exam->id,
                'question_id' => $question->id,
                'answer_id' => $id,
                'is_correct' => $isCorrect,
            ]);
        }
    } else {
        // Si es una respuesta única, proceder como antes
        $isCorrect = $question->answers()->where('id', $answerId)->where('is_correct', true)->exists();

        // Guardar la respuesta del usuario
        ExamAnswer::create([
            'exam_id' => $exam->id,
            'question_id' => $question->id,
            'answer_id' => $answerId,
            'is_correct' => $isCorrect,
        ]);
    }

    // Actualizar la puntuación y el número de respuestas correctas del examen si es necesario
    $correctAnswers = $exam->correct_answers;
    $totalQuestions = $exam->total_questions;
    
    if (is_array($answerId)) {
        $correctAnswers += count(array_filter($answerId, function($id) use ($question) {
            return $question->answers()->where('id', $id)->where('is_correct', true)->exists();
        }));
    } elseif ($isCorrect) {
        $correctAnswers++;
    }

    // Actualizar el examen con las nuevas respuestas correctas y la puntuación
    $exam->update([
        'correct_answers' => $correctAnswers,
        'score' => $correctAnswers / $totalQuestions * 100,
    ]);
}


// Si la pregunta es múltiple, podemos extender este método para aceptar un array de respuestas
public function saveMultipleAnswers(Exam $exam, Question $question, $answerIds)
{
    foreach ($answerIds as $answerId) {
        $this->saveAnswer($exam, $question, $answerId);
    }
}


    public function getExamResults(Exam $exam)
    {
        return [
            'total_questions' => $exam->total_questions,
            'correct_answers' => $exam->correct_answers,
            'score' => $exam->score,
        ];
    }

    public function getExamQuestionsWithAnswers(Exam $exam)
    {
        // Obtener todas las preguntas relacionadas con el examen junto con sus respuestas
        return $exam->subset->questions()->with('answers')->get();
    }
}