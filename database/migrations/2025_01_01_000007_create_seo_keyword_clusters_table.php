<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seo_keyword_clusters', function (Blueprint $table) {
            $table->id();
            $table->string('cluster_name');
            $table->string('primary_keyword');
            $table->string('language')->default('ar');
            $table->timestamps();

            $table->index('primary_keyword');
        });

        Schema::create('seo_cluster_keywords', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cluster_id')->constrained('seo_keyword_clusters')->cascadeOnDelete();
            $table->string('keyword');
            $table->enum('search_intent', ['transactional', 'informational'])->default('informational');
            $table->enum('page_type', ['service', 'district', 'blog', 'programmatic'])->default('blog');
            $table->unsignedBigInteger('target_entity_id')->nullable();
            $table->integer('priority')->default(10);
            $table->boolean('enabled')->default(true);
            $table->timestamps();

            $table->index('cluster_id');
            $table->index('keyword');
            $table->index('enabled');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_cluster_keywords');
        Schema::dropIfExists('seo_keyword_clusters');
    }
};
