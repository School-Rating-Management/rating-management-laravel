@extends('layout.app')

@section('title', 'Panel del Padre/Tutor')

@section('content')
    <div>
        <nav class="flex items-center space-x-2 mb-4">
            <span class="text-gray-700">Panel del Padre o Tutor</span>
        </nav>
    </div>
    <h1 class="text-2xl font-bold mb-4">Bienvenido, {{ $padre->nombre }}</h1>


    @if($alumnos->isEmpty())
        <p class="text-gray-600">No tienes hijos asignados aún.</p>
    @else
        <h2 class="text-xl font-semibold mb-2">Tus hijos:</h2>
        <ul class="space-y-4">
            @foreach ($alumnos as $alumno)
                <li class="bg-white/55 px-4 shadow rounded">
                    <a href="{{ route('alumno.detalle.padre', $alumno->id) }}" class="p-4">
                        <p><strong>Nombre:</strong> {{ $alumno->nombre }} {{ $alumno->apellido }}</p>
                        <p><strong>CURP:</strong> {{ $alumno->curp }}</p>
                        <p><strong>Grupo:</strong> {{ $alumno->grupo->nombre_grupo ?? 'N/A' }}</p>
                        <p><strong>Ciclo:</strong> {{ $alumno->ciclo->nombre ?? 'N/A' }}</p>
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
@endsection
