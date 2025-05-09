<?php

namespace App\Http\Controllers\Padre;

use App\Http\Controllers\Controller;
use App\Models\Alumnos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PadreController extends Controller
{
    public function index()
    {
        $padre = Auth::user()->padre;

        if (!$padre) {
            // abort(403, 'No tienes permiso para acceder a esta sección');
            return redirect()->route('login')->with('error', 'No tienes acceso a esta sección');
        }

        $alumnos = $padre->alumnos()->with(['grupo', 'ciclo'])->get(); // opcional: cargar relaciones

        return view('padre.home', compact('padre', 'alumnos'));
    }

}
