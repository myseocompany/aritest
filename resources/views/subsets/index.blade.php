@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-6">Listado de Subsets</h1>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="table-auto w-full">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Nombre</th>
                    <th class="px-4 py-2">Descripción</th>
                    <th class="px-4 py-2">Número de Preguntas</th>
                    <th class="px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($subsets as $subset)
                    <tr class="border-b">
                        <td class="px-4 py-2 text-center">{{ $subset->id }}</td>
                        <td class="px-4 py-2">{{ $subset->name }}</td>
                        <td class="px-4 py-2">{{ $subset->description }}</td>
                        <td class="px-4 py-2 text-center">{{ $subset->questions_count }}</td>
                        <td class="px-4 py-2 text-center">
                            <a href="{{ route('subsets.show', $subset->id) }}" class="text-blue-600 hover:underline">Ver Detalle</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
