<ul class="list-group">
    @foreach($articles as $k =>$article)
        @if($article->have_img == 1)
            <li class="list-group-item have-img">
                <a href="#" class="wrap-img">
                    <img src="http://p3.pstatp.com/large/5e3f00055a0d7bfc6ed7"/>
                </a>
                <div class="list-item-content">
                    <h2>
                        <a href="{{url($article->cate_pinyin."/".$article->id.".html")}}"  class="transition">{{ $article->title }}</a>
                    </h2>

                    <div class="author">
                        <a href="#" class="author-face"><img src="//upload.jianshu.io/users/upload_avatars/8415343/485bd37f-6e41-4445-9a85-71b6baec3728.jpg?imageMogr2/auto-orient/strip|imageView2/1/w/64/h/64"/></a>
                        <a class="author-name">{{ $article['author'] }}</a>
                        <span class="time">{{ $article['created_at'] }}</span>
                        <a href="#" class="comment"><i class="fa fa-comment-o" aria-hidden="true"></i> 20</a>
                        <a href="#" class="like"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> {{ $article['like'] }}</a>

                    </div>
                    <p>{{ $article['description'] }}
                    </p>
                    <div class="tag">
                        <span><i class="fa fa-tags" aria-hidden="true"></i> <a href="#">{{ $article['tags_name'] }}</a></span>
                        <span><i class="fa fa-tags" aria-hidden="true"></i> <a href="#">就业</a></span>
                        <span><i class="fa fa-tags" aria-hidden="true"></i> <a href="#">励志</a></span>
                    </div>
                </div>
            </li>
        @else
            <li class="list-group-item">

                <div class="list-item-content">
                    <h2>
                        <a href="{{url($article->cate_pinyin."/".$article['id'].".html")}}"  class="transition">{{ $article['title'] }}</a>
                    </h2>

                    <div class="author">
                        <a href="#" class="author-face"><img src="//upload.jianshu.io/users/upload_avatars/8415343/485bd37f-6e41-4445-9a85-71b6baec3728.jpg?imageMogr2/auto-orient/strip|imageView2/1/w/64/h/64"/></a>
                        <a class="author-name">{{ $article['author'] }}</a>
                        <span class="time">2018-10-25 22:32:03</span>
                        <a href="#" class="comment"><i class="fa fa-comment-o" aria-hidden="true"></i> 29</a>
                        <a href="#" class="like"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> {{ $article['like'] }}</a>

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
</ul>