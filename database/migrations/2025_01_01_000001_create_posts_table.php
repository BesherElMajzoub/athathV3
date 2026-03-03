<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->string('featured_image')->nullable();
            $table->string('featured_image_alt')->nullable();
            $table->enum('status', ['draft', 'scheduled', 'published'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->string('canonical_url')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('focus_keyword')->nullable();
            $table->string('schema_type')->default('Article');
            $table->json('schema_faq')->nullable(); // FAQ blocks for FAQPage schema
            $table->integer('reading_time')->nullable();
            $table->string('author_name')->nullable();
            $table->boolean('enable_auto_internal_links')->default(true);
            $table->timestamps();

            $table->index('slug');
            $table->index('status');
            $table->index('published_at');
            $table->index('updated_at');
            $table->index(['status', 'published_at']); // compound for efficient published queries
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
