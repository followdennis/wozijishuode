
<!DOCTYPE html>
<html lang="cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="YB6AyeVnFYNCeV2lmYeu6iZTkkR6XI2hk6TdOByb">

    <title>我自己说的</title>

    <!-- Styles -->
    <link href="{{ asset('bootstrap/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet" />

    <style>
        .navbar{
            min-height:45px;
        }
        .s-top-bar{
            background:#21292f;
        }
        .s-cate-bar{
            border-top:0px;
            border-left:0px;
            border-right:0px;
        }
        .label_style span{
            display: block;
            margin:3px;
            float:left;
            padding:8px;
        }
        #login_style a:hover{
            color:white;
        }
        .list-group-item {
            /*position: relative;*/
            /*display: block;*/
            /*padding: 0px;*/
            /*margin-bottom: -1px;*/
            /*background-color: #fff;*/
            /*border-bottom: 1px solid #ddd;*/
        }
        .article-list{
            border:0;
        }
        .article-list ul li{
            border:0;
        }
        .article-list .have-img .list-item-content{

            padding-left:150px;
        }
        .article-list .have-img .list-item-content h2{
            margin-top:-5px;
            font-size:24px;
        }
        .transition {
            -webkit-transition: all .2s ease-out;
            -moz-transition: all .2s ease-out;
            -ms-transition: all .2s ease-out;
            -o-transition: all .2s ease-out;
            transition: all .2s ease-out;
        }
        a:link{
            text-decoration: none;
        }
        a:hover{
            color:#3ca5f6;
        }
        .article-list .list-item-content h2{
            font-size: 24px;
        }
        a{
            color:#303030;
        }
        .article-list .list-item-content h2 a{
            font-size: 18px;
            word-break: normal;
            word-wrap: break-word;
        }
        .article-list .have-img{
            min-height:140px;
        }
        .list-item-content .author{
            margin:10px 0;
        }
        .author a:hover{
            cursor:pointer;
        }
        .list-item-content .author .author-face{
            width: 24px;
            height: 24px;
            cursor: pointer;
            margin: 0 5px 0 0;
            display: inline-block;
            vertical-align: middle;
        }
        .list-item-content .author .author-name,.author .time{
            color: #bbb;
            line-height: 24px;
            margin-left: 7px;
            font-style: normal;
            word-break: break-all;
        }
        .author .author-name a:hover{
            text-decoration: none;
        }
        .author .time{
            margin-left:5px;
        }
        .author .comment{
            margin:0 5px;
            color:#bbb;
        }
        .author .comment:hover{
            color:#ed4040;
        }
        .author .like{
            margin:0 5px;
            color:#bbb;
        }
        .author .like:hover{
            color:#ed4040;
        }
        .list-item-content .author .author-face img{
            width: 100%;
            height: 100%;
            border: 1px solid #ddd;
            border-radius: 50%;
        }
        .list-item-content p{
            color:#999;
            max-height: 80px;
            overflow: hidden;
            margin-bottom: 30px;
        }
        .list-item-content .tag{
            position: relative;
            float: right;
            bottom: 15px;
            right: 10px;
        }
        .list-item-content .tag span{
            margin:0 2px;
            color:#80839c;
        }
        .list-item-content .tag span a{
            color:#80839c;
        }
        .list-item-content .tag span a:hover{
            color:#3ca5f6;
        }
        .article-list .have-img .wrap-img img{
            width: 100%;
            height: 100%;
            border-radius: 4px;
            border: 1px solid #f0f0f0;
        }
        .article-list .have-img .wrap-img{
            position: absolute;
            top: 50%;
            margin-top: -90px;
            left: 0;
            width: 150px;
            height: 150px;
        }
        /*导航样式*/
        .nav-channel .dropdown-menu{
            border:0;
        }
        .nav-channel .channel-item{
            border-radius: 4px;
            margin:0 1px;
        }
        .nav-channel .nav-active{
            background:#ed4040;
        }
        #bs-example-navbar-collapse-1 .nav-active a{
            color:#fff;
        }
        #bs-example-navbar-collapse-1 .channel-item a:hover{
            border-radius: 4px;
            color:#fff;
            background:#ed4040;
        }

    </style>
</head>
<body>
<div id="app">
    <nav class="navbar navbar-default navbar-static-top s-top-bar">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar">1</span>
                    <span class="icon-bar">2</span>
                    <span class="icon-bar">3</span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="http://www.wozijishuode.com">
                    我自己说的
                </a>
            </div>
            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    &nbsp;
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right" id="login_style">
                    <!-- Authentication Links -->
                    <li><a href="">登陆</a></li>
                    <li><a href="">注册</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">

            <div class="col-md-8 col-md-offset-1">
                <nav class="navbar navbar-default s-cate-bar">
                    <div class="container-fluid">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar">1</span>
                                <span class="icon-bar">2</span>
                                <span class="icon-bar">3</span>
                            </button>
                            <a class="navbar-brand" href="/">首页</a>
                        </div>

                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <ul class="nav navbar-nav nav-channel">
                                <li class="channel-item"><a href="#">Link <span class="sr-only">(current)</span></a></li>
                                <li class="channel-item @if(empty($cate_name)) nav-active @endif"><a href="#">Link</a></li>
                                <li class="channel-item @if($cate_name == 'abc') nav-active @endif"><a href="/abc">Link2</a></li>
                                <li class="channel-item"><a href="/">Link3</a></li>
                                <li class="channel-item"><a href="/">Link4</a></li>
                                <li class="channel-item dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Action</a></li>
                                        <li><a href="#">Another action</a></li>
                                        <li><a href="#">Something else here</a></li>
                                        <li role="separator" class="divider"></li>
                                        <li><a href="#">Separated link</a></li>
                                        <li role="separator" class="divider"></li>
                                        <li><a href="#">One more separated link</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div><!-- /.navbar-collapse -->
                    </div><!-- /.container-fluid -->
                </nav>
                <div class="panel panel-default article-list">
                    <div class="panel-body">
                       <div class="">
                           aaa
                       </div>
                    </div>
                    <ul class="list-group">
                        <li class="list-group-item have-img">
                            <a href="#" class="wrap-img">
                                <img src="{{ asset('storage/headImg/head_img.jpeg') }}"/>
                            </a>
                            <div class="list-item-content">
                                <h2>
                                    <a href="#"  class="transition">这是一个标题</a>
                                </h2>

                                <div class="author">
                                    <a href="#" class="author-face"><img src="//upload.jianshu.io/users/upload_avatars/8415343/485bd37f-6e41-4445-9a85-71b6baec3728.jpg?imageMogr2/auto-orient/strip|imageView2/1/w/64/h/64"/></a>
                                    <a class="author-name">用户名</a>
                                    <span class="time">2018-10-25 22:32:03</span>
                                    <a href="#" class="comment"><i class="fa fa-comment-o" aria-hidden="true"></i> 29</a>
                                    <a href="#" class="like"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 20</a>

                                </div>
                                <p>胜利在望的人总是干劲十足，有眼光的人总是感觉到胜利在望
                                    胜利在望的人总是干劲十足，有眼光的人总是感觉到胜利在望
                                    胜利在望的人总是干劲十足，有眼光的人总是感觉到胜利在望
                                    胜利在望的人总是干劲十足，有眼光的人总是感觉到胜利在望
                                    胜利在望的人总是干劲十足，有眼光的人总是感觉到胜利在望
                                    胜利在望的人总是干劲十足，有眼光的人总是感觉到胜利在望
                                </p>
                                <div class="tag">
                                    <span><i class="fa fa-tags" aria-hidden="true"></i> <a href="#">创业</a></span>
                                    <span><i class="fa fa-tags" aria-hidden="true"></i> <a href="#">就业</a></span>
                                    <span><i class="fa fa-tags" aria-hidden="true"></i> <a href="#">励志</a></span>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item have-img">
                            <a href="#" class="wrap-img">
                                <img src="{{ asset('storage/headImg/head_img.jpeg') }}"/>
                            </a>
                            <div class="list-group-item-content">
                                免费域名注册
                            </div>
                        </li>
                        <li class="list-group-item">免费 Window 空间托管</li>
                        <li class="list-group-item">

                            <div class="list-item-content">
                                <h2>
                                    <a href="#"  class="transition">这是一个标题</a>
                                </h2>

                                <div class="author">
                                    <a href="#" class="author-face"><img src="//upload.jianshu.io/users/upload_avatars/8415343/485bd37f-6e41-4445-9a85-71b6baec3728.jpg?imageMogr2/auto-orient/strip|imageView2/1/w/64/h/64"/></a>
                                    <a class="author-name">用户名</a>
                                    <span class="time">2018-10-25 22:32:03</span>
                                    <a href="#" class="comment"><i class="fa fa-comment-o" aria-hidden="true"></i> 29</a>
                                    <a href="#" class="like"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 20</a>

                                </div>
                                <p>胜利在望的人总是干劲十足，有眼光的人总是感觉到胜利在望
                                    胜利在望的人总是干劲十足，有眼光的人总是感觉到胜利在望
                                    胜利在望的人总是干劲十足，有眼光的人总是感觉到胜利在望
                                    胜利在望的人总是干劲十足，有眼光的人总是感觉到胜利在望
                                    胜利在望的人总是干劲十足，有眼光的人总是感觉到胜利在望
                                    胜利在望的人总是干劲十足，有眼光的人总是感觉到胜利在望
                                </p>
                                <div class="tag">
                                    <span><i class="fa fa-tags" aria-hidden="true"></i> <a href="#">创业</a></span>
                                    <span><i class="fa fa-tags" aria-hidden="true"></i> <a href="#">就业</a></span>
                                    <span><i class="fa fa-tags" aria-hidden="true"></i> <a href="#">励志</a></span>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">图像的数量</li>
                        <li class="list-group-item">24*7 支持</li>
                        <li class="list-group-item">每年更新成本</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3 ">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div >
                            <div class="input-group">
                                <input type="text" class="form-control">
                                <span class="input-group-btn">
                                 <button class="btn btn-info" type="button">搜索</button>
                                 </span>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                           最新热文
                        </h3>
                    </div>
                    <div class="panel-body">
                        <p>这是一个基本的面板内容。这是一个基本的面板内容。
                            这是一个基本的面板内容。这是一个基本的面板内容。
                            这是一个基本的面板内容。这是一个基本的面板内容。
                            这是一个基本的面板内容。这是一个基本的面板内容。
                        </p>
                    </div>
                    <ul class="list-group">
                        <li class="list-group-item">免费域名注册</li>
                        <li class="list-group-item">免费 Window 空间托管</li>
                        <li class="list-group-item">图像的数量</li>
                        <li class="list-group-item">24*7 支持</li>
                        <li class="list-group-item">每年更新成本</li>
                    </ul>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            标签云
                        </h3>
                    </div>
                    <div class="panel-body label_style">
                        <span class="label label-default">标签</span>
                        <span class="label label-primary">主要标签</span>
                        <span class="label label-success">成功标签</span>
                        <span class="label label-info">信息标</span>
                        <span class="label label-warning">警告标签</span>
                        <span class="label label-danger">危险标签</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="{{ asset('vendor/jquery/jquery.js') }}"></script>
<script src="{{ asset('bootstrap/js/bootstrap.js') }}"></script>

</body>
</html>
