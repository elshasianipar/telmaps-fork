<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Card-style articles may have only a description + link, so the long
     * body column should be optional.
     */
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->longText('content')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->longText('content')->nullable(false)->change();
        });
    }
};
