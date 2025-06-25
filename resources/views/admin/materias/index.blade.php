@extends('layout.panel')

@section('title', 'Materias')

@section('content')
@include('partials.alerts')
    <h2 class="text-2xl font-bold mb-4">Materias {{ $status }}</h2>

    <div class="mb-4">
        <form action="{{ route('materias.index') }}" method="GET" class="flex flex-col sm:flex-row sm:items-center sm:space-x-2 space-y-2 sm:space-y-0">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Buscar materia"
                class="px-4 py-2 border rounded w-full sm:w-auto flex-1"
            />
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-800 w-full sm:w-auto">Buscar</button>
        </form>
    </div>

    <div class="mb-4 space-x-2 flex flex-wrap">
        <a href="{{ route('materias.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded mb-2">Ver Activas</a>
        <a href="{{ route('materias.inactivas') }}" class="px-4 py-2 bg-gray-600 text-white rounded mb-2">Ver Inactivas</a>
        <a href="{{ route('materias.create') }}" class="px-4 py-2 bg-green-600 text-white rounded mb-2">Agregar Materia</a>
    </div>

    <div class="mb-4 bg-white/50 shadow rounded p-6">
        <ul class="divide-y">
            @forelse($materias as $materia)
                <li class="py-2 flex justify-between items-center">
                    <span class="font-bold">{{ $materia->nombre_materia }}</span>
                    <div class="space-x-2">
                        @if ($materia->trashed())
                            <form action="{{ route('materias.restore', $materia->id) }}" method="POST" class="inline">
                                @csrf
                                <button class="text-green-600 hover:underline">♻️ Restaurar</button>
                            </form>
                            <form action="{{ route('materias.forceDelete', $materia->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar permanentemente esta materia?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline">🗑️ Eliminar</button>
                            </form>
                        @else
                            <a href="{{ route('materias.edit', $materia->id) }}" class="text-blue-600 hover:underline">✏️ Editar</a>
                            <form action="{{ route('materias.destroy', $materia->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Desactivar esta materia?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline">🗑️ Desactivar</button>
                            </form>
                        @endif
                    </div>
                </li>
            @empty
                <li class="text-gray-500">No hay materias {{ $status }}.</li>
            @endforelse
        </ul>
    </div>
@endsection
