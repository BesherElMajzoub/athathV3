<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$cols = Illuminate\Support\Facades\DB::select('DESCRIBE visitor_events');
foreach ($cols as $c) {
    echo $c->Field . ' | ' . $c->Type . ' | NULL=' . $c->Null . "\n";
}

echo "\n--- visitor_events count: " . Illuminate\Support\Facades\DB::table('visitor_events')->count() . "\n";
