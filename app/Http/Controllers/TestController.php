<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Subset;
use App\Services\ExamService;
use Illuminate\Http\Request;

class TestController extends Controller
{
    protected $examService;

    public function __construct(ExamService $examService)
    {
        $this->examService = $examService; 
    }

    public function start(Request $request) 
    {
        $request->validate([
            'subset' => 'required|exists:subsets,id',
        ]);

        $subset = Subset::findOrFail($request->subset);

        // Crear un nuevo examen usando el ExamService
        $exam = $this->examService->createExam($subset);

        // Redirigir a la primera pregunta del examen
        return redirect()->route('test.question', ['exam' => $exam]);
    }

    public function startExam(Subset $subset)
    {
        // Crear un nuevo examen
        $exam = $this->examService->createExam($subset);

        // Redirigir a la primera pregunta
        return redirect()->route('test.question', ['exam' => $exam]);
    }

    public function showQuestion(Exam $exam)
{
    // Obtener la siguiente pregunta
    $question = $this->examService->getNextQuestion($exam);

    // Si no hay más preguntas, mostrar los resultados
    if (!$question) {
        return redirect()->route('test.results', ['exam' => $exam]);
    }

    // Obtener el índice de la pregunta actual basado en las respondidas
    $answeredQuestions = $exam->examAnswers->pluck('question_id')->toArray();
    $currentQuestionIndex = $exam->subset->questions->pluck('id')->search($question->id);

    return view('test.question', compact('exam', 'question', 'currentQuestionIndex'));
}

    

public function saveAnswer(Request $request, Exam $exam)
{
    // Obtener la siguiente pregunta
    $question = $this->examService->getNextQuestion($exam);

    if (!$question) {
        return redirect()->route('test.results', ['exam' => $exam]);
    }

    // Validar las respuestas según el tipo de pregunta
    if ($question->question_type == 'multiple') {
        $request->validate([
            'answer_ids' => 'required|array|min:1',
            'answer_ids.*' => 'exists:answers,id',
        ]);

        // Pasar el arreglo completo al servicio
        $this->examService->saveAnswer($exam, $question, $request->answer_ids);
    } else {
        $request->validate([
            'answer_id' => 'required|exists:answers,id',
        ]);

        // Pasar la respuesta única al servicio
        $this->examService->saveAnswer($exam, $question, $request->answer_id);
    }

    // Redirigir a la siguiente pregunta
    return redirect()->route('test.question', ['exam' => $exam]);
}







public function showResults(Exam $exam)
{
    $examAnswers = $exam->examAnswers;
    $questions = $exam->subset->questions;
    $results = $this->examService->getExamResults($exam);

    return view('test.results', compact('exam', 'questions', 'results', 'examAnswers'));
}

    
}