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
    
    

    public function saveAnswer(Exam $exam, Question $question, $answerId)
{
    $isFullyCorrect = false;

    if (is_array($answerId)) {
        // Manejar respuestas múltiples
        $correctAnswers = $question->answers()->where('is_correct', true)->pluck('id')->toArray();
        $isFullyCorrect = count(array_intersect($correctAnswers, $answerId)) === count($correctAnswers);

        foreach ($answerId as $id) {
            // Verificar si cada respuesta seleccionada es correcta
            $isCorrect = in_array($id, $correctAnswers);

            // Guardar cada respuesta del usuario
            ExamAnswer::create([
                'exam_id' => $exam->id,
                'question_id' => $question->id,
                'answer_id' => $id,
                'is_correct' => $isCorrect,
            ]);
        }
    } else {
        // Manejar respuesta única
        $isFullyCorrect = $question->answers()->where('id', $answerId)->where('is_correct', true)->exists();

        // Guardar la respuesta del usuario
        ExamAnswer::create([
            'exam_id' => $exam->id,
            'question_id' => $question->id,
            'answer_id' => $answerId,
            'is_correct' => $isFullyCorrect,
        ]);
    }

    // Actualizar las respuestas correctas y la puntuación solo si la pregunta es totalmente correcta
    if ($isFullyCorrect) {
        $exam->correct_answers++;
    }

    // Calcular la puntuación como porcentaje de preguntas correctamente respondidas
    $exam->score = ($exam->correct_answers / $exam->total_questions) * 100;
    $exam->save();
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