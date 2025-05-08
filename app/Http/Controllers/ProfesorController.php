<?php

namespace App\Http\Controllers;

use App\Models\Alumnos;
use App\Models\Profesores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfesorController extends Controller
{
    public function home()
    {
        $profesor = Auth::user()->profesor;

        if (!$profesor) {
            // Si no es profesor, redirigir a la página de inicio de sesión
            return redirect()->route('login')->with('error', 'No tienes acceso a esta sección');
            // return redirect()->route('login')->with('error', 'No se encontró información del profesor');
        }

        $grupo = $profesor->grupo;
        $alumnos = $grupo?->alumnos ?? collect(); // En caso de que no tenga grupo aún
        $materias = $grupo?->grados?->materias ?? collect();

        return view('profesor.home', compact('profesor', 'grupo', 'alumnos', 'materias'));
    }



    private function currentProfesor() {
        return Auth::user()?->profesor;
    }
}
