<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailer;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\SerializesModels;

class OrderPlaced extends Mailable
{
    use Queueable,SerializesModels;

    protected $details;

    public function __construct($details)
    {
        $this->details = $details;
    }

    public function build()
    {
        $details = $this->details;
        $this->subject('New Order')
            ->view('master.email.order-placed',['order'=>$details]);
        return $this;
    }


}
