<div class="title">相关推荐</div>
<div class="relative-wrap">
    <ul>
        @foreach($bottom_recommend as $k => $article)
            <li>
                <div class="relative-item">
                    <div class="relative-lbox">
                        <a href="#" class="img-wrap"><img src="{{ asset('images/default/defaultimg.jpg') }}"/></a>
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
                                        <img src="{{ asset('images/default/thumb/timg.jpg') }}"/>
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