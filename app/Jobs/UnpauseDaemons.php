<?php

namespace App\Jobs;

use App\Scripts\UnpauseDaemons as UnpauseDaemonsScript;

class UnpauseDaemons extends ManipulatesDaemons
{
    /**
     * Get the script instance for the job.
     *
     * @return \App\Scripts\Script
     */
    public function script()
    {
        return new UnpauseDaemonsScript($this->deployment);
    }
}
