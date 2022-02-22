<?php

namespace App\Policies;

use App\Models\DatabaseBackup;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DatabaseBackupPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can delete the database backup.
     *
     * @param  \App\Models\User           $user
     * @param  \App\Models\DatabaseBackup $backup
     *
     * @return mixed
     */
    public function delete(User $user, DatabaseBackup $backup)
    {
        return $user->projects->contains($backup->database->project);
    }
}
