<?php

namespace App\Http\Controllers;

use App\Models\Grados;
use Illuminate\Http\Request;

class GradoController extends Controller
{
    public function index(Request $request)
    {
        $grados = Grados::when($request->search, function ($query, $search) {
            return $query->where('nombre_grado', 'like', "%$search%");
        })->get();

        return view('admin.grados.index', compact('grados'))->with('status', 'activos');
    }

    public function create()
    {
        $materias = \App\Models\Materias::all();
        return view('admin.grados.create', compact('materias'));
    }

    public function store(Request $request)
    {
         $request->validate([
            'nombre_grado' => 'required|string|max:255',
            'materias' => 'array',
        ]);

        $grado = Grados::create($request->only('nombre_grado'));

        if ($request->has('materias')) {
            $grado->materias()->sync($request->materias);
        }

        return redirect()->route('grados.index')->with('success', 'Grado creado correctamente.');
    }


    public function edit(Grados $grado)
    {
        $materias = \App\Models\Materias::all();
        $materiasAsignadas = $grado->materias->pluck('id')->toArray();

        return view('admin.grados.edit', compact('grado', 'materias', 'materiasAsignadas'));
    }

    public function update(Request $request, Grados $grado)
    {
         $request->validate([
            'nombre_grado' => 'required|string|max:255',
            'materias' => 'array',
        ]);

        $grado->update($request->only('nombre_grado'));

        $grado->materias()->sync($request->materias ?? []);

        return redirect()->route('grados.index')->with('success', 'Grado actualizado correctamente.');
    }

    public function destroy(Grados $grado)
    {
        $grado->delete();

        return redirect()->route('grados.index')->with('success', 'Grado eliminado.');
    }

    public function inactivos()
    {
        $grados = Grados::onlyTrashed()->get();
        return view('admin.grados.index', [
            'grados' => $grados,
            'status' => 'inactivos',
        ]);
    }

    public function restore($id)
    {
        $grado = Grados::onlyTrashed()->findOrFail($id);
        $grado->restore();
        return redirect()->route('grados.inactivos')->with('success', 'Grado restaurado correctamente.');
    }

    public function forceDelete($id)
    {
        $grado = Grados::onlyTrashed()->findOrFail($id);
        $grado->forceDelete();
        return redirect()->route('grados.inactivos')->with('success', 'Grado eliminado permanentemente.');
    }
}
