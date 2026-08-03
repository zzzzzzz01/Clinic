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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();

            // Foreign key to users table
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Bemorga xos qo‘shimcha ma’lumotlar
            $table->date('birth_date');
            $table->enum('gender', ['male', 'female']);
            $table->string('passport_series')->nullable(); // AA
            $table->string('passport_number')->nullable(); // 1234567
            $table->string('address')->nullable();
            // $table->string('blood_group')->nullable(); // ixtiyoriy
            // $table->text('allergies')->nullable(); // ixtiyoriy
            // $table->text('medical_history')->nullable(); // ixtiyoriy

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
