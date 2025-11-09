<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'advisor',
        'co_authors_text',
        'work_type_id',
        'file_path', // Para o upload
        'status', // 0=Pendente, 1=Aprovado, 2=Reprovado
    ];

    /**
     * Relacionamentos
     */
    public function submitter(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function type(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(WorkType::class, 'work_type_id');
    }
}