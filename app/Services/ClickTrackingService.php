<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class ClickTrackingService
{
    /**
     * Store a click event directly into DB.
     * Prevents duplicates within 2 seconds for the same IP + Event + Page.
     */
    public function logClick(array $data, string $ip): bool
    {
        $ipHash = sha1($ip);
        $eventType = substr($data['event_type'], 0, 100);
        $pageUrl = substr($data['page_url'], 0, 500);

        // Prevent duplicate clicks within 2 seconds
        $cacheKey = "click_{$ipHash}_{$eventType}_" . md5($pageUrl);
        if (Cache::has($cacheKey)) {
            return false;
        }
        Cache::put($cacheKey, 1, 2); // store for 2 seconds

        DB::table('click_events')->insert([
            'event_type' => $eventType,
            'page_url'   => $pageUrl,
            'placement'  => isset($data['placement']) ? substr($data['placement'], 0, 100) : null,
            'target_url' => isset($data['target_url']) ? substr($data['target_url'], 0, 500) : null,
            'ip_hash'    => $ipHash,
            'user_agent' => isset($data['user_agent']) ? substr($data['user_agent'], 0, 500) : null,
            'referrer'   => isset($data['referrer']) ? substr($data['referrer'], 0, 500) : null,
            'meta_data'  => isset($data['meta_data']) ? json_encode($data['meta_data'], JSON_UNESCAPED_UNICODE) : null,
            'created_at' => now(),
        ]);

        return true;
    }
}
