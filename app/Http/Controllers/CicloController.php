<?php

namespace App\Http\Controllers;

use App\Models\Ciclos;
use Illuminate\Http\Request;

class CicloController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $ciclos = Ciclos::when($request->search, function ($query, $search) {
                return $query->where('nombre', 'like', "%$search%");
            })->get();

        return view('admin.ciclos.index', compact('ciclos'))->with('status', 'activos');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.ciclos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        Ciclos::create($request->only('nombre'));

        return redirect()->route('ciclos.index')->with('success', 'Ciclo creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ciclos $ciclo)
    {
        return view('admin.ciclos.edit', compact('ciclo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ciclos $ciclo)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $ciclo->update($request->only('nombre'));

        return redirect()->route('ciclos.index')->with('success', 'Ciclo actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ciclos $ciclo)
    {
        $ciclo->delete();

        return redirect()->route('ciclos.index')->with('success', 'Ciclo eliminado.');
    }

    public function inactivos()
    {
        $ciclos = Ciclos::onlyTrashed()->get();
        return view('admin.ciclos.index', [
            'ciclos' => $ciclos,
            'status' => 'inactivos',
        ]);
    }

    public function restore($id)
    {
        $ciclos = Ciclos::onlyTrashed()->findOrFail($id);
        $ciclos->restore();
        return redirect()->route('ciclos.inactivos')->with('success', 'Ciclo restaurado correctamente.');
    }

    public function forceDelete($id)
    {
        $ciclos = Ciclos::onlyTrashed()->findOrFail($id);
        $ciclos->forceDelete();
        return redirect()->route('ciclos.inactivos')->with('success', 'Ciclo eliminado permanentemente.');
    }

}
