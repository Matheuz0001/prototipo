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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_id')->constrained('works')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // O Avaliador
            
            // 1=Aprovado, 2=Reprovado
            $table->tinyInteger('status'); 
            
            $table->text('comments')->nullable();
            $table->timestamps();

            // Um avaliador só pode avaliar um trabalho uma vez
            $table->unique(['work_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};