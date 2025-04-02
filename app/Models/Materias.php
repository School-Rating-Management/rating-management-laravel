<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Materias extends Model
{
    use HasFactory, SoftDeletes;
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
