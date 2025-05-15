<?php

namespace App\Http\Controllers;

use App\Models\Alumnos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlumnoController extends Controller
{
    public function showAlumno($id) {
        $alumno = Alumnos::with(['grupo', 'alumno', 'calificaciones.materia', 'historial.materia'])->findOrFail($id);
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
        return view('admin.alumnos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'curp' => 'required|string|max:255'
        ]);

        Alumnos::create($request->all());

        return redirect()->route('alumnos.index')->with('success', 'Alumno creado correctamente.');
    }

    public function edit(Alumnos $alumno)
    {
        return view('admin.alumnos.edit', compact('alumno'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alumnos $alumno)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255'
        ]);

        $alumno->update($request->only('nombre'));

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
