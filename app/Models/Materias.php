<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materias extends Model
{
    use HasFactory;
    protected $fillable = ['nombre_materia'];

    public function grados()
    {
        return $this->belongsToMany(Grados::class, 'materias_grados');
    }

    public function calificaciones()
    {
        return $this->hasMany(Calificaciones::class);
    }

    public function historialAlumnos()
    {
        return $this->hasMany(HistorialAlumnos::class);
    }
}
