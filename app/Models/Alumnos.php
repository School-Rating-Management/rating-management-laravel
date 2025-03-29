<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumnos extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'apellido', 'curp', 'grupo_id', 'padre_id', 'ciclo_id'];

    public function grupo()
    {
        return $this->belongsTo(Grupos::class);
    }

    public function padre()
    {
        return $this->belongsTo(Padres::class);
    }

    public function ciclo()
    {
        return $this->belongsTo(Ciclos::class);
    }

    public function calificaciones()
    {
        return $this->hasMany(Calificaciones::class);
    }

    public function historial()
    {
        return $this->hasMany(HistorialAlumnos::class);
    }
}
