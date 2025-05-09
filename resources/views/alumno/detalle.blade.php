@extends('layout.app')

@section('title', 'Detalle del Alumno')

@section('content')
    {{-- breadcrumbs --}}
    <div class="mb-4">
        <nav class="flex items-center space-x-2 mb-4">
            <a href="{{ $rol === 'padre' ? route('padre.home') : route('profesor.home') }}"
            class="text-cyan-50 hover:underline">
            Panel del {{ $rol === 'padre' ? 'Padre o Tutor' : 'Profesor' }}
            </a>
            <span class="text-gray-500">/</span>
            <span class="text-gray-700">Detalle del Alumno</span>
        </nav>
    </div>

    <div class="max-w-7xl mx-auto bg-white/60 p-6 rounded shadow">
        <h3 class="text-2xl font-bold mb-4">
            Detalle del alumno {{ $alumno->nombre }} {{ $alumno->apellido }}
        </h3>

        <p><strong>CURP:</strong> {{ $alumno->curp }}</p>
        <p><strong>Grupo actual:</strong> {{ $alumno->grupo->nombre_grupo ?? 'N/A' }}</p>
        <p><strong>Ciclo:</strong> {{ $alumno->ciclo->nombre ?? 'N/A' }}</p>

        <hr class="my-4">

        <h3 class="text-xl font-semibold mb-2">Notas Actuales</h2>

        @if($alumno->calificaciones && $alumno->calificaciones->isNotEmpty())
            <ul class="">
                @foreach ($alumno->calificaciones as $nota)
                    <li class="bg-white/60 shadow p-2 rounded mb-2 hover:bg-gray-100 transition list-none">
                        <div class="flex items-center justify-between">
                            <strong>{{ $nota->materia->nombre_materia ?? 'Materia desconocida' }}</strong>
                            @if($nota->calificacion >= 6)
                                <span class="text-green-500 font-bold">{{ $nota->calificacion }}</span>
                            @elseif ($nota->calificacion < 6 && $nota->calificacion > 0)
                                <span class="text-yellow-500 font-bold">{{ $nota->calificacion }}</span>
                            @else
                                <span class="text-slate-500/100 pl-4">Aun no hay calificaciona asignada</span>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <span class="text-slate-500/100 pl-4">Aun no hay calificaciones registradas aun conn el alumno</span>
        @endif

        @if( $rol != 'profesor')
            @if($alumno->historial && $alumno->historial->isNotEmpty())
                <hr class="my-4">
                <h3 class="text-xl font-semibold mb-2">Historial de Calificaciones</h2>
                <ul class="list-disc pl-6">
                    @foreach ($alumno->historial as $historial)
                        <li>
                            <strong>{{ $historial->materia->nombre_materia ?? 'Materia desconocida' }}</strong>
                            @if($historial->calificacion >= 6)
                                <span class="text-green-500 font-bold">{{ $historial->calificacion }}</span>
                            @elseif ($historial->calificacion < 6 && $historial->calificacion > 0)
                                <span class="text-yellow-500 font-bold">{{ $historial->calificacion }}</span>
                            @else
                                <span class="text-red-500">Aun no hay calificaciona asignada</span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="mt-4">No hay historial de calificaciones registrado.</p>
            @endif
        @endif
    </div>
@endsection
