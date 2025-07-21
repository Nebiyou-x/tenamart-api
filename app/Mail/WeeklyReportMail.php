<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WeeklyReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $total;
    public $bySource;
    public $peakDay;
    public $trends;

    public function __construct($total, $bySource, $peakDay, $trends)
    {
        $this->total = $total;
        $this->bySource = $bySource;
        $this->peakDay = $peakDay;
        $this->trends = $trends;
    }

    public function build()
    {
        return $this->view('emails.weekly_report')
                    ->with([
                        'total' => $this->total,
                        'bySource' => $this->bySource,
                        'peakDay' => $this->peakDay,
                        'trends' => $this->trends,
                    ]);
    }
}
