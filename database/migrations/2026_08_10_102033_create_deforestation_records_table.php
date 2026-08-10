<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deforestation_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('region_id')->constrained()->cascadeOnDelete();
            $table->foreignId('land_cover_type_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('year');
            $table->enum('change_type', ['loss', 'gain', 'stable'])->index();
            $table->decimal('area_km2', 12, 2);
            $table->string('cause')->nullable();
            $table->string('source')->nullable();
            $table->json('geometry')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['region_id', 'year', 'change_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deforestation_records');
    }
};

