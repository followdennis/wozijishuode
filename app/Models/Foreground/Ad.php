<?php

namespace App\Models\Foreground;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    //
    public static $position = [
        'ch_top_1' =>['position_id'=>1,'name'=>'列表页上方1'],
        'ch_top_2' =>['position_id'=>2,'name'=>'列表页上方2'],
        'ch_right' =>['position_id'=>3,'name'=>'列表页上方2'],
        'detail_middle_1'=>['position_id'=>4,'name'=>'详情页中部1'],
        'detail_middle_2'=>['position_id'=>5,'name'=>'详情页中部2'],
        'detail_right'=>['position_id'=>6,'name'=>'详情页右侧']
    ];
    protected $table = 'ad';

    public function getAdByPosition($position_id = 0){
        return $this->where(['position_id'=>$position_id])->where(['is_show'=>1])->orderBy('sort','desc')->take(1)->first();
    }

}
