<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('post_slugs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            $table->string('old_slug');
            $table->timestamp('created_at')->nullable();

            $table->index('post_id');
            $table->index('old_slug');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_slugs');
    }
};
