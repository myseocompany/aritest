@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center justify-start px-6 w-full">
    <!-- Resultados -->
    <div class="w-full max-w-6xl bg-white rounded-lg shadow-lg p-8 mt-16">
        <h2 class="text-3xl font-semibold text-gray-800">Resultados del Test</h2>

        <div class="mt-4">
            <p class="text-lg text-gray-700">Tu puntuación es: <span class="font-bold">{{ $results['score'] }}%</span></p>
        </div>

        <div class="mt-4">
            <p class="text-gray-600">¡Gracias por completar el test!</p>
        </div>

        <div class="mt-8">
            <a href="{{ route('home') }}" class="text-blue-600 hover:underline">Volver al inicio</a>
        </div>
    </div>

    <!-- Preguntas, Respuestas del Cliente y Correctas -->
    <div class="w-full max-w-6xl bg-white rounded-lg shadow-lg p-8 mt-8">
        <h3 class="text-2xl font-semibold text-gray-800 mb-6">Preguntas, Respuestas y Explicaciones</h3>

        <div class="space-y-6">
            @foreach ($questions as $question)
                <div class="p-4 bg-gray-100 rounded-lg">
                    <!-- Pregunta -->
                    <p class="text-lg font-semibold text-gray-700">{{ $loop->iteration }}. {{ $question->question_text }}</p>
                    
                    <!-- Respuestas -->
                    <ul class="mt-3 space-y-2">
                        @foreach ($question->answers as $answer)
                            <li 
                                class="ml-4 p-2 rounded-lg 
                                    {{ $answer->is_correct ? 'bg-green-100 text-green-800 font-bold' : '' }} 
                                    {{ $examAnswers->contains('answer_id', $answer->id) && !$answer->is_correct ? 'bg-red-100 text-red-800' : '' }}
                                    {{ !$examAnswers->contains('answer_id', $answer->id) && !$answer->is_correct ? 'text-gray-600' : '' }}">
                                - {{ $answer->answer_text }} 
                                @if ($answer->is_correct)
                                    <span class="text-sm text-green-500">(Correcta)</span>
                                @elseif ($examAnswers->contains('answer_id', $answer->id))
                                    <span class="text-sm text-red-500">(Tu respuesta)</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>

                    <!-- Explicación -->
                    @if ($question->explanation)
                        <div class="mt-4 p-3 bg-gray-200 rounded-lg">
                            <p class="text-sm text-gray-700"><strong>Explicación:</strong> {{ $question->explanation }}</p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
