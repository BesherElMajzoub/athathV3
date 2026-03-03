<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seo_templates', function (Blueprint $table) {
            $table->id();
            $table->string('template_key')->unique(); // "district_intro", "service_intro", "faq"
            $table->string('language')->default('ar');
            $table->longText('body'); // supports {city}, {district}, {service}, {keyword}, {brand}, {year}
            $table->timestamps();

            $table->index('template_key');
            $table->index('language');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_templates');
    }
};
