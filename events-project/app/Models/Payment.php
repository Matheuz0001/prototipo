<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_type_id',
        'inscription_id',
        'amount',
        'status', // 0=Pendente, 1=Em Análise, 2=Aprovado, 3=Recusado
        'proof_path', // O caminho do ficheiro de comprovativo
        'rejection_reason',
    ];

    public function inscription(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Inscription::class);
    }
}