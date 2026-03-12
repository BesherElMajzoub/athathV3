<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$db = Illuminate\Support\Facades\DB::connection();

// Step 1: Show current FK constraints
$fks = $db->select("
    SELECT CONSTRAINT_NAME 
    FROM information_schema.KEY_COLUMN_USAGE 
    WHERE TABLE_SCHEMA = DATABASE() 
    AND TABLE_NAME = 'visitor_events' 
    AND REFERENCED_TABLE_NAME IS NOT NULL
    AND COLUMN_NAME = 'session_uuid'
");
echo "FK constraints on session_uuid:\n";
foreach ($fks as $fk) {
    echo "  - " . $fk->CONSTRAINT_NAME . "\n";
}

// Step 2: Drop all FKs on session_uuid
foreach ($fks as $fk) {
    echo "Dropping FK: " . $fk->CONSTRAINT_NAME . "\n";
    $db->statement("ALTER TABLE visitor_events DROP FOREIGN KEY `{$fk->CONSTRAINT_NAME}`");
}

// Step 3: Alter column to nullable
echo "Altering column to NULL...\n";
$db->statement("ALTER TABLE visitor_events MODIFY COLUMN `session_uuid` varchar(36) NULL DEFAULT NULL");

// Step 4: Re-add FK with ON DELETE SET NULL
echo "Re-adding FK with SET NULL...\n";
$db->statement("ALTER TABLE visitor_events ADD CONSTRAINT `visitor_events_session_uuid_foreign` FOREIGN KEY (`session_uuid`) REFERENCES `visitor_sessions` (`uuid`) ON DELETE SET NULL");

// Step 5: Verify
$cols = $db->select("DESCRIBE visitor_events");
foreach ($cols as $c) {
    if ($c->Field === 'session_uuid') {
        echo "Result: session_uuid | Null=" . $c->Null . " | Type=" . $c->Type . "\n";
    }
}
echo "Done!\n";
