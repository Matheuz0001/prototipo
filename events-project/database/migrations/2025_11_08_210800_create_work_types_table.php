<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('work_types', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->timestamps();
        });

        DB::table('work_types')->insert([
            ['type' => 'Artigo Completo', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'Resumo Expandido', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'Resumo Simples', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'Pôster', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('work_types');
    }
};