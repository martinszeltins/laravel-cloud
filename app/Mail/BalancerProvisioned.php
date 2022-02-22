<?php

namespace App\Mail;

use App\Models\Balancer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BalancerProvisioned extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The balancer instance.
     *
     * @var \App\Models\Balancer
     */
    public $balancer;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\Balancer $balancer
     *
     * @return void
     */
    public function __construct(Balancer $balancer)
    {
        $this->balancer = $balancer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Balancer Created')
                    ->markdown('mail.balancer.provisioned', [
                        'balancer' => $this->balancer,
                    ]);
    }
}
