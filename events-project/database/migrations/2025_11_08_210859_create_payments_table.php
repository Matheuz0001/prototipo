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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inscription_id')->constrained('inscriptions')->onDelete('cascade');
            $table->foreignId('payment_type_id')->constrained('payment_types');
            $table->decimal('amount', 10, 2);
            
            // 0=Pendente (aguardando envio), 1=Em Análise (enviado), 2=Aprovado, 3=Recusado
            $table->tinyInteger('status')->default(0);
            
            // Comprovante (Adicionado da ERS, RF_F2)
            $table->string('proof_path')->nullable(); 

            // Justificativa (Adicionado da ERS, RF_F3)
            $table->text('rejection_reason')->nullable(); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};