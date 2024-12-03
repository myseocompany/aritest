@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center justify-start p-6">

    <!-- Contenedor principal -->
    <div class="max-w-lg w-full bg-white rounded-lg shadow-lg p-8 mt-16">

        <!-- Sección de bienvenida -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-semibold text-gray-800">¡Bienvenido a AriTest!</h1>
            <p class="mt-2 text-gray-600 text-lg">Selecciona un subset y empieza a practicar. ¡Mejora tu rendimiento con cada intento!</p>
        </div>

        <!-- Selección de Subset -->
        <div class="mb-6">
            <label for="subset" class="block text-xl font-medium text-gray-700">Selecciona un Tema</label>
            <div class="mt-2">
                <select id="subset" name="subset" class="block w-full p-3 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @foreach($subsets as $subset)
                        <option value="{{ $subset->id }}">{{ $subset->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Botón de Iniciar Test -->
        <div class="text-center">
            <a href="{{ route('start-test') }}" class="inline-block px-8 py-3 bg-blue-600 text-white font-semibold text-lg rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-200">
                Iniciar Test
            </a>
        </div>

    </div>
</div>
@endsection
