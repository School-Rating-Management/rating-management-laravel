@extends('layout.panel')

@section('title', 'Agregar Grado')

@section('content')
<div class="container mx-auto py-6">
    <h2 class="text-2xl font-bold mb-4">➕ Agregar Grado</h2>

    <form action="{{ route('grados.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block mb-1 font-semibold">Nombre del grado:</label>
            <input type="text" name="nombre_grado" class="w-full border rounded px-4 py-2" required>
        </div>
        <button class="px-4 py-2 bg-green-600 text-white rounded">Guardar</button>
    </form>
</div>
@endsection
