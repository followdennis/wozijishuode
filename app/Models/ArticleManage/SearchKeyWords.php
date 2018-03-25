<?php

namespace App\Models\ArticleManage;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class SearchKeyWords extends Model
{
    //
    protected $table = 'search_keywords';
    protected $guarded = [];
    /**
     * 更新搜索词
     * 并计算点击次数
     * 2018-03-25 1;19:32
     */
    public function updateWordsClick($keywords = null){
        $cur_week = Carbon::now()->startOfWeek();
        if(!empty($keywords)){
            $model = self::firstOrNew(['week'=>$cur_week,'keywords'=>$keywords]);
            $model->click = $model->click+1;
            return $model->save();
        }

    }
}
