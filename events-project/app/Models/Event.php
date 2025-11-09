<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    // 👇 ADICIONE ESTE BLOCO 👇
    public function inscriptionTypes(): HasMany
    {
        return $this->hasMany(InscriptionType::class);
    }

    /**
     * Um Evento tem muitas Atividades (ex: Palestras, Minicursos)
     */
    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }
    protected $fillable = [
        'title',
        'description',
        'location',
        'event_date',
        'registration_deadline',
        'registration_fee',
        'max_participants',
        'pix_key',
        'user_id',
    ];
}
