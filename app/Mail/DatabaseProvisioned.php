<?php

namespace App\Mail;

use App\Models\Database;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DatabaseProvisioned extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The database instance.
     *
     * @var \App\Models\Database
     */
    public $database;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\Database $database
     *
     * @return void
     */
    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Database Created')
                    ->markdown('mail.database.provisioned', [
                        'database' => $this->database,
                    ]);
    }
}
