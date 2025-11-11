<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_id',
        'user_id',
        'status',
        'comments',
    ];

    /**
     * Uma avaliação (review) pertence a um Trabalho (Work).
     */
    public function work(): BelongsTo
    {
        return $this->belongsTo(Work::class);
    }

    /**
     * Uma avaliação (review) pertence a um Utilizador (Avaliador).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}