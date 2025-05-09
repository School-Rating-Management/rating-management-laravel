@extends('layout.app')

@section('title', 'Panel Administrativo')

@section('content')
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
            <li><a href="{{ route('ciclos.index') }}" class="block text-blue-700 hover:underline">📅 Ciclos</a></li>
            {{-- <li><a href="{{ route('alumnos.index') }}" class="block text-blue-700 hover:underline">👨‍🎓 Alumnos</a></li> --}}
        </ul>

    </section>


</div>
@endsection
