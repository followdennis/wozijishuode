<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class CommonUser extends Authenticatable
{
    //
    use Notifiable,SoftDeletes;
    protected $fillable = [
        'name','email','password'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
