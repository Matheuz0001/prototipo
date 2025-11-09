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
        // 1. CRIAR A TABELA 'USER_TYPES' PRIMEIRO
        Schema::create('user_types', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // Ex: Organizador, Participante, Avaliador
            $table->timestamps();
        });

        // 2. CRIAR A TABELA 'USERS' (AGORA A CONSTRAINT VAI FUNCIONAR)
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            
            // Esta linha agora funciona, pois 'user_types' já existe
            $table->foreignId('user_type_id')->constrained('user_types');

            $table->rememberToken();
            $table->timestamps();
        });

        // 3. O RESTO DO ARQUIVO ORIGINAL (SESSIONS E TOKENS)
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // A ordem de 'drop' deve ser a REVERSA da 'create'
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
        Schema::dropIfExists('user_types'); // Não se esqueça de adicionar esta linha
    }
};