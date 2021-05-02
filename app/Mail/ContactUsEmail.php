<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactUsEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $message;
    protected $email;
    protected $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($message, $email, $name)
    {
        $this->message = $message;
        $this->email = $email;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.contact_us_email')->with([
            'message'=>$this->message,
            'email'=>$this->email,
            'name'=>$this->name
        ]);
    }
}
