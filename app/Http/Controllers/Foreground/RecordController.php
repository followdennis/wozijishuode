<?php

namespace App\Http\Controllers\Foreground;

use App\Models\Record\FastRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RecordController extends Controller
{
    //

    public function index(){

    }

    public function record(Request $request){

        $params = $request->all();
        if( !isset($params['type']) || !in_array($params['type'],FastRecord::$typeMap)){
            return 'type error';
        }
        if( !isset($params['desc']) || strlen($params['desc']) <= 0 || strlen($params['desc']) > 200){
            return 'desc error';
        }
        if(isset($params['content']) && strlen($params['content']) > 400){
            return 'content error';
        }
        if(isset($params['sort']) && (!preg_match('/\d+/',$params['sort']) || $params['sort'] > 1000 || $params['sort'] < 0 )){
            return 'sort error';
        }
        $data = [
            'type'=>$params['type'],
            'desc'=>$params['desc'],
            'content'=>$params['content'] ??'',
            'sort'=>$params['sort']??0
        ];
        // 查找最近的数据
        // 10分钟前
        $tenMinite = Carbon::now()->subMinute(10)->toDateTimeString();
        $record = FastRecord::where('created_at','>',$tenMinite)->first();
        if( $record){
            return 'wait a moment';
        }

        $time = Carbon::now()->toDateTimeString();
        $status = DB::insert('insert into '.DB::getTablePrefix().'fast_record (`type`, `desc`,`content`,`sort`,created_at,week) values (?,?,?,?,?,weekofyear(curdate()))', [$data['type'], $data['desc'],$data['content'],$data['sort'],$time]);
        if( $status){
            return 'ok';
        }else {
            return 'fail';
        }
    }

    public function types(){
        return FastRecord::$typeMap;
    }

}
