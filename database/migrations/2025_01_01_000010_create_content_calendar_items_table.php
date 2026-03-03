<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('content_calendar_items', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['blog_post', 'programmatic_page'])->default('blog_post');
            $table->unsignedBigInteger('entity_id')->nullable(); // post_id or programmatic_page_id
            $table->dateTime('scheduled_for');
            $table->enum('status', ['pending', 'published', 'skipped'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('scheduled_for');
            $table->index('status');
            $table->index(['status', 'scheduled_for']); // compound for publish-due command
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('content_calendar_items');
    }
};
