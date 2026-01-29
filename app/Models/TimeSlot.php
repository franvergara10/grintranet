<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    use HasFactory;

    protected $fillable = ['schedule_template_id', 'name', 'start_time', 'end_time', 'order'];

    public function scheduleTemplate()
    {
        return $this->belongsTo(ScheduleTemplate::class);
    }
}
