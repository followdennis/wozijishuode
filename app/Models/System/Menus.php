<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Menus extends Model
{
    //
    protected $table = 'menus';
    public function getList(){
        $data = DB::table($this->table)
            ->select('id','name','parent_id','description','sort','pinyin','py','icon','is_show')
            ->whereNull('deleted_at')
            ->orderBy('created_at')
            ->orderBy('sort');
        return $data;
    }
}
