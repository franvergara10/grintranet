<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleTemplate extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'active_days'];

    protected $casts = [
        'active_days' => 'array',
    ];

    public function timeSlots()
    {
        return $this->hasMany(TimeSlot::class)->orderBy('order')->orderBy('start_time');
    }
}
