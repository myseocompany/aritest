@extends('layouts.app') 

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            Pregunta {{ $exam->examAnswers->count() + 1 }} de {{ $exam->total_questions }}
        </div>
        <div class="card-body">
            <h5 class="card-title">{{ $question->question_text }}</h5>
            <form method="POST" action="{{ route('test.saveAnswer', ['exam' => $exam]) }}">
                @csrf
                @foreach ($question->answers as $answer)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="answer_id" id="answer_{{ $answer->id }}" value="{{ $answer->id }}">
                        <label class="form-check-label" for="answer_{{ $answer->id }}">
                            {{ $answer->answer_text }}
                        </label>
                    </div>
                @endforeach
                <button type="submit" class="btn btn-primary mt-3">Siguiente</button>
            </form>
        </div>
    </div>
</div>
@endsection