<?php

namespace App\Factories;

use App\Models\ServerProvider;
use App\Services\DigitalOcean;
use InvalidArgumentException;

class ServerProviderClientFactory
{
    /**
     * Create a server provider client instance for the given provider.
     *
     * @param  \App\Models\ServerProvider $provider
     *
     * @return \App\Contracts\ServerProviderClient
     */
    public function make(ServerProvider $provider)
    {
        switch ($provider->type) {
            case 'DigitalOcean':
                return new DigitalOcean($provider);
            default:
                throw new InvalidArgumentException("Invalid provider type.");
        }
    }
}
