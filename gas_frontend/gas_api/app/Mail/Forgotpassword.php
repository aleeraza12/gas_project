<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Forgotpassword extends Mailable
{
    use Queueable, SerializesModels;

    public $body;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($body)
    {
        $this->body = $body;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.Forgotpassword')->with('body', $this->body);
    }
}
