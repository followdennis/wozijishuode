<html lang="zh-cn">
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
?>
<head>
    <title>
        沃兹基硕德
    </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('css/global.css')}}" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
</head>
<body>
<a id="app">
   ff
</a>
<div class="container">
    <div class="row">
        <div class="form-group col-md-6">
            <input type="input" class="form-control" value="哈喽">
        </div>
        <div class="form-group col-md-6">
            <input type="input" class="form-control" value="哈喽212">
        </div>
    </div>
</div>
<div class="row onepage">
    <div class="col-xs-12 col-md-8">.col-xs-12 .col-md-8 one</div>
    <div class="col-xs-6 col-md-4">.col-xs-6 .col-md-4</div>
</div>
<form class="form-inline">
    <div class="form-group">
        <label class="sr-only" for="exampleInputEmail3">Email address</label>
        <input type="email" class="form-control" id="exampleInputEmail3" placeholder="Email">
    </div>
    <div class="form-group">
        <label class="sr-only" for="exampleInputPassword3">Password</label>
        <input type="password" class="form-control" id="exampleInputPassword3" placeholder="Password">
    </div>
    <div class="checkbox">
        <label>
            <input type="checkbox"> Remember me
        </label>
    </div>
    <button type="submit" class="btn btn-default">Sign in</button>
</form>
<div class="row">
    <table class="table table-bordered table-hover">
       <tr><td style="width:200px;">1111</td><td>2</td><td>3</td><td style="width:200px;">562222你好</td></tr>
       <tr><td>1222</td><td>2</td><td>3</td><td>41</td></tr>
       <tr><td>1</td><td>2</td><td>3</td><td>9</td></tr>
    </table>
</div>
<form class="form-inline">
    <div class="form-group">
        <label class="sr-only" for="exampleInputAmount">Amount (in dollars)</label>
        <div class="input-group">
            <div class="input-group-addon">$</div>
            <input type="text" class="form-control" id="exampleInputAmount" placeholder="Amount">
            <div class="input-group-addon">.00</div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Transfer cash</button>
</form>
<div class="pst">
    <div class="pst1">
        111111
    </div>
    <div class="pst2">
        22222
    </div>
    <div class="pst3">
        33333
    </div>
</div>
<div class="fourpage">
    <div class="container" style="width:100%;">
        <div class="coursexingqing-text">
            <h1>9要干活，不需要工具到位</h1>
            <p>怎么才能做到最快速的学习，你猜么？</p>
        </div>
    </div>
</div>
<div class="line4">
    位置测试
</div>
</body>
<script src="{{asset('js/app.js')}}" type="text/javascript"> </script>
</html>