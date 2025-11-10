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
            
            // Chave de quem submeteu (o participante)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Chave do tipo de trabalho (ex: Artigo Completo, Resumo)
            $table->foreignId('work_type_id')->constrained('work_types');

            $table->string('title'); // Título do trabalho
            $table->text('abstract'); // Resumo do trabalho
            $table->string('advisor'); // Nome do Orientador
            $table->string('co_authors_text')->nullable(); // Coautores (texto simples)
            
            // 👇 A COLUNA MAIS IMPORTANTE QUE FALTAVA 👇
            $table->string('file_path'); // Caminho para o PDF/DOC armazenado
            
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