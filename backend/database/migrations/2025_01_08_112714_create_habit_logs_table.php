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
        Schema::create('habit_logs', function (Blueprint $table) {
            $table->id();  // Primary key 'id'
            $table->foreignId('habit_id')->constrained()->onDelete('cascade');  // Foreign key reference to 'habits' table
            $table->date('date');  // 'date' field
            $table->enum('status', ['Completed', 'Skipped']);  // 'status' field with enum options
            $table->timestamps();  // 'created_at' and 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('habit_logs');
    }
};
