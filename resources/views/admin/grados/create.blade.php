@extends('layout.panel')

@section('title', 'Agregar Grado')

@section('content')
<div class="container mx-auto py-6">
    <h2 class="text-2xl font-bold mb-4">Agregar Grado</h2>

    <form action="{{ route('grados.store') }}" method="POST">
        @csrf
        <div class="flex flex-col gap-2 bg-white p-4 rounded shadow">
            <label for="nombre_grado">Nombre del grado:</label>
            <input type="text" name="nombre_grado" class="p-2 rounded border-2 border-white/1 border-b-cyan-500 focus:border-b-cyan-800 focus:ring-cyan-800" required>
        </div>

        <h3 class="mt-4 font-semibold">Materias disponibles:</h3>
        <div class="grid grid-cols-2 gap-2 bg-white p-4 rounded shadow">
            @foreach ($materias as $materia)
                <label>
                    <input type="checkbox" name="materias[]" value="{{ $materia->id }}">
                    {{ $materia->nombre_materia }}
                </label>
            @endforeach
        </div>

        <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">Crear</button>
        <a href="{{ route('grados.index') }}" class="px-4 py-2.5 bg-gray-600 text-white rounded">Volver</a>
    </form>

</div>
@endsection
