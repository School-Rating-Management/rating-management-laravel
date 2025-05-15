@extends('layout.panel')
@section('title', 'Detalles del Padre o tutor')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Detalles del Padre</h1>

    <div class="bg-white rounded-lg shadow-md p-6 space-y-4">
        <div>
            <span class="font-semibold text-gray-700">Nombre:</span>
            <span>{{ $padre->nombre }}</span>
        </div>

        <div>
            <span class="font-semibold text-gray-700">Apellido:</span>
            <span>{{ $padre->apellido }}</span>
        </div>

        <div>
            <span class="font-semibold text-gray-700">Correo:</span>
            <span>{{ $padre->correo }}</span>
        </div>

        <div>
            <span class="font-semibold text-gray-700">Teléfono:</span>
            <span>{{ $padre->telefono }}</span>
        </div>

        <div>
            <span class="font-semibold text-gray-700">Usuario:</span>
            <span>{{ $padre->user->email ?? 'No asignado' }}</span>
        </div>

        <div>
            <span class="font-semibold text-gray-700">Estado:</span>
            @if ($padre->trashed())
                <span class="text-red-600 font-medium">Inactivo</span>
            @else
                <span class="text-green-600 font-medium">Activo</span>
            @endif
        </div>
    </div>

    <div class="mt-6 flex justify-between">
        <a href="{{ route('padres.index') }}"
            class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded shadow">
            Volver
        </a>

        <a href="{{ route('padres.edit', $padre->id) }}"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
            Editar
        </a>
    </div>

    {{-- Mostrar hijos asociados --}}
    <div class="mt-10">
        <h2 class="text-xl font-semibold mb-4">Hijos Asociados</h2>
        @if ($padre->alumnos && $padre->alumnos->count())
            <div class="overflow-x-auto">
                <table class="w-full table-auto bg-white rounded shadow-md">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="px-4 py-2">Nombre</th>
                            <th class="px-4 py-2">Apellido</th>
                            <th class="px-4 py-2">CURP</th>
                            <th class="px-4 py-2">Grupo</th>
                            <th class="px-4 py-2">Ciclo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($padre->alumnos as $alumno)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $alumno->nombre }}</td>
                                <td class="px-4 py-2">{{ $alumno->apellido }}</td>
                                <td class="px-4 py-2">{{ $alumno->curp }}</td>
                                <td class="px-4 py-2">{{ $alumno->grupo->nombre_grupo ?? 'N/A' }}</td>
                                <td class="px-4 py-2">{{ $alumno->ciclo->nombre ?? 'N/A' }}</td>
                            </tr>
                            <td class="px-4 py-2">
                                <form action="{{ route('padres.alumnos.detach', [$padre->id, $alumno->id]) }}" method="POST"
                                    onsubmit="return confirm('¿Estás seguro de quitar este hijo del padre?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                </form>
                            </td>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-600">Este padre no tiene hijos asociados actualmente.</p>
        @endif
    </div>
</div>
@endsection
