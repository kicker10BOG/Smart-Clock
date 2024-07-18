<?php

namespace App\Policies;

use App\Models\Alarm;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AlarmPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Alarm $alarm): Response
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user ? Response::allow() : Response::deny('This alarm does not belong to you');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Alarm $alarm): Response
    {
        return $user && $user->id == $alarm->clock->user->id ? Response::allow() : Response::deny('This alarm does not belong to you');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Alarm $alarm): Response
    {
        return $user && $user->id == $alarm->clock->user->id ? Response::allow() : Response::deny('This alarm does not belong to you');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Alarm $alarm): Response
    {
        return $user && $user->id == $alarm->clock->user->id ? Response::allow() : Response::deny('This alarm does not belong to you');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Alarm $alarm): Response
    {
        return $user && $user->id == $alarm->clock->user->id ? Response::allow() : Response::deny('This alarm does not belong to you');
    }
}
