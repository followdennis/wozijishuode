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
        return DB::table($this->table)->insertGetId($params);//记录id
    }

    /**
     * @param $id 记录id
     * @param int $user_type
     * @return mixed
     */
    public function update_log_out($id,$user_type = 0){
        return DB::table($this->table)->where(['id'=>$id,'user_type'=>$user_type])->where('is_login',1)
            ->update(['updated_at'=>Carbon::now()->format('Y-m-d H:i:s'),'is_login'=>2]);
    }
    public function getList(){
        return self::orderBy('id','desc');
    }
}
