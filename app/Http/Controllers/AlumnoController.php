<?php

namespace App\Http\Controllers;

use App\Models\Alumnos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlumnoController extends Controller
{
    public function showAlumno($id) {
        $alumno = Alumnos::with(['grupo', 'ciclo', 'calificaciones.materia', 'historial.materia'])->findOrFail($id);
        $isPadre = request()->is('padre/*');
        $rol = $isPadre ? 'padre' : 'profesor';
        return view('alumno.detalle', compact('alumno', 'rol'));
    }

    public static function search(Request $request)
    {
        $query = $request->input('query');

        // Realiza la búsqueda en el modelo Alumnos
        $alumnos = Alumnos::where('nombre', 'LIKE', "%{$query}%")
            ->orWhere('apellido', 'LIKE', "%{$query}%")
            ->orWhere('curp', 'LIKE', "%{$query}%")
            ->get();

        return compact('alumnos');
    }
}
