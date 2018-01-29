@extends('foreground.layouts.main')
@section('script')
    <script type="text/javascript">
        window.onscroll=function(){
            var topScroll =document.body.scrollTop;//滚动的距离,距离顶部的距离
            console.log(topScroll);
            var bignav  = document.getElementById("navbar");//获取到导航栏id
            if(topScroll > 50){  //当滚动距离大于250px时执行下面的东西
                bignav.style.position = 'fixed';
                bignav.style.top = '0';
                bignav.style.width='47%';
                bignav.style.zIndex = '9999';
            }else{//当滚动距离小于250的时候执行下面的内容，也就是让导航栏恢复原状
                bignav.style.position = 'static';
            }
        }
    </script>
@endsection
@section('style')
@endsection
@section('nav')
    @include('foreground.shared.nav')
@endsection
@section('content')
    <div class="panel panel-default article-list">
        <div class="panel-body">
            <div class="">
                aaa
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
    @include('foreground.shared.search')
    @include('foreground.shared.hot')
    @include('foreground.shared.recommend')
    @include('foreground.shared.tags')
@endsection