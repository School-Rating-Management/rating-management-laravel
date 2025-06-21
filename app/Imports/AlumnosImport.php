<?php

namespace App\Imports;

use App\Models\Alumnos;
use App\Models\Grupos;
use App\Models\Padres;
use App\Models\Ciclos;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Enums\UserRole;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithValidation;

class AlumnosImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError, SkipsOnFailure
{
    use SkipsErrors, SkipsFailures;

    protected $imported = [];
    protected $updated = [];
    protected $rowCount = 0;

    public function rules(): array
    {
        return [
            'nombre' => 'required|string',
            'apellido' => 'required|string',
            'curp' => 'required|string|max:18',
            'grupo' => 'required|string',
            'padre_nombre' => 'required|string',
            'padre_apellido' => 'required|string',
            'ciclo' => 'required|string',
        ];
    }
    public function prepareForValidation($row, $index)
    {
        // Limpiar encabezados por si tienen espacios
        return collect($row)->keyBy(fn ($value, $key) => trim(strtolower($key)))->all();
    }
    public function model(array $row)
    {

        $row = array_filter($row, fn($value, $key) => is_string($key), ARRAY_FILTER_USE_BOTH);
        $row = array_map('trim', $row);
        $this->rowCount++;
        // Limpiar encabezados por si tienen espacios
        $this->prepareForValidation($row, $this->rowCount);
        // dd('Columnas recibidas:', array_keys($row));
        Log::info('Columnas recibidas:', array_keys($row));

        if (!array_key_exists('grupo', $row) || empty($row['grupo'])) {
            throw new \Exception("La columna 'grupo' no fue encontrada o está vacía en la fila {$this->rowCount}. Columnas disponibles: " . implode(', ', array_keys($row)));
        }

        if (empty(array_filter($row))) {
            // Fila completamente vacía, no hacer nada
            return null;
        }
        // Primero verificar si el alumno ya existe
        $alumnoExistente = Alumnos::where('curp', $row['curp'])->first();

        if ($alumnoExistente) {
            // Guardar datos antes de actualizar para comparación
            $originalData = $alumnoExistente->toArray();

            $grupo = Grupos::firstOrCreate(['nombre_grupo' => $row['grupo']]);
            $ciclo = Ciclos::firstOrCreate(['nombre' => $row['ciclo']]);

            $alumnoExistente->update([
                'nombre' => $row['nombre'],
                'apellido' => $row['apellido'],
                'grupo_id' => $grupo->id,
                'ciclo_id' => $ciclo->id,
            ]);

            // Registrar alumno actualizado
            $this->updated[] = [
                'row' => $this->rowCount,
                'curp' => $row['curp'],
                'changes' => [
                    'nombre' => ['old' => $originalData['nombre'], 'new' => $row['nombre']],
                    'apellido' => ['old' => $originalData['apellido'], 'new' => $row['apellido']],
                    'grupo' => ['old' => $originalData['grupo'], 'new' => $row['grupo']],
                    'ciclo' => ['old' => $originalData['ciclo'], 'new' => $row['ciclo']],
                ]
            ];
            return null; // No crear nuevo registro
        }

        // Buscar o crear grupo
        $grupo = Grupos::firstOrCreate([
            'nombre_grupo' => $row['grupo'],
        ]);

        // Buscar o crear ciclo
        $ciclo = Ciclos::firstOrCreate([
            'nombre' => $row['ciclo'],
        ]);

        // Datos del padre
        $padreNombre = trim($row['padre_nombre']);
        $padreApellido = trim($row['padre_apellido']);
        $padreCorreo = strtolower(Str::slug($padreNombre . '.' . $padreApellido)) . '@example.com';

        // Buscar padre por correo
        $padre = Padres::where('correo', $padreCorreo)->first();

        if (!$padre) {
            // Generar contraseña personalizada
            $alumnoNombre = trim($row['nombre']);
            $añoActual = Carbon::now()->year;

            $nombrePadreParte = strtolower(Str::slug(Str::before($padreNombre, ' '), ''));
            $nombreAlumnoParte = strtolower(Str::slug(Str::before($alumnoNombre, ' '), ''));

            $passwordPlain = $nombrePadreParte . $nombreAlumnoParte . $añoActual;

            // Crear usuario
            $user = User::create([
                'name' => $padreNombre,
                'apellido' => $padreApellido,
                'email' => $padreCorreo,
                'password' => Hash::make($passwordPlain),
                'role' => UserRole::PADRE->value,
            ]);

            // Crear padre
            $padre = Padres::create([
                'nombre' => $padreNombre,
                'apellido' => $padreApellido,
                'correo' => $padreCorreo,
                'user_id' => $user->id,
            ]);
        }


        $alumno = new Alumnos([
            'nombre' => $row['nombre'],
            'apellido' => $row['apellido'],
            'curp' => $row['curp'],
            'grupo_id' => $grupo->id,
            'padre_id' => $padre->id,
            'ciclo_id' => $ciclo->id,
        ]);

        // Registrar alumno importado
        $this->imported[] = [
            'row' => $this->rowCount,
            'nombre' => $row['nombre'],
            'apellido' => $row['apellido'],
            'curp' => $row['curp'],
            'grupo' => $row['grupo'],
            'ciclo' => $row['ciclo']
        ];

        return $alumno;
    }

    public function onError(\Throwable $error)
    {
        // Manejar el error aquí, si es necesario
        // Puedes registrar el error o realizar alguna acción específica
        Log::error('Error al importar fila: ' . $this->rowCount . ' - ' . $error->getMessage());
    }

    public function getRowCount()
    {
        return $this->rowCount;
    }

        public function getImported()
    {
        return $this->imported;
    }

    public function getUpdated()
    {
        return $this->updated;
    }
}
