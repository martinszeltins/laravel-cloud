<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Stack;

class LastDeploymentController extends Controller
{
    use CancelsDeployments;

    /**
     * Cancel the current deployment for the given stack.
     *
     * @param  \App\Models\Stack $stack
     *
     * @return Response
     */
    public function destroy(Stack $stack)
    {
        $this->authorize('view', $stack);

        if ($deployment = $stack->lastDeployment()) {
            return $this->cancel($deployment);
        }

        return response()->json([
            'deployment' => ['No deployments exist for this stack.'],
        ], 400);
    }
}
