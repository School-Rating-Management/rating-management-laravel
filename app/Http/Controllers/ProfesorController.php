<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\Alumnos;
use App\Models\Calificaciones;
use App\Models\Grupos;
use App\Models\Materias;
use App\Models\Profesores;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

    public function verMateria($id)
    {
        $profesor = Auth::user()->profesor;

        if (!$profesor) {
            return redirect()->route('login')->with('error', 'No tienes acceso a esta sección');
        }

        $grupo = $profesor->grupo;
        if (!$grupo) {
            return redirect()->back()->with('error', 'No tienes grupo asignado');
        }

        $materia = Materias::findOrFail($id);
        $materias = $grupo?->grados?->materias ?? collect();
        $alumnos = $grupo->alumnos;

        // Obtener calificaciones de los alumnos para esta materia
        $calificaciones = Calificaciones::whereIn('alumno_id', $alumnos->pluck('id'))
            ->where('materia_id', $materia->id)
            ->get()
            ->groupBy('alumno_id'); // Agrupar por alumno

        return view('profesor.materia', compact('materia', 'alumnos', 'calificaciones', 'materias'));
    }

    public function editarCalificacion($materiaId, $alumnoId)
    {
        $profesor = Auth::user()->profesor;
        $materias = Materias::all();
        $materia = Materias::findOrFail($materiaId);
        $alumno = Alumnos::findOrFail($alumnoId);

        // Buscar calificación existente
        $calificacion = Calificaciones::where('alumno_id', $alumnoId)
                        ->where('materia_id', $materiaId)
                        ->first();

        return view('profesor.editar-calificacion', compact('materia', 'alumno', 'calificacion', 'materias'));
    }

    public function actualizarCalificacion(Request $request, $materiaId, $alumnoId)
    {
        $request->validate([
            'calificacion' => 'nullable|numeric|min:0|max:10',
        ]);

        $calificacion = Calificaciones::updateOrCreate(
            ['alumno_id' => $alumnoId, 'materia_id' => $materiaId],
            ['calificacion' => $request->calificacion]
        );

        return redirect()->route('profesor.materia', $materiaId)->with('success', 'Calificación actualizada');
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

    public function index(Request $request)
    {
        $search = $request->get('search');

        // Si hay búsqueda, filtra por nombre o apellido
        $profesores = Profesores::when($search, function ($query) use ($search) {
            return $query->where('nombre', 'like', '%' . $search . '%')
                        ->orWhere('apellido', 'like', '%' . $search . '%');
        })->paginate(20)
        ->withQueryString(); // <- Conserva el search al paginar

        return view('admin.profesores.index', compact('profesores'))->with('status', 'activos');
    }

    public function inactivos()
    {
        $profesores = Profesores::onlyTrashed()->paginate(20); // Inactivas
        return view('admin.profesores.index', compact('profesores'))->with('status', 'inactivos');
    }

    public function edit($id)
    {
        $profesor = Profesores::withTrashed()->findOrFail($id);
        $grupoActual = $profesor->grupo;

        $gruposDisponibles = Grupos::whereNull('profesor_id')
            ->when($grupoActual, fn($query) => $query->orWhere('id', $grupoActual->id))
            ->get();

        return view('admin.profesores.edit', compact('profesor', 'gruposDisponibles'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'grupo_id' => 'nullable|exists:grupos,id',
        ]);

        $profesor = Profesores::withTrashed()
            ->with(['user' => fn($q) => $q->withTrashed()])->findOrFail($id);

        $profesor->update($request->only('nombre', 'apellido'));

        $user = $profesor->user;
        if ($user) {
            $user->name = $request->nombre . ' ' . $request->apellido;
            $user->save();
        }

        // Quitar grupo actual si se dejó vacío
        if (is_null($request->grupo_id) && $profesor->grupo) {
            $profesor->grupo->profesor_id = null;
            $profesor->grupo->save();
        }

        // Asignar nuevo grupo
        if ($request->filled('grupo_id')) {
            $grupoNuevo = Grupos::find($request->grupo_id);

            // Quitar grupo anterior si es distinto
            if ($profesor->grupo && $profesor->grupo->id !== $grupoNuevo->id) {
                $profesor->grupo->profesor_id = null;
                $profesor->grupo->save();
            }

            $grupoNuevo->profesor_id = $profesor->id;
            $grupoNuevo->save();
        }
        if ($request->has('activo')) {
            // Activar si está desactivado
            if ($profesor->trashed()) {
                $profesor->restore();
                if ($profesor->user && $profesor->user->trashed()) {
                    $profesor->user->restore();
                }
            }
        } else {
            // Desactivar si está activo
            if (!$profesor->trashed()) {
                $profesor->delete();
                if ($profesor->user && !$profesor->user->trashed()) {
                    $profesor->user->delete();
                }
            }
        }

        return redirect()->route('profesores.index')->with('success', 'Profesor actualizado correctamente.');
    }



    public function destroy($id)
    {
        $profesor = Profesores::findOrFail($id);
        $user = $profesor->user;

        $profesor->delete();
        $user->delete(); // También desactivar el usuario

        return redirect()->route('profesores.index')->with('success', 'Profesor inactivado exitosamente.');
    }

    public function restore($id)
    {
        $profesor = Profesores::onlyTrashed()->findOrFail($id);
        $user = $profesor->user()->withTrashed()->first();

        $profesor->restore();
        if ($user->trashed()) {
            $user->restore();
        }

        return redirect()->route('profesores.index')->with('success', 'Profesor restaurado exitosamente.');
    }

    public function forceDelete($id)
    {
        // Buscar al profesor que ha sido "soft deleted"
        $profesor = Profesores::onlyTrashed()->findOrFail($id);

        // Buscar al usuario asociado al profesor, incluyendo aquellos eliminados suavemente
        $user = $profesor->user()->withTrashed()->first();

        // Eliminar al usuario permanentemente
        if ($user) {
            $user->forceDelete();
        }

        // Eliminar al profesor permanentemente
        $profesor->forceDelete();

        return redirect()->route('profesores.inactivos')->with('success', 'Profesor y usuario eliminados permanentemente.');
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
            'apellido' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'grupo_id' => 'nullable|exists:grupos,id',
        ]);

        // Crear el usuario primero
        $user = User::create([
            'name' => $request->name,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => UserRole::PROFESOR,
        ]);

        // Crear el profesor usando la misma info
        $profesor = Profesores::create([
            'nombre' => $request->name,
            'apellido' => $request->apellido,
            'user_id' => $user->id,
        ]);

        // Asignar grupo si fue seleccionado
        if ($request->filled('grupo_id')) {
            $grupo = Grupos::find($request->grupo_id);
            $grupo->profesor_id = $profesor->id;
            $grupo->save();
        }

        return redirect()->route('profesores.index')->with('success', 'Profesor creado correctamente.');
    }


}
