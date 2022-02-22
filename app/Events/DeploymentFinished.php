<?php

namespace App\Events;

use App\Contracts\Alertable;
use App\Contracts\HasStack;
use App\Models\Deployment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DeploymentFinished implements Alertable, HasStack, ShouldBroadcast
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
            'level' => 'success',
            'type' => 'DeploymentFinished',
            'exception' => '',
            'meta' => [
                'deployment_id' => $this->deployment->id,
                'repository' => $this->deployment->repository(),
                'commit_hash' => $this->deployment->commit_hash,
            ],
        ]);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel(
            'stack.'.$this->deployment->stack->id
        );
    }
}
