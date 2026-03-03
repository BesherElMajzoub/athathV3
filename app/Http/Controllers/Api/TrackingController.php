<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VisitorEvent;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function logEvent(Request $request)
    {
        $validated = $request->validate([
            'event_type' => 'required|string|max:50',
            'page_url'   => 'required|url',
            'meta_data'  => 'nullable|array'
        ]);

        $sessionUuid = $request->cookie('visitor_uuid');
        if (!$sessionUuid) {
            return response()->json(['error' => 'No active session'], 400);
        }

        VisitorEvent::create([
            'session_uuid' => $sessionUuid,
            'event_type'   => $validated['event_type'],
            'page_url'     => $validated['page_url'],
            'meta_data'    => $validated['meta_data'] ?? null,
        ]);

        return response()->json(['success' => true]);
    }
}
