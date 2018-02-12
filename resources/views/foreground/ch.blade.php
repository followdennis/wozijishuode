@extends('foreground.layouts.main')
@section('script')
    <script type="text/javascript">
        window.onscroll=function(){
            var topScroll =document.body.scrollTop;//滚动的距离,距离顶部的距离
            console.log(topScroll);
            var bignav  = document.getElementById("navbar");//获取到导航栏id
            if(topScroll > 50){  //当滚动距离大于250px时执行下面的东西
                 $(bignav).addClass('nav-brand');
            }else{//当滚动距离小于250的时候执行下面的内容，也就是让导航栏恢复原状
                $(bignav).removeClass('nav-brand')
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
              ch
            </div>
        </div>
        @include('foreground.shared.content_list')
        {!! preg_replace(["~(/ch/[a-zA-Z]+)(/\d+)\?page=~","~(/ch/[a-zA-Z]+)(/)?(\d+)?\?page=~","~(/ch/[a-zA-Z]+)(/)?(\d+)~"], ['$1','$1$2$3','$1/$3'], $articles->links('foreground.pagination.page_ch')) !!}
    </div>
@endsection
@section('right_side')
    @include('foreground.shared.search')
    @include('foreground.shared.hot')
    @include('foreground.shared.recommend')
    @include('foreground.shared.tags')
@endsection