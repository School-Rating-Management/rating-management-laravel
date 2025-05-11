@extends('layout.panel')

@section('title', 'Profesores')

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

<div class="container mx-auto py-6">
    <h2 class="text-2xl font-bold mb-4">👨‍🏫 Profesores {{ $status }}</h2>

    <!-- Formulario de búsqueda -->
    <div class="mb-4">
        <form action="{{ route('profesores.index') }}" method="GET"
        class="flex items-center space-x-2">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Buscar por nombre o apellido"
                class="px-4 py-2 border rounded w-full"
            />
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-800">Buscar</button>
        </form>
    </div>

    <div class="mb-4 space-x-2">
        <a href="{{ route('profesores.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded">Ver Activos</a>
        <a href="{{ route('profesores.inactivos') }}" class="px-4 py-2 bg-gray-600 text-white rounded">Ver Inactivos</a>
        <a href="{{ route('profesores.create') }}" class="px-4 py-2 bg-green-600 text-white rounded">Agregar Profesor</a>
    </div>

    <div class="mb-4 bg-white/50 shadow rounded p-6">
        <ul class="divide-y">
            @forelse($profesores as $profesor)
            <li class="py-2 flex justify-between items-center">
                <a href="{{ route('profesores.show', $profesor->id) }}"
                class="flex-1 text-blue-800 font-bold hover:underline truncate">
                    {{ $profesor->nombre }} {{ $profesor->apellido }}
                </a>
                <div class="flex items-center space-x-2 flex-shrink-0 ml-4">
                    @if ($profesor->trashed())
                    <form action="{{ route('profesores.restore', $profesor->id) }}" method="POST" class="inline">
                        @csrf
                        <button class="text-green-600 hover:underline">♻️ Restaurar</button>
                    </form>
                    <form action="{{ route('profesores.forceDelete', $profesor->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar permanentemente este profesor?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600 hover:underline">🗑️ Eliminar</button>
                    </form>
                    @else
                    <a href="{{ route('profesores.edit', $profesor->id) }}" class="text-blue-600 hover:underline">✏️ Editar</a>
                    <form action="{{ route('profesores.destroy', $profesor->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Desactivar este profesor?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600 hover:underline">🗑️ Desactivar</button>
                    </form>
                    @endif
                </div>
            </li>
            @empty
            <li class="text-gray-500">No hay profesores {{ $status }}.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection
