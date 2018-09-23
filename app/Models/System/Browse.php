<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Browse extends Model
{
    //
    protected $table = 'browse';
    public $guarded = [];

    /**
     *  2018-09-23 by gavin
     * 获取列表数据
     */
    public function getList(){
        $list = self::orderBy('id','desc');
        return $list;
    }
    public function del($id){
        return self::destroy($id);
    }

}
