<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Bilingual fields for FAQ items. Category is shared; question and answer
     * get English equivalents with Indonesian fallback.
     */
    public function up(): void
    {
        Schema::table('faq_items', function (Blueprint $table) {
            $table->string('question_en')->nullable()->after('question');
            $table->longText('answer_en')->nullable()->after('answer');
        });
    }

    public function down(): void
    {
        Schema::table('faq_items', function (Blueprint $table) {
            $table->dropColumn(['question_en', 'answer_en']);
        });
    }
};
