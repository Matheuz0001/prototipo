<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // 👈 Importe

class InscriptionType extends Model
{
    use HasFactory;

    /**
     * Os atributos que podem ser preenchidos em massa.
     */
    protected $fillable = [
        'event_id',
        'type', // Ex: "Autor", "Ouvinte"
        'allow_work_submission', // true/false
        'price', // Preço do tipo de inscrição
    ];

    /**
     * Define os casts para os atributos.
     */
    protected $casts = [
        'allow_work_submission' => 'boolean', // Converte 0/1 para true/false
    ];

    /**
     * Um tipo de inscrição pertence a um Evento.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}