<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seo_keywords', function (Blueprint $table) {
            $table->id();
            $table->string('keyword');
            $table->enum('intent', ['transactional', 'informational', 'navigational'])->default('informational');
            $table->string('page_type')->default('blog'); // service, district, blog
            $table->string('target_slug')->nullable();
            $table->json('synonyms')->nullable();
            $table->timestamps();

            $table->index('keyword');
            $table->index('page_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_keywords');
    }
};
