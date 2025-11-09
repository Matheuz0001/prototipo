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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->string('title'); // Ex: Minicurso, Palestra
            $table->text('description')->nullable();
            $table->string('location')->nullable(); // Ex: Sala 10, Auditório
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->integer('max_participants')->nullable(); // NULL = Ilimitado
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};