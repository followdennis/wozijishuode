@extends('foreground.layouts.main')
@section('script')
@endsection
@section('style')
    <style>
        .breadcrumb{
            line-height: 20px;
            font-size: 16px;
            margin-bottom:0;
        }
        .breadcrumb a:hover{
            color:#346694;
        }
        .panel-body-detail{
            padding-top:5px;
        }
        .article-sub{
            margin-bottom: 15px;
            font-size: 13px;
            color:#807d7d;
        }
        .panel-body-detail .article-content{
            font-size:16px;
            line-height: 27px;
        }
        .panel-body-detail .article-content img{
            max-width: 100%;
            display: block;
            margin: 10px auto;
        }
        p{
            display: block;
            -webkit-margin-before: 1em;
            -webkit-margin-after: 1em;
            -webkit-margin-start: 0px;
            -webkit-margin-end: 0px;
        }
        .article-tag{
            height: 25px;
            margin-bottom: 28px;
        }
        .article-tag .tag-left{
            float:left;
        }
        .article-tag .tag-left ul{
            display: inline-block;
            vertical-align: middle;
        }
        .article-tag .tag-left ul li{
            margin-right: 8px;
            display: inline-block;
            font-size: 16px;
        }
        li.tag-item a{
            color:#3ca5f6;
        }
        li.tag-item a:hover{
            color:#616467;
        }
        ol, ul {
            list-style: none;
        }
        .tag-right{
            float:right;
        }
        .tag-right ul{
            display: inline-block;
            vertical-align: middle;
        }
        .tag-right ul li{
            margin-right: 8px;
            display: inline-block;
            font-size: 14px;
        }
        .tag-right ul li a{
            color:#919ba2;
        }
        .article-ad{
            margin:10px auto;
        }
        .detail-comment{
            margin:15px 0;
        }
        .detail-comment .comment .comment-count{
            margin-bottom:20px;
            font-size:16px;
            font-weight:700;
            color:#868181;
        }
        .detail-comment .comment .comment-count em{
            font: 22px/24px Georgia;
            color: #f85959;
        }
        .comment-input{
            border: 1px solid silver;
            border-radius: 2px;
        }
        .comment-input-button{
            height: 40px;
        }
        .comment .input-submit{
            float: right;
            line-height: 44px;
            background-color: #2392d4;
            width: 110px;
            height: 100%;
            color: #fff;
            text-align: center;
            cursor: pointer;
        }
        .comment-input-area textarea{
            width: 100%;
            height: 100%;
            border: 0;
            resize: none;
            background: #fff;
            padding: 11px 16px 0;
        }
        .comment-input-area textarea:focus{
            border:0;outline:none;
        }
        .comment-item .avatar-wrap{
            float: left;
            display: block;
            width: 30px;
            height: 30px;
            border: 1px solid #e8e8e8;
            border-radius: 50%;
            overflow: hidden;
        }
        .comment-item{
            padding: 14px 0;
            border-top: 1px solid #f2f2f2;
        }
        .comment-item:first-child{
            margin-top:22px;
        }
        .comment-content{
            margin-left:42px;
        }
        .comment-content p{
            font-size: 14px;
            line-height: 22px;
            color: #222;
            margin:0 0 10px;
        }
        .comment-user-info{
            margin-bottom:4px;
        }
        .comment-user-name{
            color: #406599;
            cursor: pointer;
        }
        .comment-time{
            color: #777;
        }
        .comment-reply{
            color: #406599;
            cursor: pointer;
        }
        .comment-expend-reply{
            color: #406599;
            cursor: pointer;
            margin-left:5px;
        }
        .comment-footer .comment-report{
            margin-top: 1px;
            margin-left: 12px;
            cursor: pointer;
        }
        .comment-footer .comment-like{
            color: #777;
            cursor: pointer;
            font-size:16px;
        }
        .comment-footer .comment-like:hover{
            color: #ff443a;
        }
        .comment-footer .comment-report{
            color:#aaa;
            cursor: pointer;
            font-size:16px;
        }
        .comment-footer .comment-report:hover{
            color:#555;
        }
        .comment-float-right{
            float:right;
            margin-right:3px;
        }
        .page-pre-next{
            font-size:16px;
        }
        .page-pre-next a {
            margin-left: 2px;
            font-size:16px;
            font-weight:600;
            color:#676565;
        }
        .relative .title{
            position: relative;
            font-size: 18px;
            color: #222;
            line-height: 18px;
            padding-left: 16px;
            margin-bottom: 6px;
            font-weight: 700;
        }
        .relative .relative-wrap ul li{
            display: list-item;
            text-align: -webkit-match-parent;
        }
        .relative .relative-wrap .relative-item{
            height: 123px;
            position: relative;
            padding: 10px 0;
            border-bottom: 1px solid #e8e8e8;
        }
        .relative-item .relative-lbox{
            width: 158px;
            height: 102px;
            margin-right: 16px;
            float:left;
        }
        .relative-item .relative-lbox .img-wrap:before{
            display: inline-block;
            height: 100%;
        }
        .relative-item .relative-lbox .img-wrap{
            position: relative;
            cursor: pointer;
            width: 100%;
            text-align: center;
            border: 1px solid #e8e8e8;
            background: #e8e8e8;
            overflow: hidden;
            transform-style: preserve-3d;
        }
        .relative-item .relative-lbox .img-wrap img{
            width:100%;
        }
        .relative-item .relative-rbox:before{
            content: "";
            visibility: hidden;
            display: inline-block;
            vertical-align: middle;
        }
        .relative-item .relative-rbox{
            height: 100%;
            overflow: hidden;
        }

        .relative-item .relative-rbox .inner{
            display: inline-block;
            width: 100%;
            vertical-align: middle;
        }
        .relative-item .relative-rbox .inner .title-box{
            font-size: 20px;
            line-height: 1.3;
            margin-bottom: 4px;
            font-weight: 700;
            max-height: 52px;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .relative-footer .footer-bar-left{
            display: inline-block;
            vertical-align: middle;
        }
        .footer-bar-left .media-avatar{
            color: #fff;
            margin-right: 2px;
            width: 18px;
            height: 18px;
            line-height: 18px;
            text-align: center;
            font-size: 12px;
            border-radius: 50%;
            background-color: #eee;
            overflow: hidden;
        }
        .footer-bar-left .media-avatar>img{
            color: #fff;
            margin-right: 2px;
            width: 18px;
            height: 18px;
            line-height: 18px;
            text-align: center;
            font-size: 12px;
            border-radius: 50%;
            background-color: #eee;
            overflow: hidden;
        }
        .footer-bar-left a{
            color: #999;
            margin-right:5px;
        }
        .footer-bar-left a:hover{
            color:#406599;
        }
        .relative-footer .footer-bar-right{
            float: right;
        }

        .relative-footer .footer-bar-right .action-dislike{
            position: relative;
            color: transparent;
            color: #fff!important;
            cursor: pointer;
            width: 20px;
            height: 20px;
            line-height: 20px;
            overflow: hidden;
            padding-right: 20px;
            padding-left: 8px;
            transition: width .3s ease;
            white-space: nowrap;
            z-index: 2;
        }
        .relative-footer .footer-bar-right .action-dislike:hover{
            background-color: #f85959;
            border-radius: 4px;
            color: #fff;
            font-size: 12px;
            width: 72px;
        }
        .footer-bar-right .action-dislike i{
            position: absolute;
            top: 2px;
            right: 0
        }
        .inner .title-box .link:hover{
            color:#406599;
        }

        .relative .title:before{
            position: absolute;
            left: 0;
            top: 0;
            content: "";
            width: 4px;
            height: 18px;
            background: #ed4040;
            border-radius: 4px;
        }
        .page-not-found {
            height: 300px;
            line-height: 300px;
            font-size: 28px;
            color: #f399a9;
        }
    </style>
@endsection
@section('content')
    <div class="panel panel-default article-list">
        <ol class="breadcrumb">
            @foreach($breads as $bread)
                @if(isset($bread['is_title']))
                    <li class="active">{{ $bread['name'] }}</li>
                @else
                    <li><a href="{{ url("{$bread['prefix']}{$bread['pinyin']}") }}">{{ $bread['name'] }}</a></li>
                @endif
            @endforeach
        </ol>
        <div class="panel-body panel-body-detail">
            <div class="article_box">
                @if($is_exist)
                <h2 class="article-title">{{ $article['title'] }}</h2>
                <div class="article-sub"><!----> <span>@if(empty($article['author']))佚名 @else{{ $article['author'] }} @endif</span> <span>@if(empty($article['created_at']))2018-01-01 20:11:32 @else {{ $article['created_at'] }} @endif </span></div>
                <div class="article-content">
                    <div>
                        {!! $article['content'] !!}
                        {{--<p>三国时期，除了诸葛亮意外，最令人敬佩的也就是司马懿了，因为这个人物也是一个比较厉害的角色，不仅有才能，还有实力。--}}
                            {{--可能他的能力跟曹家不相上下，但是不知为何一直没有实施篡权，那么这究竟是因为什么呢？司马懿又为什么害怕曹睿？</p>--}}
                        {{--<p>曹睿是曹丕的长子，也是继曹丕之后，曹魏的第二位皇帝。他在位的十三年间，前期颇有建树，后期沉迷于享乐，后来又托孤不当，造成了后期曹魏政局的动荡。曹睿字元仲，睿的意思是明智和智慧，也就是通达的意思。而元则有第一、首位的意思，仲则是排在第二的意思。</p><p>所以，字“元仲”与本名“睿”表达的大意相同，都是希望曹睿能够出类拔萃。但是，曹睿的字也引起了一些争议，而这些争议，往往与他的身世有关。因为曹睿的字的谐音是“袁种”，也有人怀疑其中暗含着另一层意思，那就是曹睿其实是其生母甄宓的前夫袁熙的儿子。</p><p><img src="http://p1.pstatp.com/large/568b000156f5694166a4" img_width="870" img_height="511" alt="司马懿城府那么深，为何偏偏惧怕曹叡？" inline="0"></p><p>至于到底有没有这层暗含的意思，其实就要看这是谁给曹睿起的字。如果是曹丕所起的话，那么应该就没有这层暗含的意思。毕竟这对男人来说是奇耻大辱，他不可能再取这样的一个谐音来供人猜测，来时刻提醒着自己曹睿不是自己的儿子。</p><p>如果这是甄宓所起的话，那就另当别论了。毕竟，甄宓与袁熙情投意合，彼此感情深厚，通过这样的谐音来给他们俩的儿子取字，也是对袁熙的一种纪念。当然，谁给曹睿起的字，就如同曹睿的身世之谜一样，如今已是无从追溯了。</p><p>曹睿是曹魏的皇帝，他的后宫中有无数的女人等着他去临幸。但是不知为何，曹睿的子嗣非常单薄，他一共有三个亲生的儿子，两个养子以及两个女儿。可惜的是，他的帝位，最后也没能传到自己亲生儿子的手中。</p><p><img src="http://p3.pstatp.com/large/568b000156f4653ac099" img_width="482" img_height="360" alt="司马懿城府那么深，为何偏偏惧怕曹叡？" inline="0"></p><p>司马懿是三国历史上让人颇为忌惮的人物，他是曹魏的大军师，他辅佐曹丕开创了大魏，他大权在握，他一生在活在权谋与算计当中，鹰视狼顾是世人对于司马懿的评价。但是出人意料的是，司马懿一生都没有对曹魏产生二心，没有因为势力的强大而篡位谋反，就连曹丕死后司马懿仍然尽心尽力的辅佐曹睿。</p><p>曹睿的才智不输给曹丕，而且曹氏宗族势力也很庞大，关键在于，司马懿打仗给他兵权，打完就收走。司马懿压根就没办法顽抗。曹睿是很有能力的君主，如果不是英年早逝，司马家未必能够篡位。</p><p>曹睿是不信任司马懿的，无论是家族个性的遗传，祖父曹操的教诲，仍是关于当时权力构架的组织，终究托孤时为司马懿组织了曹爽这个死对头，都表现出曹睿关于司马懿的不放心，但是曹睿想降服司马懿的心，让他为曹魏统一天下耗尽最后一滴汗水。司马懿既要体现出自个的价值，又不能让曹睿这个大老板心生猜疑，上天给他组织了两个贵人：诸葛亮、陆逊。</p><p><img src="http://p3.pstatp.com/large/568b000156f308480a77" img_width="435" img_height="253" alt="司马懿城府那么深，为何偏偏惧怕曹叡？" inline="0"></p><p>为了能持续生计下去，司马懿还活跃投合曹睿的喜好，当诸葛亮身后，曹睿认为最大的威胁现已不见，便大举吃苦，大修宫室，魏国大都大臣劝阻曹睿要勤政爱民，这儿却没有司马懿的声响，他采纳缄默沉静支撑的态度，曹睿关于他放下点了戒心。</p><p>不过人算不如天算，魏明帝曹睿年仅三十六岁，就因病医治无效去世了。在临死前，聪明一世的曹睿，却犯下了一个使曹家遭遇灭顶之灾的决定：立年仅八岁的曹芳为帝，由司马懿和大将军曹爽共同辅政。</p><p>司马懿的野心，也就是从曹睿去世之后，逐渐开始膨胀。此时，他手中才真正的掌握了大权，没有人可以将其分分钟收回。唯一能与之相抗衡的势力就是曹爽。而这个曹爽又是个大草包。几年之后，司马懿发动高平陵政变，以曹爽谋反的名义，将其诛杀。此后，司马家族就独揽了魏国的军政大权。--}}
                        {{--</p>--}}
                    </div>
                </div>
                <div class="article-tag">
                    <div class="tag-left">

                        <ul class="tag-list">
                            <li class="tag-item"><i class="fa fa-tags" aria-hidden="true"></i></li>
                            @if(!empty($article['tags_name']))
                                @foreach($article['tags_name'] as $tag)
                                    <li class="tag-item"><a href="/search/tag_{{ $tag }}" target="_blank" class="label-link">{{ $tag }}</a></li>
                                @endforeach
                            @endif
                            <li class="tag-item"><a href="/search/?keyword=历史" target="_blank" class="label-link">历史</a></li>
                        </ul>
                    </div>
                    <div class="tag-right">
                        <ul class="tag-list">
                            <li class="tag-item"><a href="/search/?keyword=曹操" target="_blank" class="label-link">收藏</a></li>
                            <li class="tag-item"><a href="/search/?keyword=历史" target="_blank" class="label-link">举报</a></li>
                        </ul>
                    </div>
                </div>
                @else
                    <div class="page-not-found">对不起，你查找的文章走丢了，浏览其他文章试试！</div>
                @endif
            </div>
            <div class="row page-pre-next">
                <div class="col-md-6">
                    <span class="page-pre">上一篇：<a href="#">司马懿的因人数</a></span>
                </div>
                <div class="col-md-6">
                    <span class="page-next">下一篇：<a href="#">司马昭家族</a></span>
                </div>
            </div>
            <div class="article-ad">
                我是一则广告
            </div>
            <div class="detail-comment">
                <div class="comment">
                    <div class="comment-count"><em>102&nbsp;</em>条评论</div>
                    <div class="comment-input">
                        <div class="comment-input-area">
                            <textarea>写下您的评论</textarea>
                        </div>
                        <div class="comment-input-button">
                            <div class="input-submit">评论</div>
                        </div>
                    </div>
                    <ul>
                        <li class="comment-item">
                            <a class="avatar-wrap">
                                <img src="//upload.jianshu.io/users/upload_avatars/8415343/485bd37f-6e41-4445-9a85-71b6baec3728.jpg?imageMogr2/auto-orient/strip|imageView2/1/w/64/h/64">
                            </a>
                            <div class="comment-content">
                                <div class="comment-user-info">
                                    <a href="#" target="_blank" class="comment-user-name">小白</a>
                                    <span class="comment-time">14天前</span>
                                </div>
                                <p>这是条评论</p>
                                <div class="comment-footer">
                                    <span class="comment-reply">回复</span><span class="comment-expend-reply">4条评论</span>
                                    <span title="举报" class="comment-report comment-float-right"><i class="fa fa-info-circle"></i></span>
                                    <span title="点赞" class="comment-like comment-float-right ">20 <i class="fa fa-thumbs-o-up" aria-hidden="true"></i></span>
                                </div>
                            </div>
                        </li>
                        <li class="comment-item">
                            <a class="avatar-wrap">
                                <img src="//upload.jianshu.io/users/upload_avatars/8415343/485bd37f-6e41-4445-9a85-71b6baec3728.jpg?imageMogr2/auto-orient/strip|imageView2/1/w/64/h/64">
                            </a>
                            <div class="comment-content">
                                <div class="comment-user-info">
                                    <a href="#" target="_blank" class="comment-user-name">小白</a>
                                    <span class="comment-time">14天前</span>
                                </div>
                                <p>这是条评论</p>
                                <div class="comment-footer">
                                    <span class="comment-reply">回复</span><span class="comment-expend-reply">4条评论</span>
                                    <span title="举报" class="comment-report comment-float-right"><i class="fa fa-info-circle"></i></span>
                                    <span title="点赞" class="comment-like comment-float-right ">20 <i class="fa fa-thumbs-o-up" aria-hidden="true"></i></span>
                                </div>
                            </div>
                        </li>
                        <li class="comment-item">
                            <a class="avatar-wrap">
                                <img src="//upload.jianshu.io/users/upload_avatars/8415343/485bd37f-6e41-4445-9a85-71b6baec3728.jpg?imageMogr2/auto-orient/strip|imageView2/1/w/64/h/64">
                            </a>
                            <div class="comment-content">
                                <div class="comment-user-info">
                                    <a href="#" target="_blank" class="comment-user-name">小白</a>
                                    <span class="comment-time">14天前</span>
                                </div>
                                <p>这是条评论</p>
                                <div class="comment-footer">
                                    <span class="comment-reply">回复</span><span class="comment-expend-reply">4条评论</span>
                                    <span title="举报" class="comment-report comment-float-right"><i class="fa fa-info-circle"></i></span>
                                    <span title="点赞" class="comment-like comment-float-right ">20 <i class="fa fa-thumbs-o-up" aria-hidden="true"></i></span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="relative">
                <div class="title">相关推荐</div>
                <div class="relative-wrap">
                    <ul>
                        <li>
                            <div class="relative-item">
                                <div class="relative-lbox">
                                    <a href="#" class="img-wrap"><img src="//p1.pstatp.com/list/190x124/50ed00093e440810e7f5"/></a>
                                </div>
                                <div class="relative-rbox">
                                    <div class="inner">
                                        <div class="title-box">
                                            <a href="#" class="link">
                                                司马懿失权后一兵一卒不能调动 凭他养的三千死士成功反杀
                                            </a>
                                        </div>
                                        <div class="relative-footer">
                                            <div class="footer-bar-left">
                                                <a href="#" class="media-avatar">
                                                    <img src="//upload.jianshu.io/users/upload_avatars/8415343/485bd37f-6e41-4445-9a85-71b6baec3728.jpg?imageMogr2/auto-orient/strip|imageView2/1/w/64/h/64"/>
                                                </a>
                                                <a href="#" class="source">鲁迅</a>
                                                <a href="#" class="comment-count">32 评论</a>
                                            </div>
                                            <div class="footer-bar-right">
                                                <div class="action-dislike">
                                                    <i class="fa fa-times" aria-hidden="true" style="font-size: 16px; color: rgb(221, 221, 221);"></i>
                                                    不感兴趣
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="relative-item">
                                <div class="relative-lbox">
                                    <a href="#" class="img-wrap"><img src="//p1.pstatp.com/list/190x124/50ed00093e440810e7f5"/></a>
                                </div>
                                <div class="relative-rbox">
                                    <div class="inner">
                                        <div class="title-box">
                                            <a href="#" class="link">
                                                司马懿失权后一兵一卒不能调动 凭他养的三千死士成功反杀
                                            </a>
                                        </div>
                                        <div class="relative-footer">
                                            <div class="footer-bar-left">
                                                <a href="#" class="media-avatar">
                                                    <img src="//upload.jianshu.io/users/upload_avatars/8415343/485bd37f-6e41-4445-9a85-71b6baec3728.jpg?imageMogr2/auto-orient/strip|imageView2/1/w/64/h/64"/>
                                                </a>
                                                <a href="#" class="source">鲁迅</a>
                                                <a href="#" class="comment-count">32 评论</a>
                                            </div>
                                            <div class="footer-bar-right">
                                                <div class="action-dislike">
                                                    <i class="fa fa-times" aria-hidden="true" style="font-size: 16px; color: rgb(221, 221, 221);"></i>
                                                    不感兴趣
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="relative-item">
                                <div class="relative-lbox">
                                    <a href="#" class="img-wrap"><img src="//p1.pstatp.com/list/190x124/50ed00093e440810e7f5"/></a>
                                </div>
                                <div class="relative-rbox">
                                    <div class="inner">
                                        <div class="title-box">
                                            <a href="#" class="link">
                                                司马懿失权后一兵一卒不能调动 凭他养的三千死士成功反杀
                                            </a>
                                        </div>
                                        <div class="relative-footer">
                                            <div class="footer-bar-left">
                                                <a href="#" class="media-avatar">
                                                    <img src="//upload.jianshu.io/users/upload_avatars/8415343/485bd37f-6e41-4445-9a85-71b6baec3728.jpg?imageMogr2/auto-orient/strip|imageView2/1/w/64/h/64"/>
                                                </a>
                                                <a href="#" class="source">鲁迅</a>
                                                <a href="#" class="comment-count">32 评论</a>
                                            </div>
                                            <div class="footer-bar-right">
                                                <div class="action-dislike">
                                                    <i class="fa fa-times" aria-hidden="true" style="font-size: 16px; color: rgb(221, 221, 221);"></i>
                                                    不感兴趣
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('right_side')
    @include('foreground.shared.hot')
    @include('foreground.shared.recommend')
    @include('foreground.shared.tags')
@endsection