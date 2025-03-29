<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Padres extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'apellido', 'telefono', 'correo', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function alumnos()
    {
        return $this->hasMany(Alumnos::class);
    }
}
