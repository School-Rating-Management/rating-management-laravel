<?php

namespace App\Http\Controllers;

use App\Models\Alumnos;
use App\Models\Ciclos;
use App\Models\Grupos;
use App\Models\Padres;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlumnoController extends Controller
{
    use AuthorizesRequests;
    public function showAlumno($id) {
    try {
            $alumno = Alumnos::with(['grupo.grados', 'calificaciones.materia', 'historial.materia'])->findOrFail($id);

            $this->authorize('view', $alumno);
        } catch (AuthorizationException $e) {
            return redirect()->route('welcome')
                ->with('error', 'No tienes acceso para ver este alumno.');
        }

        $isPadre = request()->is('padre/*');
        $rol = $isPadre ? 'padre' : 'profesor';
        return view('alumno.detalle', compact('alumno', 'rol'));
    }

    public static function search(Request $request)
    {
        $query = $request->input('search');

        // Realiza la búsqueda en el modelo Alumnos
        $alumnos = Alumnos::where('nombre', 'LIKE', "%{$query}%")
            ->orWhere('apellido', 'LIKE', "%{$query}%")
            ->orWhere('curp', 'LIKE', "%{$query}%")
            ->get();
        return compact('alumnos');
    }

    public function index(Request $request){
        $query = $request->input('search');

        // Realiza la búsqueda en el modelo Alumnos
        $alumnos = Alumnos::when($query, function ($q) use ($query) {
                    $q->where('nombre', 'LIKE', "%{$query}%")
                    ->orWhere('apellido', 'LIKE', "%{$query}%")
                    ->orWhere('curp', 'LIKE', "%{$query}%");
                })
                ->paginate(20) // <- Cambiar aquí
                ->withQueryString(); // <- Conserva el search al paginar

        return view('admin.alumnos.index', compact('alumnos'))->with('status', 'activos');
    }

    public function show($id)
    {
        // $alumno = Alumnos::withTrashed()->findOrFail($id);
        $alumno = Alumnos::withTrashed()
        ->with([
            'padre',
            'grupo',
            'grupo.grados',
            'calificaciones',
            'calificaciones.materia',
        ])
        ->findOrFail($id);
        // dd($alumno);
        return view('admin.alumnos.show', compact('alumno'));
    }

    public function create()
    {
        $gruposDisponibles = Grupos::with('grados')->get();
        $ciclosDisponibles = Ciclos::all();
        $padres = Padres::all();
        return view('admin.alumnos.create', compact('gruposDisponibles', 'ciclosDisponibles', 'padres'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'curp' => 'required|string|max:255',
            'grupo_id' => 'nullable|exists:grupos,id',
            'ciclo_id' => 'nullable|exists:ciclos,id',
            'padre_id' => 'nullable|exists:padres,id',
        ]);


        Alumnos::create($request->all());

        return redirect()->route('alumnos.index')->with('success', 'Alumno creado correctamente.');
    }

    public function edit(Alumnos $alumno)
    {
        $gruposDisponibles = Grupos::with('grados')->get();
        $ciclosDisponibles = Ciclos::all();
        $padres = Padres::all();
        return view('admin.alumnos.edit', compact('alumno', 'gruposDisponibles', 'ciclosDisponibles', 'padres'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alumnos $alumno)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'curp' => 'required|string|max:255',
            'grupo_id' => 'nullable|exists:grupos,id',
            'ciclo_id' => 'nullable|exists:ciclos,id',
            'padre_id' => 'nullable|exists:padres,id',
        ]);

        $alumno->update($request->only('nombre', 'apellido', 'curp', 'grupo_id', 'ciclo_id', 'padre_id'));

        return redirect()->route('alumnos.index')->with('success', 'Alumno actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alumnos $alumno)
    {
        $alumno->delete();

        return redirect()->route('alumnos.index')->with('success', 'Alumno eliminado.');
    }

    public function inactivos()
    {
        $alumnos = Alumnos::onlyTrashed()->paginate(20);
        return view('admin.alumnos.index', [
            'alumnos' => $alumnos,
            'status' => 'inactivos',
        ]);
    }

    public function restore($id)
    {
        $alumno = Alumnos::onlyTrashed()->findOrFail($id);
        $alumno->restore();
        return redirect()->route('alumnos.inactivos')->with('success', 'Alumno restaurado correctamente.');
    }

    public function forceDelete($id)
    {
        $alumno = Alumnos::onlyTrashed()->findOrFail($id);
        $alumno->forceDelete();
        return redirect()->route('alumnos.inactivos')->with('success', 'Alumno eliminado permanentemente.');
    }
}
