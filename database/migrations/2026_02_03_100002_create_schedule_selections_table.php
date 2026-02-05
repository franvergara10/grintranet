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
        Schema::create('schedule_selections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_schedule_id')->constrained()->onDelete('cascade');
            $table->foreignId('time_slot_id')->constrained()->onDelete('cascade');
            $table->string('day'); // e.g., 'Lunes', 'Martes', etc.
            $table->string('value')->nullable(); // Activity or type of guardia
            $table->timestamps();

            $table->unique(['user_schedule_id', 'time_slot_id', 'day'], 'user_slot_day_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_selections');
    }
};
