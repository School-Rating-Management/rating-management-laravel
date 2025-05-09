@extends('layout.app')

@section('title', 'Agregar Profesor')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-6">Crear Profesor</h2>

    <form action="{{ route('profesores.store') }}" method="POST" class="bg-white p-6 rounded shadow-md">
        @csrf

        <h3 class="text-lg font-semibold mb-4">Información de Usuario</h3>

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Nombre de usuario</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}"
                   class="mt-1 block w-full border-gray-300 rounded shadow-sm" required>
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}"
                   class="mt-1 block w-full border-gray-300 rounded shadow-sm" required>
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
            <input type="password" name="password" id="password"
                   class="mt-1 block w-full border-gray-300 rounded shadow-sm" required>
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar contraseña</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                   class="mt-1 block w-full border-gray-300 rounded shadow-sm" required>
        </div>

        <h3 class="text-lg font-semibold mt-8 mb-4">Información del Profesor</h3>

        <div class="mb-4">
            <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
            <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}"
                   class="mt-1 block w-full border-gray-300 rounded shadow-sm" required>
        </div>

        <div class="mb-4">
            <label for="apellido" class="block text-sm font-medium text-gray-700">Apellido</label>
            <input type="text" name="apellido" id="apellido" value="{{ old('apellido') }}"
                   class="mt-1 block w-full border-gray-300 rounded shadow-sm" required>
        </div>

        <div class="mb-6">
            <label for="grupo_id" class="block text-sm font-medium text-gray-700">Asignar Grupo (opcional)</label>
            @if($gruposDisponibles->isEmpty())
                <p class="text-red-500 mt-2">No hay grupos disponibles para asignar.</p>
            @else
                <select name="grupo_id" id="grupo_id" class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                    <option value="">-- Selecciona un grupo --</option>
                    @foreach($gruposDisponibles as $grupo)
                        <option value="{{ $grupo->id }}">{{ $grupo->nombre_grupo }}</option>
                    @endforeach
                </select>
            @endif
        </div>

        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
            Guardar Profesor
        </button>
    </form>
</div>
@endsection
