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
        Schema::create('nurses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
        
            // Shaxsiy ma'lumotlar
            $table->date('birth_date')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->string('passport_series')->nullable(); // AA
            $table->string('passport_number')->nullable(); // 1234567
            $table->string('address')->nullable(); // Uy manzili
        
            // Kasbiy ma'lumotlar
            $table->string('specialization');        // Mutaxassisligi
            $table->string('position')->nullable();  // Lavozimi
            $table->string('qualification')->nullable(); // Malaka darajasi
            $table->integer('experience_years')->nullable(); // Ish tajribasi
            $table->date('hire_date')->nullable(); // Ishga kirgan sana

            // Taʼlim maʼlumotlari
            $table->string('education_university')->nullable();
            $table->string('education_specialization')->nullable();
            $table->string('education_level')->nullable(); // Bakalavr, Magistr
            $table->date('graduation_date')->nullable();
        
            // Bo'lim va kabinet
            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade');  // Pediatriya
            $table->string('room_number')->nullable(); // 205-xona
        
            // Qoʻshimcha maʼlumotlar
            $table->text('bio')->nullable(); 
            $table->enum('status', ['active', 'inactive', 'on_leave'])->default('inactive');
            $table->string('photo')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nurses'); 
    }
};
