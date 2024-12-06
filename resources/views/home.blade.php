@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center justify-start px-6">

    <!-- Contenedor principal con un ancho más amplio y sin scroll -->
    <div class="w-full max-w-7xl bg-white rounded-lg shadow-lg p-8 mt-16">

        <!-- Sección de bienvenida -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-semibold text-gray-800">¡Bienvenido a AriTest::!</h1>
            <p class="mt-2 text-gray-600 text-lg">Selecciona un subset y empieza a practicar. ¡Mejora tu rendimiento con cada intento!</p>
        </div>

        <!-- Recomendaciones antes de iniciar el test -->
        <div class="bg-gray-50 p-6 rounded-lg mb-8">
            <h2 class="text-xl font-semibold text-gray-800">Antes de iniciar el test, ten en cuenta lo siguiente:</h2>
            <ul class="mt-4 text-gray-600 list-inside">
                <li>La evaluación de Publicidad en Búsqueda de Google Ads consta de 168 preguntas que deben completarse en un máximo de 75 minutos.</li>
                <li>Recuerda lo siguiente:</li>
                <ul class="list-inside list-disc pl-6">
                    <li>Debes obtener una puntuación del 80% o más para aprobar.</li>
                    <li>Si cierras la evaluación antes de terminar o si no respondes suficientes preguntas correctamente dentro del tiempo asignado, no la aprobarás y no podrás reanudarla desde el punto en que la abandonaste.</li>
                    <li>No tendrás oportunidad de revisar ni editar tus respuestas una vez que pases a la siguiente pregunta o selecciones el botón Enviar en la última pregunta.</li>
                    <li>Si repruebas la evaluación, deberás esperar 1 día antes de volver a realizarla.</li>
                </ul>
            </ul>
        </div>

        <form method="POST" action="{{ route('test.start') }}"> 
            @csrf 
            <div class="mb-6">
                <label for="subset" class="block text-xl font-medium text-gray-700">Selecciona un Tema</label>
                <div class="mt-2">
                    <select id="subset" name="subset" class="block w-full p-3 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @foreach($subsets as $subset)
                            <option value="{{ $subset->id }}">
                                {{ $subset->name }} ({{ $subset->questions->count() }} preguntas)
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        
            <div class="text-center">
                <button type="submit" class="inline-block px-8 py-3 bg-blue-600 text-white font-semibold text-lg rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-200">
                    Iniciar Test
                </button> 
            </div>
        </form>

    </div>
</div>
@endsection
