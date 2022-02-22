<?php

namespace App\Exceptions;

use App\Models\Stack;
use Exception;

class StackProvisioningTimeout extends Exception
{
    /**
     * The stack instance.
     *
     * @var \App\Models\Stack
     */
    public $stack;

    /**
     * Create a new exception instance.
     *
     * @param  \App\Models\Stack $stack
     *
     * @return void
     */
    public function __construct(Stack $stack)
    {
        parent::__construct();

        $this->stack = $stack;
    }
}
