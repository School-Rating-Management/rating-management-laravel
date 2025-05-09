<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Materias;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Container\Attributes\Auth;

class MateriaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Materias $materias): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === UserRole::ADMIN;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Materias $materias): bool
    {
        return $user->role === UserRole::ADMIN;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Materias $materias): bool
    {
        return $user->role === UserRole::ADMIN;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Materias $materias): bool
    {
        return $user->role === UserRole::ADMIN;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Materias $materias): bool
    {
        return $user->role === UserRole::ADMIN;
    }
}
