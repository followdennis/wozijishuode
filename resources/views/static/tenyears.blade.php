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
                未来十年
            </h2>
            <h5>2021.06.12 - 2022.06.12</h5>
            <div class="rich_media_content">

                <table class="pure-table pure-table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th style="width:150px;">类别</th>
                        <th>内容</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>职业发展</td>
                        <td>
                            1年内成为公司的骨干成员，在技术和管理方面有巨大的提升，并且积累一定的人脉资源，为后期的创业打下基础
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>个人情感发展</td>
                        <td>1年内要结婚(2022年中旬之前)</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>个人财富</td>
                        <td>3年内(2024年之前)不追求个人财富的巨幅增长，主要依靠工资收入，和一些业余方面的收入，这个时期的积累出去生活开销之外
                            要能够达到20万的存款
                            区块链的发展固然很好，但是我目前的重点，并不在这上面，短期不依靠这个发财，而是通过个人技能和认知的提升，进行财富的积累
                        </td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>职业与创业技能</td>
                        <td>
                            能够得到周围人的认可，无论是技术层面还是人际交往层面，都应该是一个非常高的水平（2023年之前）
                            每天的努力工作，都应当让别人感觉到，我存在的价值。同时，我要能够熟悉大多数情况的基本流程
                        </td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>创业与财富积累</td>
                        <td>
                            2024年左右的时候，我应该具备了所有的创业能力，这个时候，我的副业已经发展起来，可以作为一个稳定的收入
                            也具备了独立创业的能力和水平（我需要通过各种各样的标准进行自我检测，以保证我的发展进程是没有问题的）
                        </td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td>个人修养</td>
                        <td>
                            我将会是一个能够看透并把握时代的大趋势，能够守住财富，稳重的，靠谱自信的中年男性。
                            自信给人带来的都是光明，自信的好处就是，说话的时候，整个头脑都是灵活和发散的，是积极乐观并且开朗的，能够给别人
                            带来无限生机的。
                            我不应浪费时间在娱乐消遣和网络吹水上面，我应该保持充足的精力，投入到无限的工作当中来
                        </td>
                    </tr>
                    <tr>
                        <td>7</td>
                        <td>说明</td>
                        <td>
                            这个计划是充满热情和激情的，是未来十年的发展总体方向，并且是与时俱进的，要通过这分记录，保持自己充足的热情
                        </td>
                    </tr>
                    <tr>
                        <td>8</td>
                        <td>记录和修改时间</td>
                        <td>
                           2021.06.12 20:13:40
                        </td>
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

