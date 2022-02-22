<?php

namespace App\Jobs;

use App\Models\StorageProvider;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteDatabaseBackup implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The storage provider instance.
     *
     * @var \App\Models\StorageProvider
     */
    public $provider;

    /**
     * The database backup path.
     *
     * @var string
     */
    public $backupPath;

    /**
     * Create a new job instance.
     *
     * @param  \App\Models\StorageProvider $provider
     * @param  string                      $backupPath
     *
     * @return void
     */
    public function __construct(StorageProvider $provider, $backupPath)
    {
        $this->provider = $provider;
        $this->backupPath = $backupPath;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->provider->client()->delete(
            $this->backupPath
        );
    }
}
