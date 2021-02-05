<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNewPropertiesEmailable extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    private $url;
    private $name;
    private $props;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($url, $name, $props)
    {
        $this->url=$url;
        $this->name=$name;
        $this->props = $props;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // dd($this->url);
        return $this->view('admin.emails.newProperties')
            ->subject("Property Baru telah disetujui!")
            ->from("no-reply@aksamedia.com")
            ->with('url',$this->url)
            ->with('name',$this->name)
            ->with('props',$this->props);
    }
}
