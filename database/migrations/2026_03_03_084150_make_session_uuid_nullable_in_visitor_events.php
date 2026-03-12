<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('visitor_events', function (Blueprint $table) {
            // Drop the FK constraint first, then alter the column to nullable
            $table->dropForeign(['session_uuid']);
            $table->string('session_uuid', 36)->nullable()->change();
            // Re-add FK but with SET NULL on delete so orphaned events survive
            $table->foreign('session_uuid')
                ->references('uuid')
                ->on('visitor_sessions')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('visitor_events', function (Blueprint $table) {
            $table->dropForeign(['session_uuid']);
            $table->string('session_uuid', 36)->nullable(false)->change();
            $table->foreign('session_uuid')
                ->references('uuid')
                ->on('visitor_sessions')
                ->onDelete('cascade');
        });
    }
};
