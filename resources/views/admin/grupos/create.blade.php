@extends('layout.panel')

@section('title', 'Crear Grupo')

@section('content')
@include('partials.alerts')

<div class="container mx-auto py-6">
    <h2 class="text-2xl font-bold mb-4">Crear Grupo</h2>

    <form action="{{ route('grupos.store') }}" method="POST" class="space-y-4 bg-white/50 p-6 rounded shadow">
        @csrf

        <div>
            <label for="nombre_grupo" class="block font-semibold">Nombre del Grupo</label>
            <input type="text" name="nombre_grupo" id="nombre_grupo" value="{{ old('nombre_grupo') }}"
                   class="w-full px-4 py-2 border rounded" required>
        </div>

        @if($profesores->count())
            <div>
                <label for="profesor_id" class="block font-semibold">Profesor Asignado</label>
                <select name="profesor_id" id="profesor_id" class="w-full px-4 py-2 border rounded">
                    <option value="">Selecciona un profesor</option>
                    @foreach ($profesores as $profesor)
                        <option value="{{ $profesor->id }}" {{ old('profesor_id') == $profesor->id ? 'selected' : '' }}>
                            {{ $profesor->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
        @else
            <div class="p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 rounded">
                No hay profesores disponibles sin grupo. Puedes crear el grupo sin asignar profesor.
            </div>
        @endif

        <div>
            <label for="grado_id" class="block font-semibold">Grado (opcional)</label>
            <select name="grado_id" id="grado_id" class="w-full px-4 py-2 border rounded">
                @foreach ($grados as $grado)
                    <option value="{{ $grado->id }}" {{ old('grado_id') == $grado->id ? 'selected' : '' }}>
                        {{ $grado->nombre_grado }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex justify-end">
            <a href="{{ route('grupos.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded mr-2">Cancelar</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-800">Guardar</button>
        </div>
    </form>
</div>
@endsection
