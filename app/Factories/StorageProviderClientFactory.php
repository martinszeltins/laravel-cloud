<?php

namespace App\Factories;

use App\Models\StorageProvider;
use App\Services\Providers\S3;
use InvalidArgumentException;

class StorageProviderClientFactory
{
    /**
     * Create a storage provider client instance for the given provider.
     *
     * @param  \App\Models\StorageProvider $provider
     *
     * @return \App\Contracts\StorageProviderClient
     */
    public function make(StorageProvider $provider)
    {
        switch ($provider->type) {
            case 'S3':
                return new S3($provider);
            default:
                throw new InvalidArgumentException("Invalid provider type.");
        }
    }
}
