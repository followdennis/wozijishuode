<?php
/**
 * Created by PhpStorm.
 * User: libo
 * Date: 2017/11/4
 * Time: 9:07
 */
namespace App\Http\Controllers\Admin\ArticlesManage;

use App\Http\Controllers\AdminController;
use App\Models\ArticleManage\Article;
use App\Models\ArticleManage\ArticleAll;
use App\Models\ArticleManage\ArticleBody;
use App\Models\ArticleManage\ArticleHead;
use App\Models\ArticleManage\Author;
use App\Models\ArticleManage\Category;
use App\Models\ArticleManage\InnerLink;
use App\Models\ArticleManage\Tags;
use App\Models\ArticleManage\TagsArticles;
use App\Repository\ArticleRepository;
use App\Services\Tree;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;


class IndexController extends AdminController
{

    protected $articleModel;
    protected $articleHeadModel;
    protected $categoryModel;
    protected $articleAllModel;
    protected $articleBodyModel;
    protected $tagsModel;
    protected $innerLinkModel;
    protected $authorModel;
    protected $tagsArticlesModel;
    public function __construct(Request $request,
                                Article $articleModel,ArticleHead $articleHead,Category $category,Author $author,
                                ArticleAll $articleAll,ArticleBody $articleBody,Tags $tags,InnerLink $innerLink,
                                TagsArticles $tagsArticles
                                )
    {
        parent::__construct($request);
        $this->articleModel = $articleModel;
        $this->articleHeadModel = $articleHead;
        $this->categoryModel = $category;
        $this->articleAllModel = $articleAll;
        $this->articleBodyModel = $articleBody;
        $this->tagsModel = $tags;
        $this->innerLinkModel = $innerLink;
        $this->authorModel = $author;
        $this->tagsArticlesModel = $tagsArticles;
    }

    public function index(Request $request){
        $cate_list = $this->categoryModel->getFieldList();
        return view('admin.articleManage.index',compact('cate_list'));
    }

    public function get_list(Request $request){
        $record = $this->articleAllModel->getList();
        return DataTables::of($record)
            ->addColumn('action',function($record){
                $id = $record->id;
                $edit_article = '<a href="'.route('articles/edit',['id'=>$id]).'" class="btn btn-sm purple item_edit"><i class="fa fa-edit"></i>编辑</a>';
                $del_article = '<a href="javascript:;" data-id="'.$id.'" class="btn  btn-sm red item_del"><i class="fa fa-trash-o"></i> 删除 </a>';
                $show_article = '<a href="'.route('articles/show',['id'=>$id]).'" class="btn btn-sm blue item_show"><i class="fa fa-edit"></i>预览</a>';
                return $edit_article.$del_article.$show_article;
            })
            ->editColumn('created_at',function($record){
                return Carbon::parse($record->created_at)->format('Y-m-d');
            })
            ->filter(function ($query) use($request){
                if($request->filled('keyword')){
                    $kw = trim($request->get('keyword'));
                    $query->where('title','like',"%$kw%");
                }
                $cate_id = $request->get('cate_id');
                $query->when($cate_id,function($subQuery)use($cate_id){
                    $subQuery->where('cate_id',$cate_id);
                });
            })->make(true);
    }
//    /**
//     * 2017-11-19 弃用
//     * 自定义的通过ajax实现的翻页效果
//     * @param Request $request
//     * @return \Illuminate\Http\JsonResponse
//     */
//    public function get_list(Request $request){
//        $perPage = 10;
//        $cate_id = $request->get('cateId');
//        if($request->filled('perPage') && $request->get('perPage') < 101){
//            $perPage = intval($request->get('perPage'));
//        }
//        $page = $this->articleAllModel->getList($cate_id)->pagination($perPage);
//
//        $response = array(
//            'list'   => $page->toArray()['data'],
//            'page' => array(
//                'total'        => $page->total(),
//                'per_page'     => $page->perPage(),
//                'current_page' => $page->currentPage(),
//                'last_page'    => $page->lastPage(),
//                'from'         => $page->firstItem(),
//                'to'           => $page->lastItem()
//            ),
//            'links'=>$page->links('vendor.pagination.new')->toHtml()
//        );
//        return response()->json($response);
//    }
//    public function get_list(Request $request){
//        $perPage = 10;
//        $cate_id = $request->get('cateId');
//        if($request->filled('perPage') && $request->get('perPage') < 101){
//            $perPage = intval($request->get('perPage'));
//        }
//        $page = $this->articleModel->getIds($cate_id)->pagination($perPage);
//        foreach($page as $k =>$v){
//            $ids_arr[] = $v->id;
//        }
//        $links = $page->links('vendor.pagination.new')->toHtml();
//        $list = ArticleRepository::getArticleRandList($ids_arr);
//        $from = $page->firstItem();
//        $to = $page->lastItem();
//        $total = $page->total();
//        return response()->json(compact('links','list','from','to','total'));
//    }
    public function show(Request $request){
        $id = $request->get('id');
        $start = microtime(true);
        $data = ArticleRepository::getArticleData($id);
        $end = microtime(true);
        $long = ($end-$start);
        $long = sprintf('%.3f',$long);
        return view('admin.articleManage.show',['data'=>$data,'long'=>$long.'s']);
    }
    public function add(Request $request){
        if($request->isMethod('post')){
            $params = $request->all();
            $tags_name = [];
            $tags_id = [];
            $data_head = [];
            if(isset($params['tags']) && !empty($params['tags'])){
                foreach($params['tags'] as $tag){
                    $tag_arr = explode(',',$tag);
                    $tagModel = $this->tagsModel->firstOrCreate(['name'=>@$tag_arr[1]],[
                        'pinyin'=>pinyin_permalink($tag_arr[1],''),
                        'py'=>pinyin_abbr($tag_arr[1]),
                        'tables_id'=>0,
                        'description'=>''
                    ]);
                    $tags_name[] = @$tag_arr[1];
                    if(@tag_arr[0] == 0){
                        $tags_id[] = $tagModel->id;
                    }else{
                        $tags_id[] = @$tag_arr[0];
                    }
                }
                $data_head = array_add($data_head,'tags_name',implode(',',$tags_name));
                $data_head = array_add($data_head,'tags_id',implode(',',$tags_id));
            }
            if(!empty($params['author'])){
                $data_head = array_add($data_head,'author',explode(',',$params['author'])[1]);
                $data_head = array_add($data_head,'author_id',explode(',',$params['author'])[0]);
            }
            $cate = explode(',',$params['cate']);
            $cate_id = @$cate[0];
            $cate_name = @$cate[1];
            //获取id
            $id = $this->articleModel->insertData(['cate_id'=>$cate_id]);
            if(!empty($params['inner_link'])){
                $data_head = array_add($data_head,'inner_link_name',$params['inner_link']);
                $data_head = array_add($data_head,'inner_link_id',1);
                $inner_link_state = $this->innerLinkModel->insert(['article_id'=>$id,'name'=>$params['inner_link'],'tables_id'=>1]);
            }
            $data_head['id'] = $id;
            $data_head['title'] = $params['title'];
            $data_head['description'] = $params['description'];
            $data_head['cate_name'] = $cate_name;
            $data_head['cate_id'] = $cate_id;
            $body = [
                'id'=>$id,
                'content'=>$params['content']
            ];
            try{
                $article_state = $this->articleAllModel->insertData($data_head);
                $tag_count_plus = $this->tagsModel->changeArticleCount($tags_id,1);//更新数量
                $article_head_state = $this->articleHeadModel->insertData($data_head);
                $article_content_state = $this->articleBodyModel->insertData($body);//tag文章文章数量
                $tag_article_state = $this->add_tag_article_id($id,$tags_id);
            }catch (\Exception $e){

            }
            return redirect(route('articles'));
        }else{
            $tree = new Tree();
            $tree->icon = array('└ ','├ ','│');
            $cate_list = $this->categoryModel->getCateList();
            $array = array();
            foreach($cate_list as $r) {
                $r['cname'] =  $r['name'];
                $array[] = $r;
            }
            $str  = "<option value='\$id,\$name' \$selected>\$spacer \$cname</option>";
            $tree->init($array);
            $category = $tree->get_tree(0, $str);
            $tags = $this->tagsModel->getAllList();
            $authors = $this->authorModel->getAllList();
            $data['cate_list'] = $category;
            $data['tags_list'] = $tags;
            $data['author_list'] = $authors;
            return view('admin.articleManage.add',compact('data'));
        }

    }

    public function edit(Request $request){
        $id = intval($request->get('id'));
        if($request->isMethod('post')){
            $this->validate($request,[
                'click'=>'required|integer',
                'is_show'=>''
            ]);
                $params = $request->all();
                $tags_name = [];
                $tags_id = [];
                $data_head = [];
                $current_tag_ids = $this->articleAllModel->getTagIdsById($id);
                $this->tagsModel->changeArticleCount($current_tag_ids,-1);//数量减少
                $this->tagsArticlesModel->delDataByArticleId($id);
                if(!empty($params['tags'])){
                    $tag_articles_data = [];
                    foreach($params['tags'] as $tag){
                        $tag_arr = explode(',',$tag);
                        $tagModel = $this->tagsModel->firstOrCreate(['name'=>@$tag_arr[1]],[
                            'pinyin'=>pinyin_permalink($tag_arr[1],''),
                            'py'=>pinyin_abbr($tag_arr[1]),
                            'tables_id'=>0,
                            'description'=>''
                        ]);

                        $tags_name[] = @$tag_arr[1];
                        if(@tag_arr[0] == 0){
                            $tags_id[] = $tagModel->id;
                        }else{
                            $tags_id[] = @$tag_arr[0];
                        }
                        //tag_article
                        array_push($tag_articles_data,[
                            'tag_id'=>$tagModel->id,
                            'article_id'=> $id,
                            'created_at'=>Carbon::now()->toDateTimeString()
                        ]);
                    }
                    $this->tagsArticlesModel->insert($tag_articles_data);//增加tag_article
                    $this->tagsModel->changeArticleCount($tags_id,1);//更新数量
                    $data_head = array_add($data_head,'tags_name',implode(',',$tags_name));
                    $data_head = array_add($data_head,'tags_id',implode(',',$tags_id));
                }

                if(!empty($params['author'])){
                    $data_head = array_add($data_head,'author',explode(',',$params['author'])[1]);
                    $data_head = array_add($data_head,'author_id',explode(',',$params['author'])[0]);
                }

                $cate = explode(',',$params['cate']);
                $cate_id = @$cate[0];
                $cate_name = @$cate[1];
                $id = $params['id'];
                if(!empty($params['inner_link'])){
                    $data_head = array_add($data_head,'inner_link_name',$params['inner_link']);
                    $data_head = array_add($data_head,'inner_link_id',1);
                    $inner_link_state = $this->innerLinkModel->updateOrCreate(['article_id'=>$id],['name'=>$params['inner_link'],'tables_id'=>1]);
                }
                $is_show = isset($params['is_show']) ? 1 : 0;
                $data_head['id'] = $id;
                $data_head['title'] = $params['title'];
                $data_head['description'] = $params['description'];
                $data_head['cate_name'] = $cate_name;
                $data_head['cate_id'] = $cate_id;
                $data_head['is_show'] = $is_show;
                $data_head['click'] = $params['click'];
                $body = [
                    'id'=>$id,
                    'content'=>$params['content']
                ];
                try{
                    $article_state = $this->articleAllModel->editData($data_head);
                    $article_index_state = $this->articleModel->updateData(['cate_id'=>$cate_id,'id'=>$id,'is_show'=>$is_show]);
                    $article_head_state = $this->articleHeadModel->updateData($data_head);
                    $article_content_state = $this->articleBodyModel->updateData($body);
                }catch (\Exception $e){

                }
//                return response()->json(['status'=>1,'msg'=>'编辑成功']);
                return redirect(route('articles'));
        }else{
            $articleRepo = new ArticleRepository($this->articleAllModel,$this->articleBodyModel,$this->articleHeadModel);
            $data = $articleRepo->getInfoByArticle($id);//为数组值
            $patten = array("\r\n", "\n", "\r");//替换文本中的换行符
            $data['content']=addslashes(trim(str_replace($patten, "", $data['content'])));
            $data['author_and_id'] = $data['author_id'].','.$data['author'];
            $data['created_at'] = Carbon::parse($data['created_at'])->format('Y-m-d H:i:s');
            $tree = new Tree();
            $tree->icon = array('└ ','├ ','│');
            $cate_list = $this->categoryModel->getCateList();
            $array = array();
            foreach($cate_list as $r) {
                $r['cname'] =  $r['name'];
                $r['selected'] = $r['id'] == $data['cate_id'] ? 'selected' : '';
                $array[] = $r;
            }
            $str  = "<option value='\$id,\$name' \$selected>\$spacer \$cname</option>";
            $tree->init($array);
            $category = $tree->get_tree(0, $str);
            $tags = $this->tagsModel->getAllList();
            $authors = $this->authorModel->getAuthorAndId();
            $data['cate_list'] = $category;
            $data['tags_list'] = $tags;
            $data['author_list'] = $authors;
            if(!empty($data['tags_name'])){
                $data['tags_name'] = explode(',',$data['tags_name']);
                $data['tags_id'] = explode(',',$data['tags_id']);
            }else{
                $data['tags_name'] = '';
            }
            return view('admin.articleManage.edit',compact('data'));
        }

    }
    public function del(Request $request){
        $id = $request->get('id');
//        $status = $this->articleAllModel->delData($id);
        $article = ArticleAll::find($id);
        if($tags = $article->tags_id){
            $tag_ids = explode(',',$tags);
            $this->tagsModel->changeArticleCount($tag_ids,-1);
            $tags_article = $this->tagsArticlesModel->delData($tag_ids,$id);
        }

        $article_index_status = $this->articleModel->delData($id);
        $article_head_status = $this->articleHeadModel->delData($id);
        $article_body = $this->articleBodyModel->delete($id);
        if($article->delete()){
            return response()->json(['status'=>1,'msg'=>'删除成功']);
        }else{
            return response()->json(['status'=>0,'msg'=>'删除失败']);
        }
    }
    //文章是否在前台展示
    public function is_show(Request $request){
        $id = $request->get('id');
        $is_show = $request->get('is_show');
        $condition = ['id'=>$id];
        $update = ['is_show'=>$is_show];
        $article_index_status = $this->articleModel->changeShow($condition,$update);
        $article_all_status = $this->articleAllModel->changeShow($condition,$update);
        $article_head_status = $this->articleHeadModel->changeShow($condition,$update);
        if($article_all_status && $article_index_status && $article_head_status){
            return response()->json(['status'=>1,'msg'=>'修改成功']);
        }else{
            return response()->json(['status'=>0,'msg'=>'修改失败']);
        }
    }

    public function add_tag_article_id($article_id = 0,$tag_ids =[]){
        $data = [];
        if(empty($tag_ids)){
            return false;
        }else{
            foreach($tag_ids as $id){
                array_push($data,[
                    'tag_id'=>$id,
                    'article_id'=>$article_id,
                    'created_at'=>Carbon::now()->toDateTimeString()
                ]);
            }
            return TagsArticles::insert($data);
        }
    }
}