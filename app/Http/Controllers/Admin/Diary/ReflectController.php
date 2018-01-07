<?php

namespace App\Http\Controllers\Admin\Diary;

use App\Http\Controllers\AdminController;
use App\Models\Diary\MyQuestion;
use App\Models\Diary\MyQuestionTask;
use App\Models\Diary\MyReflect;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReflectController extends AdminController
{
    //反思
    protected $questionModel;
    protected $reflectModel;
    protected $taskModel;
    public function __construct(Request $request,MyQuestion $question,MyReflect $reflect,MyQuestionTask $task)
    {
        parent::__construct($request);
        $this->questionModel = $question;
        $this->reflectModel = $reflect;
        $this->taskModel = $task;
    }

    public function index(){
        return view('admin.diary.reflect.index');
    }
    public function get_task_list(){
        $task_list = $this->taskModel->getList();
        return response()->json($task_list);
    }
    public function lists(Request $request){
        $questions = $this->questionModel->getList()
            ->where(function($query) use($request){
                if($request->filled('query')) {
                    $kw = $request->get('query');
                    $query->where('question', 'like', '%'.$kw.'%');
                }
            })
            ->get();
        $task_id = 0;
        if($request->filled('today')){
            $task_id = $request->get('today');
        }
        $latest = $this->reflectModel->getLatest($task_id);
        $results = [];
        foreach($questions as $k =>$question){
            array_push($results,[
                'questionId'=>$question->id,
                'questionName'=>$question->question,
                'description'=>$question->description,
                'answer'=>[
                    'description'=>isset($latest[$question->id]['description'])?$latest[$question->id]['description']:'',
                    'num'=>isset($latest[$question->id]['num'])?$latest[$question->id]['num']:0,
                    'numDesc'=>isset($latest[$question->id]['num_desc'])?$latest[$question->id]['num_desc']:'',
                    'assess'=>isset($latest[$question->id]['assess'])?$latest[$question->id]['assess']:0,
                    'taskId'=>isset($latest[$question->id]['task_id']) ?$latest[$question->id]['task_id']:0,
                    'isCreate'=>isset($latest[$question->id]['created_at'])?1:0,
                    'start'=>false
                ]
            ]);
        }
        return response()->json($results);
    }
    //添加或编辑 今日任务20180104
    public function add(Request $request){
        $this->validate($request,[
            'questionId'=>'required|integer',
            'num'=>'required|integer',
            'numDesc'=>'max:255',
            'assess'=>'required|integer',
            'taskId'=>'required|integer',
            'today'=>''
        ]);
        $user_id = Auth::user()->id;
        $today = Carbon::today()->toDateTimeString();
        $task_id = MyQuestionTask::updateOrCreate(['today'=>$today,'user_id'=>$user_id])->task_id;

        if($request->get('taskId') <$task_id && $request->get('taskId') > 0 || intval($request->get('today')) < $task_id){
            //非当天的数据无法处理
            return response()->json(['state'=>2,'msg'=>'非当天的数据无法处理']);
        }
        $params = $request->all();
        $condition = ['question_id'=>$params['questionId'],'task_id'=>$task_id,'user_id'=>$user_id];
        $create = [
            'num'=>$params['num'],
            'num_desc'=>$params['numDesc'],
            'assess'=>$params['assess'],
            'description'=>$params['description']
        ];
        $status = $this->reflectModel->updateData($condition,$create);
        if($status){
            return response()->json(['state'=>1,'msg'=>'保存成功']);
        }else{
            return response()->json(['state'=>0,'msg'=>'处理失败']);
        }
    }
}
