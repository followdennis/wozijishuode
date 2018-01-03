<?php

namespace App\Http\Controllers\Admin\Diary;

use App\Http\Controllers\AdminController;
use App\Models\Diary\MyQuestion;
use App\Models\Diary\MyReflect;
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
                    'num_desc'=>isset($latest[$question->id]['num_desc'])?$latest[$question->id]['num_desc']:'',
                    'assess'=>isset($latest[$question->id]['assess'])?$latest[$question->id]['assess']:0
                ]
            ]);
        }
        dd($results);
        return response()->json($results);

    }
    public function add(){

    }
}
