<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hospitalization_rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospitalization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('bed_id')->constrained('bed_rooms')->cascadeOnDelete();
            // qachondan qachongacha mas’ul bo‘lgan
            $table->dateTime('assigned_at')->nullable();
            $table->dateTime('unassigned_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospitalization_rooms');
    }
};
