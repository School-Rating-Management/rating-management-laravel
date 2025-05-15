@extends('layout.app')

@section('title', 'Panel del Profesor')

@section('sidebar')
    <h2 class="text-xl font-bold mb-4 text-blue-800">📘 Materias Asignadas</h2>
    <ul class="space-y-2">
        <li class="border-l-4 border-blue-500 pl-2">
             <a href="{{ route('profesor.home') }}" class="text-blue-700 hover:underline hover:bg-white/50 px-3 py-0.5 rounded-md">Panel inicial</a>
        </li>
        <hr>
        @forelse ($materias as $m)
            <li class="border-l-4 border-blue-500 pl-2">
                <a href="{{ route('profesor.materia', $m->id) }}" class="text-blue-700 hover:underline hover:bg-white/50 px-3 py-0.5 rounded-md">
                    {{ $m->nombre_materia }}
                </a>
            </li>
            <hr>
        @empty
            <li class="text-gray-600">No hay materias asignadas.</li>
        @endforelse
    </ul>
@endsection

@section('content')
    <h3 class="text-2xl font-bold mb-4 text-center">Bienvenido Profesor(a), {{ $profesor->nombre }}</h3>

    @if ($grupo)
        <div class="mb-6 text-center">
            <p class="text-xl font-semibold">Grupo: {{ $grupo->nombre_grupo }}</p>
            <p>Grado: {{ $grupo->grados->nombre_grado }}</p>
        </div>

        {{-- Alumnos --}}
        <div>
            <h2 class="text-lg font-semibold mb-2">Alumnos del grupo:</h2>
            <section class="bg-white/60 shadow p-4 rounded">
                <ul class="space-y-2">
                    @foreach ($alumnos as $alumno)
                        <li class="bg-white/60 shadow rounded">
                            <a href="{{ route('alumno.detalle.profesor', $alumno->id) }}" class="block p-4">
                                <p><strong>{{ $alumno->nombre }} {{ $alumno->apellido }}</strong></p>
                                <p>CURP: {{ $alumno->curp }}</p>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </section>
        </div>
    @else
        <p class="text-red-600 text-center">No tienes un grupo asignado aún.</p>
    @endif
@endsection
