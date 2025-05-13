@extends('layout.panel')

@section('title', 'Editar Grado')

@section('content')
<div class="container mx-auto py-6">
    <h2 class="text-2xl font-bold mb-4">✏️ Editar Grado</h2>

    <form action="{{ route('grados.update', $grado) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label class="block mb-1 font-semibold">Nombre del grado:</label>
            <input type="text" name="nombre_grado" value="{{ $grado->nombre_grado }}" class="w-full border rounded px-4 py-2" required>
        </div>
        <button class="px-4 py-2 bg-blue-600 text-white rounded">Actualizar</button>
    </form>
</div>
@endsection
