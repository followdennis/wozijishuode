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
</head>
<body>

<div class="switch" id="mySwitch">
    <input type="checkbox" checked data-on-text="YES" data-off-text="NO"/>
</div>
</body>
</html>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>this is a bootstrap-switch test</title>



</head>
<body>
<div id="app">
    <example></example>
</div>

</body>
<script src="{{ mix('js/app.js') }}"></script>
</html>

