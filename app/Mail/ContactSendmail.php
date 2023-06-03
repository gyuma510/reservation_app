<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactSendmail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $contact;

    /**
     * Create a new message instance.
     */
    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    public function build()
    {
        return $this
            ->from('yumagoto287@gmail.com')
            ->view('contacts.mail')
            ->with([
                'name' => $this->contact->name,
                'email' => $this->contact->email,
                'content' => $this->contact->content,
            ])
            ->subject('お問い合わせを受け付けました');
    }
}
