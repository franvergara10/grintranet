<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HallPass extends Model
{
    protected $fillable = [
        'user_id',
        'teacher_id',
        'reason',
        'date',
        'start_time',
        'end_time'
    ];

    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
