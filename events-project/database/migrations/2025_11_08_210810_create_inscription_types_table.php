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
        Schema::create('inscription_types', function (Blueprint $table) {
            $table->id();
            $table->decimal('price', 10, 2)->default(0.00); // Coluna do preço
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade'); // A que evento esse tipo pertence
            $table->string('type'); // Ex: Ouvinte, Autor
            $table->boolean('allow_work_submission')->default(false); // Adicionado da ERS (RF_B3)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscription_types');
    }
};