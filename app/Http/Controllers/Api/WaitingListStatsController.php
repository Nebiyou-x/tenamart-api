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

    
    if (!in_array($view, ['daily', 'weekly'])) {
        return response()->json(['error' => 'Invalid view type. Must be daily or weekly.'], 400);
    }

   
    $total = DB::table('waiting_lists')->count();

    
    $bySource = DB::table('waiting_lists')
        ->select('signup_source', DB::raw('count(*) as total'))
        ->groupBy('signup_source')
        ->get();

    
    $trends = DB::table('waiting_lists')
        ->selectRaw("
            " . ($view === 'daily'
                ? "DATE(created_at) as period"
                : "YEARWEEK(created_at, 1) as period") . ",
            count(*) as total
        ")
        ->where('created_at', '>=', now()->subDays(30))
        ->groupBy('period')
        ->orderBy('period')
        ->get();

    
    $peak = DB::table('waiting_lists')
        ->selectRaw('DATE(created_at) as date, count(*) as total')
        ->groupBy('date')
        ->orderByDesc('total')
        ->limit(1)
        ->first();

    return response()->json([
        'total_signups' => $total,
        'by_source' => $bySource,
        'trends' => $trends,
        'peak_day' => $peak,
    ]);
}
}
