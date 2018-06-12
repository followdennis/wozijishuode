<?php

namespace App\Models\ArticleManage;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use phpDocumentor\Reflection\Types\Self_;

class ClickStatics extends Model
{
    //
    use SoftDeletes;
    protected $table = 'click_statistics';
    protected $guarded = [];

    public function getList(){
        return self::orderBy('created_at','desc');
    }
    public function updateClick(int $cate_id = 0)
    {
        $today = Carbon::today()->toDateTimeString();
        $model = self::firstOrNew (['today'=>$today]);
        $model->total = $model->total + 1;
        if($cate_id > 0){
            if(intval($cate_id)> 50){
                $cate_id = 50;
            }
            $cate_id = 'cate_'.$cate_id;
            $model->$cate_id += 1;
            Log::info('click');
        }
        return $model->save();
    }
}
