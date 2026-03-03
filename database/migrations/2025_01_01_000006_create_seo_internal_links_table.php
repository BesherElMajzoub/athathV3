<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seo_internal_links', function (Blueprint $table) {
            $table->id();
            $table->string('phrase'); // e.g., "شراء مكيفات مستعملة"
            $table->string('target_url');
            $table->integer('priority')->default(10);
            $table->boolean('enabled')->default(true);
            $table->timestamps();

            $table->index('phrase');
            $table->index('enabled');
            $table->index('priority');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_internal_links');
    }
};
