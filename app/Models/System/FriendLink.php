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
    public function getInfoById($id){
        return self::find($id);
    }
    public function insertData($data){
        return \DB::table($this->table)->insert($data);
    }
    public function delData($id){
        return self::destroy($id);
    }
    public function updateData($data,$id){
        return self::where('id',$id)->update($data);
    }
}
