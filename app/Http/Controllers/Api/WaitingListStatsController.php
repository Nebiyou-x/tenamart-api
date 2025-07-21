<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WaitingList;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class WaitingListStatsController extends Controller
{
    public function index(Request $request)
    {
        $view = $request->query('view', 'daily');

        // Total signups
        $totalSignups = WaitingList::count();

        // Signups by source
        $signupsBySource = WaitingList::select('signup_source', DB::raw('count(*) as total'))
            ->groupBy('signup_source')
            ->get();

        // Date range - last 30 days or weeks
        if ($view === 'weekly') {
            $start = Carbon::now()->subWeeks(30)->startOfWeek();
            $end = Carbon::now()->endOfWeek();

            $trends = WaitingList::select(
                    DB::raw('YEAR(created_at) as year'),
                    DB::raw('WEEK(created_at, 1) as week'),
                    DB::raw('count(*) as total')
                )
                ->whereBetween('created_at', [$start, $end])
                ->groupBy('year', 'week')
                ->orderBy('year')
                ->orderBy('week')
                ->get()
                ->map(function ($item) {
                    return [
                        'year' => $item->year,
                        'week' => $item->week,
                        'total' => $item->total,
                    ];
                });

            // Find peak signup week
            $peak = $trends->sortByDesc('total')->first();
        } else {
            // daily (default)
            $start = Carbon::now()->subDays(30)->startOfDay();
            $end = Carbon::now()->endOfDay();

            $trends = WaitingList::select(
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('count(*) as total')
                )
                ->whereBetween('created_at', [$start, $end])
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            // Find peak signup day
            $peak = $trends->sortByDesc('total')->first();
        }

        return response()->json([
            'total_signups' => $totalSignups,
            'signups_by_source' => $signupsBySource,
            'trends' => $trends,
            'peak_signup' => $peak,
        ]);
    }
}
