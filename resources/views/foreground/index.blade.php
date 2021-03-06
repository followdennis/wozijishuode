@extends('foreground.layouts.main')

@section('script')
<script type="text/javascript" src="{{ asset('js/front/index.js') }}"></script>
<script type="text/javascript">
 var resizeTimer = undefined;
 $(function(){
     var winH = $(window).height();//生命了doctype时的，浏览器可视区的高度
     var winW = $(window).width();
     var is_login = "{{ $is_login }}";
     var i = 2; //当前页数
     var hasMore = true;
     var is_loading = false;
     var scrollHeight=document.getElementById("right").offsetHeight;//div的真实高度 好像只能原生
     var initRightTop = scrollHeight + $("#right").offset().top;//这是高度加上偏移高度
     var init_W = $("#right").width()+30;
     var init_L = $("#right").offset().left;//动态获取偏移量

     $('ul.pagination').hide();
     if(winW <= 975){
         $('ul.pagination').show();
     }
     $(window).scroll(function(){
         var pageH = $(document.body).height();
         var scrollT = $(window).scrollTop();//滚动条top
         var bottom = (pageH-winH-scrollT)/winH; //

         //初始隐藏翻页

         if(bottom < 0.01 && !is_loading){
             $.ajax({
                 type:'get',
                 dataType:'json',
                 data:{page:i},
                 url:'/article/more',
                 beforeSend:function(){
                     var html = '<img src="{{ asset('images/loading_1.gif') }}">';
                     is_loading = true;
                     $("#loading").show();
                 },
                 success:function(json){
                     var lists = json.data;
                     if(lists.length > 0){
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
                             var have_img = array['have_img'];
                             var tags = ''
                             if(array['tags'].length > 0){
                                 $.each(array['tags'],function(index,item){
                                     tags += '<span><i class="fa fa-tags" aria-hidden="true"></i> <a href="/search/t/'+ item['name']+'">'+ item['name'] +'</a></span>';
                                     item['name']
                                 })
                             }
                             if(have_img == 0){

                             }else {
                                 var  img_url = array['img'];
                             }
                             var img_url = '{{ asset('images/default/thumb/timg.jpg') }}';
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
                             str += '<a href="#" class="author-face"><img src="'+ img_url +'"></a>';
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
                 },
                 complete:function(){
                     is_loading = false;
                     $("#loading").hide();
                 },
                 error:function(e){
                    console.log(e);
                 }
             });
         }
         //下拉到底部时，固定右侧
         var  plus = {state:0};
         var new_offset;
         if((scrollT > initRightTop -winH)){
             $(window).resize(function () {
                 $('#right').width($('#right').width());
                 var newWinW = $(window).width();
                 clearTimeout(resizeTimer); //清楚时间，解决resize执行两次的问题
                 resizeTimer = setTimeout(function () {
                      var new_offset = (newWinW - winW)/2;

                     var left = $("#right").offset().left + new_offset; //还动到底部的时候加偏移量
                     winW = newWinW;
                     $('body,html').animate({'scrollTop':scrollT+1},10);//模拟滚动条滚动一个像素

                     init_L = left;
                 }, 100);
             });

             //动态赋值
             if(winW >= 975){

                 if(new_offset != undefined && new_offset > 0){

                     $("#right").css({'position':'','left':'','bottom':'','width':''});
                     $("#right").addClass("col-md-3 ");
                 }else{

                     $("#right").css({'position':'fixed','left':init_L,'bottom':'5px','width':init_W});
                 }

             }else{
                 $("#right").css({'position':'','left':'','bottom':'','width':''});
                 $("#right").addClass("col-md-3 ");
             }
         }else{
             $(window).resize(function () {
                 $('#right').width($('#right').width());
                 var newWinW = $(window).width();
                 clearTimeout(resizeTimer);//
                 resizeTimer = setTimeout(function () {
                     var new_offset = (newWinW - winW)/2;
                     console.log(parseInt(new_offset));
                     var left = $("#right").offset().left; //未滑动到底部的时候，不加偏移量
                     winW = newWinW;
                     init_L = left;
                 }, 100);
//             $("#right").offset({"left":left});
             });
             if(winW >= 975){
                 $("#right").css({'position':'','left':'','bottom':'','width':''});
                 $("#right").addClass("col-md-3 ");
             }

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
        <div id="loading" style="display:none"><img src="{{ asset('images/loading_1.gif') }}"></div>
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