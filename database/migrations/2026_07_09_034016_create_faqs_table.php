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
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
        
            $table->string('question_uz');
            $table->string('question_ru');
            $table->string('question_en');
        
            $table->text('answer_uz');
            $table->text('answer_ru');
            $table->text('answer_en');
        
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('status')->default(true);
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faqs');
    }
};
