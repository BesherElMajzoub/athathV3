<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisitorEvent;
use Illuminate\Http\Request;

class ClickTrackingController extends Controller
{
    public function index(Request $request)
    {
        $query = VisitorEvent::where('event_type', '!=', 'page_view');

        // Date filters
        if ($request->filled('from')) {
            $query->where('created_at', '>=', $request->from . ' 00:00:00');
        }
        if ($request->filled('to')) {
            $query->where('created_at', '<=', $request->to . ' 23:59:59');
        }

        // Event type filter
        if ($request->filled('event_type')) {
            $query->where('event_type', 'like', '%' . $request->event_type . '%');
        }

        // Page URL filter
        if ($request->filled('page_url')) {
            $query->where('page_url', 'like', '%' . $request->page_url . '%');
        }

        // Stats (before pagination)
        $statsQuery = clone $query;
        $totalClicks = $statsQuery->count();

        $topPages = (clone $query)
            ->selectRaw('page_url, COUNT(*) as click_count')
            ->groupBy('page_url')
            ->orderByDesc('click_count')
            ->limit(5)
            ->get();

        $topEvents = (clone $query)
            ->selectRaw('event_type, COUNT(*) as click_count')
            ->groupBy('event_type')
            ->orderByDesc('click_count')
            ->limit(5)
            ->get();

        // Paginated results
        $events = $query->orderByDesc('created_at')->paginate(25)->appends($request->all());

        return view('admin.tracking.clicks', compact(
            'events', 'totalClicks', 'topPages', 'topEvents'
        ));
    }
}
