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

        return view('test.question', compact('exam', 'question'));
    }

    public function saveAnswer(Request $request, Exam $exam)
    {
        // Validar la respuesta del usuario
        $request->validate([
            'answer_id' => 'required|exists:answers,id',
        ]);

        // Obtener la pregunta actual
        $question = $this->examService->getNextQuestion($exam);

        // Guardar la respuesta
        $this->examService->saveAnswer($exam, $question, $request->answer_id);

        // Redirigir a la siguiente pregunta
        return redirect()->route('test.question', ['exam' => $exam]);
    }

    public function showResults(Exam $exam)
    {
        // Obtener las respuestas del examen
        $examAnswers = $exam->examAnswers;
    
        // Obtener las preguntas del examen
        $questions = $exam->subset->questions;
    
        // Obtener los resultados
        $results = $this->examService->getExamResults($exam);
    
        return view('test.results', compact('exam', 'questions', 'results', 'examAnswers'));
    }
    
}