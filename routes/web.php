<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//test
Route::any('test_view',function(){
    return view('test');
});
Route::any('test',['uses'=>'TestController@test','as'=>'test']);
Route::any('test2',['uses'=>'TestController@test2','as'=>'test2']);

Route::any('view',function(){
    return view('layouts.common');
});
//Route::any('index',function(){
//    return view('layouts.main_layout');
//});

/**
 * 后台操作
 */
Route::group(['domain'=>'www.wozijishuode.com','prefix'=>'back'],function() {
    Auth::routes();
    Route::group(['middleware' => ['permissions', 'auth']], function () {

        //    Route::get('/home', 'HomeController@index')->name('home');
        Route::any('/', ['uses' => 'Admin\IndexController@index', 'as' => 'home']);
        Route::any('/home', ['uses' => 'Admin\IndexController@index', 'as' => 'home']);


        Route::any('index', ['uses' => 'Admin\IndexController@index', 'as' => 'index']);
        Route::any('fileupload', ['uses' => 'Admin\IndexController@file_upload']);
        Route::any('/upload', ['uses' => 'Admin\IndexController@upload']);
        Route::any('/add_role', ['uses' => 'Admin\IndexController@add_role']);
//    Route::any('login',['uses'=>'Admin\LoginController@login','as'=>'login']);
        /**
         * 文章管理
         */
        Route::any('/articles', ['uses' => 'Admin\ArticlesManage\IndexController@index', 'as' => 'articles']);
        Route::any('/articles/list', ['uses' => 'Admin\ArticlesManage\IndexController@get_list', 'as' => 'articles/list']);
        Route::any('/articles/show', ['uses' => 'Admin\ArticlesManage\IndexController@show', 'as' => 'articles/show']);
        Route::any('/articles/add', ['uses' => 'Admin\ArticlesManage\IndexController@add', 'as' => 'articles/add']);
        Route::any('/articles/edit', ['uses' => 'Admin\ArticlesManage\IndexController@edit', 'as' => 'articles/edit']);
        Route::any('/articles/del', ['uses' => 'Admin\ArticlesManage\IndexController@del', 'as' => 'articles/del']);
        Route::any('public_articles/is_show', ['uses' => 'Admin\ArticlesManage\IndexController@is_show', 'as' => 'public_articles/is_show']);

        /**
         * 线上文章批量管理
         */
        Route::get('/articles/mass', ['uses' => 'Admin\ArticlesManage\ArticleOnlineMassController@index', 'as' => 'articles/mass']);
        Route::get('/articles/mass/list', ['uses' => 'Admin\ArticlesManage\ArticleOnlineMassController@lists', 'as' => 'articles/mass/list']);
        Route::post('/articles/mass/edit', ['uses' => 'Admin\ArticlesManage\ArticleOnlineMassController@edit', 'as' => 'articles/mass/edit']);

        /**
         * 个人日记管理
         * 问题管理
         */
        Route::any('diary/questions', ['uses' => 'Admin\Diary\QuestionController@index', 'as' => 'diary/questions']);//视图
        Route::any('diary/questions/lists', ['uses' => 'Admin\Diary\QuestionController@lists', 'as' => 'diary/questions/lists']);
        Route::any('diary/question/add', ['uses' => 'Admin\Diary\QuestionController@add', 'as' => 'diary/question/add']);
        Route::any('diary/question/del', ['uses' => 'Admin\Diary\QuestionController@del', 'as' => 'diary/question/del']);
        Route::any('diary/question/edit', ['uses' => 'Admin\Diary\QuestionController@edit', 'as' => 'diary/question/edit']);
        /**
         * 自我评价
         */
        Route::any('diary/today/thoughts', ['uses' => 'Admin\Diary\ReflectController@index', 'as' => 'diary/today/thoughts']);//视图
        Route::any('diary/today/thoughts/lists', ['uses' => 'Admin\Diary\ReflectController@lists', 'as' => 'diary/today/thoughts/lists']);
        Route::any('diary/today/thoughts/add', ['uses' => 'Admin\Diary\ReflectController@add', 'as' => 'diary/today/thoughts/add']);
        Route::any('diary/today_get_task_list', ['uses' => 'Admin\Diary\ReflectController@get_task_list', 'as' => 'public_diary/today/tasks']);

        /**
         * 分类管理category
         */
        Route::any('/category', ['uses' => 'Admin\ArticlesManage\CategoryController@index', 'as' => 'category']);//分类管理
        Route::any('/category/list', ['uses' => 'Admin\ArticlesManage\CategoryController@get_list', 'as' => 'category/list']);//分类列表
        Route::any('/category/edit', ['uses' => 'Admin\ArticlesManage\CategoryController@edit', 'as' => 'category/edit']);//编辑分类
        Route::any('/category/del', ['uses' => 'Admin\ArticlesManage\CategoryController@del', 'as' => 'category/del']);//删除分类
        Route::any('/category/add', ['uses' => 'Admin\ArticlesManage\CategoryController@add', 'as' => 'category/add']);//添加分类

        /**
         * 标签管理
         */
        Route::any('/tags', ['uses' => 'Admin\ArticlesManage\TagsController@index', 'as' => 'tags']);
        Route::any('/tags/list', ['uses' => 'Admin\ArticlesManage\TagsController@get_list', 'as' => 'tags/list']);
        Route::any('/tags/edit', ['uses' => 'Admin\ArticlesManage\TagsController@edit', 'as' => 'tags/edit']);
        Route::any('/tags/del', ['uses' => 'Admin\ArticlesManage\TagsController@del', 'as' => 'tags/del']);
        Route::any('/tags/add', ['uses' => 'Admin\ArticlesManage\TagsController@add', 'as' => 'tags/add']);
        /**
         * 内链管理
         */
        Route::any('innerlink', ['uses' => 'Admin\ArticlesManage\InnerLinkController@index', 'as' => 'innerlink']);
        Route::any('innerlink/list', ['uses' => 'Admin\ArticlesManage\InnerLinkController@get_list', 'as' => 'innerlink/list']);
        Route::any('innerlink/add', ['uses' => 'Admin\ArticlesManage\InnerLinkController@add', 'as' => 'innerlink/add']);
        Route::any('innerlink/edit', ['uses' => 'Admin\ArticlesManage\InnerLinkController@edit', 'as' => 'innerlink/edit']);
        Route::any('innerlink/del', ['uses' => 'Admin\ArticlesManage\InnerLinkController@del', 'as' => 'innerlink/del']);
        /**
         * 评论管理
         */
        Route::any('comments', ['uses' => 'Admin\ArticlesManage\CommentsController@index', 'as' => 'comments']);
        Route::any('comments/list', ['uses' => 'Admin\ArticlesManage\CommentsController@get_list', 'as' => 'comments/list']);
        Route::any('comments/del', ['uses' => 'Admin\ArticlesManage\CommentsController@del', 'as' => 'comments/del']);
        Route::any('comments/hide', ['uses' => 'Admin\ArticlesManage\CommentsController@hide_message', 'as' => 'comments/hide']);//是否屏蔽

        /**
         * 作者管理
         */
        Route::get('author', ['uses' => 'Admin\ArticlesManage\AuthorController@index', 'as' => 'author']);
        Route::get('author/list', ['uses' => 'Admin\ArticlesManage\AuthorController@get_list', 'as' => 'author/list']);
        Route::match(['get', 'post'], 'author/add', ['uses' => 'Admin\ArticlesManage\AuthorController@add', 'as' => 'author/add']);
        Route::match(['get', 'post'], 'author/edit', ['uses' => 'Admin\ArticlesManage\AuthorController@edit', 'as' => 'author/edit']);
        Route::get('author/del', ['uses' => 'Admin\ArticlesManage\AuthorController@del', 'as' => 'author/del']);

        /**
         * 系统管理
         */
        /**
         * 菜单管理
         */
        Route::any('menus', ['uses' => 'Admin\System\MenusController@index', 'as' => 'menus']);
        Route::any('menus/list', ['uses' => 'Admin\System\MenusController@get_list', 'as' => 'menus/list']);
        Route::any('menus/add', ['uses' => 'Admin\System\MenusController@add', 'as' => 'menus/add']);
        Route::any('menus/edit', ['uses' => 'Admin\System\MenusController@edit', 'as' => 'menus/edit']);
        Route::any('menus/del', ['uses' => 'Admin\System\MenusController@del', 'as' => 'menus/del']);
        /**
         * 角色管理
         */
        Route::any('role', ['uses' => 'Admin\System\RoleController@index', 'as' => 'role']);
        Route::any('role/list', ['uses' => 'Admin\System\RoleController@get_list', 'as' => 'role/list']);
        Route::any('role/add', ['uses' => 'Admin\System\RoleController@add', 'as' => 'role/add']);
        Route::any('ajax_role/check_role_exist', ['uses' => 'Admin\System\RoleController@checkRoleNameUnique', 'as' => 'ajax_role/check_role_exist']);
        Route::any('role/edit', ['uses' => 'Admin\System\RoleController@edit', 'as' => 'role/edit']);
        Route::any('role/del', ['uses' => 'Admin\System\RoleController@del', 'as' => 'role/del']);
        Route::any('role/power', ['uses' => 'Admin\System\RoleController@power', 'as' => 'role/power']);
        Route::any('role/member', ['uses' => 'Admin\System\RoleController@member', 'as' => 'role/member']);//展示及列表
        Route::any('role/member_del', ['uses' => 'Admin\System\RoleController@member_del', 'as' => 'role/member_del']);
        /**
         * 用户管理
         */
        Route::any('user', ['uses' => 'Admin\System\UserController@index', 'as' => 'user']);
        Route::any('user/list', ['uses' => 'Admin\System\UserController@get_list', 'as' => 'user/list']);
        Route::any('user/edit', ['uses' => 'Admin\System\UserController@edit', 'as' => 'user/edit']);
        Route::any('user/add', ['uses' => 'Admin\System\UserController@add', 'as' => 'user/add']);
        Route::any('user/del', ['uses' => 'Admin\System\UserController@del', 'as' => 'user/del']);
        Route::any('user/check_exists', ['uses' => 'Admin\System\UserController@check_exists', 'as' => 'user/check_exists']);
        /**
         * 友情链接
         */
        Route::any('friend_link', ['uses' => 'Admin\System\FriendLinkController@index', 'as' => 'friend_link']);
        Route::any('friend_link/add', ['uses' => 'Admin\System\FriendLinkController@add', 'as' => 'friend_link/add']);
        Route::any('friend_link/edit', ['uses' => 'Admin\System\FriendLinkController@edit', 'as' => 'friend_link/edit']);
        Route::any('friend_link/del', ['uses' => 'Admin\System\FriendLinkController@del', 'as' => 'friend_link/del']);
        Route::any('friend_link/list', ['uses' => 'Admin\System\FriendLinkController@get_list', 'as' => 'friend_link/list']);
        Route::any('sidebar', function () {
            return view('partial.leftmenu');
        });
    });
});
//前台
Route::group(['domain'=>'www.wozijishuode.com'],function(){
    Route::get('/login',['uses'=>'Foreground\Auth\LoginController@showLoginForm','as'=>'front.login']);
    Route::post('/login',['uses'=>'Foreground\Auth\LoginController@login']);
    Route::get('/register',['uses'=>'Foreground\Auth\RegisterController@showRegistrationForm','as'=>'front.register']);
    Route::post('/register',['uses'=>'Foreground\Auth\RegisterController@register']);

    Route::post('/logout',['uses'=>'Foreground\Auth\LoginController@logout','as'=>'front.logout']);
    Route::get('/password/reset',['uses'=>'Foreground\Auth\ResetPasswordController@showResetForm','as'=>'front.password.request']);


    Route::any('/',['uses'=>'Foreground\IndexController@index']);
    Route::get('/p/{page}',['uses'=>'Foreground\IndexController@index']);//分页参数修改
    Route::any('/index.html',['uses'=>'Foreground\IndexController@index']);
    Route::any('/ch/{cate?}/',['uses'=>'Foreground\IndexController@lists']);
    Route::any('/ch/{cate}/{page}/',['uses'=>'Foreground\IndexController@lists'])->where('page', '[0-9]+')->where('cate', '[A-Za-z]+');//分类中的分页参数修改
    Route::any('/{cate}/{id}.html',['uses'=>'Foreground\IndexController@detail']);
    Route::any('/search',['uses'=>'Foreground\SearchController@search_keywords']);//关键词搜索
    Route::any('/search/t/{tag}/',['uses'=>'Foreground\SearchController@search_tag']);//tag搜索

    /**
     * 评论点赞的功能
     */
    Route::group(['middleware'=>'auth.front'],function(){
        Route::post('comment/add',['uses'=>'Foreground\CommentsController@add']);
        Route::get('comment/del',['uses'=>'Foreground\CommentsController@del']);
        Route::get('comment/like',['uses'=>'Foreground\CommentsController@like']);
        //文章点赞
        Route::get('article/like',['uses'=>'Foreground\IndexController@article_like']);
        //文章或评论举报1 文章 2评论
        Route::post('article_comment/report',['uses'=>'Foreground\ReportController@add']);
    });
    /**
     * 评论列表
     */
    Route::get('comment/lists',['uses'=>'Foreground\CommentsController@lists']);
    /**
     * 个人中心
     */
    Route::get('/user_center',['uses'=>'Foreground\CommonUserController@index']);
});
//前台
Route::group(['domain'=>'wx.wozijishuode.com'],function(){
    Route::any('/',function(){
        return view('wechat.index');
    });
});
Route::get('wx',function(){
    return view('wechat.wx');
});
//移动端
Route::group(['domain'=>'m.wozijishuode.com'],function(){
    Route::any('/',function(){
        return view('mobile.index');
    });
    Route::any('list',function(){
        return view('mobile.list');
    });
    Route::any('detail',function(){
        return view('mobile.detail');
    });
});

Route::any('spider',['uses'=>'TestController@spider','as'=>'spider']);
Route::any('querylist',['uses'=>'TestController@query_list','as'=>'querylist']);




