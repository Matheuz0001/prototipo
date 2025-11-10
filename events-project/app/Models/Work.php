<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Work extends Model
{
    use HasFactory;

    /**
     * Os atributos que podem ser preenchidos em massa.
     */
    protected $fillable = [
        'user_id',
        'work_type_id',
        'title',
        'abstract',
        'advisor',
        'co_authors_text',
        'file_path',
    ];

    /**
     * Um trabalho pertence a um Utilizador (Autor).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Um trabalho pertence a um Tipo de Trabalho.
     */
    public function workType(): BelongsTo
    {
        return $this->belongsTo(WorkType::class);
    }

    /**
     * Um trabalho está ligado a uma Inscrição.
     */
    public function inscription(): HasOne
    {
        return $this->hasOne(Inscription::class);
    }
}