<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserStatus extends Model
{
    protected $table = 'user_statuses';
    protected $primaryKey = 'user_status_id';
    protected $keyType = 'int';
    public $timestamps = true;
    protected $fillable = [
        'status_name',
        'status_description'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'user_status_id', 'user_status_id');
    }
}
