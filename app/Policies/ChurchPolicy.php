<?php

namespace App\Policies;

use App\Enums\RoleType;
use Illuminate\Auth\Access\Response;
use App\Models\Church;
use App\Models\User;

class ChurchPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->role->name != RoleType::ADMIN) return  false;
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Church $church): bool
    {
        if ($church->id==$user->church->id) return  true;
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->role->name != RoleType::ADMIN) return  false;
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Church $church): bool
    {
        if ($church->id==$user->church->id) return  true;
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Church $church): bool
    {
        if ($church->id==$user->church->id) return  true;
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Church $church): bool
    {
        if ($church->id==$user->church->id) return  true;
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Church $church): bool
    {
        if ($church->id==$user->church->id) return  true;
        return false;
    }
}
