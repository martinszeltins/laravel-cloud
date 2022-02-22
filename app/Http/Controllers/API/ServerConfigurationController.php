<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Stack;

class ServerConfigurationController extends Controller
{
    /**
     * Update the stack's server configuration.
     *
     * @param  \App\Models\Stack $stack
     *
     * @return mixed
     */
    public function update(Stack $stack)
    {
        $this->authorize('view', $stack);

        $stack->syncServers();
    }
}
