<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class StackIsPromotable implements Rule
{
    /**
     * The stack instance.
     *
     * @var \App\Models\Stack
     */
    public $stack;

    /**
     * Create a new rule instance.
     *
     * @param  \App\Models\Stack $stack
     *
     * @return void
     */
    public function __construct($stack)
    {
        $this->stack = $stack;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->stack->promotable();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The specified stack is not promotable. Please verify the stack has a "serves" directive.';
    }
}
