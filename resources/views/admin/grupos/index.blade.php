@extends('layout.panel')

@section('title', 'Grupos')

@section('content')
@include('partials.alerts')

<div class="container mx-auto py-6 px-4">
    <h2 class="text-2xl font-bold mb-4">Grupos {{ $status ?? '' }}</h2>

    <div class="mb-4">
        <form action="{{ route('grupos.index') }}" method="GET" class="flex flex-col sm:flex-row sm:items-center sm:space-x-2 space-y-2 sm:space-y-0">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Buscar grupo"
                class="px-4 py-2 border rounded w-full sm:w-auto flex-1"
            />
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-800 w-full sm:w-auto">Buscar</button>
        </form>
    </div>

    <div class="mb-4 flex flex-wrap gap-2">
        <a href="{{ route('grupos.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded">Ver Activos</a>
        <a href="{{ route('grupos.inactivas') }}" class="px-4 py-2 bg-gray-600 text-white rounded">Ver Inactivos</a>
        <a href="{{ route('grupos.create') }}" class="px-4 py-2 bg-green-600 text-white rounded">Agregar Grupo</a>
    </div>


    <div class="bg-white/50 shadow rounded p-4 overflow-x-auto hidden lg:block">
        <table class="min-w-full table-auto text-sm">
            <thead>
                <tr class="text-left font-semibold text-gray-700 border-b">
                    <th class="px-4 py-2">Nombre</th>
                    <th class="px-4 py-2">Profesor</th>
                    <th class="px-4 py-2">Grado</th>
                    <th class="px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-300">
                @forelse($grupos as $grupo)
                <tr class="hover:bg-gray-100 transition cursor-pointer" onclick="window.location='{{ route('grupos.show', $grupo) }}'">
                    <td class="px-4 py-2 text-blue-900 font-semibold truncate">{{ $grupo->nombre_grupo }}</td>
                    <td class="px-4 py-2 truncate">
                        {{ $grupo->profesor ? $grupo->profesor->nombre . ' ' . $grupo->profesor->apellido : 'Sin profesor' }}
                    </td>
                    <td class="px-4 py-2 truncate">{{ $grupo->grados->nombre_grado }}</td>
                    <td class="px-4 py-2" onclick="event.stopPropagation()">
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('grupos.edit', $grupo) }}" class="text-yellow-600 hover:underline">✏️ Editar</a>

                            @if($grupo->trashed())
                                <form action="{{ route('grupos.restore', $grupo) }}" method="POST">
                                    @csrf
                                    <button class="text-green-600 hover:underline">♻️ Restaurar</button>
                                </form>
                                <form action="{{ route('grupos.forceDelete', $grupo) }}" method="POST" onsubmit="return confirm('¿Eliminar permanentemente este grupo?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline">🗑️ Eliminar</button>
                                </form>
                            @else
                                <form action="{{ route('grupos.destroy', $grupo) }}" method="POST" onsubmit="return confirm('¿Desactivar este grupo?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline">🗑️ Desactivar</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-gray-500 py-4">No hay grupos {{ $status ?? '' }}.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="lg:hidden space-y-4">
        @forelse($grupos as $grupo)
        <div onclick="window.location='{{ route('grupos.show', $grupo) }}'" class="bg-white/70 shadow rounded p-4 space-y-2 cursor-pointer hover:bg-gray-100">
            <p><span class="font-semibold text-gray-700">Nombre:</span> <span class="text-blue-900">{{ $grupo->nombre_grupo }}</span></p>
            <p><span class="font-semibold text-gray-700">Profesor:</span> {{ $grupo->profesor ? $grupo->profesor->nombre . ' ' . $grupo->profesor->apellido : 'Sin profesor' }}</p>
            <p><span class="font-semibold text-gray-700">Grado:</span> {{ $grupo->grados->nombre_grado }}</p>
            <div class="flex flex-wrap gap-3 pt-2" onclick="event.stopPropagation()">
                <a href="{{ route('grupos.edit', $grupo) }}" class="text-yellow-600 hover:underline">✏️ Editar</a>

                @if($grupo->trashed())
                    <form action="{{ route('grupos.restore', $grupo) }}" method="POST">
                        @csrf
                        <button class="text-green-600 hover:underline">♻️ Restaurar</button>
                    </form>
                    <form action="{{ route('grupos.forceDelete', $grupo) }}" method="POST" onsubmit="return confirm('¿Eliminar permanentemente este grupo?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600 hover:underline">🗑️ Eliminar</button>
                    </form>
                @else
                    <form action="{{ route('grupos.destroy', $grupo) }}" method="POST" onsubmit="return confirm('¿Desactivar este grupo?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600 hover:underline">🗑️ Desactivar</button>
                    </form>
                @endif
            </div>
        </div>
        @empty
        <p class="text-center text-gray-500">No hay grupos {{ $status ?? '' }}.</p>
        @endforelse
    </div>

    <div class="mt-4 max-md:flex justify-center">
        {{ $grupos->onEachSide(1)->links('vendor.pagination.tailwind') }}
    </div>
</div>
@endsection
