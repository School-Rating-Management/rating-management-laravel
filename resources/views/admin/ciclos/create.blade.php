@extends('layout.panel')

@section('title', 'Agregar Ciclo')

@section('content')
<div class="container mx-auto py-6">
    <h2 class="text-2xl font-bold mb-4">➕ Agregar Ciclo</h2>

    <form action="{{ route('ciclos.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block mb-1 font-semibold">Nombre del ciclo:</label>
            <input type="text" name="nombre" class="w-full border rounded px-4 py-2" required>
        </div>
        <button class="px-4 py-2 bg-green-600 text-white rounded">Guardar</button>
    </form>
</div>
@endsection
