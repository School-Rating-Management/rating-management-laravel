<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MateriasGrados extends Model
{
    use HasFactory;
    protected $table = 'materias_grados';

    protected $fillable = [
        'grado_id',
        'materia_id',
    ];

    public function grado()
    {
        return $this->belongsTo(Grados::class, 'grado_id');
    }

    public function materia()
    {
        return $this->belongsTo(Materias::class, 'materia_id');
    }
}
