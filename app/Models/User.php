<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    protected $keyType = 'string';
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone_number',
        'email',
        'avatar',
        'address',
        'gender',
        'user_status_id'
    ];
    protected static function booted()
    {
        static::creating(function ($user) {
            $user->user_id = (string) Str::uuid();
        });
    }

    public function userStatus()
    {
        return $this->hasOne(UserStatus::class, 'user_status_id', 'user_status_id');
    }
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role', 'user_id', 'role_id');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_permission', 'user_id', 'permission_id');
    }
}
