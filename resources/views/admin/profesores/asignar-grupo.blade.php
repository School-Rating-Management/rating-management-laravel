@extends('layout.app')

@section('title', 'Asignar Grupo')

@section('content')
<div class="container mx-auto py-6">
    <h2 class="text-2xl font-bold mb-4">Asignar Grupo a {{ $profesor->nombre }} {{ $profesor->apellido }}</h2>

    <form action="{{ route('profesores.guardarGrupo', $profesor->id) }}" method="POST" class="bg-white p-6 rounded shadow">
        @csrf
        <div class="mb-4">
            <label for="grupo_id" class="block text-sm font-semibold text-gray-700">Selecciona un grupo:</label>
            <select name="grupo_id" id="grupo_id" class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @foreach($grupos as $grupo)
                    <option value="{{ $grupo->id }}">{{ $grupo->nombre_grupo }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
            💾 Guardar
        </button>
    </form>
</div>
@endsection
