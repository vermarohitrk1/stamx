<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailTest extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
     
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       
       $this->markdown('email.test')->subject('Nice Subject - ' . env('APP_NAME'));;
 
    }
}
