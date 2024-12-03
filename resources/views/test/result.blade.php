@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center justify-start px-6 w-full">
    <div class="w-full max-w-6xl bg-white rounded-lg shadow-lg p-8 mt-16">
        <h2 class="text-3xl font-semibold text-gray-800">Resultados del Test</h2>

        <div class="mt-4">
            <p class="text-lg text-gray-700">Tu puntuación es: {{ session('score') }}%</p>
        </div>

        <div class="mt-4">
            <p class="text-gray-600">¡Gracias por completar el test!</p>
        </div>

        <div class="mt-8">
            <a href="{{ route('home') }}" class="text-blue-600">Volver al inicio</a>
        </div>
    </div>
</div>
@endsection
