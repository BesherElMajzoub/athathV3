<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\VisitorSession;
use App\Models\VisitorEvent;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;

class TrackVisitor
{
    public function handle(Request $request, Closure $next): Response
    {
        // Don't track API or Admin routes
        if ($request->is('api/*') || $request->is('admin/*')) {
            return $next($request);
        }

        $sessionUuid = $request->cookie('visitor_uuid');
        $ipHash = hash('sha256', $request->ip());

        if (!$sessionUuid) {
            $sessionUuid = (string) Str::uuid();
            Cookie::queue('visitor_uuid', $sessionUuid, 60 * 24 * 365); // 1 year

            VisitorSession::create([
                'uuid'         => $sessionUuid,
                'ip_hash'      => $ipHash,
                'user_agent'   => $request->userAgent(),
                'referrer'     => $request->header('referer'),
                'utm_source'   => $request->query('utm_source'),
                'utm_medium'   => $request->query('utm_medium'),
                'utm_campaign' => $request->query('utm_campaign'),
                'utm_term'     => $request->query('utm_term'),
                'utm_content'  => $request->query('utm_content'),
                'gclid'        => $request->query('gclid'),
            ]);
        } else {
            // Update session
            $session = VisitorSession::find($sessionUuid);
            if ($session) {
                // Approximate duration based on difference between first and current request
                // Ensure integer and non-negative
                $diff = max(0, (int) now()->diffInSeconds($session->first_seen_at));
                $session->update([
                    'last_seen_at' => now(),
                    'pageviews' => $session->pageviews + 1,
                    'duration_seconds' => $diff
                ]);
            } else {
                // Cookie exists but DB swept? recreate
                VisitorSession::create([
                    'uuid'       => $sessionUuid,
                    'ip_hash'    => $ipHash,
                    'user_agent' => $request->userAgent(),
                    'referrer'   => $request->header('referer'),
                ]);
            }
        }

        // Log page view event
        VisitorEvent::create([
            'session_uuid' => $sessionUuid,
            'event_type'   => 'page_view',
            'page_url'     => $request->fullUrl(),
        ]);

        return $next($request);
    }
}
