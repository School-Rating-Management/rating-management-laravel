@extends('layout.panel')

@section('title', 'Detalles del Grupo')

@section('content')
<div class="container mx-auto py-6">
    <h2 class="text-2xl font-bold mb-4">Detalles del Grupo</h2>

    <div class="bg-white/50 p-6 rounded shadow space-y-4">
        <div>
            @if ($grupo->trashed())
                <div class="p-4 bg-red-100 text-red-700 rounded mb-2">
                    Este grupo actualmente está eliminado. Puedes restaurarlo para volver a usarlo.
                </div>
            @endif
            <strong class="text-gray-700">Nombre del Grupo:</strong>
            <p class="text-blue-800 font-bold">{{ $grupo->nombre_grupo }}</p>
        </div>

        <div>
            <strong class="text-gray-700">Profesor Asignado:</strong>
            <p>{{ $grupo->profesor ? $grupo->profesor->nombre . ' ' . $grupo->profesor->apellido : 'Sin profesor' }}</p>
        </div>

        <div>
            <strong class="text-gray-700">Grado:</strong>
            <p>{{ $grupo->grados->nombre_grado }}</p>
        </div>

        <div>
            <strong class="text-gray-700">Promedio Grupal:</strong>
            @if($promedioGrupal <= 0)
                <p class="text-gray-500 italic">No hay calificaciones registradas.</p>
            @else
                <p class="text-green-700 font-bold">
                    {{ number_format($promedioGrupal, 2) }}
                </p>
            @endif
        </div>

        <div>
            <strong class="text-gray-700">Mejores Alumnos:</strong>
            @if($topAlumnos->count())
                <ul class="mt-2">
                    @foreach($topAlumnos as $alumno)
                        <li class="list-none">
                            <span class="text-blue-900 font-medium">{{ $alumno->nombre }} {{ $alumno->apellido }}</span>
                            — Promedio: <span class="text-green-700">{{ number_format($alumno->promedio, 2) }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500 italic">No hay calificaciones registradas aún.</p>
            @endif
        </div>

        <div class="flex justify-end space-x-2">
            <a href="{{ route('grupos.edit', $grupo) }}" class="px-4 py-2 bg-yellow-500 text-white rounded">Editar</a>
            <a href="{{ route('grupos.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded">Volver</a>
        </div>
    </div>

    <div class="mt-6 bg-white/50 p-6 rounded shadow">
        <strong class="text-gray-700">Lista completa de alumnos con promedio:</strong>
        @if($alumnosConPromedio->count())
            <div class="overflow-y-auto max-h-72 mt-2  rounded-md shadow-sm">
                <table class="min-w-full bg-blue-300/30 text-sm text-left text-gray-800 ">
                    <thead class="bg-slate-400 sticky top-0 ">
                        <tr class="text-gray-700">
                            <th class="px-4 py-2">Nombre</th>
                            <th class="px-4 py-2">Apellido</th>
                            <th class="px-4 py-2 text-center">Promedio</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-400">
                        @foreach($alumnosConPromedio->sortByDesc('promedio') as $alumno)
                            <tr class="hover:bg-gray-200">
                                <td class="px-4 py-2">{{ $alumno->nombre }}</td>
                                <td class="px-4 py-2">{{ $alumno->apellido }}</td>
                                <td class="px-4 py-2 text-green-700 font-medium text-center">
                                    {{ number_format($alumno->promedio, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 italic mt-2">No hay alumnos o calificaciones aún.</p>
        @endif
    </div>

</div>
@endsection
