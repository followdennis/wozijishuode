<?php

namespace App\Models\Diary;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class SkillTask extends Model
{
    //
    use SoftDeletes;
    protected $table = 'skill_task';
//    protected $dates = ['deleted_at','created_at','updated_at'];

    public function getInfoById($id){
        return self::find($id);
    }
    public function getList($sort_order = 0){
        return DB::table($this->table)
            ->when($sort_order,function($query) use($sort_order){
                // 1创建时间降序   3  实际时间 降序
                switch($sort_order){
                    case 1 :return $query->orderBy('created_at','desc');
                        break;
                    case 2: return $query->orderBy('created_at','asc');
                        break;
                    case 3:return $query->orderBy('true_time','desc');
                        break;
                    case 4:return $query->orderBy('true_time','asc');
                        break;
                    default: return $query->orderBy('id','desc');
                }
            })
            ->whereNull('deleted_at')
            ->orderBy('is_finish','asc')
            ->orderBy('id','desc');
    }
    public function delItem($id){
        $status = self::where('id',$id)->delete();
        return $status;
    }
    public function insertData($params = array()){
        $skilltask = new self;
        $skilltask->title = $params['title'];
        $skilltask->description = $params['description'];
        $skilltask->content = $params['content'];
        $skilltask->estimate_time = $params['estimate_time'];
        if(!empty($params['start_time'])){
            $skilltask->start_time = $params['start_time'];
        }
//        $skilltask->end_time = $params['end_time'];
        $skilltask->true_time = $params['true_time'];
        $skilltask->assess_value = $params['assess_value'];
        return $skilltask->save();

    }
    public function updateData($params = array()){
        $skilltask = self::find($params['id']);
        $skilltask->title = $params['title'];
        $skilltask->description = $params['description'];
        $skilltask->content = $params['content'];
        $skilltask->estimate_time = $params['estimate_time'];
        if(!empty($params['start_time'])){
            $skilltask->start_time = $params['start_time'];
        }
        if(!empty($params['end_time'])){
            $skilltask->end_time = $params['end_time'];
        }
        $skilltask->is_finish = $params['is_finish'];
        $skilltask->true_time = $params['true_time'];
        $skilltask->assess_value = $params['assess_value'];
        return $skilltask->save();

    }
}
