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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            
            // 👇 GARANTA QUE ESTA LINHA ESTÁ AQUI 👇
            // Ela diz "qual organizador criou este evento"
            $table->foreignId('user_id')->constrained('users');

            $table->string('title');
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->datetime('event_date');
            $table->datetime('registration_deadline');
            $table->decimal('registration_fee', 10, 2)->default(0.00);
            $table->integer('max_participants')->nullable();
            $table->string('pix_key')->nullable()->comment('Chave PIX do organizador');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};