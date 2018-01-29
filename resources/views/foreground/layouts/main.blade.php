<!DOCTYPE html>
<html lang="cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>我自己说的</title>

    <!-- Styles -->
    <link href="{{ asset('bootstrap/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet" />
    <style>
        *{
            padding:0;
            margin:0;
        }
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
        .label_style a{
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
        .navbar{
            margin-bottom:5px;
        }
        .nav-brand{
            position:fixed;
            top:0;
            width:47%;
            z-index:999;
            background:#fff;
        }
    </style>
    @yield('style')
</head>
<body>
<div id="app">

    <nav class="navbar navbar-default navbar-static-top s-top-bar">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
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
                    @if (Auth::guard('front')->guest())
                        <li><a href="{{ route('front.login') }}">登陆</a></li>
                        <li><a href="{{ route('front.register') }}">注册</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::guard('front')->user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ route('front.logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        退出
                                    </a>

                                    <form id="logout-form" action="{{ route('front.logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                                <li>
                                    <a href="#" style="color:red">更多功能,敬请期待</a>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-1">
                <ul style="list-style: none">
                    <li></li>
                </ul>
            </div>
            <div class="col-md-8">
                @yield('nav')
                @yield('content')
            </div>
            <div class="col-md-3 ">
                <div style="height:15px;"></div>
                @yield('right_side')
            </div>
        </div>
    </div>

</div>

<script src="{{ asset('vendor/jquery/jquery.js') }}"></script>
<script src="{{ asset('bootstrap/js/bootstrap.js') }}"></script>
@yield('script')
</body>
</html>
