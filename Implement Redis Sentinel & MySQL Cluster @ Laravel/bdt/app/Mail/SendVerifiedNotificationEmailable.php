<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendVerifiedNotificationEmailable extends Mailable
{
    use Queueable, SerializesModels;
    private $recipient;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name)
    {
        //
        $this->recipient=$name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('admin.emails.verifiedNotification')->with('recipient',$this->recipient)->from("no-reply@aksamedia.com")->subject("Notifikasi Verifikasi");
    }
}
