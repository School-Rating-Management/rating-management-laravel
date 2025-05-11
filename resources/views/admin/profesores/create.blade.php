@extends('layout.panel')

@section('title', 'Agregar Profesor')

@section('content')
<div class="container mx-auto p-6">
    @if ($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <strong>Ups!</strong> Hubo algunos problemas con los datos ingresados.
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <h2 class="text-2xl font-bold mb-6">Crear Profesor</h2>

    <form action="{{ route('profesores.store') }}" method="POST" class="bg-white p-6 rounded shadow-md">
        @csrf

        <h3 class="text-lg font-semibold mb-4">Información del Profesor</h3>

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}"
                   class="mt-1 block w-full border-2 border-white border-b-blue-500 rounded shadow-sm focus:border-b-blue-800 focus:outline-none" required>
        </div>

        <div class="mb-4">
            <label for="apellido" class="block text-sm font-medium text-gray-700">Apellido</label>
            <input type="text" name="apellido" id="apellido" value="{{ old('apellido') }}"
                   class="mt-1 block w-full  border-2 border-white border-b-blue-500 rounded shadow-sm focus:border-b-blue-800 focus:outline-none" required>
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}"
                   class="mt-1 block w-full border-2 border-white border-b-blue-500 rounded shadow-sm focus:border-b-blue-800 focus:outline-none" required>
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
            <input type="password" name="password" id="password"
                   class="mt-1 block w-full border-2 border-white border-b-blue-500 rounded shadow-sm focus:border-b-blue-800 focus:outline-none" required>
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar contraseña</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                   class="mt-1 block w-full border-2 border-white border-b-blue-500 rounded shadow-sm focus:border-b-blue-800 focus:outline-none" required>
        </div>

        <div class="mb-6">
            <label for="grupo_id" class="block text-sm font-medium text-gray-700">Asignar Grupo (opcional)</label>
            @if($gruposDisponibles->isEmpty())
                <p class="text-slate-500 italic mt-2">No hay grupos disponibles para asignar.</p>
            @else
                <select name="grupo_id" id="grupo_id" class="mt-1 block w-full border-2 border-white border-b-blue-500 rounded shadow-sm focus:border-b-blue-800 focus:outline-none">
                    <option value="">-- Selecciona un grupo --</option>
                    @foreach($gruposDisponibles as $grupo)
                        <option value="{{ $grupo->id }}" {{ old('grupo_id') == $grupo->id ? 'selected' : '' }}>
                            {{ $grupo->nombre_grupo }}
                        </option>
                    @endforeach
                </select>

            @endif
        </div>

        <div class="flex items-center justify-between">
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
            Guardar Profesor
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
