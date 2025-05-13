@extends('layout.panel')

@section('title', 'Grupos')

@section('content')
@include('partials.alerts')

<div class="container mx-auto py-6">
    <h2 class="text-2xl font-bold mb-4">Grupos {{ $status ?? '' }}</h2>

    <div class="mb-4">
        <form action="{{ route('grupos.index') }}" method="GET" class="flex items-center space-x-2">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Buscar grupo"
                class="px-4 py-2 border rounded w-full"
            />
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-800">Buscar</button>
        </form>
    </div>

    <div class="mb-4 space-x-2">
        <a href="{{ route('grupos.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded">Ver Activos</a>
        <a href="{{ route('grupos.inactivas') }}" class="px-4 py-2 bg-gray-600 text-white rounded">Ver Inactivos</a>
        <a href="{{ route('grupos.create') }}" class="px-4 py-2 bg-green-600 text-white rounded">Agregar Grupo</a>
    </div>

    <div class="bg-white/50 shadow rounded p-6 overflow-x-auto">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-200 text-left text-sm font-semibold text-gray-700">
                    <th class="px-4 py-2">Nombre</th>
                    <th class="px-4 py-2">Profesor</th>
                    <th class="px-4 py-2">Grado</th>
                    <th class="px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-400">
                @forelse($grupos as $grupo)
                <tr
                    x-data
                    @click="window.location='{{ route('grupos.show', $grupo) }}'"
                    class="hover:bg-gray-100 cursor-pointer"
                >
                    <td class="px-4 py-2 text-blue-900 font-semibold">{{ $grupo->nombre_grupo }}</td>
                    <td class="px-4 py-2">
                        {{ $grupo->profesor ? $grupo->profesor->nombre . ' ' . $grupo->profesor->apellido : 'Sin profesor' }}
                    </td>
                    <td class="px-4 py-2">{{ $grupo->grados->nombre_grado }}</td>
                    <td
                        class="px-4 py-2 flex flex-wrap gap-2"
                        @click.stop
                    >
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
</div>
@endsection
