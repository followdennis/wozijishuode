<?php

namespace App\Http\Controllers\Admin\Diary;

use App\Http\Controllers\AdminController;
use App\Models\Diary\ProjectTask;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Vinkla\Hashids\Facades\Hashids;
use Yajra\DataTables\DataTables;

class ProjectTaskController extends AdminController
{
    //
    protected $projecttaskModel;
    public function __construct(Request $request,ProjectTask $projecttask)
    {
        parent::__construct($request);
        $this->projecttaskModel = $projecttask;
    }

    public function index(){
        return view('admin.diary.task.project_task.index');
    }
    public function get_list(Request $request){
        $sort_order = intval($request->get('search_order'));
        $data = $this->projecttaskModel->getList($sort_order);
        return DataTables::of($data)
            ->addColumn('action', function($record){
                $id = Hashids::encode($record->id);
                return
                    '<a href="javascript:;" class="btn green itemDetail" data-id="'.$id.'"><i class="fa fa-share"></i>查看</a>'.
                    '<a href="javascript:;" class="btn blue itemEdit" data-id="'.$id.'"><i class="fa fa-edit"></i>编辑</a>'.
                    '<a href="javascript:;" class="btn red itemDel" data-id="'.$id.'"><i class="fa fa-trash"></i>删除</a>';
            })
            ->editColumn('created_at',function($record){
                return Carbon::parse($record->created_at)->format('Y-m-d');
            })
            ->editColumn('start_time',function($record){
                if(!empty($record->start_time)){
                    return Carbon::parse($record->start_time)->format('Y-m-d');
                }else{
                    return '未开始';
                }

            })
            ->filter(function($query) use($request){
                if($request->filled('keyword')){
                    $kw = trim($request->get('keyword'));
                    $query->where('title','like',"%$kw%");
                }
                if($request->filled('description')){
                    $desc = trim($request->get('description'));
                    $query->where('description','like',"%$desc%");
                }
                if($request->filled('is_finish') ){

                    $is_finish = intval($request->get('is_finish'));
                    $query->where('is_finish',$is_finish);
                }
                if($request->filled('start_date')) {
                    $startDate = Carbon::parse(trim($request->get('start_date')))->format('Y-m-d H:i:s');
                    $query->where(function ($subQuery) use($startDate){
                        $subQuery->where('start_time', '>=', $startDate);
                    });
                }
                if($request->filled('end_date')) {
                    $endDate = Carbon::parse(trim($request->get('end_date')))->addHours(23)->addMinutes(59)->second(59)->format('Y-m-d H:i:s');
                    $query->where(function ($subQuery) use($endDate){
                        $subQuery->where('start_time', '<=', $endDate);
                    });
                }


            })
            ->make(true);
    }
    //ajax 修改完成状态
    public function change_status(Request $request){
        $id = $request->get('id');
        $status = $request->get('is_finish');
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $res = $this->projecttaskModel->where('id',$id)->update(['is_finish'=>$status,'start_time'=>$now]);

        if($res){
            return ['status'=>1,'msg'=>'修改成功'];
        }else{
            return ['status'=>0,'msg'=>'修改失败'];
        }
    }
    public function add(Request $request){
        if($request->isMethod('post')){
            $params = $request->all();
            if(empty($params['title'])){
                return ['action'=>'add','msg'=>'标题不能为空','status'=>0];
            }
            if(!isset($params['assess_value'])){
                return ['action'=>'add','msg'=>'评估价值不能为空','status'=>0];
            }
            $status = $this->projecttaskModel->insertData($params);
            if($status){
                return response()->json(['action'=>'add','msg'=>'添加成功','status'=>1]);
            }
            return response()->json(['action'=>'add','msg'=>'添加失败','status'=>0]);
        }else{
            return view('admin.diary.task.project_task.add');
        }
    }
    //变
    public function edit(Request $request){

        if($request->isMethod('post')){
            $params = $request->all();
            $status = $this->projecttaskModel->updateData($params);
            info($params);
            if($status){
                return response()->json(['status'=>1,'msg'=>'编辑成功','action'=>'edit']);
            }
            return response()->json(['status'=>0,'msg'=>'编辑失败','action'=>'edit']);
        }else{
            $id = intval(Hashids::decode($request->get('id'))[0]);
            $info = $this->projecttaskModel->getInfoById($id);
            if(!empty($info->start_time)){
                $info->start_time = Carbon::parse($info->start_time)->format('Y-m-d');
            }
            if(!empty($info->ent_time)){
                $info->end_time = Carbon::parse($info->end_time)->format('Y-m-d');
            }
            $data['info'] = $info;
            return view('admin.diary.task.project_task.edit',$data);
        }
    }
    public function show(Request $request){
        $id = Hashids::decode(trim($request->get('id')))[0];

        $info = ProjectTask::find($id)->toArray();

        return view('admin.diary.task.project_task.detail',['info'=>$info]);
    }
    public function del(Request $request){
        $id = intval(Hashids::decode($request->get('id'))[0]);
        $res = $this->projecttaskModel->delItem($id);

        if($res){
            return ['status'=>1,'msg'=>'删除成功'];
        }else{
            return ['status'=>0,'msg'=>'删除失败'];
        }
    }
}
