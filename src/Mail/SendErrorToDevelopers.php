<?php

namespace BrandStudio\Devil\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendErrorToDevelopers extends Mailable
{
    use Queueable, SerializesModels;

    protected $trace;
    protected $message = [];

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($trace, $message)
    {
        $this->trace = $trace;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.error', ['trace' => $this->trace, 'message' => $this->message]);
    }
}
