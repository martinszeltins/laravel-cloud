<?php

namespace App\Events;

use App\Contracts\Alertable;
use App\Contracts\HasStack;
use App\Models\Deployment;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DeploymentTimedOut implements Alertable, HasStack
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The deployment instance.
     *
     * @var \App\Models\Deployment
     */
    public $deployment;

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\Deployment $deployment
     *
     * @return void
     */
    public function __construct(Deployment $deployment)
    {
        $this->deployment = $deployment;
    }

    /**
     * Get the stack instance for the object.
     *
     * @return \App\Models\Stack
     */
    public function stack()
    {
        return $this->deployment->stack;
    }

    /**
     * Create an alert for the given instance.
     *
     * @return \App\Models\Alert
     */
    public function toAlert()
    {
        return $this->deployment->project()->alerts()->create([
            'stack_id' => $this->deployment->stack->id,
            'type' => 'DeploymentTimedOut',
            'exception' => '',
            'meta' => [
                'deployment_id' => $this->deployment->id
            ],
        ]);
    }
}
