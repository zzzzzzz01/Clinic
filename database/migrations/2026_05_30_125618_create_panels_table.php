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
        Schema::create('panels', function (Blueprint $table) {
            $table->id(); 
            $table->string('name_uz'); 
            $table->string('name_ru'); 
            $table->string('name_en'); 
            $table->string('code')->unique();
            $table->decimal('price', 10, 2); 
            $table->integer('time'); 
            $table->text('description_uz')->nullable(); 
            $table->text('description_ru')->nullable(); 
            $table->text('description_en')->nullable(); 
            $table->unsignedBigInteger('department_id')->nullable();
            $table->foreign('department_id')
                  ->references('id')
                  ->on('departments')
                  ->onDelete('set null'); 
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('panels');
    }
};
