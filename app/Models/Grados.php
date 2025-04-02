<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grados extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['nombre_grado'];

    public function grupos()
    {
        return $this->hasMany(Grupos::class);
    }

    public function materias()
    {
        return $this->belongsToMany(Materias::class, 'materias_grados');
    }

    public function historialAlumnos()
    {
        return $this->hasMany(HistorialAlumnos::class);
    }
}
