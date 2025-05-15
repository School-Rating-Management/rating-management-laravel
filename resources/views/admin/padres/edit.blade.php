@extends('layout.panel')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Editar Padre: {{ $padre->nombre }} {{ $padre->apellido }}</h1>

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

    <form action="{{ route('padres.update', $padre->id) }}" method="POST" class="bg-white p-6 rounded shadow-md">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Nombre</label>
            <input type="text" name="nombre" value="{{ old('nombre', $padre->nombre) }}" required
                class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" />
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Apellido</label>
            <input type="text" name="apellido" value="{{ old('apellido', $padre->apellido) }}" required
                class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" />
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
            <input type="email" name="correo" value="{{ old('correo', $padre->correo) }}" required
                class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" />
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Teléfono</label>
            <input type="text" name="telefono" value="{{ old('telefono', $padre->telefono) }}" required
                class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" />
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Contraseña (opcional)</label>
            <input type="password" name="password"
                class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" />
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Confirmar Contraseña</label>
            <input type="password" name="password_confirmation"
                class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" />
        </div>

        <div class="mb-6">
            <label class="inline-flex items-center">
                <input type="checkbox" name="activo" class="form-checkbox h-5 w-5 text-blue-600"
                    {{ !$padre->trashed() ? 'checked' : '' }}>
                <span class="ml-2 text-sm text-gray-700">Activo</span>
            </label>
        </div>

        <div class="flex items-center justify-between">
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg">
                Actualizar
            </button>
            <a href="{{ route('padres.index') }}"
                class="text-blue-600 hover:underline">
                Cancelar
            </a>
        </div>
    </form>

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
    <div class="mt-8">
        <h3 class="text-lg font-semibold mb-2">Asociar un Alumno Existente</h3>
        @if($alumnosDisponibles->count() <= 0)
            <p class="text-gray-600">No hay alumnos disponibles</p>
        @else
            <form action="{{ route('padres.alumnos.attach', $padre->id) }}" method="POST">
                @csrf
                <select name="alumno_id" class="mt-1 block w-full border-2 border-white/1 border-b-blue-500 focus:border-b-cyan-300 focus:outline-none">
                    <option value="">-- Selecciona un Alumno --</option>
                    @foreach($alumnosDisponibles as $alumno)
                        <option value="{{ $alumno->id }}">{{ $alumno->nombre }} {{ $alumno->apellido }}</option>
                    @endforeach
                </select>
                <button type="submit" class="mt-4 bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-lg">
                    Asociar Alumno
                </button>
            </form>
        @endif
    </div>
</div>
@endsection

