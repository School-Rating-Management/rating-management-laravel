<?php

namespace App\Http\Controllers;

use App\Models\Grados;
use App\Models\Grupos;
use App\Models\Profesores;
use Illuminate\Http\Request;

class GrupoController extends Controller
{
    public function index(Request $request)
    {
        $grupos = Grupos::with(['profesor', 'grados'])
            ->when($request->search, function ($query, $search) {
                return $query->where('nombre_grupo', 'like', "%$search%");
            })->paginate(10)
            ->withQueryString(); // <- Conserva el search al paginar

        return view('admin.grupos.index', compact('grupos'))->with('status', 'activos');
    }

    public function create()
    {
        // Solo profesores que no estén ya en algún grupo
        $profesores = Profesores::whereDoesntHave('grupo')->get();
        $grados = Grados::all();
        return view('admin.grupos.create', compact('profesores', 'grados'));
    }

    public function store(Request $request)
    {
         $request->validate([
            'nombre_grupo' => 'required|string|max:255',
            'profesor_id' => 'nullable|exists:profesores,id|unique:grupos,profesor_id',
            'grado_id' => 'required|exists:grados,id',
        ]);

        Grupos::create($request->all());
        return redirect()->route('grupos.index')->with('success', 'Grupo creado exitosamente.');
    }

    public function show($id)
    {
        $grupo = Grupos::withTrashed()
        ->with([
            'profesor',
            'grados',
            'alumnos' => function ($query) {
                $query->withTrashed()->with('calificaciones');
            }
        ])
        ->findOrFail($id);

        // Calcular promedio de cada alumno
        $alumnosConPromedio = $grupo->alumnos->map(function ($alumno) {
            $promedio = $alumno->calificaciones->avg('calificacion');
            $alumno->promedio = $promedio ?? 0;
            return $alumno;
        });

        // Promedio grupal (promedio de los promedios de los alumnos)
        $promedioGrupal = round($alumnosConPromedio->avg('promedio'), 2);

        // Top 3 mejores alumnos
        $topAlumnos = $alumnosConPromedio->sortByDesc('promedio')->take(3);

        return view('admin.grupos.show', compact('grupo', 'promedioGrupal', 'topAlumnos', 'alumnosConPromedio'));
    }

    public function edit($id)
    {
        $grupo = Grupos::withTrashed()->findOrFail($id);


        $profesoresDisponibles = Profesores::whereDoesntHave('grupo')->get();


        $grados = Grados::all();

        return view('admin.grupos.edit', [
            'grupo' => $grupo,
            'profesores' => $profesoresDisponibles,
            'grados' => $grados,
        ]);
    }

    public function update(Request $request, $id)
    {
        $grupo = Grupos::withTrashed()->findOrFail($id);

        $request->validate([
            'nombre_grupo' => 'required|string|max:255',
            'profesor_id' => 'nullable|exists:profesores,id|unique:grupos,profesor_id,' . $grupo->id,
            'grado_id' => 'required|exists:grados,id',
        ]);

        $data = $request->all();
        $data['profesor_id'] = $data['profesor_id'] ?: null;
        $grupo->update($data);

        return redirect()->route('grupos.index')->with('success', 'Grupo actualizado correctamente.');
    }

    public function destroy(Grupos $grupo)
    {
        $grupo->delete();
        return redirect()->route('grupos.index')->with('success', 'Grupo desactivado correctamente.');
    }

    public function inactivas()
    {
        $grupos = Grupos::onlyTrashed()->with(['profesor', 'grados'])->paginate(10)
            ->withQueryString(); // <- Conserva el search al paginar
        return view('admin.grupos.index', [
            'grupos' => $grupos,
            'status' => 'inactivos',
        ]);
    }

    public function restore($id)
    {
        $grupo = Grupos::onlyTrashed()->findOrFail($id);
        $grupo->restore();
        return redirect()->route('grupos.inactivas')->with('success', 'Grupo restaurado correctamente.');
    }

    public function forceDelete($id)
    {
        $grupo = Grupos::onlyTrashed()->findOrFail($id);
        $grupo->forceDelete();
        return redirect()->route('grupos.inactivas')->with('success', 'Grupo eliminado permanentemente.');
    }
}
