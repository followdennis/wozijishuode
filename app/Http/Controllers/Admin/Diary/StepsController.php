<?php

namespace App\Http\Controllers\Admin\Diary;

use App\Http\Controllers\AdminController;
use App\Models\Diary\Steps;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StepsController extends AdminController
{
    //
    protected $stepsModel;
    public $type = [
        0=>'迭代日志',
        1=>'大计划',
        2=>'小步骤'
    ];
    public function __construct(Request $request,Steps $steps)
    {
        parent::__construct($request);
        $this->stepsModel = $steps;
    }

    public function index(){
        return view('admin.diary.steps.index');
    }
    public function lists(Request $request){
        $this->validate($request,[
            'type'=>'required|integer',
            'date'=>'',
            'is_show'=>'max:2',
            'keywords'=>'max:255'
        ]);
        $perPage = !empty($request->get('perPage')) ? intval($request->get('perPage')) : 10;
        $data = $this->stepsModel->getList()->where(function ($query) use($request){
            if($request->filled('keywords')){
                $kw = trim($request->get('keywords'));
                $query->where('content','like','%'.$kw.'%');
            }
            $type = intval($request->get('type') );
            if($type<3){
                $query->where('type',$type);
            }
            if($request->get('date')){
                $date = Carbon::parse($request->get('date'))->toDateString();
                $query->where('created_at',$date);
            }
            if($request->filled('is_show')){
                $query->where('is_show',intval($request->get('is_show')));
            }
        })
            ->orderBy('is_show','asc')
            ->orderBy('level','desc')
            ->paginate($perPage);
        $results = [
            'total'=>$data->total(),
            'perPage' => $data->perPage(),
            'currentPage' => $data->currentPage(),
            'lastPage' => $data->lastPage(),
            'from' => $data->firstItem(),
            'to' => $data->lastItem(),
            'items' => []
        ];
        $item = $data->map(function($item){
            return [
                'id'=>$item->id,
                'content'=>$item->content,
                'is_show'=>$item->is_show,
                'level'=>$item->level,
                'type'=>$item->type,
                'date'=>Carbon::parse($item->created_at)->toDateString()
            ];
        });
        if(empty($item) || count($item) <= 0){
            return response()->json($results);
        }
        $results['items'] = $item;
        return response()->json($results,200);

    }
    public function add(Request $request){
        $this->validate($request,[
            'content'=>'required|max:255',
            'type'=>'integer',
            'is_show'=>'required|integer',
            'level'=>'required|integer'
        ]);
        $params = [
            'user_id'=>Auth::user()->id,
            'content'=>trim($request->get('content')),
            'is_show'=>intval($request->get('is_show')) ? 1:0,
            'type'=>$request->get('type'),
            'level'=>intval($request->get('level')),
            'created_at'=>Carbon::now()->toDateTimeString()
        ];
        $state = $this->stepsModel->insertData($params);
        if($state){
            return response()->json(['state'=>1,'msg'=>'添加成功'],200);
        }else{
            return response()->json(['state'=>0,'msg'=>'添加失败'],500);
        }

    }
    public function edit(Request $request){
        $this->validate($request,[
            'id'=>'required',
            'content'=>'required|max:255',
            'type'=>'required',
            'is_show'=>'required'
        ]);
        $id = $request->get('id');
        $user_id = Auth::user()->id;
        $con = ['user_id'=>$user_id,'id'=>$id];
        $params = [
            'content'=>$request->get('content'),
            'is_show'=>intval($request->get('is_show')) ? 1:0,
            'type'=>$request->get('type') ? $request->get('type'):0,
            'level'=>$request->get('level')
        ];
        $state = $this->stepsModel->updateData($con,$params);
        if($state){
            return response()->json(['state'=>1,'msg'=>'编辑成功']);
        }else{
            return response()->json(['state'=>0,'msg'=>'编辑失败']);
        }
    }
    public function del(Request $request){
            $this->validate($request,['id'=>'required|array']);
            $state = $this->stepsModel->delData($request->get('id'));

            if($state){
                return response()->json(['state'=>1,'msg'=>'删除成功']);
            }else{
                return response()->json(['state'=>0,'msg'=>'删除失败']);
            }
    }
}
