<html>
<head>
    <title></title>

    <link href="{{asset('bootstrap/css/bootstrap.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('vendor/bootstrap-switch/bootstrap-switch.css')}}" rel="stylesheet" type="text/css" />
    {{--<link href="{{asset('test/bootstrap-switch/dist/css/highlight.css')}}" rel="stylesheet" type="text/css" />--}}

    <script src="{{asset('admin/assets/js/jquery.js')}}" type="text/javascript"></script>
    <script src="{{asset('bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('vendor/bootstrap-switch/bootstrap-switch.js')}}" type="text/javascript"></script>
    {{--<script src="{{asset('test/bootstrap-switch/dist/js/highlight.js')}}" type="text/javascript"></script>--}}
    {{--    <script src="{{asset('test/bootstrap-switch/dist/js/main.js')}}" type="text/javascript"></script>--}}
    <script type="text/javascript">
        $(function(){
            $('#mySwitch input').bootstrapSwitch();
        })
    </script>
    <style>
        .rich_media{
            position: relative;
        }
        .rich_media_area_primary{
            background-color: #fff;
            padding-top: 32px;
            padding: 20px 16px 12px;
            padding: calc(20px + constant(safe-area-inset-top)) calc(16px + constant(safe-area-inset-right)) 12px calc(16px + constant(safe-area-inset-left));
            padding: calc(20px + env(safe-area-inset-top)) calc(16px + env(safe-area-inset-right)) 12px calc(16px + env(safe-area-inset-left));
        }
        .rich_media_inner{
            max-width: 677px;
            margin-left: auto;
            margin-right: auto;

        }
        .rich_media_title{
            font-size: 22px;
            line-height: 1.4;
            margin-bottom: 14px;
        }
        .rich_media_content{
            position: relative;
        }
        .rich_media_content p{
            margin: 0cm 0cm 15px;
            max-width: 100%;
            min-height: 1em;
            font-family: -apple-system-font, BlinkMacSystemFont, Helvetica Neue, PingFang SC, Hiragino Sans GB, Microsoft YaHei UI, Microsoft YaHei, Arial, sans-serif;
            letter-spacing: 0.544px;
            background-color: rgb(255, 255, 255);
            line-height: 1.75em;
            box-sizing: border-box !important;
            overflow-wrap: break-word !important;
            overflow: hidden;
            color: #333;
            font-size: 17px;
            word-wrap: break-word;
            -webkit-hyphens: auto;
            -ms-hyphens: auto;
            hyphens: auto;
            text-align: justify;
            position: relative;
            z-index: 0;
        }
        html {
            font-family: sans-serif;
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        body {
            margin: 10px;
        }
        table {
            border-collapse: collapse;
            border-spacing: 0;
        }

        td,th {
            padding: 0;
        }

        .pure-table {
            border-collapse: collapse;
            border-spacing: 0;
            empty-cells: show;
            border: 1px solid #cbcbcb;
        }

        .pure-table caption {
            color: #000;
            font: italic 85%/1 arial,sans-serif;
            padding: 1em 0;
            text-align: center;
        }

        .pure-table td,.pure-table th {
            border-left: 1px solid #cbcbcb;
            border-width: 0 0 0 1px;
            font-size: inherit;
            margin: 0;
            overflow: visible;
            padding: .5em 1em;
        }

        .pure-table thead {
            background-color: #e0e0e0;
            color: #000;
            text-align: left;
            vertical-align: bottom;
        }

        .pure-table td {
            background-color: transparent;
        }

        .pure-table-bordered td {
            border-bottom: 1px solid #cbcbcb;
        }

        .pure-table-bordered tbody>tr:last-child>td {
            border-bottom-width: 0;
        }
    </style>
</head>
<body>
<div class="rich_media">
    <div class="rich_media_area_primary">
        <div class="rich_media_inner">
            <h2 class="rich_media_title">
                生活原则
            </h2>
            <h5>2021.06.12 - 2022.06.12</h5>
            <div class="rich_media_content">

                <table class="pure-table pure-table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>原则</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>无敌的自信？ Yes or No</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>今天是傻逼吗？ Yes Or No</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>今天有给别人带来价值吗？ Yes Or No</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>今天有没有累成狗？ Yes Or No</td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>人群中的小太阳？浑身散发这领袖气质？ Yes Or No</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>