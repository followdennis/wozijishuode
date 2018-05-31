<ul class="list-group">
    @if($is_exists)
        @foreach($articles as $k =>$article)
            @if($article->have_img == 1)
                <li class="list-group-item have-img">
                    <a href="{{url($article->cate_pinyin."/".$article->id.".html")}}" class="wrap-img">
                        <img src="{{ asset($article->img) }}"/>
                    </a>
                    <div class="list-item-content">
                        <h2>
                            <a href="{{url($article->cate_pinyin."/".$article->id.".html")}}"  class="transition">{!! $article->title !!} </a>
                        </h2>

                        <div class="author">
                            <a href="#" class="author-face"><img src="//upload.jianshu.io/users/upload_avatars/8415343/485bd37f-6e41-4445-9a85-71b6baec3728.jpg?imageMogr2/auto-orient/strip|imageView2/1/w/64/h/64"/></a>
                            <a class="author-name">{{ $article['author'] }}</a>
                            <span class="time">{{ $article['post_time'] }}</span>
                            <span class="time"><i class="fa fa-eye" aria-hidden="true"></i> {{ $article['click'] }}</span>
                            <a href="{{url($article->cate_pinyin."/".$article['id'].".html")}}#comments" class="comment"><i class="fa fa-comment-o" aria-hidden="true"></i> {{ $article['comments_count'] }}</a>
                            <a href="javascript:;" data-status="{{ $is_login }}"  data-id="{{ $article->article_id }}" class="like"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> {{ $article['like'] }}</a>
                        </div>
                        <p>{{ $article['description'] }}
                        </p>
                        <div class="tag">
                            @if(!empty($article->tags_name))
                                @foreach($article->tags_name as $tag)
                                    <span><i class="fa fa-tags" aria-hidden="true"></i> <a href="{{ url("/search/t/$tag") }}">{{ $tag }}</a></span>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </li>
            @else
                <li class="list-group-item">

                    <div class="list-item-content">
                        <h2>
                            <a href="{{url($article->cate_pinyin."/".$article['id'].".html")}}"  class="transition">{!! $article->title !!}</a>
                        </h2>
                        <div class="author">
                            <a href="#" class="author-face"><img src="//upload.jianshu.io/users/upload_avatars/8415343/485bd37f-6e41-4445-9a85-71b6baec3728.jpg?imageMogr2/auto-orient/strip|imageView2/1/w/64/h/64"/></a>
                            <a class="author-name">{{ $article['author'] }}</a>
                            <span class="time">{{ $article['post_time'] }}</span>
                            <span class="time"><i class="fa fa-eye" aria-hidden="true"></i> {{ $article['click'] }}</span>
                            <a href="{{url($article->cate_pinyin."/".$article['id'].".html")}}#comments" class="comment"><i class="fa fa-comment-o" aria-hidden="true"></i> {{ $article['comments_count'] }}</a>
                            <a href="javascript:;" onclick="click_like(this)" data-status="{{ $is_login }}"   data-id="{{ $article->article_id }}" class="like"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> {{ $article['like'] }}</a>

                        </div>
                        <p>{{ $article['description'] }}
                        </p>
                        <div class="tag">
                            @if(!empty($article->tags_name))
                                @foreach($article->tags_name as $tag)
                                    <span><i class="fa fa-tags" aria-hidden="true"></i> <a href="{{ url("/search/t/$tag") }}">{{ $tag }}</a></span>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </li>
            @endif
        @endforeach
    @else
        <li class="list-group-item">

            <div class="list-item-content">
                <h2>
                    <p>没有找到您搜索的文章，换个关键词试试！</p>
                </h2>
                <div class="author">
                </div>
                <p>
                    <a href="/">返回首页</a>
                </p>
                <div class="tag">
                </div>
            </div>
        </li>
    @endif

</ul>