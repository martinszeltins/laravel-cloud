<?php

namespace App\Policies;

use App\Models\Stack;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StackPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the stack.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Stack $stack
     *
     * @return mixed
     */
    public function view(User $user, Stack $stack)
    {
        return $user->canAccessProject($stack->environment->project);
    }

    /**
     * Determine whether the user can delete the stack.
     *
     * @param \App\Models\User   $user
     * @param  \App\Models\Stack $stack
     *
     * @return mixed
     */
    public function delete(User $user, Stack $stack)
    {
        return $stack->creator->id == $user->id ||
               $user->projects->contains($stack->environment->project);
    }
}
