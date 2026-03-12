<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('click_events', function (Blueprint $table) {
            $table->id();
            $table->string('event_type', 100)->index();
            $table->string('page_url', 500)->index();
            $table->string('placement', 100)->nullable();
            $table->string('target_url', 500)->nullable();
            $table->string('ip_hash', 40)->index();
            $table->text('user_agent')->nullable();
            $table->string('referrer', 500)->nullable();
            $table->json('meta_data')->nullable();
            $table->timestamp('created_at')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('click_events');
    }
};
