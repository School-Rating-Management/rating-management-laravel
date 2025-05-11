@extends('layout.panel')

@section('title', 'Profesores')

@section('content')

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="container mx-auto py-6">
    <h2 class="text-2xl font-bold mb-4">👨‍🏫 Profesores {{ $status }}</h2>

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
                    {{ $profesor->nombre }}
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
