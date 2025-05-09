<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\Alumnos;
use App\Models\Grupos;
use App\Models\Profesores;
use App\Models\User;
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



    public function show($id)
    {
        $profesor = Profesores::withTrashed()
        ->with([
            'grupo.grados.materias',   // materias del grado asociado al grupo del profesor
            'grupo.grados',            // el grado en sí
            'grupo.alumnos'            // los alumnos del grupo
        ])
        ->findOrFail($id);

    return view('admin.profesores.show', compact('profesor'));
    }

    public function index()
    {
        $profesores = Profesores::all(); // Activas
        return view('admin.profesores.index', compact('profesores'))->with('status', 'activos');
    }

    public function inactivos()
    {
        $profesores = Profesores::onlyTrashed()->get(); // Inactivas
        return view('admin.profesores.index', compact('profesores'))->with('status', 'inactivos');
    }

    public function restore($id)
    {
        $profesor = Profesores::onlyTrashed()->findOrFail($id);
        $profesor->restore();
        return redirect()->route('profesores.index')->with('success', 'Profesor restaurado exitosamente.');
    }

    public function forceDelete($id)
    {
        $profesor = Profesores::onlyTrashed()->findOrFail($id);
        $profesor->forceDelete();
        return redirect()->route('profesores.inactivos')->with('success', 'Profesor eliminado permanentemente.');
    }

    public function asignarGrupo($id)
    {
        $profesor = Profesores::findOrFail($id);
        $grupos = Grupos::whereNull('profesor_id')->get(); // solo los grupos libres

        return view('admin.profesores.asignar-grupo', compact('profesor', 'grupos'));
    }

    public function guardarGrupo(Request $request, $id)
    {
        $request->validate([
            'grupo_id' => 'required|exists:grupos,id'
        ]);

        $grupo = Grupos::findOrFail($request->grupo_id);
        $grupo->profesor_id = $id;
        $grupo->save();

        return redirect()->route('profesores.show', $id)->with('success', 'Grupo asignado correctamente.');
    }

    public function create()
    {
        $gruposDisponibles = Grupos::whereNull('profesor_id')->get(); // Grupos sin profesor asignado
        return view('admin.profesores.create', compact('gruposDisponibles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'grupo_id' => 'nullable|exists:grupos,id',
        ]);

        // Crear el usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => UserRole::PROFESOR, // Enum
        ]);

        // Crear el profesor
        $profesor = Profesores::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'user_id' => $user->id,
        ]);

        // Asignar grupo si se seleccionó
        if ($request->filled('grupo_id')) {
            $grupo = Grupos::find($request->grupo_id);
            $grupo->profesor_id = $profesor->id;
            $grupo->save();
        }

        return redirect()->route('profesores.index')->with('success', 'Profesor creado correctamente.');
    }

}
