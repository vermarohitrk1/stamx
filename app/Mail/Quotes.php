<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Quotes extends Mailable
{
    use Queueable, SerializesModels;

    public $template;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($template)
    {
       $this->template = $template;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    // public function build()
    // {
    //     return $this->from(config('mail.from.address'), $this->template->from)->subject($this->template->subject)->view('email.courses_list_template')->with('template', $this->template);
    // }
    public function build()
    {
      //  dd( $this->template);
        return $this->markdown('email.test')->subject('Nice Subject - ' . env('APP_NAME'))->with("content",$this->template);
    }
}
