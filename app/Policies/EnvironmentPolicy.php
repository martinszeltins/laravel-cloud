<?php

namespace App\Policies;

use App\Models\Environment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EnvironmentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can delete the environment.
     *
     * @param  \App\Models\User        $user
     * @param  \App\Models\Environment $environment
     *
     * @return mixed
     */
    public function delete(User $user, Environment $environment)
    {
        return $user->projects->contains($environment->project) ||
               $environment->creator->id == $user->id;
    }
}
