<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommonEmailTemplate extends Mailable
{
    use Queueable, SerializesModels;

    public $template;

    /**
     * Create a new message instance.
     *
     * @return void
     */
//     public function __construct($template)
//     {
//         $this->template = $template;
//     }

//     /**
//      * Build the message.
//      *
//      * @return $this
//      */
//     public function build()
//     {
//         return $this->from(config('mail.from.address'), $this->template->from)->markdown('email.common_template')->subject($this->template->subject)->with(["content"=>$this->template->content]);
//     }

public function __construct($template)
{
    $this->template = $template;
}

/**
 * Build the message.
 *
 * @return $this
 */
public function build()
{
   // dd( $this->template);
    return $this->from(config('mail.from.address'), $this->template['from'])->markdown('email.common_template')->subject($this->template['subject'])->with(["content"=>$this->template['content']]);
}
 }
