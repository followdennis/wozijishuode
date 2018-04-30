<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            最新热文
        </h3>
    </div>
    <div class="panel-body">
        <p>
           分享网友最为喜爱的文章！
        </p>
    </div>
    <ul class="list-group" id="slide_more">
        @foreach($hots as $hot)
        <li class="list-group-item"><a href="{{ url($hot->cate_pinyin.'/'.$hot->id.'.html') }}">{{ $hot->title }}</a></li>
        @endforeach
        <li class="list-group-item more" >更多</li>
    </ul>
</div>