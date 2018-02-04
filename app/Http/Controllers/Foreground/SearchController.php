<?php

namespace App\Http\Controllers\Foreground;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends CommonController
{
    //
    public function search_keywords($keywords = null){
        return view('foreground.search.search_keywords',['cate_name'=>'bb']);
    }

    public function search_tag($tag = null){
        return view('foreground.search.search_tag',['cate_name'=>'bbv']);
    }
}
