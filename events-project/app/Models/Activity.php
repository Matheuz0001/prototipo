<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // 👈 Importe

class Activity extends Model
{
    use HasFactory;

    /**
     * Os atributos que podem ser preenchidos em massa.
     */
    protected $fillable = [
        'event_id',
        'title',
        'description',
        'location',
        'start_time',
        'end_time',
        'max_participants',
    ];

    /**
     * Define o relacionamento: Uma atividade pertence a um Evento.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}