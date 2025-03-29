<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profesores extends Model
{

    use HasFactory;
    protected $fillable = ['nombre', 'apellido', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function grupo()
    {
        return $this->hasOne(Grupos::class);
    }
}
