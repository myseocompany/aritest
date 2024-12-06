@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="bg-gray-200 px-6 py-4 border-b">
            <h2 class="text-xl font-bold">Pregunta {{ $currentQuestionIndex + 1 }} de {{ $exam->total_questions }}</h2>
        </div>
        <div class="p-6">
            <h5 class="text-lg font-semibold mb-4">{{ $question->question_text }}</h5>

            <div class="text-sm text-gray-500 mb-4">
                Tipo de pregunta: 
                <strong>
                    @if($question->question_type == 'multiple')
                        Selección múltiple
                    @else
                        Selección única
                    @endif
                </strong>
            </div>

            <form method="POST" action="{{ route('test.saveAnswer', ['exam' => $exam]) }}">
                @csrf
                <div class="space-y-3">
                    @foreach ($question->answers as $answer)
                        <div class="flex items-center">
                            @if($question->question_type == 'multiple')
                                <input 
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500" 
                                    type="checkbox" 
                                    name="answer_ids[]" 
                                    id="answer_{{ $answer->id }}" 
                                    value="{{ $answer->id }}">
                            @else
                                <input 
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500" 
                                    type="radio" 
                                    name="answer_id" 
                                    id="answer_{{ $answer->id }}" 
                                    value="{{ $answer->id }}">
                            @endif
                            <label class="ml-2 text-gray-700" for="answer_{{ $answer->id }}">
                                {{ $answer->answer_text }}
                            </label>
                        </div>
                    @endforeach
                </div>
                <div class="flex space-x-4 mt-6">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Siguiente
                    </button>
                    <a href="{{ route('home') }}" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
