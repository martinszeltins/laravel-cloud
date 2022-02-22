<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ServerProvider;
use Illuminate\Http\Request;

class ServerProviderSizeController extends Controller
{
    /**
     * Get all of the regions for the given provider.
     *
     * @param  Request                    $request
     * @param  \App\Models\ServerProvider $provider
     *
     * @return Response
     */
    public function index(Request $request, ServerProvider $provider)
    {
        return $provider->sizes();
    }
}
