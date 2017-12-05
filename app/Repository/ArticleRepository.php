<?php
namespace App\Repository;
use App\Models\ArticleManage\Article;
use App\Models\ArticleManage\ArticleAll;
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
    protected $articleAllModel;
    protected $articleBodyModel;
    public function __construct(ArticleAll $articleAll,ArticleBody $articleBody)
    {
        $this->articleAllModel = $articleAll;
        $this->articleBodyModel = $articleBody;
    }

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
        return array_merge(collect($head)->toArray(),collect($body)->toArray());
    }
    /**
     * 通过article 表获取内容
     * retuan 数组
     */
    public function getInfoByArticle($id){

        $article_head_info = $this->articleAllModel->getInfoById($id);
        $content = $this->articleBodyModel->getInfoById($id,['content']);
        $article = collect($article_head_info)->merge($content);
        return $article->toArray();

    }



}