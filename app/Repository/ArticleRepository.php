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
    protected $articleHeadModel;
    public function __construct(ArticleAll $articleAll,ArticleBody $articleBody,ArticleHead $articleHead)
    {
        $this->articleAllModel = $articleAll;
        $this->articleBodyModel = $articleBody;
        $this->articleHeadModel = $articleHead;
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
    public function getArticleTitle($id){
        $articleHead = new ArticleHead();
        return $articleHead->getInfoById($id,['title','id']);
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
    /**
     * 获取完整的跨表的多条数据
     * 2017-12-25
     */
    public function getArticlesByIds($ids = array(1000,2333,1123,45555)){
        if(count($ids) > 0){
            $articles = [];
            foreach($ids as $id){
                $article = $this->getArticleById($id);
                array_push($articles,$article);
            }
            return $articles;
        }
    }

    /**
     * 获取articleHead 和 articleBody中的文章
     */
    public function getArticleById($id = 1){
        $article_head = $this->articleHeadModel->getInfoById($id,['id','title','author','author_id','description','tags_name','tags_id','inner_link_name','inner_link_id','img','cate_name','is_show','cate_id','click','like']);
        $article_body = $this->articleBodyModel->getInfoById($id,['content']);
        $article = collect($article_head)->merge($article_body);
        return $article->toArray();
    }
    /**
     * 用户文章点赞
     * @param $user_id
     * @param $article_id
     */
    public function articleLikeChange($article_id){
        $articleHead = new ArticleHead();
        $articleAll_count = ArticleAll::where('id',$article_id)->increment('like');
        $head_count = $articleHead->likeCount($article_id);
        if($articleAll_count && $head_count){
            return $articleAll_count;
        }else{
            return false;
        }
    }

}