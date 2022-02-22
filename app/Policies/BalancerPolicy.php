<?php

namespace App\Policies;

use App\Models\Balancer;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BalancerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can delete the balancer.
     *
     * @param  \App\Models\User     $user
     * @param  \App\Models\Balancer $balancer
     *
     * @return mixed
     */
    public function delete(User $user, Balancer $balancer)
    {
        return $user->projects->contains($balancer->project);
    }
}
