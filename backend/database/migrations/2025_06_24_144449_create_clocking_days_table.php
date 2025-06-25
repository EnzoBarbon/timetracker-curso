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
        Schema::create('clocking_days', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->time('check_in')->nullable();
            $table->time('check_out')->nullable();
            $table->time('coffee_break_in')->nullable();
            $table->time('coffee_break_out')->nullable();
            $table->time('lunch_break_in')->nullable();
            $table->time('lunch_break_out')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            // Agregar índice único para evitar duplicados de usuario/fecha
            $table->unique(['user_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clocking_days');
    }
};
