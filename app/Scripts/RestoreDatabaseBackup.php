<?php

namespace App\Scripts;

use App\Models\DatabaseRestore;

class RestoreDatabaseBackup extends Script
{
    /**
     * The user that the script should be run as.
     *
     * @var string
     */
    public $sshAs = 'cloud';

    /**
     * The database restore instance.
     *
     * @var \App\Models\DatabaseRestore
     */
    public $restore;

    /**
     * Create a new script instance.
     *
     * @param  \App\Models\DatabaseRestore $restore
     *
     * @return void
     */
    public function __construct(DatabaseRestore $restore)
    {
        $this->restore = $restore;
    }

    /**
     * Get the name of the script.
     *
     * @return string
     */
    public function name()
    {
        return "Restoring Database Backup ({$this->restore->database->name})";
    }

    /**
     * Get the contents of the script.
     *
     * @return string
     */
    public function script()
    {
        return view('scripts.database.restore', [
            'script' => $this,
            'restore' => $this->restore,
            'backup' => $this->restore->backup,
        ])->render();
    }

    /**
     * Get the timeout for the script.
     *
     * @return int|null
     */
    public function timeout()
    {
        return 3600;
    }
}
