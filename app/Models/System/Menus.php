<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Menus extends Model
{
    //
    protected $table = 'menus';
    public function getList(){
        $data = DB::table($this->table." as m")
            ->leftJoin('permissions as p',function($query){
                $query->on('p.id','=','m.permission_id');
            })
            ->select('m.*','p.name as permission_name','p.display_name as permission_display_name','p.description as permission_description')
            ->whereNull('deleted_at')
            ->orderBy('created_at')
            ->orderBy('sort','desc');
        return $data;
    }
}
