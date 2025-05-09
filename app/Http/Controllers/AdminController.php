<?php

namespace App\Http\Controllers;

use App\Models\Alumnos;
use App\Models\Ciclos;
use App\Models\Materias;
use App\Models\Profesores;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $materias = Materias::all();
        $profesores = Profesores::all();
        $ciclos = Ciclos::all();
        $alumnos = Alumnos::paginate(10); // Paginación de 10 alumnos por página

        return view('admin.panel', compact('materias', 'profesores', 'ciclos', 'alumnos'));
    }
}
