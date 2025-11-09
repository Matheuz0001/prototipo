<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'work_type_id',
        'title',
        'abstract',
        'file_path',
        'file_name',
        'advisor',
        'co_authors',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function workType()
    {
        return $this->belongsTo(WorkType::class);
    }
}