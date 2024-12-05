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
        // Obtener las preguntas del subconjunto del examen
        $subsetQuestions = $exam->subset->questions;

        // Obtener las preguntas ya respondidas en el examen
        $answeredQuestions = $exam->examAnswers->pluck('question_id');

        // Obtener la siguiente pregunta que no ha sido respondida
        $nextQuestion = $subsetQuestions->whereNotIn('id', $answeredQuestions)->first();

        return $nextQuestion;
    }

    public function saveAnswer(Exam $exam, Question $question, $answerId)
    {
        // Verificar si la respuesta es correcta
        $isCorrect = $question->answers()->where('id', $answerId)->where('is_correct', true)->exists();

        // Guardar la respuesta del usuario
        ExamAnswer::create([
            'exam_id' => $exam->id,
            'question_id' => $question->id,
            'answer_id' => $answerId,
            'is_correct' => $isCorrect,
        ]);

        // Actualizar la puntuación y el número de respuestas correctas del examen
        if ($isCorrect) {
            $exam->increment('correct_answers');
            $exam->increment('score', 1 / $exam->total_questions * 100); // Asume que cada pregunta vale lo mismo
        }

        $exam->save();
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