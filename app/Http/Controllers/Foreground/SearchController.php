<?php

namespace App\Http\Controllers\Foreground;

use App\Repository\Foreground\SearchRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends CommonController
{
    //
    protected $searchRepo;
    public function __construct(SearchRepository $search)
    {
        $this->searchRepo = $search;
    }

    public function search_keywords($keywords = null){

        return view('foreground.search.search_keywords',['cate_name'=>'bb']);
    }

    public function search_tag(Request $request,$tag = null){
        list($data,$article_list) = $this->searchRepo->getDataByTag('赤壁之战');



        return view('foreground.search.search_tag',['cate_name'=>'bbv','tag'=>$tag,'articles'=>$article_list]);
    }
}
