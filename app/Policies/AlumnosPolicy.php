<?php

namespace App\Policies;

use App\Models\Alumnos;
use App\Models\User;

class AlumnosPolicy
{
    public function view(User $user, Alumnos $alumno)
    {
        // dd('La política se está ejecutando');
       $user->loadMissing('profesor.grupo.grados', 'padre');

        if ($user->profesor) {
            $profesorGrupo = $user->profesor->grupo;
            $profesorGrado = $profesorGrupo?->grados;

            $alumnoGrupo = $alumno->grupo;
            $alumnoGrado = $alumnoGrupo?->grados;

            if ($profesorGrupo && $profesorGrado && $alumnoGrupo && $alumnoGrado) {
                return $profesorGrupo->id === $alumnoGrupo->id
                    && $profesorGrado->id === $alumnoGrado->id;
            }

            return false; // relaciones incompletas
        }

        if ($user->padre) {
            return $alumno->padre_id === $user->padre->id;
        }

        return false;
    }
}
