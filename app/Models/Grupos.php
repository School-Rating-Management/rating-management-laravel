<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grupos extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['nombre_grupo', 'profesor_id', 'grado_id'];

    public function profesor()
    {
        return $this->belongsTo(Profesores::class);
    }

    public function grados()
    {
        return $this->belongsTo(Grados::class);
    }

    public function alumnos()
    {
        return $this->hasMany(Alumnos::class);
    }

    public function historialAlumnos()
    {
        return $this->hasMany(HistorialAlumnos::class);
    }
}
