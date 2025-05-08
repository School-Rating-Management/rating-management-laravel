<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Padres extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['nombre', 'apellido', 'telefono', 'correo', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function alumnos()
    {
        return $this->hasMany(Alumnos::class, 'padre_id', 'id');
    }
}
