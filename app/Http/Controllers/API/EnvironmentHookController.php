<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Environment;
use Illuminate\Http\Request;

class EnvironmentHookController extends Controller
{
    /**
     * Get the hooks for the given environment.
     *
     * @param  Request                 $request
     * @param  \App\Models\Environment $environment
     *
     * @return Response
     */
    public function index(Request $request, Environment $environment)
    {
        $this->authorize('view', $environment->project);

        return $environment->stacks->load('hooks.stack')
                            ->flatMap
                            ->hooks
                            ->sortBy('name')
                            ->sortBy('stack.name')
                            ->values();
    }
}
