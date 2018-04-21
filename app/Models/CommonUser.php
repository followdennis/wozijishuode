<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class CommonUser extends Authenticatable
{
    //
    use Notifiable,SoftDeletes,HasApiTokens;
    protected $fillable = [
        'name','email','password'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
