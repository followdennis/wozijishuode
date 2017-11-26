<?php

namespace App\Models\ArticleManage;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InnerLink extends Model
{
    //
    use SoftDeletes;
    protected $table = 'inner_link';
    protected $guarded = [];
    public function getInfoById($id){
        return self::find($id);
    }
    //获取列表数据
    public function getList(){
        return self::orderBy('id','desc');
    }
    //删除
    public function delData($id){
        return self::destroy($id);
    }
    //编辑数据
    public function updateData($params,$id){
        return self::where('id',$id)->update($params);
    }
    //创建或者更新

}
