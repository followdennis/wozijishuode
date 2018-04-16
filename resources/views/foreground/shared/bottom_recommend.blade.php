<div class="title">相关推荐</div>
<div class="relative-wrap">
    <ul>
        @foreach($bottom_recommend as $k => $article)
            <li>
                <div class="relative-item">
                    <div class="relative-lbox">
                        <a href="#" class="img-wrap"><img src="//p1.pstatp.com/list/190x124/50ed00093e440810e7f5"/></a>
                    </div>
                    <div class="relative-rbox">
                        <div class="inner">
                            <div class="title-box">
                                <a href="{{ url($article->cate->pinyin.'/'.$article->id.'.html') }}" class="link">
                                    {{ $article->title }}
                                </a>
                            </div>
                            <div class="relative-footer">
                                <div class="footer-bar-left">
                                    <a href="#" class="media-avatar">
                                        <img src="//upload.jianshu.io/users/upload_avatars/8415343/485bd37f-6e41-4445-9a85-71b6baec3728.jpg?imageMogr2/auto-orient/strip|imageView2/1/w/64/h/64"/>
                                    </a>
                                    <a href="#" class="source">{{ $article->author_name }}</a>
                                    <a href="{{ url($article->cate->pinyin.'/'.$article->id.'.html') }}#comments" class="comment-count">{{ $article->comments_count }} 评论</a>

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
        @endforeach
    </ul>
</div>