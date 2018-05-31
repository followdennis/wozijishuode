@extends('foreground.layouts.main')
@section('script')
<script>
    $(document).ready(function(){
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        $("#auto_search").bigAutocomplete({
            width:618,
            url:'{{ url('search/auto') }}',
            callback:function(data){
                //alert(data.title);
            }
        });
        var hasMore = true;
        var is_loading = false;
        var is_login = "{{ $is_login }}";
        var i = 2; //当前页数
        $("#load_more").on('click',function(){
            var kw = $("#auto_search").val().trim();
            $.ajax({
                type:'get',
                dataType:'json',
                data:{page:i,kw:kw},
                url:'/search/more',
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
                            var title = array['title'].replace(kw,'<font color="red">'+ kw + '</font>');
                            var author = array['author'] ? array['author']:'未知';
                            var cate_py = array['cate']['pinyin'];
                            var comments_count = array['comments_count'];
                            var created_at = array['created_at'];
                            var description = array['description'];
                            var img = array['img'];
                            var post_time = array['post_time'];
                            var tags = ''
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
                        $("#load_more").hide();
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
        })
    })
</script>
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
        #load_more{
            background-color:#ea5c5c;
            border-color:#ea5c5c;
        }
    </style>
@endsection
@section('nav')
    <div class="search-bar">
        <form action="{{ url('search') }}" method="get" name="searchForm">
            <div class="col-lg-12">
                <div class="input-group">
                    <input type="text" value="{{ $kw }}" placeholder="请输入关键词" name="keywords" id="auto_search" class="form-control y-left">
                    <span class="input-group-btn y-right">
						<button class="btn btn-default search-btn" id="search-btn" type="submit">
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
               热门搜索：
                @foreach($words as $word)
                    <a href="{{ url('search?keywords='.$word->keywords) }}" >{{ $word->keywords }}</a>
                @endforeach
            </div>
        </div>
        @include('foreground.shared.content_list')
        <div id="loading" style="display:none"><img src="{{ asset('images/loading_1.gif') }}"></div>
        <button class="btn btn-primary" data-loading-text="加载更多" id="load_more">加载更多</button>
    </div>
@endsection
@section('right_side')
    @include('foreground.shared.hotsearch')
    @include('foreground.shared.latest_hot')
    @include('foreground.shared.tags')
@endsection