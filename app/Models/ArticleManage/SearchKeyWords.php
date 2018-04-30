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
    public function updateWordsClick($keywords = null,$is_exists = 0){
        $cur_week = Carbon::now()->startOfWeek();
        if(!empty($keywords)){
            $model = self::firstOrNew(['week'=>$cur_week,'keywords'=>$keywords]);
            $model->click = $model->click+1;
            $model->is_exists = $is_exists;
            $model->is_show = 1;
            return $model->save();
        }

    }
    /**
     * 热搜  2018-04-29 13:45:30
     * @author gavin
     */
    public function hotSearch(){
        $cur_week = Carbon::now()->subWeek()->startOfWeek();//最近两周的热搜
        $list = self::where([
                'is_show'=>1,
                'is_exists'=>1
            ])
            ->where('week','>=',$cur_week)
            ->select(['keywords','click'])
            ->orderBy('click','desc')->take(10)->get();
        return $list;
    }
}
