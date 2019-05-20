<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class sendMailRegisterByAdmin extends Mailable
{
    use Queueable, SerializesModels;
    public $commerce;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $commerce )
    {
        $this->commerce  = $commerce;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.account.register-by-admin')
                    ->subject('Has sido registrado en Kryptopay');
    }
}
