<?php

namespace App\Mail;

use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ShiftRequest extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $shift;
    private $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($shift, $user)
    {
        $this->shift = $shift;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        $date = Carbon::parse($this->shift->date_time)->format('Y-m-d');
        $time = Carbon::parse($this->shift->date_time)->format('H:i A');
        $user = $this->user;
        $url = route('shifts.index');

        return $this->to($this->shift->company->email)
            ->subject(Shift::PICK_UP_REQUEST)
            ->markdown('mail.shift-request', compact('date', 'time', 'user', 'url'));
    }
}
