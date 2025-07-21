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

    
    $total = \App\Models\WaitingList::count();

    
    $bySource = \App\Models\WaitingList::select('signup_source', DB::raw('count(*) as total'))
        ->groupBy('signup_source')
        ->get();

   
    if ($view === 'weekly') {
        $trends = \App\Models\WaitingList::select(DB::raw('YEARWEEK(created_at, 1) as week'), DB::raw('count(*) as total'))
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('week')
            ->orderBy('week')
            ->get()
            ->map(function ($item) {
                return [
                    'week' => $item->week,
                    'total' => $item->total
                ];
            });
    } else {
        $trends = \App\Models\WaitingList::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();
    }

    
    $peakDay = \App\Models\WaitingList::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
        ->groupBy(DB::raw('DATE(created_at)'))
        ->orderByDesc('total')
        ->limit(1)
        ->first();

    return response()->json([
        'total_signups' => $total,
        'by_source' => $bySource,
        'trends' => $trends,
        'peak_day' => $peakDay,
    ]);
}

}
