<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
//use Illuminate\Contracts\Queue\ShouldQueue;

class SenderMailRecuePassCommerci extends Mailable
{
    public $name_soli;
    public $name_admin_commerce;
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct($name_soli,$name_admin_commerce)
    {
        $this->name_soli = $name_soli;
        $this->name_admin_commerce = $name_admin_commerce;
    }

    /**
     * Build the message.
     *
     * @return $this
     */

    public function build()
    {
        return $this->view('emails.account.reset-pass-type-commerce')
                    ->subject('Solicitud de recuperacion de contraseña');
    }
}
