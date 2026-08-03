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
        Schema::create('hospitalization_staff', function (Blueprint $table) {
            $table->id();
        
            $table->foreignId('hospitalization_id')
                  ->constrained()
                  ->cascadeOnDelete();
        
            // polymorphic staff (doctor | nurse)
            $table->unsignedBigInteger('staff_id');
            $table->string('staff_type'); // App\Models\Doctor | App\Models\Nurse
        
            $table->string('role')->nullable();
        
            $table->dateTime('assigned_at')->nullable();
            $table->dateTime('unassigned_at')->nullable();
        
            $table->timestamps();
        
            $table->index(['staff_id', 'staff_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospitalization_staff');
    }
};
