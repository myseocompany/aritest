@extends('layouts.app')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    {{ __('Dashboard') }}::
</h2>

@endsection
@section('content')
        
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    Hola, <br>puedes ir a presentar tus exámenes de prueba 
                    <a href="/home" class="text-blue-400">aqui</a>
                </div>
            </div>
        </div>
    </div>
@endsection
