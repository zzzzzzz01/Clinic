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
        Schema::create('hospitalization_procedures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospitalization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete(); // Bemor

            $table->foreignId('procedure_id')->constrained(); // Protsedura
            $table->unsignedBigInteger('staff_id');
            $table->string('staff_type'); // App\Models\Doctor | App\Models\Nurse
            
            // $table->foreignId('assigned_by')->constrained('users'); // Kim biriktirdi (user id)
            
            // $table->enum('assigned_by_type', ['doctor', 'nurse']); // Kimligi (Doctor / Nurse)
            
            $table->decimal('price', 10, 2); // Narx (biriktirilgan paytdagi)
            
            $table->timestamp('assigned_at')->useCurrent(); // Biriktirilgan vaqt
            
            $table->foreignId('room_id')->nullable()->constrained()->nullOnDelete(); // Xona
            
            $table->text('notes')->nullable(); // Izoh

            $table->enum('status', ['pending','scheduled','in_progress','completed','cancelled'])->default('pending'); // Holati

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospitalization_procedurs');
    }
};
