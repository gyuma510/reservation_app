<?php

namespace App\Console\Commands;

use App\Models\Reservation;
use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Mail\RemindMail;
use Illuminate\Support\Facades\Mail;

class RemindBatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:remindBatch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '宿泊前日の10時にリマインドメールを送信する';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tomorrow = Carbon::tomorrow();
        $reservations = Reservation::where('start_date', $tomorrow)->get();

        foreach ($reservations as $reservation){
            Mail::to($reservation->email)->send(new RemindMail($reservation));
        }
    }
}
