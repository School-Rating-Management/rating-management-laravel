@extends('layout.panel')

@section('title', 'Profesores')

@section('content')
@include('partials.alerts')

<div class="container mx-auto py-6">
    <h2 class="text-2xl font-bold mb-4">Alumnos {{ $status }}</h2>

    <div class="mb-4">
        <form action="{{ route('alumnos.index') }}" method="GET" class="flex flex-col sm:flex-row sm:items-center sm:space-x-2 space-y-2 sm:space-y-0">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Buscar por nombre, apellido, curp"
                class="px-4 py-2 border rounded w-full sm:w-auto flex-1"
            />
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-800 w-full sm:w-auto">Buscar</button>
        </form>
    </div>

    <div class="mb-4 space-x-2 flex flex-wrap">
        <a href="{{ route('alumnos.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded mb-2">Ver Activos</a>
        <a href="{{ route('alumnos.inactivos') }}" class="px-4 py-2 bg-gray-600 text-white rounded mb-2">Ver Inactivos</a>
        <a href="{{ route('alumnos.create') }}" class="px-4 py-2 bg-green-600 text-white rounded mb-2">Agregar Alumno</a>
    </div>

    {{-- <div class="mb-4"> --}}
        {{-- <form action="{{ route('alumnos.importar') }}" method="POST" enctype="multipart/form-data" class="flex flex-col sm:flex-row sm:items-center sm:space-x-2 space-y-2 sm:space-y-0">
            @csrf
            <input type="file" name="archivo" required class="border rounded p-2 w-full sm:w-auto">
            <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-800">📥 Importar Excel</button>
        </form> --}}
        {{-- a ref to view to importing --}}
        {{-- <a href="{{ route('alumnos.importar.form') }}" class="px-4 py-2 bg-purple-600 text-white rounded mb-2">
            📥 Importar Excel
        </a>
    </div> --}}



    <div class="mb-4 bg-white/50 shadow rounded p-6">

        <div class="hidden md:grid grid-cols-12 font-semibold text-gray-700 border-b pb-2 mb-2">
            <div class="col-span-5">Nombre</div>
            <div class="col-span-5">CURP</div>
            <div class="col-span-2 text-center">Acciones</div>
        </div>

        @forelse($alumnos as $alumno)
            <div class="flex flex-col md:grid md:grid-cols-12 items-start md:items-center py-4 border-b last:border-b-0 hover:bg-gray-100 transition px-2 gap-2 md:gap-0">
                <div class="md:col-span-5 w-full">
                    <span class="block text-sm font-semibold text-gray-500 md:hidden">Nombre</span>
                    <a href="{{ route('alumnos.show', $alumno) }}" class="text-blue-800 hover:underline truncate block">
                        {{ $alumno->nombre }} {{ $alumno->apellido }}
                    </a>
                </div>

                <div class="md:col-span-5 w-full">
                    <span class="block text-sm font-semibold text-gray-500 md:hidden">CURP</span>
                    <a href="{{ route('alumnos.show', $alumno) }}" class="text-gray-800 truncate block">
                        {{ $alumno->curp }}
                    </a>
                </div>

                <div class="md:col-span-2 w-full flex justify-start md:justify-center flex-wrap gap-2">
                    @if ($alumno->trashed())
                        <form action="{{ route('alumnos.restore', $alumno->id) }}" method="POST">
                            @csrf
                            <button class="text-green-600 hover:underline" title="Restaurar">♻️ Restaurar</button>
                        </form>
                        <form action="{{ route('alumnos.forceDelete', $alumno->id) }}" method="POST" onsubmit="return confirm('¿Eliminar permanentemente este profesor?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 hover:underline" title="Eliminar permanente">🗑️ Eliminar</button>
                        </form>
                    @else
                        <a href="{{ route('alumnos.edit', $alumno->id) }}" class="text-blue-600 hover:underline" title="Editar">✏️ Editar</a>
                        <form action="{{ route('alumnos.destroy', $alumno->id) }}" method="POST" onsubmit="return confirm('¿Desactivar este alumno?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 hover:underline" title="Desactivar">🗑️ Desactivar</button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-gray-500">No hay alumnos {{ $status }}.</p>
        @endforelse
    </div>
    <div class="mt-4 max-md:flex justify-center">
        {{ $alumnos->onEachSide(1)->links('vendor.pagination.tailwind') }}
    </div>
</div>
@endsection
