@extends('layout.app')

@section('title', 'Calificaciones - ' . $materia->nombre_materia)

@section('sidebar')
    <h2 class="text-xl font-bold mb-4 text-blue-800">📘 Materias Asignadas</h2>
    <ul class="space-y-2">
        <li class="border-l-4 border-blue-500 pl-2">
             <a href="{{ route('profesor.home') }}" class="text-blue-700 hover:underline hover:bg-white/50 px-3 py-0.5 rounded-md">Panel inicial</a>
        </li>
        <hr>
        @forelse ($materias as $m)
            <li class="border-l-4 border-blue-500 pl-2">
                <a href="{{ route('profesor.materia', $m->id) }}" class="text-blue-700 hover:underline hover:bg-white/50 px-3 py-0.5 rounded-md">
                    {{ $m->nombre_materia }}
                </a>
            </li>
            <hr>
        @empty
            <li class="text-gray-600">No hay materias asignadas.</li>
        @endforelse
    </ul>
@endsection

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold mb-4">📘 {{ $materia->nombre_materia }}</h2>

    <table class="min-w-full bg-blue-200 shadow-md rounded overflow-hidden">
        <thead>
            <tr class="bg-blue-100">
                <th class="text-left py-2 px-4">Alumno</th>
                <th class="py-2 px-4 text-center">Calificación</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($alumnos as $alumno)
                <tr
                    class="border-b hover:bg-blue-50 cursor-pointer"
                    @click="window.location.href='{{ route('profesor.calificacion.edit', [$materia->id, $alumno->id]) }}'"
                >
                    <td class="py-2 px-4">
                        {{ $alumno->nombre }} {{ $alumno->apellido }}
                    </td>
                    <td class="py-2 px-4 text-center font-bold text-blue-700">
                        {{ $calificaciones[$alumno->id][0]->calificacion ?? 'Sin calificación' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
