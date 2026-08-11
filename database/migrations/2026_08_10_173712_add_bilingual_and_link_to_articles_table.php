<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Bilingual fields (Indonesian is the default in title/excerpt/content;
     * English equivalents are nullable and fall back to Indonesian on the
     * public site) plus an optional external link for card-style articles.
     */
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('title_en')->nullable()->after('title');
            $table->text('excerpt_en')->nullable()->after('excerpt');
            $table->longText('content_en')->nullable()->after('content');
            $table->string('link')->nullable()->after('featured_image');
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumns(['title_en', 'excerpt_en', 'content_en', 'link']);
        });
    }
};
