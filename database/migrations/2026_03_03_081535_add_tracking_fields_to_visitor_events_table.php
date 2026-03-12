<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('visitor_events', function (Blueprint $table) {
            $table->string('ip_hash', 64)->nullable()->after('session_uuid');
            $table->string('user_agent', 512)->nullable()->after('ip_hash');
            $table->string('referrer', 512)->nullable()->after('user_agent');
        });
    }

    public function down(): void
    {
        Schema::table('visitor_events', function (Blueprint $table) {
            $table->dropColumn(['ip_hash', 'user_agent', 'referrer']);
        });
    }
};
