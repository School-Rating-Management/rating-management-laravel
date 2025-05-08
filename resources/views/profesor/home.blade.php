
@extends('layout.app')

@section('title', 'Panel del Profesor')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Bienvenido Profesor(a), {{ $profesor->nombre }}</h1>

    @if ($grupo)
        <div class="mb-6">
            <h2 class="text-xl font-semibold">Grupo: {{ $grupo->nombre_grupo }}</h2>
            <p>Grado: {{ $grupo->grados->nombre_grado }}</p>
        </div>


        <div class="mb-6">
            <h2 class="text-lg font-semibold">{{\Illuminate\Support\Str::plural('Alumno', $alumnos->count()) }} del grupo:</h2>
            <section class="bg-white/60 shadow p-4 rounded  my-2">
                <ul class="space-y-2 mt-2">
                    @foreach ($alumnos as $alumno)
                        <li class="bg-white/60 shadow rounded">
                            <a href="{{route('alumno.detalle.profesor', $alumno->id)}}" class="block p-4">
                                <p>{{ $alumno->nombre }} {{ $alumno->apellido }}</p>
                                <p>CURP: {{ $alumno->curp }}</p>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </section>
        </div>

        <div class="mb-6 bg-white/60 shadow p-4 rounded">
            <h2 class="text-lg font-semibold">Materias asignadas al grado:</h2>
            <ul class="ml-6 mt-2">
                @foreach ($materias as $materia)
                    <lic class="list-disc block">{{ $materia->nombre_materia }}</li>
                @endforeach
            </ul>
        </div>
    @else
        <p class="text-red-600">No tienes un grupo asignado aún.</p>
    @endif
@endsection
