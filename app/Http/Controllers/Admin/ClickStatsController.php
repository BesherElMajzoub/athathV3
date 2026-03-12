<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClickStatsController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', now()->subDays(30)->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());
        $eventType = $request->input('event_type');
        $pageUrl = $request->input('page_url');

        $query = DB::table('click_events')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);

        if ($eventType) {
            $query->where('event_type', $eventType);
        }

        if ($pageUrl) {
            $query->where('page_url', 'LIKE', "%{$pageUrl}%");
        }

        // Stats
        $totalClicks = $query->count();

        // Sub queries without applying identical complex builder clones manually to avoid mutation issues
        $topPagesQuery = clone $query;
        $topPages = $topPagesQuery->select('page_url', DB::raw('COUNT(*) as total'))
            ->groupBy('page_url')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $topPlacementsQuery = clone $query;
        $topPlacements = $topPlacementsQuery->select('placement', DB::raw('COUNT(*) as total'))
            ->whereNotNull('placement')
            ->groupBy('placement')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $eventsListQuery = clone $query;
        $events = $eventsListQuery->orderByDesc('created_at')->paginate(50);
        
        $allEventTypes = DB::table('click_events')->select('event_type')->distinct()->pluck('event_type');

        return view('admin.clicks.index', compact(
            'events', 'totalClicks', 'topPages', 'topPlacements', 
            'startDate', 'endDate', 'eventType', 'pageUrl', 'allEventTypes'
        ));
    }
}
