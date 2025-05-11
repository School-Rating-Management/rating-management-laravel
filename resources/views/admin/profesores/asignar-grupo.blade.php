@extends('layout.panel')

@section('title', 'Asignar Grupo')

@section('content')
<div class="container mx-auto py-6">
    <h2 class="text-2xl font-bold mb-4">Asignar Grupo a {{ $profesor->nombre }} {{ $profesor->apellido }}</h2>

    <form action="{{ route('profesores.guardarGrupo', $profesor->id) }}" method="POST" class="bg-white p-6 rounded shadow">
        @csrf
        <div class="mb-4">
            <label for="grupo_id" class="block text-sm font-semibold text-gray-700">Selecciona un grupo:</label>
            <select name="grupo_id" id="grupo_id" class="mt-1 block w-full border-2 border-white border-b-blue-500 rounded shadow-sm focus:outline-none focus:border-b-blue-800 focus:shadow-outline">
                @foreach($grupos as $grupo)
                    <option value="{{ $grupo->id }}">{{ $grupo->nombre_grupo }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
            💾 Guardar
        </button>
        <a href="{{ route('profesores.index') }}"
                class="ml-8 inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                Cancelar
        </a>
    </form>
    <div class="mt-4 space-x-2">
        <a href="{{ route('profesores.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded">Volver</a>
    </div>
</div>
@endsection
