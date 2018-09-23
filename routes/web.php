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
        Route::get('/public_links/load',['uses'=>'Admin\ArticlesManage\InnerLinkController@links_load','as'=>'public_links/load']);
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
         *  大计划小步骤 迭代日志
         */
        Route::any('diary/steps', ['uses' => 'Admin\Diary\StepsController@index', 'as' => 'diary/steps']);//视图
        Route::any('diary/steps/lists', ['uses' => 'Admin\Diary\StepsController@lists', 'as' => 'diary/steps/lists']);
        Route::any('diary/steps/add', ['uses' => 'Admin\Diary\StepsController@add', 'as' => 'diary/steps/add']);
        Route::any('diary/steps/edit', ['uses' => 'Admin\Diary\StepsController@edit', 'as' => 'diary/steps/edit']);
        Route::any('diary/steps/del', ['uses' => 'Admin\Diary\StepsController@del', 'as' => 'diary/steps/del']);

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
         * 投诉与举报
         */
        Route::get('report',['uses'=>'Admin\Report\ReportController@index','as'=>'report']);//投诉信息列表
        Route::get('report/get_list',['uses'=>'Admin\Report\ReportController@get_list','as'=>'report/get_list']);
        Route::get('report/process',['uses'=>'Admin\Report\ReportController@edit','as'=>'report/process']);
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

        /**
         * 技能提升计划和业余项目进展记录功能
         */
        Route::any('skill_task',['uses'=>'Admin\Diary\SkillTaskController@index','as'=>'skill_task']);
        Route::any('skill_task/list',['uses'=>'Admin\Diary\SkillTaskController@get_list','as'=>'skill_task/list']);
        Route::any('skill_task/show',['uses'=>'Admin\Diary\SkillTaskController@show','as'=>'skill_task/show']);
        Route::any('skill_task/add',['uses'=>'Admin\Diary\SkillTaskController@add','as'=>'skill_task/add']);
        Route::any('skill_task/edit',['uses'=>'Admin\Diary\SkillTaskController@edit','as'=>'skill_task/edit']);
        Route::any('skill_task/del',['uses'=>'Admin\Diary\SkillTaskController@del','as'=>'skill_task/del']);
        Route::any('public_skill_task/change_status',['uses'=>'Admin\Diary\SkillTaskController@change_status','as'=>'public_skill_task/change_status']);


        Route::any('project_task',['uses'=>'Admin\Diary\ProjectTaskController@index','as'=>'project_task']);
        Route::any('project_task/list',['uses'=>'Admin\Diary\ProjectTaskController@get_list','as'=>'project_task/list']);
        Route::any('project_task/show',['uses'=>'Admin\Diary\ProjectTaskController@show','as'=>'project_task/show']);
        Route::any('project_task/add',['uses'=>'Admin\Diary\ProjectTaskController@add','as'=>'project_task/add']);
        Route::any('project_task/edit',['uses'=>'Admin\Diary\ProjectTaskController@edit','as'=>'project_task/edit']);
        Route::any('project_task/del',['uses'=>'Admin\Diary\ProjectTaskController@del','as'=>'project_task/del']);
        Route::any('public_project_task/change_status',['uses'=>'Admin\Diary\ProjectTaskController@change_status','as'=>'public_project_task/change_status']);

        /**
         * 项目管理
         */
        Route::any('project/index',['uses'=>'Admin\Project\IndexController@index','as'=>'project/index']);
        Route::any('project/lists',['uses'=>'Admin\Project\IndexController@lists','as'=>'project/lists']);
        Route::any('project/edit',['uses'=>'Admin\Project\IndexController@edit','as'=>'project/edit']);
        Route::any('project/add',['uses'=>'Admin\Project\IndexController@add','as'=>'project/add']);
        Route::any('project/del',['uses'=>'Admin\Project\IndexController@del','as'=>'project/del']);
        /**
         * 需求/进展管理
         */
        Route::any('requirement/index',['uses'=>'Admin\Project\Requirement@index','as'=>'requirement/index']);
        Route::any('requirement/edit',['uses'=>'Admin\Project\Requirement@edit','as'=>'requirement/edit']);
        Route::any('requirement/add',['uses'=>'Admin\Project\Requirement@add','as'=>'requirement/add']);
        Route::any('requirement/lists',['uses'=>'Admin\Project\Requirement@lists','as'=>'requirement/lists']);
        Route::any('requirement/del',['uses'=>'Admin\Project\Requirement@del','as'=>'requirement/del']);
        /**
         *  表名称
         */
        Route::any('table/index',['uses'=>'Admin\Project\Table@index','as'=>'requirement/index']);
        Route::any('table/edit',['uses'=>'Admin\Project\Table@edit','as'=>'requirement/edit']);
        Route::any('table/add',['uses'=>'Admin\Project\Table@add','as'=>'requirement/add']);
        Route::any('table/lists',['uses'=>'Admin\Project\Table@lists','as'=>'requirement/lists']);
        Route::any('table/del',['uses'=>'Admin\Project\Table@del','as'=>'requirement/del']);
        /**
         * 表字段
         */
        Route::any('field/index',['uses'=>'Admin\Project\TableController@index','as'=>'field/index']);
        Route::any('field/add',['uses'=>'Admin\Project\TableController@add','as'=>'field/add']);
        Route::any('field/edit',['uses'=>'Admin\Project\TableController@edit','as'=>'field/edit']);
        Route::any('field/lists',['uses'=>'Admin\Project\TableController@lists','as'=>'field/lists']);
        Route::any('field/del',['uses'=>'Admin\Project\TableController@del','as'=>'field/del']);

        /**
         *  文件上传
         */
        Route::post('upload',['uses'=>'Admin\UploadController@run','as'=>'upload']);
        /**
         * 系统日志
         */
        Route::any('system_log', ['uses' => 'Admin\System\SystemLogController@index', 'as' => 'system_log']);
        Route::any('system_log/lists', ['uses' => 'Admin\System\SystemLogController@lists', 'as' => 'system_log/lists']);
        Route::any('system_log/browse',['uses'=>'Admin\System\SystemLogController@browse_history','as'=>'system_log/browse']);//用户访问历史
        Route::any('system_log/browse_list',['uses'=>'Admin\System\SystemLogController@browse_list','as'=>'system_log/browse_list']);//列表

    });
});
//前台
Route::group(['domain'=>'www.wozijishuode.com'],function(){
    Route::any('login/qq',['uses'=>'Foreground\Auth\QQLoginController@qq']);
    Route::any('login/qq_login',['uses'=>'Foreground\Auth\QQLoginController@qqlogin']);
    Route::get('/login',['uses'=>'Foreground\Auth\LoginController@showLoginForm','as'=>'front.login']);
    Route::post('/login',['uses'=>'Foreground\Auth\LoginController@login']);
    Route::get('/register',['uses'=>'Foreground\Auth\RegisterController@showRegistrationForm','as'=>'front.register']);
    Route::post('/register',['uses'=>'Foreground\Auth\RegisterController@register']);

    Route::post('/logout',['uses'=>'Foreground\Auth\LoginController@logout','as'=>'front.logout']);
    Route::get('/password/reset',['uses'=>'Foreground\Auth\ResetPasswordController@showResetForm','as'=>'front.password.request']);


    Route::any('/',['uses'=>'Foreground\IndexController@index']);
    Route::get('/p/{page}',['uses'=>'Foreground\IndexController@index']);//分页参数修改
    Route::get('/article/more',['uses'=>'Foreground\IndexController@more']);//瀑布流
    Route::any('/index.html',['uses'=>'Foreground\IndexController@index']);
    Route::any('/ch/{cate?}/',['uses'=>'Foreground\IndexController@lists']);
    Route::any('/ch/{cate}/{page}/',['uses'=>'Foreground\IndexController@lists'])->where('page', '[0-9]+')->where('cate', '[A-Za-z]+');//分类中的分页参数修改
    Route::any('/{cate}/{id}.html',['uses'=>'Foreground\IndexController@detail']);
    Route::post('/browse',['uses'=>'Foreground\IndexController@browse']);//浏览
    Route::any('/search',['uses'=>'Foreground\SearchController@search_keywords']);//关键词搜索
    Route::any('/search/more',['uses'=>'Foreground\SearchController@more']);//关键词搜索
    Route::any('/search/t/{tag}/',['uses'=>'Foreground\SearchController@search_tag']);//tag搜索
    Route::any('/search/auto',['uses'=>'Foreground\SearchController@autoload2']);//搜素自动完成
    Route::any('/article/another_batch',['uses'=>'Foreground\IndexController@another_batch']);//换一批

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
        //文章收藏
        Route::get('article/collect',['uses'=>'Foreground\CollectionController@add']);
        /**
         *  文件上传
         */
        Route::post('upload',['uses'=>'Foreground\UploadController@run']);
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




