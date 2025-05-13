@extends('layout.panel')

@section('title', 'Grados')

@section('content')
@include('partials.alerts')

<div class="container mx-auto py-6">
    <h2 class="text-2xl font-bold mb-4">Grados {{ $status }}</h2>

    <div class="mb-4">
        <form action="{{ route('grados.index') }}" method="GET" class="flex items-center space-x-2">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Buscar grado"
                class="px-4 py-2 border rounded w-full"
            />
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-800">Buscar</button>
        </form>
    </div>

    <div class="mb-4 space-x-2">
        <a href="{{ route('grados.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded">Ver Activos</a>
        <a href="{{ route('grados.inactivos') }}" class="px-4 py-2 bg-gray-600 text-white rounded">Ver Inactivos</a>
        <a href="{{ route('grados.create') }}" class="px-4 py-2 bg-green-600 text-white rounded">Agregar Grado</a>
    </div>

    <div class="mb-4 bg-white/50 shadow rounded p-6">
        <ul class="divide-y">
            @forelse($grados as $grado)
            <li class="py-2 flex justify-between items-center">
                <span class="flex-1 text-blue-800 font-bold truncate">
                    {{ $grado->nombre_grado }}
                </span>
                <div class="flex items-center space-x-2 flex-shrink-0 ml-4">
                    @if ($grado->trashed())
                    <form action="{{ route('grados.restore', $grado->id) }}" method="POST" class="inline">
                        @csrf
                        <button class="text-green-600 hover:underline">♻️ Restaurar</button>
                    </form>
                    <form action="{{ route('grados.forceDelete', $grado->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar permanentemente este grado?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600 hover:underline">🗑️ Eliminar</button>
                    </form>
                    @else
                    <a href="{{ route('grados.edit', $grado->id) }}" class="text-blue-600 hover:underline">✏️ Editar</a>
                    <form action="{{ route('grados.destroy', $grado->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Desactivar este grado?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600 hover:underline">🗑️ Desactivar</button>
                    </form>
                    @endif
                </div>
            </li>
            @empty
            <li class="text-gray-500">No hay grados {{ $status }}.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection
