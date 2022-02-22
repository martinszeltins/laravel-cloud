<?php

namespace App\Exceptions;

use App\Models\Stack;
use Exception;

class ManifestNotFoundException extends Exception
{
    /**
     * The stack instance.
     *
     * @var \App\Models\Stack
     */
    public $stack;

    /**
     * The repository name.
     *
     * @var string
     */
    public $repository;

    /**
     * The branch name.
     *
     * @var string
     */
    public $branch;

    /**
     * Create a new exception instance.
     *
     * @param  \App\Models\Stack $stack
     * @param  string            $repository
     * @param  string            $branch
     *
     * @return void
     */
    public function __construct(Stack $stack, $repository, $branch)
    {
        $this->stack = $stack;
        $this->branch = $branch;
        $this->repository = $repository;
    }

    /**
     * Render the exception.
     *
     * @return Response
     */
    public function render()
    {
        return response('Cloud manifest not found.', 404);
    }
}
