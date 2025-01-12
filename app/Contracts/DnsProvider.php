<?php

namespace App\Contracts;

use App\Models\Stack;

interface DnsProvider
{
    /**
     * Add a DNS record for the given stack.
     *
     * @param  \App\Models\Stack $stack
     *
     * @return string
     */
    public function addRecord(Stack $stack);

    /**
     * Determine if the stack's DNS record has propagated.
     *
     * @param \App\Models\Stack $stack
     *
     * @return bool
     */
    public function propagated(Stack $stack);

    /**
     * Delete a DNS record for the given stack.
     *
     * @param \App\Models\Stack $stack
     *
     * @return void
     */
    public function deleteRecord(Stack $stack);

    /**
     * Delete a DNS record for the given name and address.
     *
     * @param  string  $name
     * @param  string  $ipAddress
     * @return void
     */
    public function deleteRecordByName($name, $ipAddress);
}
