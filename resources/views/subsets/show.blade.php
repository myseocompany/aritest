@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-6">Detalle del Subset: {{ $subset->name }}</h1>

    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h2 class="text-xl font-bold mb-4">Información del Subset</h2>
        <p><strong>Descripción:</strong> {{ $subset->description }}</p>
        <p><strong>Total de Preguntas:</strong> {{ $subset->questions->count() }}</p>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <h2 class="text-xl font-bold p-6">Usuarios que Presentaron el Examen</h2>
        <table class="table-auto w-full">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2">ID del Usuario</th>
                    <th class="px-4 py-2">Nombre</th>
                    <th class="px-4 py-2">Correo Electrónico</th>
                    <th class="px-4 py-2">Nota</th>
                    <th class="px-4 py-2">Fecha del Examen</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($exams as $exam)
                    <tr class="border-b">
                        <td class="px-4 py-2 text-center">{{ $exam->user->id }}</td>
                        <td class="px-4 py-2">{{ $exam->user->name }}</td>
                        <td class="px-4 py-2">{{ $exam->user->email }}</td>
                        <td class="px-4 py-2 text-center">{{ number_format($exam->score, 2) }}%</td>
                        <td class="px-4 py-2 text-center">{{ $exam->created_at->format('d/m/Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center px-4 py-2">No se encontraron exámenes para este subset.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
