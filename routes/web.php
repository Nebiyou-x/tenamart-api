<?php

use Illuminate\Support\Facades\Route;
use App\Mail\WeeklyReportMail;
use Illuminate\Support\Facades\DB;
use App\Models\WaitingList;
use Illuminate\Support\Facades\Mail;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/preview-weekly-report', function () {
        $total = WaitingList::count();

        $bySource = WaitingList::select('signup_source', DB::raw('count(*) as total'))
            ->groupBy('signup_source')->get();

        $peakDay = WaitingList::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderByDesc('total')->first();

        $trends = WaitingList::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy(DB::raw('DATE(created_at)'))->get();

        return new WeeklyReportMail($total, $bySource, $peakDay, $trends);
    });
});



Route::get('/send-weekly-report', function () {
    $total = WaitingList::count();

    $bySource = WaitingList::select('signup_source', DB::raw('count(*) as total'))
        ->groupBy('signup_source')->get();

    $peakDay = WaitingList::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
        ->groupBy(DB::raw('DATE(created_at)'))
        ->orderByDesc('total')->first();

    $trends = WaitingList::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
        ->where('created_at', '>=', now()->subDays(30))
        ->groupBy(DB::raw('DATE(created_at)'))->get();

    Mail::to('admin@example.com')->send(new WeeklyReportMail($total, $bySource, $peakDay, $trends));

    return 'Weekly report sent!';
});


Route::get('/', function () {
    return view('welcome');
});
