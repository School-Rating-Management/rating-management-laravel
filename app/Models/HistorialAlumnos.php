<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialAlumnos extends Model
{
    use HasFactory;
    protected $fillable = [
        'alumno_id',
        'ciclo_id',
        'grado_id',
        'grupo_id',
        'materia_id',
        'calificacion',
        'fecha_calificacion',
        'fecha_cambio'
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumnos::class);
    }

    public function ciclo()
    {
        return $this->belongsTo(Ciclos::class);
    }

    public function grado()
    {
        return $this->belongsTo(Grados::class);
    }

    public function grupo()
    {
        return $this->belongsTo(Grupos::class);
    }

    public function materia()
    {
        return $this->belongsTo(Materias::class);
    }
}
