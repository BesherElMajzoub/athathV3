<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ClickTrackingService;

class ClickTrackingController extends Controller
{
    protected $trackingService;

    public function __construct(ClickTrackingService $trackingService)
    {
        $this->trackingService = $trackingService;
    }

    public function track(Request $request)
    {
        $validated = $request->validate([
            'event_type' => ['required', 'string', 'max:100'],
            'page_url'   => ['required', 'string', 'max:500'],
            'placement'  => ['nullable', 'string', 'max:100'],
            'target_url' => ['nullable', 'string', 'max:500'],
            'meta_data'  => ['nullable', 'array'],
        ]);

        $ip = $request->ip();

        $data = [
            'event_type' => $validated['event_type'],
            'page_url'   => $validated['page_url'],
            'placement'  => $validated['placement'] ?? null,
            'target_url' => $validated['target_url'] ?? null,
            'meta_data'  => $validated['meta_data'] ?? null,
            'user_agent' => $request->userAgent(),
            'referrer'   => $request->header('referer'),
        ];

        $this->trackingService->logClick($data, $ip);

        if ($request->isMethod('get')) {
            return response(base64_decode('R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7'))
                ->header('Content-Type', 'image/gif')
                ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        }

        return response()->json(['success' => true]);
    }
}
