@extends('layout.panel')

@section('title', 'Editar Profesor')

@section('content')
<div class="container mx-auto py-6">
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

    <h2 class="text-2xl font-bold mb-4">✏️ Editar Profesor</h2>


    <form action="{{ route('profesores.update', $profesor->id) }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="nombre">
                Nombre
            </label>
            <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $profesor->nombre) }}"
                class="shadow appearance-none border-2 border-white border-b-blue-500 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-b-blue-800 focus:shadow-outline">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="apellido">
                Apellido
            </label>
            <input type="text" name="apellido" id="apellido" value="{{ old('apellido', $profesor->apellido) }}"
                class="shadow appearance-none border-2 border-white border-b-blue-500 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-b-blue-800 focus:shadow-outline">
        </div>



        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="grupo_id">
                Grupo Asignado
            </label>

            @if ($profesor->grupo)
                <p class="mb-2">Grupo actual: <strong>{{ $profesor->grupo->nombre_grupo }}</strong></p>

                {{-- Mostrar select con opción para quitar grupo, aunque no haya grupos disponibles --}}
                <select name="grupo_id" id="grupo_id"
                    class="block appearance-none w-full border-2 border-white border-b-blue-500 hover:border-b-blue-800 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline focus:border-b-blue-800">
                    <option value="">-- Quitar Grupo --</option>
                    @foreach ($gruposDisponibles as $grupo)
                        <option value="{{ $grupo->id }}"
                            {{ old('grupo_id', optional($profesor->grupo)->id) == $grupo->id ? 'selected' : '' }}>
                            {{ $grupo->nombre }}
                        </option>
                    @endforeach
                </select>
            @elseif ($gruposDisponibles->count() > 0)
                {{-- Mostrar select solo si hay grupos disponibles y el profesor no tiene grupo --}}
                <select name="grupo_id" id="grupo_id"
                    class="block appearance-none w-full border-2 border-white border-b-blue-500 hover:border-b-blue-800 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline focus:border-b-blue-800">
                    <option value="">-- Selecciona un grupo --</option>
                    @foreach ($gruposDisponibles as $grupo)
                       <option value="{{ $grupo->id }}"
                            {{ old('grupo_id') == $grupo->id ? 'selected' : '' }}>
                    @endforeach
                </select>
            @else
                <p class="text-gray-600 italic">No hay grupos disponibles para asignar.</p>
            @endif

        </div>

        <div class="mb-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="activo" class="form-checkbox"
                    {{ old('activo', is_null($profesor->deleted_at)) ? 'checked' : '' }}>
                <span class="ml-2">Profesor activo</span>
            </label>
        </div>


        <div class="flex items-center justify-between">
            <button type="submit"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Guardar Cambios
            </button>
            <a href="{{ route('profesores.index') }}"
                class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                Cancelar
            </a>
        </div>
    </form>
    <div class="mt-4 space-x-2">
        <a href="{{ route('profesores.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded">Volver</a>
    </div>
</div>
@endsection
