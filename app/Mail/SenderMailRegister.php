<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SenderMailRegister extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $token;

    /**
     * Create a new message instance.
     * SenderMailRegister constructor.
     * @param $name
     * @param $token
     *
     */
    public function __construct( $name,$token )
    {
        $this->name = $name;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.account.request-pass')->subject('Verificación de correo - Kryptopago');
    }
}
