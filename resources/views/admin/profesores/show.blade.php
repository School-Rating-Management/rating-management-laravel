@extends('layout.panel')

@section('title', 'Detalles del Profesor')

@section('content')
<div class="container mx-auto py-6">
    <h2 class="text-2xl font-bold mb-4">👨‍🏫 Detalles del Profesor</h2>

    <div class="bg-white shadow rounded p-6 mb-6">
        <p><strong>Nombre:</strong> {{ $profesor->nombre }} {{ $profesor->apellido }}</p>
        <p><strong>Estado:</strong>
            @if($profesor->trashed())
                <span class="text-red-600">Inactivo</span>
            @else
                <span class="text-green-600">Activo</span>
            @endif
        </p>
    </div>

    @if($profesor->grupo)
    <div class="bg-white shadow rounded p-6 mb-6">
        <h3 class="text-xl font-semibold mb-2">👥 Grupo Asignado</h3>
        <p><strong>Grupo:</strong> {{ $profesor->grupo->nombre_grupo }}</p>
        <p><strong>Grado:</strong> {{ $profesor->grupo->grados->nombre_grado ?? 'Sin grado asignado' }}</p>

        <h4 class="text-lg font-semibold mt-4">📘 Materias del Grado</h4>
        <ul class="list-disc list-inside ml-4">
            @forelse($profesor->grupo->grados->materias as $materia)
                <div class="mb-2">
                    <li class="list-none pl-3">{{ $materia->nombre_materia }}</li>
                    <hr>
                </div>
            @empty
                <li class="text-gray-500 list-none pl-3">No hay materias asignadas al grado</li>
            @endforelse
        </ul>

        <h4 class="text-lg font-semibold mt-4">🎓 Alumnos en el Grupo</h4>
        <ul class="list-disc list-inside ml-4">
            @forelse($profesor->grupo->alumnos as $alumno)
                <div class="mb-2">
                    <li class="list-none pl-3"> {{ $alumno->nombre }} {{ $alumno->apellido }}</li>
                    <hr>
                </div>
            @empty
                <li class="text-gray-500 list-none pl-3">No hay alumnos asignados</li>
            @endforelse
        </ul>
    </div>
    @else
        <div class="bg-yellow-100 text-yellow-800 p-4 rounded mb-4">
            <p>Este profesor aún no tiene un grupo asignado.</p>
        </div>

        <a href="{{ route('profesores.asignarGrupo', $profesor->id) }}"
        class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
            ➕ Asignar Grupo
        </a>
    @endif

    <div class="mt-4 space-x-2">
        <a href="{{ route('profesores.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded">⬅️ Volver</a>
        <a href="{{ route('profesores.edit', $profesor->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded">✏️ Editar</a>
    </div>
</div>
@endsection
