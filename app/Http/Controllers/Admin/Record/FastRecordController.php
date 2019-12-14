<?php

namespace App\Http\Controllers\Admin\Record;

use App\Http\Controllers\AdminController;
use App\Models\Record\FastRecord;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;

class FastRecordController extends AdminController
{
    public $types;
    // 记录列表
    public function index(){

        $types = FastRecord::$typeMap;
        return view('admin.record.index',['types'=>$types]);
    }
    // 获取列表数据
    public function lists(Request $request){

        $list = FastRecord::orderBy('sort','dsc')->orderBy('id','desc');
        return DataTables::of($list)
            ->addColumn('action',function($item){
                $text = $item->is_finish ? '未完成':'完成';
                $mod =  '<a data-id="'.$item->id.'" data-finish="'.$item->is_finish.'" class="btn btn-sm green item_mod"> '.$text.' </a>';
                $del =  '<a data-id="'.$item->id.'" class="btn btn-sm red item_del"> 删除 </a>';
                return $mod .$del;
            })
            ->filter(function($query)  use($request){
                if($request->filled('keyword')){
                    $kw = trim($request->get('keyword'));
                    $query->where('desc','like','%'.$kw.'%')->orWhere('content','like','%'.$kw.'%');
                }
                $type = $request->get('type');
                if(in_array($type,FastRecord::$typeMap)){
                    $query->where('type',$type);
                }
            })
            ->make(true);
    }

    /**
     * created by gavin
     * date 2019/12/14 14:42
     * desc : 设置完成状态
     */
    public function setFinish(Request $request){
        $id = $request->get('id',0);
        $is_finish = $request->get('status',0);
        $status = FastRecord::where('id',$id)->update(['is_finish'=>$is_finish]);
        if( $status){
            return response()->json(['code'=>0,'msg'=>'设置成功']);
        } else {
            return response()->json(['code'=>-1,'msg'=>'设置失败']);
        }
    }
    /**
     * created by gavin
     * date 2019/12/14 14:43
     * desc : 删除记录
     */
    public function del(Request $request){
        $id = $request->get('id',0);
        $status = FastRecord::where('id',$id)->delete();
        if( $status){
            return response()->json(['code'=>0,'msg'=>'删除成功']);
        } else {
            return response()->json(['code'=>-1,'msg'=>'删除失败']);
        }
    }
}
