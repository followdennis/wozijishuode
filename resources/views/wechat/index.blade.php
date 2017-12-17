@extends('layouts.wx')
@section('CUSTOM_STYLE')
    <link rel="stylesheet" href="{{ asset('vendor/font-awesome/css/font-awesome.css') }}">
    <style>

        .list li.have-img{
            min-height: 140px;
        }
        .list .author {
            margin-bottom: 14px;
            font-size: 13px;
        }
        .list .author a{
            color: #333;
        }
        img {
            vertical-align: middle;
        }
        .list .author .avatar{
            width: 24px;
            height: 24px;
            display: block;
            cursor: pointer;
            margin: 0 5px 0 0;
            display: inline-block;
            vertical-align: middle;
        }
        .list .author .avatar img{
            width: 100%;
            height: 100%;
            border: 1px solid #ddd;
            border-radius: 50%;
        }
        .list .author .info{
            display: inline-block;
            vertical-align: middle;
        }
        .list .author .info span{
            display: inline-block;
            padding-left: 3px;
            color: #969696;
            vertical-align: middle;
        }
        .list .title{
            font-family: -apple-system,SF UI Display,Arial,PingFang SC,Hiragino Sans GB,Microsoft YaHei,WenQuanYi Micro Hei,sans-serif;
            margin: -7px 0 4px;
            display: inherit;
            font-size: 18px;
            font-weight: 700;
            line-height: 1.5;
        }
        .list .abstract{
            margin: 0 0 8px;
            font-size: 13px;
            line-height: 24px;
        }
        .list .meta{
            padding-right: 0!important;
            font-size: 12px;
            font-weight: 400;
            line-height: 20px;
        }
        .list .meta .collection-tag{
            font-size: 12px;
            color: #eee;
            margin-right: 10px;
            padding: 1px 2px;
            border: 1px solid #eee;
            border-color: #87a5b5!important;
            color: #87a5b5!important;
            /*color: #ec6149!important;*/
            /*background-color: rgba(236,97,73,.05);*/
            /*border-color: #ec6149;*/
            /*display: inline-block;*/
            /*padding: 3px 6px;*/
            /*margin-top: -1px;*/
            /*max-width: 200px;*/
            /*overflow: hidden;*/
            /*text-overflow: ellipsis;*/
            /*white-space: nowrap;*/
            /*line-height: 1;*/
            /*vertical-align: middle;*/
            /*border: 1px solid rgba(236,97,73,.7);*/
            /*border-radius: 3px;*/
        }
        .list .meta a{
            margin-right: 10px;
            color: #b4b4b4;
        }
        .iconfont{
            font-family: iconfont!important;
            font-size: inherit;
            font-style: normal;
            font-weight: 400!important;
            -webkit-font-smoothing: antialiased;
        }
        .meta span{
            margin-right: 10px;
            color: #b4b4b4;
        }
        .author .title:visited{
            color: #969696;
        }
        .list .have-img .wrap-img{
            position: absolute;
            top: 50%;
            margin-top: -68px;
            left: 0;
            width: 150px;
            height: 120px;
        }
        .list .have-img .wrap-img img{
            width: 100%;
            height: 100%;
            border-radius: 4px;
            border: 1px solid #f0f0f0;
        }
        .list-group .have-img>div{
            padding-left: 160px;
        }
    </style>

@endsection
@section('CUSTOM_SCRIPT')

    <script type="text/javascript">

    </script>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-2 ">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>

                    <div class="panel-body">
                        这是面板主题<br/>
                        这是面板主题<br/>
                        这是面板主题<br/>
                        这是面板主题<br/>
                    </div>
                    <div class="panel-footer">
                        面板脚注
                    </div>
                </div>
            </div>
            <div class="col-md-7">

                <div class="panel panel-default">
                    <div class="panel-body">
                        这是面板主题<br/>
                        这是面板主题<br/>
                        这是面板主题<br/>
                        这是面板主题<br/>
                        这是面板主题<br/>
                    </div>
                    <ul class="list-group list" >
                        <li id="note-21198170" data-note-id="21198170" class="list-group-item have-img">
                            <a class="wrap-img" href="/p/8830fad9262e" target="_blank">
                                <img class="  img-blur-done" src="//upload-images.jianshu.io/upload_images/8415343-8228fcd59346a645.jpg?imageMogr2/auto-orient/strip|imageView2/1/w/300/h/240" alt="64">
                            </a>
                            <div class="content">

                                <a class="title" target="_blank" href="/p/8830fad9262e">打碗碗花</a>
                                <div class="author">
                                    <a class="avatar" target="_blank" href="/u/255933444f09">
                                        <img src="//upload.jianshu.io/users/upload_avatars/8415343/485bd37f-6e41-4445-9a85-71b6baec3728.jpg?imageMogr2/auto-orient/strip|imageView2/1/w/64/h/64" alt="64">
                                    </a>
                                    <div class="info">
                                        <a class="nickname" target="_blank" href="/u/255933444f09">上善若水_cd86</a>
                                        <span class="time" data-shared-at="2017-12-15T20:52:19+08:00">昨天 20:52</span>
                                    </div>
                                </div>
                                <p class="abstract">
                                    初识打碗花，是在一个毫不经意的季节里，一个稍不留心的午后。天，蓝得温润，有风在吹，湿漉漉的空气里，似乎有五谷的醇香添加在里面。空阔寂寥的田野上，蓝天拖着白云，慢慢地，慢慢地，...
                                </p>
                                <div class="meta">
                                    <a class="collection-tag" target="_blank" href="/c/RfYyQj">散文</a>
                                    <a target="_blank" href="/p/8830fad9262e">
                                        <i class="fa fa-eye"></i> 616
                                    </a>        <a target="_blank" href="/p/8830fad9262e#comments">
                                        <i class="fa fa-commenting-o"></i> 82
                                    </a>      <span><i class="iconfont ic-list-like"></i> 123</span>
                                </div>
                            </div>
                        </li>
                        <li id="note-21212270" data-note-id="21212270" class="list-group-item">
                            <div class="content">

                                <a class="title" target="_blank" href="/p/676a0f10f011">散文 | 不见炊烟</a>
                                <div class="author">
                                    <a class="avatar" target="_blank" href="/u/7337b18e8744">
                                        <img src="//upload.jianshu.io/users/upload_avatars/3459365/0565c4019819?imageMogr2/auto-orient/strip|imageView2/1/w/64/h/64" alt="64">
                                    </a>
                                    <div class="info">
                                        <a class="nickname" target="_blank" href="/u/7337b18e8744">丁_香</a>
                                        <span class="time" data-shared-at="2017-12-16T06:24:21+08:00">14小时前</span>
                                    </div>
                                </div>
                                <p class="abstract">
                                    我曾经是个扎着麻花辫，赤着脚在山乡田野间，四处疯跑的野丫头，那时的山乡真的是山青水秀，炊烟袅袅。早晨闻鸡啼，中午闻鸟叫。傍晚，老水牛从树林里走出来缓缓下山，牛脖子下的铃叮清脆...
                                </p>
                                <div class="meta">
                                    <a class="collection-tag" target="_blank" href="/c/fcd7a62be697">故事</a>
                                    <a target="_blank" href="/p/676a0f10f011">
                                        <i class="iconfont ic-list-read"></i> 316
                                    </a>        <a target="_blank" href="/p/676a0f10f011#comments">
                                        <i class="iconfont ic-list-comments"></i> 43
                                    </a>      <span><i class="iconfont ic-list-like"></i> 51</span>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">图像的数量</li>
                        <li class="list-group-item">24*7 支持</li>
                        <li class="list-group-item">每年更新成本</li>
                    </ul>
                    <div class="panel-footer">
                        面板脚注
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">最新热文</div>

                    <div class="panel-body">
                        这是面板主题
                    </div>
                    <table class="table">
                        <th>产品</th><th>价格 </th>
                        <tr><td>产品 A</td><td>200</td></tr>
                        <tr><td>产品 B</td><td>400</td></tr>
                    </table>
                    <ul class="list-group">
                        <li class="list-group-item">免费域名注册</li>
                        <li class="list-group-item">免费 Window 空间托管</li>
                        <li class="list-group-item">图像的数量</li>
                        <li class="list-group-item">24*7 支持</li>
                        <li class="list-group-item">每年更新成本</li>
                    </ul>
                    <div class="panel-footer">
                        面板脚注
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">热门标签</div>

                    <div class="panel-body">
                        这是面板主题
                    </div>
                    <table class="table">
                        <th>产品</th><th>价格 </th>
                        <tr><td>产品 A</td><td>200</td></tr>
                        <tr><td>产品 B</td><td>400</td></tr>
                    </table>
                    <ul class="list-group">
                        <li class="list-group-item">免费域名注册</li>
                        <li class="list-group-item">免费 Window 空间托管</li>
                        <li class="list-group-item">图像的数量</li>
                        <li class="list-group-item">24*7 支持</li>
                        <li class="list-group-item">每年更新成本</li>
                    </ul>
                    <div class="panel-footer">
                        面板脚注
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
