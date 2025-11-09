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
        Schema::table('events', function (Blueprint $table) {
            // Adiciona a coluna do organizador (user_id) após o 'id'
            $table->foreignId('user_id')
                ->after('id') // Opcional, mas organiza
                ->constrained('users') // Liga na tabela 'users'
                ->onDelete('cascade'); // Se o user for deletado, deleta os eventos dele
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
