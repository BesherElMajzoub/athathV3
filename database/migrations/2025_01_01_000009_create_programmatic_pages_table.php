<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('programmatic_pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('city')->default('جدة');
            $table->unsignedBigInteger('district_id')->nullable();
            $table->unsignedBigInteger('service_id')->nullable();
            $table->string('primary_keyword');
            $table->string('title');
            $table->string('meta_title');
            $table->string('meta_description');
            $table->string('canonical_url')->nullable();
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->boolean('indexable')->default(true);
            $table->json('content_blocks')->nullable(); // intro, bullets, faq, cta blocks
            $table->timestamp('last_generated_at')->nullable();
            $table->timestamps();

            $table->index('slug');
            $table->index('status');
            $table->index('indexable');
            $table->index('district_id');
            $table->index('service_id');
            $table->index('primary_keyword');
            $table->index(['status', 'indexable']); // compound for sitemap queries
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('programmatic_pages');
    }
};
