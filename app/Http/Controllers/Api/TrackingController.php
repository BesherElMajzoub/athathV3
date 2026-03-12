<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VisitorEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class TrackingController extends Controller
{
    /**
     * POST /api/track/click
     * Stores a click event. No session required — tracks anonymous clicks.
     * Rate limited: 30 clicks per IP per minute.
     */
    public function click(Request $request)
    {
        $ip = $request->ip();
        $key = 'track:' . $ip;

        if (RateLimiter::tooManyAttempts($key, 30)) {
            return response()->json(['ok' => false, 'error' => 'rate_limited'], 429);
        }
        RateLimiter::hit($key, 60);

        $validated = $request->validate([
            'event_type' => ['required', 'string', 'max:80', 'regex:/^[a-z_]+$/'],
            'page_url'   => ['required', 'string', 'max:512'],
            'referrer'   => ['nullable', 'string', 'max:512'],
            'meta_data'  => ['nullable', 'array'],
        ]);

        $sessionUuid = $request->cookie('visitor_uuid');

        VisitorEvent::create([
            'session_uuid' => $sessionUuid ?: null,
            'event_type'   => $validated['event_type'],
            'page_url'     => substr($validated['page_url'], 0, 512),
            'ip_hash'      => hash('sha256', $ip . config('app.key')),
            'user_agent'   => substr($request->userAgent() ?? '', 0, 512),
            'referrer'     => substr($validated['referrer'] ?? $request->header('Referer', ''), 0, 512),
            'meta_data'    => $validated['meta_data'] ?? null,
            'created_at'   => now(),
        ]);

        return response()->json(['ok' => true]);
    }

    /**
     * Legacy endpoint — keep working for old code
     */
    public function logEvent(Request $request)
    {
        return $this->click($request->merge([
            'event_type' => $request->input('event_type', 'page_view'),
        ]));
    }
}
