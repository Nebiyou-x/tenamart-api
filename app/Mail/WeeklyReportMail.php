<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class WeeklyReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $stats;

    public function __construct($stats)
    {
        $this->stats = $stats;
    }

    public function build()
    {
        return $this->subject('Weekly Signup Report')
                    ->view('emails.weekly_report');
    }
}

