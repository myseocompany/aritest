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
    
        // Obtener las preguntas ya respondidas completamente
        $answeredQuestions = $exam->examAnswers
            ->groupBy('question_id')
            ->map(function ($answers, $questionId) use ($exam) {
                $question = $exam->subset->questions->find($questionId);
                if ($question->question_type == 'multiple') {
                    // Para preguntas múltiples, considera respondida si todas las respuestas correctas están seleccionadas
                    $correctAnswerCount = $question->answers()->where('is_correct', true)->count();
                    $userAnswerCount = $answers->count();
    
                    return $userAnswerCount >= $correctAnswerCount;
                }
    
                // Para preguntas únicas, basta con tener una respuesta
                return true;
            })
            ->filter()
            ->keys()
            ->toArray();
    
        // Filtrar preguntas no respondidas completamente
        $unansweredQuestions = $subsetQuestions->whereNotIn('id', $answeredQuestions);
            //dd($unansweredQuestions);
        // Si no hay preguntas sin responder, devolver null
        if ($unansweredQuestions->isEmpty()) {
            return null;
        }
    
        // Retornar la siguiente pregunta
        return $unansweredQuestions->first();
    }
    
    

    public function saveAnswer(Exam $exam, Question $question, $answerIds)
{
    if (is_array($answerIds)) {
        // Si la pregunta es múltiple
        $correctAnswers = $question->answers()->where('is_correct', true)->pluck('id')->toArray();

        // Verifica si las respuestas seleccionadas coinciden exactamente con las correctas
        $isCorrect = empty(array_diff($answerIds, $correctAnswers)) && empty(array_diff($correctAnswers, $answerIds));

        // Guardar cada respuesta seleccionada
        foreach ($answerIds as $id) {
            ExamAnswer::create([
                'exam_id' => $exam->id,
                'question_id' => $question->id,
                'answer_id' => $id,
                'is_correct' => in_array($id, $correctAnswers),
            ]);
        }

        // Incrementar o no las respuestas correctas según el resultado global de la pregunta
        if ($isCorrect) {
            $exam->increment('correct_answers');
        }
    } else {
        // Si es una respuesta única
        $isCorrect = $question->answers()->where('id', $answerIds)->where('is_correct', true)->exists();

        ExamAnswer::create([
            'exam_id' => $exam->id,
            'question_id' => $question->id,
            'answer_id' => $answerIds,
            'is_correct' => $isCorrect,
        ]);

        if ($isCorrect) {
            $exam->increment('correct_answers');
        }
    }

    // Actualizar la puntuación y el número de respuestas correctas del examen
    $totalQuestions = $exam->total_questions;
    $exam->update([
        'score' => $exam->correct_answers / $totalQuestions * 100,
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