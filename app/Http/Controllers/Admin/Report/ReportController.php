<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\AdminController;
use App\Models\Foreground\ArticleOrCommentReport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;

class ReportController extends AdminController
{
    //
    public $articleOrCommentModel;
    public function __construct(Request $request,ArticleOrCommentReport $articleOrCommentReport)
    {
        parent::__construct($request);
        $this->articleOrCommentModel = $articleOrCommentReport;
    }

    public function index(){


        return view('admin.report.index');
    }
    public function get_list(){
        $data = $this->articleOrCommentModel->getList();
        return DataTables::of($data)
            ->addColumn('title',function($query){
                return $query->article->title;
            })
            ->addColumn('comment',function($item){
                if($item->type == 2){
                    return $item->comment->comment;
                }else{
                    return '非评论投诉';
                }
            })
            ->addColumn('report_time',function($item){
                return Carbon::parse($item->created_at)->format('m-d H:i');
            })
            ->filter(function($query){

            })->make(true);
    }
    public function edit(){
        echo '投诉处理';
    }
}
