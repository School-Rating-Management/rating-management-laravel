@extends('layout.app')

@section('title', 'Editar Calificación')

@section('content')
<div class="p-6 max-w-xl mx-auto bg-white shadow rounded">
    <h2 class="text-2xl font-bold mb-4 text-blue-800">✏️ Editar Calificación</h2>

    <p class="mb-2"><strong>Alumno:</strong> {{ $alumno->nombre }} {{ $alumno->apellido }}</p>
    <p class="mb-4"><strong>Materia:</strong> {{ $materia->nombre_materia }}</p>

    <form action="{{ route('profesor.calificacion.update', [$materia->id, $alumno->id]) }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label for="calificacion" class="block font-medium">Calificación (0 a 10 o dejar vacío):</label>
            <input type="number" name="calificacion" id="calificacion" value="{{ old('calificacion', $calificacion->calificacion ?? '') }}" min="0" max="10" step="0.1"
                   class="w-full px-3 py-2 border rounded shadow focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Guardar
        </button>
        <a href="{{ route('profesor.materia', $materia->id) }}" class="ml-4 text-gray-600 hover:underline">Cancelar</a>
    </form>
</div>
@endsection
