<?php

namespace App\Contracts;

interface HasStack
{
    /**
     * Get the stack instance for the object.
     *
     * @return \App\Models\Stack
     */
    public function stack();
}
