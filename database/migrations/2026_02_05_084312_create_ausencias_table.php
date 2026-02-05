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
        Schema::create('ausencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('fecha');
            $table->foreignId('time_slot_id')->constrained('time_slots')->onDelete('cascade'); // tramo
            $table->foreignId('group_id')->constrained('groups')->onDelete('cascade'); // grupo
            $table->foreignId('zona_id')->constrained('zonas')->onDelete('cascade'); // zona
            $table->text('tarea');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ausencias');
    }
};
