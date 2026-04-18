<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'inscription_id',
        'event_id',
        'checked_in_by',
        'status',
        'reason',
    ];
}
