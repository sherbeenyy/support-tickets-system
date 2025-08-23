<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Enums\RoleEnum;

class User extends Authenticatable 
{
    protected $fillable = ['name', 'email', 'password', 'role'];

    protected $hidden = ["password"];

    protected $casts = [
        'role' => RoleEnum::class, 
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    } 
}
