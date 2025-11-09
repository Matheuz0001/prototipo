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
        Schema::create('works', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Autor principal
            $table->string('title');
            $table->string('advisor')->nullable();
            $table->text('co_authors_text')->nullable();
            $table->foreignId('work_type_id')->constrained('work_types');
            
            // Campo para o arquivo (Adicionado da ERS, RF_F5)
            $table->string('file_path'); 
            
            // Status da avaliação (Adicionado da nossa discussão)
            $table->tinyInteger('status')->default(0); // 0=Pendente, 1=Aprovado, 2=Reprovado
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('works');
    }
};