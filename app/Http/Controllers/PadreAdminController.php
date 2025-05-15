<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\Alumnos;
use App\Models\Padres;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PadreAdminController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        // Si hay búsqueda, filtra por nombre o apellido
        $padres = Padres::when($search, function ($query) use ($search) {
                return $query->where('nombre', 'like', '%' . $search . '%')
                            ->orWhere('apellido', 'like', '%' . $search . '%');
            })->paginate(20)
            ->withQueryString(); // <- Conserva el search al paginar
        // $padres = Padres::withTrashed()->with('user')->paginate(30);
        return view('admin.padres.index', compact('padres'))->with('status', 'activos');
    }

    public function create()
    {
        return view('admin.padres.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'correo' => 'required|email|unique:users,email',
            'telefono' => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Crear el usuario primero
        $user = User::create([
            'name' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->correo,
            'password' => Hash::make($request->password),
            'role' => UserRole::PADRE,
        ]);

        // Crear el padre
        Padres::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'telefono' => $request->telefono,
            'correo' => $request->correo,
            'user_id' => $user->id,
        ]);

        return redirect()->route('padres.index')->with('success', 'Padre creado correctamente.');
    }

    public function edit($id)
    {
        $padre = Padres::withTrashed()->with(['user', 'alumnos.grupo', 'alumnos.ciclo'])->findOrFail($id);

        // Excluir alumnos que ya están asociados
        $alumnosDisponibles = Alumnos::whereNull('padre_id')
            ->get();

        return view('admin.padres.edit', compact('padre', 'alumnosDisponibles'));
    }

    public function update(Request $request, $id)
    {
        $padre = Padres::withTrashed()->with('user')->findOrFail($id);
        $userId = $padre->user->id ?? null;

        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'correo' => 'required|email|unique:users,email,' . $userId,
        ]);

        $padre->update($request->only('nombre', 'apellido', 'telefono', 'correo'));

        // Actualizar datos en User
        if ($padre->user) {
            $padre->user->update([
                'name' => $request->nombre,
                'apellido' => $request->apellido,
                'email' => $request->correo,
            ]);
        }

        if ($request->filled('password')) {
            $padre->user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        // Activar / Desactivar
        if ($request->has('activo')) {
            if ($padre->trashed()) {
                $padre->restore();
                if ($padre->user && $padre->user->trashed()) {
                    $padre->user->restore();
                }
            }
        } else {
            if (!$padre->trashed()) {
                $padre->delete();
                if ($padre->user && !$padre->user->trashed()) {
                    $padre->user->delete();
                }
            }
        }

        return redirect()->route('padres.index')->with('success', 'Padre actualizado correctamente.');
    }

    public function destroy($id)
    {
        $padre = Padres::findOrFail($id);
        $user = $padre->user;

        $padre->delete();
        if ($user) {
            $user->delete();
        }

        return redirect()->route('padres.index')->with('success', 'Padre inactivado correctamente.');
    }

    public function restore($id)
    {
        $padre = Padres::onlyTrashed()->findOrFail($id);
        $user = $padre->user()->withTrashed()->first();

        $padre->restore();
        if ($user && $user->trashed()) {
            $user->restore();
        }

        return redirect()->route('padres.index')->with('success', 'Padre restaurado correctamente.');
    }

    public function forceDelete($id)
    {
        $padre = Padres::onlyTrashed()->findOrFail($id);
        $user = $padre->user()->withTrashed()->first();

        if ($user) {
            $user->forceDelete();
        }

        $padre->forceDelete();

        return redirect()->route('padres.index')->with('success', 'Padre eliminado permanentemente.');
    }

    public function inactivos()
    {
        $padres = Padres::onlyTrashed()->with('user')->paginate(30);
        return view('admin.padres.index', compact('padres'))->with('status', 'inactivos');
    }

    public function show($id)
    {
        $padre = Padres::withTrashed()->with('user')->findOrFail($id);
        return view('admin.padres.show', compact('padre'));
    }

    public function attachAlumno(Request $request, $padreId)
    {
        $request->validate([
            'alumno_id' => 'required|exists:alumnos,id'
        ]);

        $alumno = Alumnos::findOrFail($request->alumno_id);
        $alumno->padre_id = $padreId;
        $alumno->save();

        return redirect()->back()->with('success', 'Alumno asociado correctamente.');
    }

    public function detachAlumno($padreId, $alumnoId)
    {
        $alumno = Alumnos::where('id', $alumnoId)->where('padre_id', $padreId)->firstOrFail();
        $alumno->padre_id = null;
        $alumno->save();

        return redirect()->back()->with('success', 'Alumno desvinculado correctamente.');
    }

}
