<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventStaff extends Model
{
    use HasFactory;

    protected $table = 'event_staff';
    
    protected $fillable = [
        'event_id',
        'user_id',
        'is_active',
    ];
}
