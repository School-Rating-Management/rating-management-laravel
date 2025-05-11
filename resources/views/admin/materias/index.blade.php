@extends('layout.panel')

@section('title', 'Materias')

@section('content')
@if(session('error'))
    <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 5000)"
        x-show="show"
        x-transition:leave="transition ease-in duration-500"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="mb-4 flex bg-red-100 border-l-8 border-red-500 text-red-700 px-4 py-3 rounded"
    >
        <!-- Contenido del mensaje -->
        <div class="flex-1 pl-4">
            <strong>¡Ups!</strong> {{ session('error') }}
        </div>
    </div>
@endif

@if(session('success'))
    <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 5000)"
        x-show="show"
        x-transition:leave="transition ease-in duration-500"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="mb-4 bg-green-200 border-l-8 border-green-500 text-green-700 px-4 py-3 rounded"
    >
        <!-- Contenido del mensaje -->
        <div class="flex-1 pl-4">
            <strong>¡Éxito!</strong> {{ session('success') }}
        </div>
    </div>
@endif
    {{-- Aquí solo va el contenido de materias sin sidebar --}}
    <h2 class="text-2xl font-bold mb-4">📘 Materias {{ $status }}</h2>

    <div class="mb-4 space-x-2">
        <a href="{{ route('materias.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded">Ver Activas</a>
        <a href="{{ route('materias.inactivas') }}" class="px-4 py-2 bg-gray-600 text-white rounded">Ver Inactivas</a>
        <a href="{{ route('materias.create') }}" class="px-4 py-2 bg-green-600 text-white rounded">Agregar Materia</a>
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
