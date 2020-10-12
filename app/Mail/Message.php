<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Message extends Mailable
{
    use Queueable, SerializesModels;

    protected  $message_;
    protected  $subject_;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($message_,$subject_)
    {
        $this->message_ = $message_;
        $this->subject_ = $subject_;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject_)->view('client.mails.message')->with(['text'=> $this->message_]);
    }
}
