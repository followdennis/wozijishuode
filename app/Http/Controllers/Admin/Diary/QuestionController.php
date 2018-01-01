<?php

namespace App\Http\Controllers\Admin\Diary;

use App\Http\Controllers\AdminController;
use App\Models\Diary\MyQuestion;
use Carbon\Carbon;
use Illuminate\Http\Request;

class QuestionController extends AdminController
{
    //自建问题
    protected $questionModel;
    public function __construct(Request $request,MyQuestion $myquestion)
    {
        parent::__construct($request);
        $this->questionModel = $myquestion;
    }

    public function index(){
        return view('admin/diary/question/index');
    }
    public function lists(Request $request){
        $data = $this->questionModel->where(function($query)use($request){
            if($request->filled('keywords')){
                $kw = $request->get('keywords');
                $query->where('question','like','%'.$kw.'%');
            }
        })->paginate(10);
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
                'question'=>$item->question,
                'sort'=>$item->sort,
                'createdAt'=>Carbon::parse($item->created_at)->toDateString()
            ];
        });
        if(empty($item) || count($item)<=0){
            return response()->json($results);
        }
        $results['items'] = $item;
        return response()->json($results,200);
    }
    public function add(){

    }
    public function edit(){

    }
    public function del(){

    }

}
