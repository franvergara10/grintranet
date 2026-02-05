<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ausencia extends Model
{
    protected $fillable = [
        'user_id',
        'fecha',
        'time_slot_id',
        'group_id',
        'zona_id',
        'tarea',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function timeSlot()
    {
        return $this->belongsTo(TimeSlot::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function zona()
    {
        return $this->belongsTo(Zona::class);
    }
}
