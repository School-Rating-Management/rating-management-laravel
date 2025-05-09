@extends('layout.app')

@section('title', 'Materias')

@section('content')

{{-- Sidebar --}}
<div x-data="{ sidebarOpen: false }" class="flex flex-col md:flex-row gap-4">
    {{-- Botón para responsive --}}
    <button @click="sidebarOpen = !sidebarOpen"
        class="md:hidden p-2 bg-blue-600 text-white rounded shadow w-max ml-auto">
        <span x-show="!sidebarOpen">📂 Ver Menú</span>
        <span x-show="sidebarOpen">❌ Cerrar</span>
    </button>

    {{-- Sidebar --}}
    <section x-show="sidebarOpen || window.innerWidth >= 768"
        @resize.window="sidebarOpen = window.innerWidth >= 768"
        class="w-full md:w-full bg-white/70 rounded shadow-md p-4 md:block"
        x-transition>
        <h3 class="text-lg font-semibold mb-4">🔧 Administración</h3>

        <ul class="space-y-2">
            <li><a href="{{ route('materias.index') }}" class="block text-blue-700 hover:underline">📘 Materias</a></li>
            <li><a href="{{ route('profesores.index') }}" class="block text-blue-700 hover:underline">👨‍🏫 Profesores</a></li>
            {{-- <li><a href="{{ route('ciclos.index') }}" class="block text-blue-700 hover:underline">📅 Ciclos</a></li> --}}
            {{-- <li><a href="{{ route('alumnos.index') }}" class="block text-blue-700 hover:underline">👨‍🎓 Alumnos</a></li> --}}
        </ul>
    </section>
</div>
{{-- Edit materia --}}
<div class="max-w-xl mx-auto mt-10 bg-white shadow p-6 rounded">
    <h2 class="text-xl font-bold mb-4">Editar Materia</h2>

    <form action="{{ route('materias.update', $materia->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label class="block mb-2 font-semibold">Nombre de la materia:</label>
        <input type="text" name="nombre_materia" value="{{ old('nombre_materia', $materia->nombre_materia) }}"
            class="w-full border p-2 rounded mb-4" required>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Guardar</button>
        <a href="{{ route('admin.panel') }}" class="ml-4 text-gray-600">Cancelar</a>
    </form>
</div>
@endsection
