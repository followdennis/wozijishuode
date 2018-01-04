<?php

namespace App\Http\Controllers\Admin\Diary;

use App\Http\Controllers\AdminController;
use App\Models\Diary\MyQuestion;
use App\Models\Diary\MyQuestionTask;
use App\Models\Diary\MyReflect;
use Carbon\Carbon;
use function GuzzleHttp\Psr7\str;
use Illuminate\Http\Request;

class ReflectController extends AdminController
{
    //反思
    protected $questionModel;
    protected $reflectModel;
    public function __construct(Request $request,MyQuestion $question,MyReflect $reflect)
    {
        parent::__construct($request);
        $this->questionModel = $question;
        $this->reflectModel = $reflect;
    }

    public function index(){
        return view('admin.diary.reflect.index');
    }
    public function lists(Request $request){
        $questions = $this->questionModel->getList()
            ->where(function($query) use($request){
                if($request->filled('query')){
                    $kw = $request->get('query');
                    $query->where('question','like','%'.$kw.'%');
                }
            })
            ->get();
        $latest = $this->reflectModel->getLatest();
        $results = [];
        foreach($questions as $k =>$question){
            array_push($results,[
                'questionId'=>$question->id,
                'questionName'=>$question->question,
                'answer'=>[
                    'description'=>isset($latest[$question->id]['description'])?$latest[$question->id]['description']:'',
                    'num'=>isset($latest[$question->id]['num'])?$latest[$question->id]['num']:0,
                    'numDesc'=>isset($latest[$question->id]['num_desc'])?$latest[$question->id]['num_desc']:'',
                    'assess'=>isset($latest[$question->id]['assess'])?$latest[$question->id]['assess']:0,
                    'taskId'=>isset($last[$question->id]['task_id']) ?$last[$question->id]['task_id']:0
                ]
            ]);
        }
        return response()->json($results);
    }
    //添加或编辑 今日任务20180104
    public function add(Request $request){
        $today = Carbon::today()->toDateTimeString();
        $task = MyQuestionTask::updateOrCreate(['today'=>$today]);
        $this->validate($request,[
            'questionId'=>'required|integer',
            'description'=>'max:255',
            'num'=>'required|integer',
            'numDesc'=>'string',
            'assess'=>'required|integer'
        ]);
        $params = $request->all();
        $condition = ['question_id'=>$params['questionId'],'task_id'=>$task->task_id];
        $create = [
            'description'=>$params['description'],
            'num'=>$params['num'],
            'num_desc'=>$params['numDesc'],
            'assess'=>$params['assess']
        ];
        $status = $this->reflectModel->updateData($condition,$create);
        if($status){
            return response()->json(['state'=>1,'msg'=>'处理完成']);
        }else{
            return response()->json(['state'=>0,'msg'=>'处理失败']);
        }
    }
}
