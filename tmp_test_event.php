<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    $result = \App\Models\VisitorEvent::create([
        'session_uuid' => null,
        'event_type'   => 'cta_whatsapp_click',
        'page_url'     => 'http://127.0.0.1:8000/',
        'ip_hash'      => hash('sha256', '127.0.0.1' . 'secret'),
        'user_agent'   => 'TestAgent/1.0',
        'referrer'     => '',
        'meta_data'    => ['placement' => 'hero', 'device_hint' => 'desktop'],
        'created_at'   => now(),
    ]);
    echo "OK - ID: " . $result->id . "\n";
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "LINE: " . $e->getFile() . ':' . $e->getLine() . "\n";
}
