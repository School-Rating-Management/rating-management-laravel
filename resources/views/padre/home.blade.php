@extends('layout.app')

@section('title', 'Panel del Padre/Tutor')


@section('sidebar')
<ul class="space-y-2">
    <h2 class="text-xl font-bold mb-4 text-blue-800">Panel</h2>
    <li class="border-l-4 border-blue-500 pl-2">
        <a href="{{ route('padre.home') }}" class="text-blue-700 hover:underline hover:bg-white/50 px-3 py-0.5 rounded-md">Panel inicial</a>
    </li>
    <hr>
    <h2 class="text-xl font-bold mb-4 text-blue-800">Alumnos asignados</h2>
        @forelse ($alumnos as $alum)
            <li class="border-l-4 border-blue-500 pl-2">
                <a href="#" class="text-blue-700 hover:underline hover:bg-white/50 px-3 py-0.5 rounded-md">
                    {{ $alum->nombre }}
                </a>
            </li>
            <hr>
        @empty
            <li class="text-gray-600">No hay materias asignadas.</li>
        @endforelse
    </ul>
@endsection

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
