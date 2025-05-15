@extends('layout.panel')

@section('title', 'Editar Grupo')

@section('content')
@include('partials.alerts')

<div class="container mx-auto py-6">
    <h2 class="text-2xl font-bold mb-4">Editar Alumno</h2>

    <form action="{{ route('alumnos.update', $alumno) }}" method="POST" class="space-y-4 bg-white/50 p-6 rounded shadow">
        @csrf
        @method('PUT')

        <div>
            <label for="nombre" class="block font-semibold">Nombre del Alumno</label>
            <input type="text" name="nombre" id="nombre_grupo"
                   value="{{ old('nombre', $alumno->nombre) }}"
                   class="w-full px-4 py-2 border rounded" required>
        </div>
        <div>
            <label for="apellido" class="block font-semibold">Apellido del Alumno</label>
            <input type="text" name="apellido" id="apellido"
                   value="{{ old('apellido', $alumno->apellido) }}"
                   class="w-full px-4 py-2 border rounded" required>
        </div>
        <div>
            <label for="curp" class="block font-semibold">Curp del Alumno</label>
            <input type="text" name="curp" id="curp"
                   value="{{ old('curp', $alumno->curp) }}"
                   class="w-full px-4 py-2 border rounded" required>
        </div>

        <div>
            <label for="grupo_id" class="block font-semibold">Grupo (opcional)</label>
            <select name="grupo_id" id="grupo_id" class="w-full px-4 py-2 border rounded">
                <option value="">-- Sin grupo --</option>
                @foreach($gruposDisponibles as $grupo)
                    <option value="{{ $grupo->id }}" {{ $alumno->grupo_id == $grupo->id ? 'selected' : '' }}>
                        {{ $grupo->nombre_grupo }}- {{ $grupo->grados->nombre_grado ?? 'Sin grado'}}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="ciclo_id" class="block font-semibold">Ciclo Escolar (opcional)</label>
            <select name="ciclo_id" id="ciclo_id" class="w-full px-4 py-2 border rounded">
                <option value="">-- Sin ciclo --</option>
                @foreach($ciclosDisponibles as $ciclo)
                    <option value="{{ $ciclo->id }}" {{ $alumno->ciclo_id == $ciclo->id ? 'selected' : '' }}>
                        {{ $ciclo->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="padre_id" class="block text-sm font-medium text-gray-700">Padre (opcional)</label>
            <input
                type="text"
                id="buscar_padre"
                placeholder="Buscar por nombre o apellido"
                class="mt-1 block w-full border-2 border-white border-b-blue-500 focus:border-b-cyan-300 focus:outline-none"
            >
            <select name="padre_id" id="padre_id"
                class="mt-2 block w-full border-2 border-white border-b-blue-500 rounded shadow-sm focus:border-b-blue-800 focus:outline-none">
                <option value="">-- Sin padre --</option>
                @foreach($padres as $padre)
                    <option value="{{ $padre->id }}"
                        {{ old('padre_id', isset($alumno) ? $alumno->padre_id : '') == $padre->id ? 'selected' : '' }}>
                        {{ $padre->nombre }} {{ $padre->apellido }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex justify-end">
            <a href="{{ route('alumnos.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded mr-2">Cancelar</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-800">Actualizar</button>
        </div>
    </form>
</div>
@endsection
