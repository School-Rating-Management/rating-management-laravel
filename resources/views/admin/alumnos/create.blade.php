@extends('layout.panel')

@section('title', 'Agregar Alumno')

@section('content')
<div class="container mx-auto p-6">
    @if ($errors->any())
        <div
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 5000)"
            x-show="show"
            x-transition:leave="transition ease-in duration-500"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded"
        >
            <strong>Ups!</strong> Hubo algunos problemas con los datos ingresados.
            <ul class="mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <h2 class="text-2xl font-bold mb-6">Crear Alumno</h2>

    <form action="{{ route('alumnos.store') }}" method="POST" class="bg-white p-6 rounded shadow-md">
        @csrf

        <h3 class="text-lg font-semibold mb-4">Información del Alumno</h3>

        <div class="mb-4">
            <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
            <input type="text" name="nombre" id="name" value="{{ old('nombre') }}"
                   class="mt-1 block w-full border-2 border-white border-b-blue-500 focus:border-b-cyan-300 focus:outline-none" required>
        </div>

        <div class="mb-4">
            <label for="apellido" class="block text-sm font-medium text-gray-700">Apellido</label>
            <input type="text" name="apellido" id="apellido" value="{{ old('apellido') }}"
                   class="mt-1 block w-full  border-2 border-white border-b-blue-500 focus:border-b-cyan-300 focus:outline-none" required>
        </div>

        <div class="mb-4">
            <label for="curp" class="block text-sm font-medium text-gray-700">Curp</label>
            <input type="text" name="curp" id="curp" value="{{ old('curp') }}"
                   class="mt-1 block w-full border-2 border-white border-b-blue-500 focus:border-b-cyan-300 focus:outline-none" required>
        </div>

        <div class="mb-6">
            <label for="grupo_id" class="block text-sm font-medium text-gray-700">Grupo (opcional)</label>
            <select name="grupo_id" id="grupo_id" class="mt-1 block w-full border-2 border-white border-b-blue-500 rounded shadow-sm focus:border-b-blue-800 focus:outline-none">
                <option value="">-- Sin grupo --</option>
                @foreach($gruposDisponibles as $grupo)
                    <option value="{{ $grupo->id }}" {{ old('grupo_id') == $grupo->id ? 'selected' : '' }}>
                        {{ $grupo->nombre_grupo }}- {{ $grupo->grados->nombre_grado ?? 'Sin grado'}}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-6">
            <label for="ciclo_id" class="block text-sm font-medium text-gray-700">Ciclo Escolar (opcional)</label>
            <select name="ciclo_id" id="ciclo_id" class="mt-1 block w-full border-2 border-white border-b-blue-500 rounded shadow-sm focus:border-b-blue-800 focus:outline-none">
                <option value="">-- Sin ciclo --</option>
                @foreach($ciclosDisponibles as $ciclo)
                    <option value="{{ $ciclo->id }}" {{ old('ciclo_id') == $ciclo->id ? 'selected' : '' }}>
                        {{ $ciclo->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Buscar padre</label>
            @livewire('buscar_padre')
        </div> --}}

        {{-- Añadir el campo del padre, que tenga un input que haga
        bsuqueda por nombre o apellido y despligue una lista de los padres con la coincidencia --}}

        <div class="flex items-center justify-between">
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
            Guardar Alumno
        </button>
        <a href="{{ route('alumnos.index') }}"
                class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                Cancelar
        </a>
        </div>
    </form>
    <div class="mt-4 space-x-2">
        <a href="{{ route('alumnos.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded">Volver</a>
    </div>
</div>
@endsection
