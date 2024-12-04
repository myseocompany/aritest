@extends('layouts.app') 

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Resultados del examen</div>
        <div class="card-body">
            <p>Preguntas totales: {{ $results['total_questions'] }}</p>
            <p>Respuestas correctas: {{ $results['correct_answers'] }}</p>
            <p>Puntuación: {{ $results['score'] }}%</p>
        </div>
    </div>
</div>
@endsection