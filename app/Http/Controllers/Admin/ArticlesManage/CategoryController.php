<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/11/6
 * Time: 20:04
 */
namespace App\Http\Controllers\Admin\ArticlesManage;

use App\Http\Controllers\AdminController;
use App\Models\ArticleManage\Category;
use App\Services\Tree;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CategoryController extends AdminController
{
    protected $categoryModel;
    public function __construct(Request $request,Category $category)
    {
        parent::__construct($request);
        $this->categoryModel = $category;
    }

    public function index(){
        return view('admin.category.index');
    }

    public function get_list(){
        $data = $this->categoryModel->getList();
        $json = DataTables::of($data)
            ->addColumn('sort',function($record){
                return $record->is_show;
            })
            ->editColumn('is_show',function($record){
                return $record->is_show>0 ? '是':'否';
            })
            ->addColumn('action',function($record){
                $add_cate =  '<a data-id="'.$record->id.'" class="btn btn-sm green item_add"><i class="fa fa-plus"></i> 添加子分类 </a>';
                $edit_cate = '<a  data-id="'.$record->id.'" class="btn btn-sm purple item_edit"><i class="fa fa-edit"></i>编辑</a>';
                $del_cate = '<a href="javascript:;" data-id="'.$record->id.'" class="btn dark btn-sm red item_del"><i class="fa fa-trash-o"></i> 删除 </a>';
                return $add_cate.$edit_cate.$del_cate;
            })
            ->make(true);
        $json = htmlspecialchars_decode($json);//防止无法解析其中的引号
        preg_match('/{.*/',$json,$out);//把json的请求头过滤掉
        $m = $out[0];
        $new = json_decode($m,true);
        $arr = $new['data'];//这个数据有可能为空，所以要加个判断
        if(!empty($arr)){
            $tree = new Tree();
            $tree->init($arr);
            $str = "\$spacer\$name";
            $tree_new = $tree->get_menu_tree(0,$str);
            $new['data'] = $tree_new;
        }
        return response()->json($new);
    }

    public function add(Request $request){
        $params = $request->all();
        if($request->isMethod('post')){
            $data = [
                'name'=>trim($params['name']),
                'parent_id'=>intval($params['parent_id']),
                'is_show'=>intval($params['is_show']),
                'description'=>strval($params['description']),
                'py'=>pinyin_abbr($params['name']),
                'pinyin'=>pinyin_permalink($params['name'],''),
                'alias'=>strval($params['alias'])
            ];
            $status = $this->categoryModel->insertData($data);
            if($status){
                return response()->json(['status'=>1,'msg'=>'添加分类成功']);
            }else{
                return response()->json(['status'=>0,'msg'=>'添加分类失败']);
            }
        }else{
            $tree = new Tree();
            $tree->icon = array('└ ','├ ','│');
            $cate_list = $this->categoryModel->getAllList();
            $array = array();
            foreach($cate_list as $r) {
                $r['cname'] =  $r['name'];
                $r['selected'] = $r['id'] == $request->get('parent_id') ? 'selected' : '';
                $array[] = $r;
            }
            $str  = "<option value='\$id' \$selected>\$spacer \$cname</option>";
            $tree->init($array);
            $select_categorys = $tree->get_tree(0, $str);
            return view('admin.category.add',compact('select_categorys'));
        }
    }

    public function edit(Request $request){
        $id = $request->get('id');

        if($request->isMethod('post')){
            $params = $request->all();
            $now = Carbon::now()->format('Y-m-d H:i:s');
            $data = [
                'name'=>trim($params['name']),
                'parent_id'=>intval($params['parent_id']),
                'is_show'=>intval($params['is_show']),
                'description'=>strval($params['description']),
                'pinyin' => trim($params['pinyin']),
                'py'=>trim($params['py']),
                'alias'=>strval($params['alias']),
                'updated_at'=>$now
            ];

            $status = $this->categoryModel->updateData($data,$id);
            if($status){
                return response()->json(['status'=>1, 'msg'=>'编辑分类成功']);
            }else{
                return response()->json(['status'=>0,'msg'=>'编辑分类失败']);
            }
        }else{
            $info = $this->categoryModel->getInfoById($id);
            $tree = new Tree();
            $tree->icon = array('└ ','├ ','│');
            $menu_list = $this->categoryModel->getAllList();
            $array = array();
            foreach($menu_list as $r) {
                $r['cname'] =  $r['name'];
                $r['selected'] = $r['id'] == $info->parent_id ? 'selected' : '';
                $array[] = $r;
            }
            $str  = "<option value='\$id' \$selected>\$spacer \$cname</option>";
            $tree->init($array);
            $select_categorys = $tree->get_tree(0, $str);
            return view('admin.category.edit',compact("info","select_categorys"));
        }
    }

    public function del(Request $request){
        $id = $request->get('id');
        $status = $this->categoryModel->delData($id);
        if($status){
            return response()->json(['status'=>1,'msg'=>'删除分类成功']);
        }else{
            return response()->json(['status'=>0,'msg'=>'删除分类失败']);
        }
    }
}