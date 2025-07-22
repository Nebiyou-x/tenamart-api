<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\WaitingList;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\WeeklyReportMail;

class SendWeeklyReport extends Command
{
    protected $signature = 'report:weekly';
    protected $description = 'Send weekly signup report email to admin';

    public function handle()
    {
        $total = WaitingList::count();

        $bySource = WaitingList::select('signup_source', DB::raw('count(*) as total'))
            ->groupBy('signup_source')->get();

        $peakDay = WaitingList::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderByDesc('total')->first();

        $trends = WaitingList::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy(DB::raw('DATE(created_at)'))->get();

        Mail::to('Nebiyoutad@gmail.com')->send(new WeeklyReportMail($total, $bySource, $peakDay, $trends));

        $this->info('Weekly report sent to admin.');
    }
}
