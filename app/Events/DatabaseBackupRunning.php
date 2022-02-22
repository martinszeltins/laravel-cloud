<?php

namespace App\Events;

use App\Models\DatabaseBackup;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DatabaseBackupRunning
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The database backup instance.
     *
     * @var \App\Models\DatabaseBackup
     */
    public $backup;

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\DatabaseBackup $backup
     *
     * @return void
     */
    public function __construct(DatabaseBackup $backup)
    {
        $this->backup = $backup;
    }
}
