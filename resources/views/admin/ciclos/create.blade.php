@extends('layout.panel')

@section('title', 'Agregar Ciclo')

@section('content')
<div class="container mx-auto py-6">
    <h2 class="text-2xl font-bold mb-4">Agregar Ciclo</h2>

    <form action="{{ route('ciclos.store') }}" method="POST" class="space-y-4 bg-white/50 p-6 rounded shadow">
        @csrf
        <div>
            <label class="block mb-1 font-semibold">Nombre del ciclo:</label>
            <input type="text" name="nombre" class="w-full border-2 border-white/1 border-b-cyan-500 rounded px-4 py-2" required>
        </div>
        <button class="px-4 py-2 bg-green-600 text-white rounded">Guardar</button>
        <a href="{{ route('ciclos.index') }}" class="px-4 py-2.5 bg-gray-600 text-white rounded">Volver</a>
    </form>
</div>
@endsection
