@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center justify-start px-6 w-full">

    <!-- Contenedor de Test -->
    <div class="w-full max-w-6xl bg-white rounded-lg shadow-lg p-8 mt-16">

        <div class="mb-8 text-center">
            <h2 class="text-3xl font-semibold text-gray-800 mb-4">Pregunta {{ $currentQuestionIndex + 1 }} de {{ $totalQuestions }}</h2>
        </div>

        <!-- Mostrar la pregunta -->
        <form action="{{ route('test.start') }}" method="GET">
            @csrf
            <div class="mb-6">
                <p class="text-lg text-gray-700">{{ $question->question_text }}</p>
            </div>

            <div class="mb-6">
                @foreach($question->answers as $answer)
                    <div class="flex items-center mb-4">
                    <input type="radio" id="answer{{ $answer->id }}" name="answers[{{ $question->id }}][]" value="{{ $answer->id }}" class="form-radio" />
                        <label for="answer{{ $answer->id }}" class="ml-2 text-gray-700">{{ $answer->answer_text }}</label>
                    </div>
                @endforeach
            </div>

            <!-- Botón para avanzar a la siguiente pregunta -->

        </form>

        <!-- Enviar respuestas y avanzar a la siguiente pregunta -->
        <div class="mt-4">
            <a href="{{ route('test.start', ['question' => $currentQuestionIndex + 1]) }}" class="inline-block px-8 py-3 bg-green-600 text-white font-semibold text-lg rounded-lg shadow-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition duration-200">
                Siguiente Pregunta
            </a>
        </div>
        
    </div>
</div>
@endsection
