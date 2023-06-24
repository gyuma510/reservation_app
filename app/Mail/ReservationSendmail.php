<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservationSendmail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $reservation;

    /**
     * Create a new message instance.
     */
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    public function build()
    {
        return $this
            ->from('yumagoto287@gmail.com')
            ->view('reservations.mail')
            ->with([
                'first_name' => $this->reservation->first_name,
                'last_name' => $this->reservation->last_name,
                'email' => $this->reservation->email,
                'message' => $this->reservation->message,
            ])
            ->subject('予約が完了しました');
    }
}
