<?php

namespace App\Events;

use App\Models\Alert;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AlertCreated
{
    use Dispatchable, SerializesModels;

    /**
     * The alert instance.
     *
     * @var \App\Models\Alert
     */
    public $alert;

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\Alert $alert
     *
     * @return void
     */
    public function __construct(Alert $alert)
    {
        $this->alert = $alert;
    }

    /**
     * Get the user IDs affected by this alert.
     *
     * @return array
     */
    public function affectedIds()
    {
        return collect([$this->alert->project->user])->merge(
            $this->alert->project->collaborators
        )->pluck('id')->all();
    }
}
