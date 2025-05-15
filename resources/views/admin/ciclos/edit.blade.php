@extends('layout.panel')

@section('title', 'Editar Ciclo')

@section('content')
<div class="container mx-auto py-6">
    <h2 class="text-2xl font-bold mb-4">✏️ Editar Ciclo</h2>

    <form action="{{ route('ciclos.update', $ciclo) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label class="block mb-1 font-semibold">Nombre del ciclo:</label>
            <input type="text" name="nombre" value="{{ $ciclo->nombre }}" class="w-full border rounded px-4 py-2" required>
        </div>
        <button class="px-4 py-2 bg-blue-600 text-white rounded">Actualizar</button>
    </form>
</div>
@endsection
