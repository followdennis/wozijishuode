<?php
namespace App\Repository;
use App\Models\ArticleManage\Article;
use App\Models\ArticleManage\ArticleBody;
use App\Models\ArticleManage\ArticleHead;

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/11/4
 * Time: 20:29
 */
class ArticleRepository
{
    /**
     * 获取article列表数据
     */
    public static function getArticleList($ids = []){
        $articleHead = new ArticleHead();
        $data = $articleHead->getHeadList($ids);
        return $data;
    }
    /**
     * 获取跨表的一组数据
     */
    public static function getArticleRandList($ids = []){
        $articleHead = new ArticleHead();
        $data = $articleHead->getHeadRandList($ids);
        return $data;
    }
    /**
     * 获取文章单条数据
     * @param $id
     * @return array
     */
    public static function getArticleData($id){
        $articleHead = new ArticleHead();
        $articlebody = new ArticleBody();
        $head = $articleHead->getInfoById($id);
        $body = $articlebody->getInfoById($id);
        return [
            'id'=>$head->id,
            'title'=>$head->title,
            'content'=>$body->content
        ];
    }




}