@extends('layout.panel')

@section('title', 'Profesores')

@section('content')
@include('partials.alerts')

<div class="container mx-auto py-6">
    <h2 class="text-2xl font-bold mb-4">Profesores {{ $status }}</h2>

    <div class="mb-4">
        <form action="{{ route('profesores.index') }}" method="GET" class="flex flex-col sm:flex-row sm:items-center sm:space-x-2 space-y-2 sm:space-y-0">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Buscar profesor por nombre o apellido"
                class="px-4 py-2 border rounded w-full sm:w-auto flex-1"
            />
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-800 w-full sm:w-auto">Buscar</button>
        </form>
    </div>

    <!-- Filtros -->
    <div class="mb-4 space-x-2 flex flex-wrap">
        <a href="{{ route('profesores.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded mb-2">Ver Activos</a>
        <a href="{{ route('profesores.inactivos') }}" class="px-4 py-2 bg-gray-600 text-white rounded mb-2">Ver Inactivos</a>
        <a href="{{ route('profesores.create') }}" class="px-4 py-2 bg-green-600 text-white rounded mb-2">Agregar Profesor</a>
    </div>

    <!-- Tabla Responsiva -->
    <div class="mb-4 bg-white/50 shadow rounded p-6">
        <div class="hidden md:grid grid-cols-12 font-semibold text-gray-700 border-b pb-2 mb-2">
            <div class="col-span-6">Nombre</div>
            <div class="col-span-2 text-center">Acciones</div>
        </div>

        @forelse($profesores as $profesor)
            <div class="flex flex-col md:grid md:grid-cols-12 items-start md:items-center py-4 border-b last:border-b-0 hover:bg-gray-100 transition px-2 gap-2 md:gap-0">
                <!-- Nombre -->
                <div class="md:col-span-6 w-full">
                    <span class="block text-sm font-semibold text-gray-500 md:hidden">Nombre</span>
                    <a href="{{ route('profesores.show', $profesor) }}" class="text-blue-800 hover:underline truncate block">
                        {{ $profesor->nombre }} {{ $profesor->apellido }}
                    </a>
                </div>

                <!-- Acciones -->
                <div class="md:col-span-2 w-full flex justify-start md:justify-center flex-wrap gap-2">
                    @if ($profesor->trashed())
                        <form action="{{ route('profesores.restore', $profesor->id) }}" method="POST">
                            @csrf
                            <button class="text-green-600 hover:underline" title="Restaurar">♻️ Restaurar</button>
                        </form>
                        <form action="{{ route('profesores.forceDelete', $profesor->id) }}" method="POST" onsubmit="return confirm('¿Eliminar permanentemente este profesor?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 hover:underline" title="Eliminar permanente">🗑️ Eliminar</button>
                        </form>
                    @else
                        <a href="{{ route('profesores.edit', $profesor->id) }}" class="text-blue-600 hover:underline" title="Editar">✏️ Editar</a>
                        <form action="{{ route('profesores.destroy', $profesor->id) }}" method="POST" onsubmit="return confirm('¿Desactivar este profesor?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 hover:underline" title="Desactivar">🗑️ Desactivar</button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-gray-500">No hay profesores {{ $status }}.</p>
        @endforelse
    </div>
    <div class="mt-4 max-md:flex justify-center">
        {{ $profesores->onEachSide(1)->links('vendor.pagination.tailwind') }}
    </div>
</div>
@endsection
