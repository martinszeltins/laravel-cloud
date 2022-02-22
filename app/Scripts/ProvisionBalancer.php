<?php

namespace App\Scripts;

use App\Models\Balancer;

class ProvisionBalancer extends ProvisioningScript
{
    /**
     * The displayable name of the script.
     *
     * @var string
     */
    public $name = 'Provisioning Balancer';

    /**
     * The balancer instance.
     *
     * @var \App\Models\Balancer
     */
    public $balancer;

    /**
     * Create a new script instance.
     *
     * @param  \App\Models\Balancer $balancer
     *
     * @return void
     */
    public function __construct(Balancer $balancer)
    {
        parent::__construct($balancer);

        $this->balancer = $balancer;
    }

    /**
     * Get the contents of the script.
     *
     * @return string
     */
    public function script()
    {
        return view('scripts.balancer.provision', ['script' => $this])->render();
    }
}
