@extends('layout.panel')

@section('title', 'Ciclo')

@section('content')
@include('partials.alerts')

<div class="container mx-auto py-6">
    <h2 class="text-2xl font-bold mb-4">Ciclos {{ $status }}</h2>

    <div class="mb-4">
        <form action="{{ route('ciclos.index') }}" method="GET" class="flex flex-col sm:flex-row sm:items-center sm:space-x-2 space-y-2 sm:space-y-0">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Buscar ciclo"
                class="px-4 py-2 border rounded w-full sm:w-auto flex-1"
            />
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-800 w-full sm:w-auto">Buscar</button>
        </form>
    </div>

    <div class="mb-4 space-x-2 flex flex-wrap">
        <a href="{{ route('ciclos.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded mb-2">Ver Activos</a>
        <a href="{{ route('ciclos.inactivos') }}" class="px-4 py-2 bg-gray-600 text-white rounded mb-2">Ver Inactivos</a>
        <a href="{{ route('ciclos.create') }}" class="px-4 py-2 bg-green-600 text-white rounded mb-2">Agregar Ciclo</a>
    </div>

    <div class="mb-4 bg-white/50 shadow rounded p-6">
        <ul class="divide-y">
            @forelse($ciclos as $ciclo)
            <li class="py-2 flex justify-between items-center">
                <span class="flex-1 text-blue-800 font-bold truncate">
                    {{ $ciclo->nombre }}
                </span>
                <div class="flex items-center space-x-2 flex-shrink-0 ml-4">
                    @if ($ciclo->trashed())
                    <form action="{{ route('ciclos.restore', $ciclo->id) }}" method="POST" class="inline">
                        @csrf
                        <button class="text-green-600 hover:underline">♻️ Restaurar</button>
                    </form>
                    <form action="{{ route('ciclos.forceDelete', $ciclo->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar permanentemente este grado?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600 hover:underline">🗑️ Eliminar</button>
                    </form>
                    @else
                    <a href="{{ route('ciclos.edit', $ciclo->id) }}" class="text-blue-600 hover:underline">✏️ Editar</a>
                    <form action="{{ route('ciclos.destroy', $ciclo->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Desactivar este grado?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600 hover:underline">🗑️ Desactivar</button>
                    </form>
                    @endif
                </div>
            </li>
            @empty
            <li class="text-gray-500">No hay ciclo {{ $status }}.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection
