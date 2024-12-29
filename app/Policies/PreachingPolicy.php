<?php

namespace App\Policies;

use App\Enums\RoleType;
use Illuminate\Auth\Access\Response;
use App\Models\Preaching;
use App\Models\User;

class PreachingPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->role->name == RoleType::CREATOR) return true;
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Preaching $preaching): bool
    {
        if (
            $user->id == $preaching->church->user_id &&
            $user->role->name == RoleType::CREATOR
        ) return true;
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if (
            $user->id == $user->church->user_id &&
            $user->role->name == RoleType::CREATOR
        ) return true;
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Preaching $preaching): bool
    {
        if (
            $user->id == $preaching->church->user_id &&
            $user->role->name == RoleType::CREATOR
        ) return true;
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Preaching $preaching): bool
    {
        if (
            $user->id == $preaching->church->user_id &&
            $user->role->name == RoleType::CREATOR
        ) return true;
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Preaching $preaching): bool
    {
        if (
            $user->id == $preaching->church->user_id &&
            $user->role->name == RoleType::CREATOR
        ) return true;
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Preaching $preaching): bool
    {
        if (
            $user->id == $preaching->church->user_id &&
            $user->role->name == RoleType::CREATOR
        ) return true;
        return false;
    }
}