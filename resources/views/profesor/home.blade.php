
@extends('layout.app')

@section('title', 'Panel del Profesor')

@section('content')
<div x-data="{ sidebarOpen: false }" class="flex flex-col md:flex-row gap-4">
    {{-- Botón para mostrar/ocultar la sidebar --}}
    <button @click="sidebarOpen = !sidebarOpen"
        class="md:hidden p-2 bg-blue-600 text-white rounded shadow w-max ml-auto">
        <span x-show="!sidebarOpen">📂 Ver Materias</span>
        <span x-show="sidebarOpen">❌ Cerrar</span>
    </button>

    {{-- Sidebar de materias (visible en móvil y escritorio) --}}
    <aside
        x-show="sidebarOpen || window.innerWidth >= 768"
        @resize.window="sidebarOpen = window.innerWidth >= 768"
        class="w-full md:w-64 bg-white/70 rounded shadow-md p-4 md:block"
        x-transition
    >
        <h3 class="text-lg font-semibold mb-2">📘 Materias Asignadas:</h2>
        <ul class="space-y-2">
            @forelse ($materias as $materia)
                <li class="border-l-4 border-blue-500 pl-2">{{ $materia->nombre_materia }}</li>
                <hr>
            @empty
                <li class="text-gray-600">No hay materias asignadas.</li>
            @endforelse
        </ul>
    </aside>

    {{-- Contenido principal --}}
    <div class="flex-1">
        <h3 class="text-2xl font-bold mb-4 text-center">Bienvenido Profesor(a), {{ $profesor->nombre }}</h1>

        @if ($grupo)
            <div class="mb-6 justify-center items-center text-center">
                <p class="text-xl font-semibold">Grupo: {{ $grupo->nombre_grupo }}</p>
                <p>Grado: {{ $grupo->grados->nombre_grado }}</p>
            </div>

            <div class="mb-6">


            </div>

            {{-- Seccion de alumnos --}}
            <div class="mb-6">
                <h2 class="text-lg font-semibold">{{ \Illuminate\Support\Str::plural('Alumno', $alumnos->count()) }} del grupo:</h2>
                <section class="bg-white/60 shadow p-4 rounded my-2">
                    <ul class="space-y-2 mt-2">
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
    </div>
</div>
@endsection

