@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-6">Detalle del Estudiante</h1>

    <!-- Datos del Usuario -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h2 class="text-xl font-bold mb-4">Datos Personales</h2>
        <p><strong>Nombre:</strong> {{ $user->name }}</p>
        <p><strong>Correo Electrónico:</strong> {{ $user->email }}</p>
        <p><strong>Fecha de Registro:</strong> {{ $user->created_at->format('d/m/Y') }}</p>
    </div>

    <!-- Lista de Exámenes -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <h2 class="text-xl font-bold p-6">Exámenes Tomados</h2>
        <table class="table-auto w-full">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2">ID del Examen</th>
                    <th class="px-4 py-2">Nombre del Subset</th>
                    <th class="px-4 py-2">Nota</th>
                    <th class="px-4 py-2">Número de Preguntas</th>
                    <th class="px-4 py-2">Fecha del Examen</th>
                </tr>
            </thead>
            <tbody>
                @forelse($user->exams as $exam)
                    <tr class="border-b">
                        <td class="px-4 py-2 text-center">{{ $exam->id }}</td>
                        <td class="px-4 py-2 text-center">{{ $exam->subset->name }}</td>
                        <td class="px-4 py-2 text-center">{{ number_format($exam->score, 2) }}</td>
                        <td class="px-4 py-2 text-center">{{ $exam->total_questions }}</td>
                        <td class="px-4 py-2 text-center">{{ $exam->created_at->format('d/m/Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center px-4 py-2">No se encontraron exámenes.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
