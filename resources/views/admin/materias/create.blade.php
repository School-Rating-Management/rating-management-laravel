@extends('layout.panel')

@section('title', 'Materias')

@section('content')


<div class="max-w-xl mx-auto mt-10 bg-white shadow p-6 rounded">
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

    <h2 class="text-xl font-bold mb-4">Agregar Materia</h2>

    <form action="{{ route('materias.store') }}" method="POST">
        @csrf

        <label class="block mb-2 font-semibold">Nombre de la materia:</label>
        <input type="text" name="nombre_materia" value="{{ old('nombre_materia') }}"
            class="w-full border-2 border-white border-b-blue-500 focus:outline-none focus:border-b-blue-800 p-2 rounded mb-4" required>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Guardar</button>
        <a href="{{ route('materias.index') }}" class="ml-4 text-gray-600">Cancelar</a>
    </form>
</div>
@endsection
