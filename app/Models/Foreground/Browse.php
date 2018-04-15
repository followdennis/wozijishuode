<?php

namespace App\Models\Foreground;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Browse extends Model
{
    //
    protected $table = 'browse';

    /**
     * @param $browse_list
     * @param $clientip
     * @param $is_login
     * @param int $user_id
     * @return mixed
     * 批量处理
     */
    public function insertData($browse_list,$clientip,$is_login,$user_id = 0){
        $data = [];
        foreach($browse_list as $k => $article_id){
            array_push($data,[
                'article_id'=> $article_id,
                'is_login'=>$is_login,
                'ip'=>$clientip,
                'user_id'=>$user_id,
                'created_at'=>Carbon::now()->toDateTimeString()
            ]);
        }
        return DB::table($this->table)->insert($data);
    }
    public function insertSingleData($browse_id,$clientip,$is_login,$user_id){
        $data = ['is_login'=>$is_login,'user_id'=>$user_id,'article_id'=>$browse_id,'ip'=>$clientip,'created_at'=>Carbon::now()->toDateTimeString()];
        return DB::table($this->table)->insert($data);
    }
}
