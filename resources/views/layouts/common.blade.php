<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description')">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="@yield('meta_keyword')">

    <title>欢迎来到管理后台</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!--external css-->
    <link href="{{ asset('admin/assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="{{ asset('admin/assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/css/style-responsive.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/sidebar-menu.css') }}">
    <link href="{{asset('vendor/metronic_theme/css/components.css')}}" rel="stylesheet" id="style_components" type="text/css" />
    <link href="{{asset('vendor/metronic_theme/css/plugins.css')}}" rel="stylesheet" type="text/css" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    @yield('CUSTOM_STYLE')
    <style>
        .pagination > .active > a, .pagination > .active > a:hover, .pagination > .active > a:focus, .pagination > .active > span, .pagination > .active > span:hover, .pagination > .active > span:focus {
            color: #fff;
            background-color: #e7505a;
            border-color: #e7505a;
        }
        .pagination > li > a:hover, .pagination > li > a:focus, .pagination > li > span:hover, .pagination > li > span:focus {
            z-index: 2;
            color: red;
            background-color: #eeeeee;
            border-color: #ddd;
        }
        .pagination > li > a:hover, .pagination > li > a:focus, .pagination > li > span:hover, .pagination > li > span:focus {
            color: red;
            border-color: #ddd;
        }
        .pagination > li > a, .pagination > li > span {
            color: #555;
        }
        .row{
            margin-left:-15px;
        }
        .portlet.box > .portlet-title {
            padding: 0px 15px;
        }
    </style>
</head>
<body>
<section id="container" >
    <!-- **********************************************************************************************************************************************************
    TOP BAR CONTENT & NOTIFICATIONS
    *********************************************************************************************************************************************************** -->
    <!--header start-->

    <!--header end-->

    <!-- **********************************************************************************************************************************************************
    MAIN SIDEBAR MENU
    *********************************************************************************************************************************************************** -->
    <!--sidebar start-->
    <aside>

    </aside>
    <!--sidebar end-->

    <!-- **********************************************************************************************************************************************************
    MAIN CONTENT
    *********************************************************************************************************************************************************** -->
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            @yield('body')
        </section>
    </section>

    <!--main content end-->
@section('footer')
    <!--footer start-->

        <!--footer end-->
    @show
</section>

<!-- js placed at the end of the document so the pages load faster -->


<script src="{{ asset('admin/assets/js/jquery-1.8.3.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/sidebar-menu.js') }}"></script>
@yield('CUSTOM_SCRIPT')
<script>
    $.sidebarMenu($('.sidebar-menu'))
</script>
</body>
</html>
