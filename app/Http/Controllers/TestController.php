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
    // Verificar si hay una pregunta actual
    $question = $this->examService->getNextQuestion($exam);

    if (!$question) {
        // Si no hay más preguntas, redirigir a los resultados
        return redirect()->route('test.results', ['exam' => $exam]);
    }

    // Validar la respuesta del usuario dependiendo del tipo de pregunta
    if ($question->question_type == 'multiple') {
        // Para preguntas de selección múltiple, validamos que sean respuestas múltiples
        $request->validate([
            'answer_ids' => 'required|array',
            'answer_ids.*' => 'exists:answers,id', // Validar que cada id de respuesta sea válido
        ]);
    } else {
        // Para preguntas de selección única, validamos una sola respuesta
        $request->validate([
            'answer_id' => 'required|exists:answers,id', // Validar que la respuesta sea válida
        ]);
    }

    // Guardar la respuesta
    $this->examService->saveAnswer($exam, $question, $request->answer_id ?? $request->answer_ids);

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