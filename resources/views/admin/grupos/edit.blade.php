@extends('layout.panel')

@section('title', 'Editar Grupo')

@section('content')
@include('partials.alerts')

<div class="container mx-auto py-6">
    <h2 class="text-2xl font-bold mb-4">Editar Grupo</h2>

    <form action="{{ route('grupos.update', $grupo) }}" method="POST" class="space-y-4 bg-white/50 p-6 rounded shadow">
        @csrf
        @method('PUT')

        <div>
            <label for="nombre_grupo" class="block font-semibold">Nombre del Grupo</label>
            <input type="text" name="nombre_grupo" id="nombre_grupo"
                   value="{{ old('nombre_grupo', $grupo->nombre_grupo) }}"
                   class="w-full px-4 py-2 border rounded" required>
        </div>

        <div>
            <label for="profesor_id" class="block font-semibold">Profesor Asignado</label>
            <select name="profesor_id" id="profesor_id" class="w-full px-4 py-2 border rounded">
                <option value="">Sin profesor</option>
                @foreach ($profesores as $profesor)
                    <option value="{{ $profesor->id }}" {{ $grupo->profesor_id == $profesor->id ? 'selected' : '' }}>
                        {{ $profesor->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="grado_id" class="block font-semibold">Grado</label>
            <select name="grado_id" id="grado_id" class="w-full px-4 py-2 border rounded" required>
                @foreach ($grados as $grado)
                    <option value="{{ $grado->id }}" {{ $grupo->grado_id == $grado->id ? 'selected' : '' }}>
                        {{ $grado->nombre_grado }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex justify-end">
            <a href="{{ route('grupos.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded mr-2">Cancelar</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-800">Actualizar</button>
        </div>
    </form>
</div>
@endsection
