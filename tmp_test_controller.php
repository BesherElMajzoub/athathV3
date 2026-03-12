<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Simulate exactly what the TrackingController receives
$request = \Illuminate\Http\Request::create('/api/track/click', 'POST', [], [], [], [
    'CONTENT_TYPE'  => 'application/json',
    'HTTP_ACCEPT'   => 'application/json',
], json_encode([
    'event_type' => 'cta_whatsapp_click',
    'page_url'   => 'http://127.0.0.1:8000/',
    'meta_data'  => ['placement' => 'hero', 'device_hint' => 'desktop'],
]));

try {
    $controller = new \App\Http\Controllers\Api\TrackingController();
    $response   = $controller->click($request);
    echo "HTTP Status: " . $response->getStatusCode() . "\n";
    echo "Body: " . $response->getContent() . "\n";
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "AT: " . $e->getFile() . ':' . $e->getLine() . "\n";
    echo "TRACE:\n" . $e->getTraceAsString() . "\n";
}
