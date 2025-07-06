<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternalAccout extends Model
{
    protected $table = 'internal_accouts';
    protected $primaryKey = 'internal_account_id';
    protected $keyType = 'int';
    public $timestamps = true;
    protected $fillable = [
        'user_id',
        'username',
        'password'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'user_id', 'user_id');
    }
}
