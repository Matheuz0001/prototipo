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
        Schema::create('inscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->foreignId('inscription_type_id')->constrained('inscription_types');
            
            // O trabalho só é ligado DEPOIS (opcional)
            $table->unsignedBigInteger('work_id')->nullable();
            
            $table->string('registration_code')->nullable()->unique();
            
            // 0=Pendente, 1=Confirmada (Pago), 2=Recusada, 3=Cancelada
            $table->tinyInteger('status')->default(0); 
            
            // Controle de presença (Adicionado da ERS, RF_F10)
            $table->boolean('attended')->default(false);

            // Controle de apresentação (Adicionado da ERS, RF_F12)
            $table->boolean('presented_work')->default(false); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscriptions');
    }
};