<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FriendLink extends Model
{
    //
    use SoftDeletes;
    protected $table='friend_link';
    public function getList(){
        return self::select('*');
    }

}
