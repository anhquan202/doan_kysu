<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class InternalAccout extends Authenticatable implements JWTSubject
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

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }


    public function user()
    {
        return $this->hasOne(User::class, 'user_id', 'user_id');
    }
}
