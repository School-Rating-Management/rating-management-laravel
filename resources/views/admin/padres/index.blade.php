@extends('layout.panel')

@section('content')
@include('partials.alerts')

<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4">Lista de Padres {{ $status }}</h1>

    <div class="mb-4">
        <form action="{{ route('padres.index') }}" method="GET" class="flex flex-col sm:flex-row sm:items-center sm:space-x-2 space-y-2 sm:space-y-0">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Buscar por nombre, apellido"
                class="px-4 py-2 border rounded w-full sm:w-auto flex-1"
            />
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-800 w-full sm:w-auto">Buscar</button>
        </form>
    </div>

    <div class="mb-4 space-x-2 flex flex-wrap">
        <a href="{{ route('padres.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded mb-2">Ver Activos</a>
        <a href="{{ route('padres.inactivos') }}" class="px-4 py-2 bg-gray-600 text-white rounded mb-2">Ver Inactivos</a>
        <a href="{{ route('padres.create') }}" class="px-4 py-2 bg-green-600 text-white rounded mb-2">Agregar padre</a>
    </div>

    <div class="mb-4 bg-white/50 shadow rounded p-6">
        <div class="hidden md:grid grid-cols-12 font-semibold text-gray-700 border-b pb-2 mb-2">
            <div class="col-span-2">Nombre</div>
            <div class="col-span-2">Apellido</div>
            <div class="col-span-3">Correo</div>
            <div class="col-span-2 md:hidden">Teléfono</div>
            <div class="col-span-1">Estado</div>
            <div class="col-span-2 text-center">Acciones</div>
        </div>

        @forelse($padres as $padre)
            <div class="flex flex-col md:grid md:grid-cols-12 items-start md:items-center py-4 border-b last:border-b-0 hover:bg-gray-100 transition px-2 gap-2 md:gap-0">
                <div class="md:col-span-2 w-full">
                    <span class="block text-sm font-semibold text-gray-500 md:hidden">Nombre</span>
                    <a href="{{ route('padres.show', $padre->id) }}" class="text-blue-800 hover:underline truncate block">
                        {{ $padre->nombre }}
                    </a>
                </div>
                <div class="md:col-span-2 w-full">
                    <span class="block text-sm font-semibold text-gray-500 md:hidden">Apellido</span>
                    <span class="block truncate">{{ $padre->apellido }}</span>
                </div>
                <div class="md:col-span-3 w-full">
                    <span class="block text-sm font-semibold text-gray-500 md:hidden">Correo</span>
                    <span class="block truncate">{{ $padre->correo }}</span>
                </div>
                <div class="md:col-span-2 w-full md:hidden">
                    <span class="block text-sm font-semibold text-gray-500 md:hidden">Teléfono</span>
                    <span class="block truncate">{{ $padre->telefono ?? '-' }}</span>
                </div>
                <div class="md:col-span-1 w-full">
                    <span class="block text-sm font-semibold text-gray-500 md:hidden">Estado</span>
                    @if ($padre->deleted_at)
                        <span class="text-red-500 font-semibold">Inactivo</span>
                    @else
                        <span class="text-green-500 font-semibold">Activo</span>
                    @endif
                </div>
                <div class="md:col-span-2 w-full flex justify-start md:justify-center flex-wrap gap-2">
                    <a href="{{ route('padres.edit', $padre->id) }}" class="text-blue-600 hover:underline" title="Editar">✏️ Editar</a>

                    @if ($padre->deleted_at)
                        <form action="{{ route('padres.restore', $padre->id) }}" method="POST">
                            @csrf
                            <button class="text-green-600 hover:underline" title="Activar">♻️ Activar</button>
                        </form>
                        <form action="{{ route('padres.forceDelete', $padre->id) }}" method="POST" onsubmit="return confirm('¿Eliminar permanentemente este padre?');">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 hover:underline" title="Eliminar permanente">🗑️ Eliminar</button>
                        </form>
                    @else
                        <form action="{{ route('padres.destroy', $padre->id) }}" method="POST" onsubmit="return confirm('¿Desactivar este padre?');">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 hover:underline" title="Desactivar">🗑️ Desactivar</button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-gray-500">No hay padres {{ $status }}.</p>
        @endforelse
    </div>

    <div class="mt-4 max-md:flex justify-center">
        {{ $padres->onEachSide(1)->links('vendor.pagination.tailwind') }}
    </div>
</div>
@endsection
