<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// 👇 Adicione estes imports para os relacionamentos
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne; 
use Illuminate\Database\Eloquent\Relations\HasMany; 

class Inscription extends Model
{
    use HasFactory;

    /**
     * Os atributos que podem ser preenchidos em massa.
     */
    protected $fillable = [
        'user_id',
        'event_id',
        'inscription_type_id',
        'work_id', // CAMPO PARA LIGAR AO TRABALHO
        'registration_code',
        'status',
        'attended',
        'presented_work',
    ];

    /**
     * Uma inscrição pertence a um Utilizador (Participante).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Uma inscrição pertence a um Evento.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Uma inscrição tem um Tipo de Inscrição.
     */
    public function inscriptionType(): BelongsTo
    {
        return $this->belongsTo(InscriptionType::class);
    }

    /**
     * Uma inscrição pode ser ligada a um Trabalho submetido (RF-F5).
     * (ESTA É A FUNÇÃO QUE CORRIGE O ERRO DE RELAÇÃO)
     */
    public function work(): BelongsTo
    {
        return $this->belongsTo(Work::class);
    }

    /**
     * Uma inscrição tem um Pagamento.
     */
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }
}