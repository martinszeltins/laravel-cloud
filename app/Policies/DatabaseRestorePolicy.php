<?php

namespace App\Policies;

use App\Models\Database;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DatabaseRestorePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can restore databases.
     *
     * @param  \App\Models\User     $user
     * @param  \App\Models\Database $database
     *
     * @return mixed
     */
    public function create(User $user, Database $database)
    {
        return $user->projects->contains($database->project);
    }
}
