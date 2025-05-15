<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ciclos extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['nombre'];

    public function alumnos()
    {
        return $this->hasMany(Alumnos::class);
    }

    public function historialAlumnos()
    {
        return $this->hasMany(HistorialAlumnos::class);
    }
}
