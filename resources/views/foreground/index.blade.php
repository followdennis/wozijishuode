
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
    <style>
        .navbar{
            background:#21292f;
            min-height:45px;
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
            position: relative;
            display: block;
            padding: 0px;
            margin-bottom: -1px;
            background-color: #fff;
            border-bottom: 1px solid #ddd;
        }
        .list-group-item-content{
            width:100%;
            height:200px;
            border-bottom:1px solid black;
        }
    </style>
</head>
<body>
<div id="app">
    <nav class="navbar navbar-default navbar-static-top">
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
                <div class="panel panel-default">
                    <div class="panel-heading">Login</div>

                    <div class="panel-body">
                       <div class="">
                           aaa
                       </div>
                    </div>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <div class="list-group-item-content">
                                免费域名注册
                            </div>
                        </li>
                        <li class="list-group-item">免费 Window 空间托管</li>
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
