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
        Schema::create('post_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('is_liked')->default(true); // true = like, false = unlike
            $table->timestamps();

            // Bir foydalanuvchi bir postga faqat bitta like yoki unlike qoldira oladi
            $table->unique(['post_id', 'user_id']);
            
            // Indexes
            $table->index(['post_id', 'is_liked']);
            $table->index(['user_id', 'is_liked']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_likes');
    }
};
