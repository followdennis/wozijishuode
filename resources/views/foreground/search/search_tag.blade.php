@extends('foreground.layouts.main')
@section('script')
@endsection
@section('style')
<style>
    form{
        margin:0;
        padding:0;
    }
    .y-left{
        height: 40px;
        padding: 0 16px;
        background-color: #fff;
        border: 1px solid #ed4040;
        box-sizing: border-box;
        border-radius: 4px 0 0 4px;
    }
    .y-left:focus{
        border:0;outline:none;
        border: 1px solid #ed4040;
        webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
        -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
        -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
        transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
    }
    .y-right{
        outline: 0;
        border: 0;
        background: #ed4040;
        font-size: 16px;
        text-align: center;
        color: #fff;
        border-radius: 0 4px 4px 0;
    }
    .y-right .search-btn:focus{
        outline: 0;
        border: 0;
        background: #ed4040;
    }
    .search-btn{
        outline: 0;
        border: 0;
        width:100px;
        background: #ed4040;
        font-size: 16px;
        line-height: 40px;
        text-align: center;
        color: #fff;
        border-radius: 0 4px 4px 0;
        padding:0;
    }
    .search-btn:hover,.search-btn:visited,.search-btn:link.search-btn:active{
        background: #ed4040;
        color: #fff;
    }
    #search-btn{
        background: #ed4040;
        color: #fff;
    }
    .btn-default{
        background: #ed4040;
        color: #fff;
    }

    .search-bar{
        margin-top:30px;
        overflow:hidden;
    }
</style>
@endsection
@section('nav')
<div class="search-bar">
    <form action="/search/t/" method="get" name="searchForm">
        <div class="col-lg-12">
            <div class="input-group">
                <input type="text" class="form-control y-left">
                <span class="input-group-btn y-right">
						<button class="btn btn-default search-btn" id="search-btn" type="button">
							搜索
						</button>
                </span>
            </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
    </form>

</div>
@endsection
@section('content')
    <div class="panel panel-default article-list">
        <div class="panel-body">
            <div class="">
                tag
            </div>
        </div>
        <ul class="list-group">
            <li class="list-group-item have-img">
                <a href="#" class="wrap-img">
                    <img src="{{ asset('storage/headImg/head_img.jpeg') }}"/>
                </a>
                <div class="list-item-content">
                    <h2>
                        <a href="#"  class="transition">这是一个标题</a>
                    </h2>

                    <div class="author">
                        <a href="#" class="author-face"><img src="//upload.jianshu.io/users/upload_avatars/8415343/485bd37f-6e41-4445-9a85-71b6baec3728.jpg?imageMogr2/auto-orient/strip|imageView2/1/w/64/h/64"/></a>
                        <a class="author-name">用户名</a>
                        <span class="time">2018-10-25 22:32:03</span>
                        <a href="#" class="comment"><i class="fa fa-comment-o" aria-hidden="true"></i> 29</a>
                        <a href="#" class="like"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 20</a>

                    </div>
                    <p>胜利在望的人总是干劲十足，有眼光的人总是感觉到胜利在望
                        胜利在望的人总是干劲十足，有眼光的人总是感觉到胜利在望
                        胜利在望的人总是干劲十足，有眼光的人总是感觉到胜利在望
                        胜利在望的人总是干劲十足，有眼光的人总是感觉到胜利在望
                        胜利在望的人总是干劲十足，有眼光的人总是感觉到胜利在望
                        胜利在望的人总是干劲十足，有眼光的人总是感觉到胜利在望
                    </p>
                    <div class="tag">
                        <span><i class="fa fa-tags" aria-hidden="true"></i> <a href="#">创业</a></span>
                        <span><i class="fa fa-tags" aria-hidden="true"></i> <a href="#">就业</a></span>
                        <span><i class="fa fa-tags" aria-hidden="true"></i> <a href="#">励志</a></span>
                    </div>
                </div>
            </li>
            <li class="list-group-item have-img">
                <a href="#" class="wrap-img">
                    <img src="{{ asset('storage/headImg/head_img.jpeg') }}"/>
                </a>
                <div class="list-group-item-content">
                    免费域名注册
                </div>
            </li>
            <li class="list-group-item">免费 Window 空间托管</li>
            <li class="list-group-item">

                <div class="list-item-content">
                    <h2>
                        <a href="#"  class="transition">这是一个标题</a>
                    </h2>

                    <div class="author">
                        <a href="#" class="author-face"><img src="//upload.jianshu.io/users/upload_avatars/8415343/485bd37f-6e41-4445-9a85-71b6baec3728.jpg?imageMogr2/auto-orient/strip|imageView2/1/w/64/h/64"/></a>
                        <a class="author-name">用户名</a>
                        <span class="time">2018-10-25 22:32:03</span>
                        <a href="#" class="comment"><i class="fa fa-comment-o" aria-hidden="true"></i> 29</a>
                        <a href="#" class="like"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 20</a>

                    </div>
                    <p>胜利在望的人总是干劲十足，有眼光的人总是感觉到胜利在望
                        胜利在望的人总是干劲十足，有眼光的人总是感觉到胜利在望
                        胜利在望的人总是干劲十足，有眼光的人总是感觉到胜利在望
                        胜利在望的人总是干劲十足，有眼光的人总是感觉到胜利在望
                        胜利在望的人总是干劲十足，有眼光的人总是感觉到胜利在望
                        胜利在望的人总是干劲十足，有眼光的人总是感觉到胜利在望
                    </p>
                    <div class="tag">
                        <span><i class="fa fa-tags" aria-hidden="true"></i> <a href="#">创业</a></span>
                        <span><i class="fa fa-tags" aria-hidden="true"></i> <a href="#">就业</a></span>
                        <span><i class="fa fa-tags" aria-hidden="true"></i> <a href="#">励志</a></span>
                    </div>
                </div>
            </li>
            <li class="list-group-item">图像的数量</li>
            <li class="list-group-item">24*7 支持</li>
            <li class="list-group-item">每年更新成本</li>
        </ul>
    </div>
@endsection
@section('right_side')
    @include('foreground.shared.hotsearch')
    @include('foreground.shared.tags')
@endsection