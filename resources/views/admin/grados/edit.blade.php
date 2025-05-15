@extends('layout.panel')

@section('title', 'Editar Grado')

@section('content')
<div class="container mx-auto py-6">
    <h2 class="text-2xl font-bold mb-4">Editar Grado</h2>

    <form action="{{ route('grados.update', $grado->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="flex flex-col gap-2 bg-white p-4 rounded shadow">
            <label for="nombre_grado">Nombre del grado:</label>
            <input type="text" name="nombre_grado" value="{{ $grado->nombre_grado }}" class="p-2 rounded border-2 border-white/1 border-b-cyan-500 focus:border-b-cyan-800 focus:ring-cyan-800" required>
        </div>

        <h3 class="mt-4 font-semibold">Materias asignadas:</h3>
        <div class="flex flex-col gap-2 bg-white p-4 rounded shadow">
            @foreach ($materias as $materia)
                <label>
                    <input type="checkbox" name="materias[]" value="{{ $materia->id }}"
                        {{ in_array($materia->id, $materiasAsignadas) ? 'checked' : '' }}>
                    {{ $materia->nombre_materia }}
                </label>
            @endforeach
        </div>

        <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">Actualizar</button>
        <a href="{{ route('grados.index') }}" class="px-4 py-2.5 bg-gray-600 text-white rounded">Volver</a>
    </form>
    @if(count($grado->materias))
        <div class="mt-6">
            <h4 class="text-lg font-semibold text-gray-700 mb-2">Materias asignadas actualmente:</h4>
            <div class="flex flex-wrap gap-2">
                @foreach ($grado->materias as $materia)
                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm shadow">
                        {{ $materia->nombre_materia }}
                    </span>
                @endforeach
            </div>
        </div>
    @else
        <div class="mt-6 text-gray-600 italic">
            Este grado aún no tiene materias asignadas.
        </div>
    @endif

</div>
@endsection
