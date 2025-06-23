@extends('layout.panel')

@section('title', 'Importar Alumnos')

@section('content')
@include('partials.alerts')

@if(session('imported') || session('updated'))
<div class="bg-white shadow rounded-lg p-6 mb-6">
    <h3 class="text-lg font-semibold mb-4">Detalles de la Importación</h3>

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-4">
            <p class="text-green-700">{{ session('success') }}</p>
        </div>
    @endif

    @if(session('imported'))
        <div class="mb-6">
            <h4 class="font-medium text-blue-600 mb-2">Nuevos Alumnos Importados ({{ count(session('imported')) }}):</h4>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="py-2 px-4 border">Fila</th>
                            <th class="py-2 px-4 border">Nombre</th>
                            <th class="py-2 px-4 border">Apellido</th>
                            <th class="py-2 px-4 border">CURP</th>
                            <th class="py-2 px-4 border">Grupo</th>
                            <th class="py-2 px-4 border">Ciclo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(session('imported') as $item)
                        <tr>
                            <td class="py-2 px-4 border">{{ $item['row'] }}</td>
                            <td class="py-2 px-4 border">{{ $item['nombre'] }}</td>
                            <td class="py-2 px-4 border">{{ $item['apellido'] }}</td>
                            <td class="py-2 px-4 border">{{ $item['curp'] }}</td>
                            <td class="py-2 px-4 border">{{ $item['grupo'] }}</td>
                            <td class="py-2 px-4 border">{{ $item['ciclo'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    @if(session('updated'))
        <div class="mb-6">
            <h4 class="font-medium text-purple-600 mb-2">Alumnos Actualizados ({{ count(session('updated')) }}):</h4>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="py-2 px-4 border">Fila</th>
                            <th class="py-2 px-4 border">CURP</th>
                            <th class="py-2 px-4 border">Campo</th>
                            <th class="py-2 px-4 border">Valor Anterior</th>
                            <th class="py-2 px-4 border">Nuevo Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(session('updated') as $item)
                            @foreach($item['changes'] as $field => $change)
                                @if($change['old'] != $change['new'])
                                <tr>
                                    <td class="py-2 px-4 border">{{ $item['row'] }}</td>
                                    <td class="py-2 px-4 border">{{ $item['curp'] }}</td>
                                    <td class="py-2 px-4 border">{{ ucfirst($field) }}</td>
                                    <td class="py-2 px-4 border">{{ $change['old'] }}</td>
                                    <td class="py-2 px-4 border">{{ $change['new'] }}</td>
                                </tr>
                                @endif
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endif

<div class="container mx-auto py-6">
    <h2 class="text-2xl font-bold mb-4">Importar Alumnos desde Excel</h2>

    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-2">Instrucciones para importar:</h3>
            <ol class="list-decimal pl-5 space-y-2 text-gray-700">
                <li>Descarga la plantilla de ejemplo o usa un archivo Excel con el formato correcto</li>
                <li>El archivo debe contener las columnas: <span class="font-mono bg-gray-100 px-2 py-1 rounded">nombre</span>, <span class="font-mono bg-gray-100 px-2 py-1 rounded">apellido</span>, <span class="font-mono bg-gray-100 px-2 py-1 rounded">curp</span>, <span class="font-mono bg-gray-100 px-2 py-1 rounded">grupo</span>, <span class="font-mono bg-gray-100 px-2 py-1 rounded">padre_nombre</span>, <span class="font-mono bg-gray-100 px-2 py-1 rounded">padre_apellido</span>, <span class="font-mono bg-gray-100 px-2 py-1 rounded">ciclo</span></li>
                <li>No incluir filas adicionales antes de los encabezados</li>
                <li>El archivo debe estar en formato .xlsx, .xls o .csv</li>
            </ol>
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-4 space-y-4 sm:space-y-0">
            <a href="{{ asset('plantillas/plantilla_alumnos.xlsx') }}"
               class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Descargar Plantilla
            </a>

            <span class="text-gray-500 text-sm sm:border-l sm:border-gray-300 sm:pl-4">
                Tamaño máximo: 5MB
            </span>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <form action="{{ route('alumnos.importar') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="archivo" class="block text-sm font-medium text-gray-700 mb-2">Seleccionar archivo Excel</label>
                <input type="file" name="archivo" id="archivo" required
                       class="block w-full text-sm text-gray-500
                              file:mr-4 file:py-2 file:px-4
                              file:rounded-md file:border-0
                              file:text-sm file:font-semibold
                              file:bg-blue-50 file:text-blue-700
                              hover:file:bg-blue-100">
                @error('archivo')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('alumnos.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Cancelar
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    Importar Alumnos
                </button>
            </div>
        </form>
    </div>
</div>

@if(session('import_errors'))
<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-2xl w-full max-h-[80vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-red-600">Errores en la importación</h3>
            <button onclick="this.parentElement.parentElement.parentElement.remove()" class="text-gray-500 hover:text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="space-y-4">
            @foreach(session('import_errors') as $error)
            <div class="border-l-4 border-red-500 bg-red-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">
                            Fila {{ $error['row'] }}: {{ $error['message'] }}
                            @if(isset($error['values']))
                            <br><span class="text-xs text-gray-500">Valores: {{ json_encode($error['values']) }}</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-4 flex justify-end">
            <button onclick="this.parentElement.parentElement.remove()" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Entendido
            </button>
        </div>
    </div>
</div>
@endif
@endsection
