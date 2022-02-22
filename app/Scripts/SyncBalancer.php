<?php

namespace App\Scripts;

use App\Models\Balancer;
use App\Models\Stack;
use App\Services\CaddyBalancerConfiguration;

class SyncBalancer extends Script
{
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
        $this->balancer = $balancer;
    }

    /**
     * Get the name of the script.
     *
     * @return string
     */
    public function name()
    {
        return "Syncing Load Balancer ({$this->balancer->name})";
    }

    /**
     * Get the contents of the script.
     *
     * @return string
     */
    public function script()
    {
        return view('scripts.balancer.sync', ['script' => $this])->render();
    }

    /**
     * Get the Caddy server configuration for the actual domains.
     *
     * @return string
     */
    public function actualDomainConfiguration()
    {
        return collect($this->balancer->project->allStacks())->flatMap(function ($stack) {
            return $this->balancerConfigurations(
                $stack,
                $stack->actualDomainsWithPorts(),
                $stack->privateWebAddresses()
            );
        })->implode(PHP_EOL);
    }

    /**
     * Get the Caddy server configuration for the vanity domains.
     *
     * @return string
     */
    public function vanityDomainConfiguration()
    {
        return collect($this->balancer->project->allStacks())->flatMap(function ($stack) {
            return $this->balancerConfigurations(
                $stack,
                $stack->vanityDomainsWithPorts(),
                $stack->privateWebAddresses()
            );
        })->implode(PHP_EOL);
    }

    /**
     * Get the balancer configurations for the given domain and proxies.
     *
     * @param  \App\Models\Stack $stack
     * @param  array             $domains
     * @param  array             $proxyTo
     *
     * @return array
     */
    protected function balancerConfigurations(Stack $stack, $domains, $proxyTo)
    {
        return collect($domains)->map(function ($domain) use ($stack, $proxyTo) {
            return (new CaddyBalancerConfiguration(
                $this->balancer, $stack, $domain, $proxyTo
            ))->render();
        })->all();
    }

    /**
     * Get the timeout for the script.
     *
     * @return int|null
     */
    public function timeout()
    {
        return 15;
    }
}
