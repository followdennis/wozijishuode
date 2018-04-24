@extends('foreground.layouts.main')
@section('script')
<script type="text/javascript">
 window.onscroll=function(){
      var topScroll = document.documentElement.scrollTop;//滚动的距离,距离顶部的距离
      var bignav  = document.getElementById("navbar");//获取到导航栏id
//      var brand = document.getElementById('site-brand');
      if(topScroll > 50){  //当滚动距离大于250px时执行下面的东西
          $(bignav).addClass('nav-brand');
      }else{//当滚动距离小于50的时候执行下面的内容，也就是让导航栏恢复原状
         $(bignav).removeClass('nav-brand');
      }
 }
 $(function(){
     var winH = $(window).height();
     var is_login = "{{ $is_login }}";
     var i = 2; //当前页数
     var hasMore = true;
     $(window).scroll(function(){
         var pageH = $(document.body).height();
         var scrollT = $(window).scrollTop();//滚动条top
         var bottom = (pageH-winH-scrollT)/winH; //
         //初始隐藏翻页
         $('ul.pagination').hide();
         if(bottom < 0.01){
             $.getJSON("/article/more", {page:i}, function(json){
                 var lists = json.data;
                 if(lists){
                     $.each(lists,function(index,array){
                         var id = array['id'];
                         var hash_id = array['hash_id'];
                         var title = array['title'];
                         var author = array['author'] ? array['author']:'未知';
                         var cate_py = array['cate']['pinyin'];
                         var comments_count = array['comments_count'];
                         var created_at = array['created_at'];
                         var description = array['description'];
                         var img = array['img'];
                         var post_time = array['post_time'];
                         tags = ''
                         if(array['tags'].length > 0){
                             $.each(array['tags'],function(index,item){
                                 tags += '<span><i class="fa fa-tags" aria-hidden="true"></i> <a href="/search/t/'+ item['name']+'">'+ item['name'] +'</a></span>';
                                 item['name']
                             })
                         }
                         var click = array['click'];
                         var like = array['like'];
                         var comment_url = '/'+ cate_py +'/'+ id +'.html#comments';
                         var article_url = '/' + cate_py + '/' + id + '.html';
                         //alert(array['id']+array['title']+array['author']+array['content']);
                         var str = '';
                         str += '<li class="list-group-item">';
                         str += '<div class="list-item-content"><h2>';
                         str += '<a href="'+ article_url +'" class="transition">'+title+'</a>';
                         str += '</h2><div class="author">';
                         str += '<a href="#" class="author-face"><img src="//upload.jianshu.io/users/upload_avatars/8415343/485bd37f-6e41-4445-9a85-71b6baec3728.jpg?imageMogr2/auto-orient/strip|imageView2/1/w/64/h/64"></a>';
                         str += '<a class="author-name">'+ author +'</a>';
                         str += '<span class="time">'+ post_time +'</span>';
                         str += '<span class="time"><i class="fa fa-eye" aria-hidden="true"></i> '+ click +'</span>';
                         str += '<a href="'+ comment_url +'" class="comment"><i class="fa fa-comment-o" aria-hidden="true"></i> '+ comments_count +'</a>';
                         str += '<a href="javascript:;" onclick="click_like(this)" data-status="'+ is_login +'" data-id="'+ hash_id +'" class="like"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> '+ like +'</a>';
                         str += '</div>';
                         str +='<p>';
                         str +='</p>';
                         str +='<div class="tag">';
                         str += tags;
                         str +='</div>';
                         str +='</div>';
                         str += '</li>';
                         $(".article-list .list-group").append(str);

                     });
                     i++;
                 }else{
                     //$(".nodata").show().html("别滚动了，已经到底了。。。");
                     alert('没有数据了');
                     hasMore = false;
                     //return false;
                 }
             });
         }
     })
 });
</script>
@endsection
@section('style')
@endsection
@section('content')
    <div class="panel panel-default article-list">
        <div class="panel-body">
            <div class="">
                我自己说的，你说
            </div>
        </div>
        @include('foreground.shared.content_list')

        {!! preg_replace("~(/p/\d+)?\?page=~", '/p/', $articles->links('foreground.pagination.page_index')) !!}

    </div>
@endsection
@section('nav')
    @include('foreground.shared.nav')
@endsection
@section('right_side')
    @include('foreground.shared.search')
    @include('foreground.shared.hot')
    @include('foreground.shared.recommend')
    @include('foreground.shared.tags')
    @include('foreground.shared.friendlink')
    @include('foreground.shared.copyright')
@endsection