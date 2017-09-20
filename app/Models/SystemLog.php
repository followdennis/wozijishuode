<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SystemLog extends Model
{
    //
    protected $table = 'sys_log';
    //记录登陆信息
    public function record_login($params = array()){
        return DB::table($this->table)->insertGetId($params);
    }
    public function update_log_out($id){
        return DB::table($this->table)->where('id',$id)->where('is_login',1)
            ->update(['updated_at'=>Carbon::now()->format('Y-m-d H:i:s'),'is_login'=>2]);
    }
}
