<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the project.
     *
     * @param  \App\Models\User    $user
     * @param  \App\Models\Project $project
     *
     * @return mixed
     */
    public function view(User $user, Project $project)
    {
        return $user->canAccessProject($project);
    }

    /**
     * Determine whether the user can create projects.
     *
     * @param  \App\Models\User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the project's collaborators.
     *
     * @param \App\Models\User    $user
     * @param \App\Models\Project $project
     *
     * @return mixed
     */
    public function updateCollaborators(User $user, Project $project)
    {
        return $user->projects->contains($project);
    }

    /**
     * Determine whether the user can delete the project.
     *
     * @param \App\Models\User    $user
     * @param \App\Models\Project $project
     *
     * @return mixed
     */
    public function delete(User $user, Project $project)
    {
        return $user->projects->contains($project);
    }
}
