<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visitor_events', function (Blueprint $table) {
            $table->id();
            $table->uuid('session_uuid')->index();
            $table->string('event_type')->index(); // page_view, cta_whatsapp_click, etc.
            $table->text('page_url');
            $table->json('meta_data')->nullable(); // extra info
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('session_uuid')->references('uuid')->on('visitor_sessions')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitor_events');
    }
};
