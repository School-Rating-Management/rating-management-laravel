@extends('layout.app')

@section('title', 'Profesores')

@section('content')

{{-- Sidebar --}}
<div x-data="{ sidebarOpen: false }" class="flex flex-col md:flex-row gap-4">
    {{-- Botón para responsive --}}
    <button @click="sidebarOpen = !sidebarOpen"
        class="md:hidden p-2 bg-blue-600 text-white rounded shadow w-max ml-auto">
        <span x-show="!sidebarOpen">📂 Ver Menú</span>
        <span x-show="sidebarOpen">❌ Cerrar</span>
    </button>

    {{-- Sidebar --}}
    <section x-show="sidebarOpen || window.innerWidth >= 768"
        @resize.window="sidebarOpen = window.innerWidth >= 768"
        class="w-full md:w-full bg-white/70 rounded shadow-md p-4 md:block"
        x-transition>
        <h3 class="text-lg font-semibold mb-4">🔧 Administración</h3>

        <ul class="space-y-2">
            <li><a href="{{ route('materias.index') }}" class="block text-blue-700 hover:underline">📘 Materias</a></li>
            <li><a href="{{ route('profesores.index') }}" class="block text-blue-700 hover:underline">👨‍🏫 Profesores</a></li>
            {{-- <li><a href="{{ route('ciclos.index') }}" class="block text-blue-700 hover:underline">📅 Ciclos</a></li> --}}
            {{-- <li><a href="{{ route('alumnos.index') }}" class="block text-blue-700 hover:underline">👨‍🎓 Alumnos</a></li> --}}
        </ul>
    </section>
</div>

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
                <a href="{{ route('profesores.show', $profesor->id) }}" class="text-blue-800 font-bold hover:underline">
                    {{ $profesor->nombre }}
                </a>
                <div class="space-x-2">
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
