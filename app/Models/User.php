<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'course',
        'group',
        'group_id',
        'email',
        'password',
        'google_id',
        'avatar',
    ];

    public function groupRel()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function tutoredGroups()
    {
        return $this->hasMany(Group::class, 'tutor_id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function hallPasses()
    {
        return $this->hasMany(HallPass::class, 'teacher_id');
    }

    public function hallPassesAsStudent()
    {
        return $this->hasMany(HallPass::class, 'user_id');
    }
}
