<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupos extends Model
{
    use HasFactory;
    protected $fillable = ['nombre_grupo', 'profesor_id', 'grado_id'];

    public function profesor()
    {
        return $this->belongsTo(Profesores::class);
    }

    public function grado()
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
