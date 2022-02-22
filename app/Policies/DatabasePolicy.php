<?php

namespace App\Policies;

use App\Models\Database;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DatabasePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can transfer the database.
     *
     * @param  \App\Models\User     $user
     * @param  \App\Models\Database $database
     *
     * @return mixed
     */
    public function transfer(User $user, Database $database)
    {
        return $user->projects->contains($database->project);
    }

    /**
     * Determine whether the user can delete the database.
     *
     * @param  \App\Models\User    $user
     * @param \App\Models\Database $database
     *
     * @return mixed
     */
    public function delete(User $user, Database $database)
    {
        return $user->projects->contains($database->project);
    }
}
