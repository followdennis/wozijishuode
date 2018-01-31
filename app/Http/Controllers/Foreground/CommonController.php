<?php

namespace App\Http\Controllers\Foreground;

use App\Models\Foreground\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommonController extends Controller
{
    public function __construct()
    {

    }
    public function nav(){
        $category = new Category();
        return $category->getList();
    }
    //热门文章
    public function hot(){

    }
    //热门标签
    public function tags(){

    }
    //推荐
    public function recommend(){

    }
    //友情链接
    public function friendLink(){

    }
}
