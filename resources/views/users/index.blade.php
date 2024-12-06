@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-6">Estudiantes</h1>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="table-auto w-full">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Nombre</th>
                    <th class="px-4 py-2">Correo Electrónico</th>
                    <th class="px-4 py-2">Exámenes Tomados</th>
                    <th class="px-4 py-2">Promedio de Notas</th>
                    <th class="px-4 py-2">Fecha de Registro</th>
                    
                    
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr class="border-b">
                        <td class="px-4 py-2 text-center">{{ $user->id }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('users.show', $user->id) }}" class="text-blue-500 underline">
                                {{ $user->name }}
                            </a>
                            </td>
                        <td class="px-4 py-2">{{ $user->email }}</td>
                        <td class="px-4 py-2 text-center">{{ $user->exams_count }}</td>
                        <td class="px-4 py-2 text-center">{{ number_format($user->exams_avg_score, 2) }}</td>
                        <td class="px-4 py-2 text-center">{{ $user->created_at->format('d/m/Y') }}</td>
                        
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center px-4 py-2">No se encontraron estudiantes.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
@endsection
