@extends('layout.panel')

@section('title', 'Detalles del Alumno')

@section('content')
<div class="container mx-auto py-6">
    <h2 class="text-2xl font-bold mb-4">Detalles del Alumno</h2>

    <div class="bg-white/50 p-6 rounded shadow space-y-4">
        <div>
            @if ($alumno->trashed())
                <div class="p-4 bg-red-100 text-red-700 rounded mb-2">
                    Este alumno actualmente está eliminado. Puedes restaurarlo para volver a editarlo.
                </div>
            @endif
            <div class="flex justify-between">
                <div>
                    <strong class="text-gray-700">Nombre del Alumno:</strong>
                    <p class="text-blue-800 font-bold">{{ $alumno->nombre . ' ' . $alumno->apellido}}</p>
                </div>
                <div>
                    <strong class="text-gray-700">Curp:</strong>
                    <p class="text-blue-800 font-bold">{{ $alumno->curp }}</p>
                </div>
            </div>
        </div>

        <hr class="text-blue-500">

        <div class="flex justify-between">
            <div>
                <strong class="text-gray-700">Grupo Asignado:</strong>
                @if($alumno->grupo)
                    <p>{{ $alumno->grupo->nombre_grupo }}</p>
                @else
                    <p class="text-gray-400 italic">Aun no hay un grupo asignado</p>
                @endif
            </div>
            <div>
                <strong class="text-gray-700">Grado Asignado:</strong>
                @if($alumno->grupo && $alumno->grupo->grados)
                    <p>{{ $alumno->grupo->grados->nombre_grado }}</p>
                @else
                    <p class="text-gray-400 italic">Aun no hay un grado asignado</p>
                @endif
            </div>
        </div>

        <hr class="text-blue-500">

        <div>
            <strong class="text-gray-700">Padre Asignado:</strong>
            @if($alumno->padre)
                <p class="text-blue-800">{{ $alumno->padre->nombre }}</p>
            @else
                <p class="text-gray-400 italic">Aun no hay un padre asignado</p>
            @endif
        </div>

        <hr class="text-blue-500">

        <div>
            <strong class="text-gray-700">Calificaciones asignadas:</strong>
            @if($alumno->calificaciones->isNotEmpty())
                @foreach ($alumno->calificaciones as $calificacion )
                    <div class="flex justify-between p-1">
                        <p>{{ $calificacion->materia->nombre_materia }}</p>
                        <p class="font-bold">{{$calificacion->calificacion}}</p>
                    </div>
                    <hr class="text-gray-400">
                @endforeach
            @else
                <p class="text-gray-400 italic">Aun no hay un calificaciones asignadas</p>
            @endif
        </div>

        <div class="flex justify-end space-x-2">
            @if(!$alumno->trashed())
                <a href="{{ route('alumnos.edit', $alumno) }}" class="px-4 py-2 bg-yellow-500 text-white rounded">Editar</a>
            @endif
            <a href="{{ route('alumnos.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded">Volver</a>
        </div>
    </div>

</div>
@endsection
