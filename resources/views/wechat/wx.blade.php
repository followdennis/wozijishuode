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
    <script src="{{ mix('js/wechat.js') }}"></script>
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
                <div id="wechat">

                </div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        这是面板主题<br/>
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
            <div class="col-md-3">
                <div class="panel panel-default">
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
