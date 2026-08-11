<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Bilingual fields for the About singleton. Indonesian is the default in
     * the existing columns; English equivalents are nullable and fall back to
     * Indonesian on the public site, mirroring the articles pattern.
     */
    public function up(): void
    {
        Schema::table('abouts', function (Blueprint $table) {
            $table->string('hero_eyebrow_en')->nullable()->after('hero_eyebrow');
            $table->string('hero_title_en')->nullable()->after('hero_title');
            $table->text('hero_subtitle_en')->nullable()->after('hero_subtitle');
            $table->string('story_eyebrow_en')->nullable()->after('story_eyebrow');
            $table->string('story_title_en')->nullable()->after('story_title');
            $table->text('story_body_en')->nullable()->after('story_body');
            $table->text('mission_en')->nullable()->after('mission');
            $table->text('vision_en')->nullable()->after('vision');
        });
    }

    public function down(): void
    {
        Schema::table('abouts', function (Blueprint $table) {
            $table->dropColumn([
                'hero_eyebrow_en', 'hero_title_en', 'hero_subtitle_en',
                'story_eyebrow_en', 'story_title_en', 'story_body_en',
                'mission_en', 'vision_en',
            ]);
        });
    }
};
