<!DOCTYPE html>
<html lang="cn">
<head>
    @section('seo')
<title>{{ config('app.front_name', 'Laravel') }}_我自己说的网（wozijishuode.com）</title>
    <meta name="keywords" content="我自己说的,沃兹基硕德,名人语录,至理名言,励志故事,励志大全,心灵鸡汤" />
    <meta name="description" content="沃兹基硕德网(wozijishuode.com)是一家致力于帮助于青少年成长的网站,通过网友撰文和搜集整理网络最有趣、最有价值的名人语录、励志故事以及搞笑的文章段子,给青少年甚至成年人提供成长的养料和方向的指南,也帮助大家缓解生活、工作的压力,给迷茫中的人提供方向的选择和建议,关心您的成长！" />
    @show
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('logo/icon.png') }}" media="screen" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Styles -->
    <link href="{{ asset('bootstrap/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet" />
    <link  href="{{asset('layui/src/css/layui.css')}}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('js/bigautocomplete/bigautocomplete.css') }}" rel="stylesheet">
    @yield('style')
</head>
<body>
<div id="app">
    @include('foreground.shared.top_bar')
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
            <div class="col-md-3 " id="right">
                <div style="height:15px;"></div>
                @yield('right_side')
            </div>
        </div>
    </div>

</div>

<script src="{{ asset('vendor/jquery/jquery.js') }}"></script>
<script src="{{ asset('bootstrap/js/bootstrap.js') }}"></script>
<script type="text/javascript" src="{{asset('layui/src/layui.js')}}"></script>
<script src="{{ asset('js/bigautocomplete/bigautocomplete.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/front/main.js') }}"></script>
@yield('script')
</body>
</html>
