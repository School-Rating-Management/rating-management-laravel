<?php

namespace App\Http\Controllers;

use App\Models\Materias;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Stmt\TryCatch;

class MateriaController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $search = $request->get('search');

        // Si hay búsqueda, filtra por nombre
        $materias = Materias::when($search, function ($query) use ($search) {
            return $query->where('nombre_materia', 'like', '%' . $search . '%');
        })->get();
        return view('admin.materias.index', compact('materias'))->with('status', 'activas');
    }

    public function inactivas()
    {
        $materias = Materias::onlyTrashed()->get(); // Inactivas
        return view('admin.materias.index', compact('materias'))->with('status', 'inactivas');
    }

    public function create()
    {
        return view('admin.materias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_materia' => 'required|string|max:255|unique:materias,nombre_materia',
        ]);

        Materias::create($request->all());

        return redirect()->route('materias.index')->with('success', 'Materia creada exitosamente.');
    }

    public function edit($id)
    {
        $materia = Materias::findOrFail($id);
        return view('admin.materias.edit', compact('materia'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_materia' => 'required|string|max:255|unique:materias,nombre_materia,',
        ]);

        $materia = Materias::findOrFail($id);
        $materia->update($request->all());

        return redirect()->route('materias.index')->with('success', 'Materia actualizada exitosamente.');
    }

    public function destroy($id)
    {
        try {
            $materia = Materias::findOrFail($id);
            $materia->delete();

            return redirect()->route('materias.index')->with('success', 'Materia desactivada.');
        }catch (\Exception $e) {
            Log::error('Error al eliminar la materia: ' . $e->getMessage());
            return redirect()->route('materias.index')->with('error', 'Error al eliminar la materia: ');
        }
    }

    public function restore($id)
    {
        try {
            $materia = Materias::withTrashed()->findOrFail($id);
            $materia->restore();

            return redirect()->route('materias.inactivas')->with('success', 'Materia restaurada.');
        }catch (\Exception $e) {
            Log::error('Error al restaurar la materia: ' . $e->getMessage());
            return redirect()->route('materias.inactivas')->with('error', 'Error al restaurar la materia: ');
        }
    }

    public function forceDelete($id)
    {
        try {
            $materia = Materias::withTrashed()->findOrFail($id);
            $materia->forceDelete();

            return redirect()->route('materias.inactivas')->with('success', 'Materia eliminada permanentemente.');
        } catch (\Exception $e) {
            // Loggear el error
            Log::error('Error al eliminar la materia: ' . $e->getMessage());
            // Retornar con un mensaje general
            return redirect()->route('materias.inactivas')->with('error', 'Ocurrió un error al eliminar la materia permanentemente.');
        }
    }
}
