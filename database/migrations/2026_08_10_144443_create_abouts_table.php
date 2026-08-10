<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Halaman "Tentang" di-edit sebagai satu baris konten (singleton).
     */
    public function up(): void
    {
        Schema::create('abouts', function (Blueprint $table) {
            $table->id();

            // Hero
            $table->string('hero_eyebrow')->nullable();
            $table->string('hero_title')->nullable();
            $table->text('hero_subtitle')->nullable();
            $table->string('hero_image')->nullable();

            // Our story
            $table->string('story_eyebrow')->nullable();
            $table->string('story_title')->nullable();
            $table->text('story_body')->nullable();
            $table->string('story_image')->nullable();

            // Mission & vision
            $table->text('mission')->nullable();
            $table->text('vision')->nullable();

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('abouts');
    }
};
