<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Menus extends Model
{
    //
    use SoftDeletes;
    protected $table = 'menus';
    public function scopeOfMenu($query, $id) {
        return $query->where('id', '>', $id);
    }
    public function getAllList(){
        return self::all()->toArray();
    }

}
