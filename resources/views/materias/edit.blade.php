@extends('layout.app')

@section('title', 'Editar Materia')

@section('content')
<div class="max-w-xl mx-auto mt-10 bg-white shadow p-6 rounded">
    <h2 class="text-xl font-bold mb-4">Editar Materia</h2>

    <form action="{{ route('materias.update', $materia->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label class="block mb-2 font-semibold">Nombre de la materia:</label>
        <input type="text" name="nombre_materia" value="{{ old('nombre_materia', $materia->nombre_materia) }}"
            class="w-full border p-2 rounded mb-4" required>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Guardar</button>
        <a href="{{ route('admin.panel') }}" class="ml-4 text-gray-600">Cancelar</a>
    </form>
</div>
@endsection
