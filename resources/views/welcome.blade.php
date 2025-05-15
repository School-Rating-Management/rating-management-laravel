@extends('layout.init')

@section('title', 'Inicio')

@section('content')
@include('partials.alerts')
    <div class="flex flex-col items-center justify-center h-screen max-sm:px-8">
        <h1 class="text-4xl font-bold text-white">Bienvenido a la Gestión Escolar</h1>
        <p class="mt-4 text-lg text-white">Sistema de gestión escolar para padres de familia y profesores.</p>
        <a href="{{route('login')}}" class="mt-6 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">Iniciar sesión</a>
    </div>
@endsection
