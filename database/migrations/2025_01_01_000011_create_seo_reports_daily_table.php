<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seo_reports_daily', function (Blueprint $table) {
            $table->id();
            $table->date('date')->unique();
            $table->integer('posts_published')->default(0);
            $table->integer('programmatic_published')->default(0);
            $table->integer('drafts_count')->default(0);
            $table->integer('indexable_pages_count')->default(0);
            $table->integer('sitemap_urls_count')->default(0);
            $table->timestamps();

            $table->index('date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_reports_daily');
    }
};
