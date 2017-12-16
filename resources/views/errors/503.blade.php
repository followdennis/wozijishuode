<!DOCTYPE html>
<html>
    <head>
        <title>have a rest.</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 100;
                font-family: 'Lato', sans-serif;
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 48px;
                margin-bottom: 40px;
            }
            .left_time {
                font-size: 24px;
                margin-bottom: 40px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">君不见，高堂明镜悲白发，朝如青丝暮成雪！</div>
                <div class="left_time" id="LeftTime">

                </div>
            </div>
        </div>
    </body>
    <script>
        function FreshTime()
        {
            var endtime=new Date("2018/1/1,0:0:0");//结束时间
            var nowtime = new Date();//当前时间
            var lefttime=parseInt((endtime.getTime()-nowtime.getTime())/1000);
            var d=parseInt(lefttime/3600/24);
            var h=parseInt((lefttime/3600)%24);
            var hh=checkTime(h)
            var m=parseInt((lefttime/60)%60);
            var mm=checkTime(m)
            var s=parseInt(lefttime%60);
            var ss=checkTime(s)
            document.getElementById("LeftTime").innerHTML=" 距离新年还有:"+d+"天"+hh+"小时"+mm+"分"+ss+"秒";
            function checkTime(i){
                if (i<10){
                    i="0" + i;
                }
                return i;
            }
            if(lefttime<=0){
                document.getElementById("LeftTime").innerHTML="结束";
                clearInterval(sh);
            }
        }
        FreshTime();

        var sh=setInterval(FreshTime,1000);
    </script>
</html>
