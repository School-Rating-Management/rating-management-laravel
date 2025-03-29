<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calificaciones extends Model
{
    use HasFactory;
    protected $fillable = ['alumno_id', 'materia_id', 'calificacion', 'fecha'];

    public function alumno()
    {
        return $this->belongsTo(Alumnos::class);
    }

    public function materia()
    {
        return $this->belongsTo(Materias::class);
    }
}
