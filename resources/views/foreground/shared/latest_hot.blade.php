<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            热门文章
        </h3>
    </div>
    <ul class="list-group">
        @foreach($latest_hot as $hot)
            <li class="list-group-item"><a href="{{ url($hot->cate_pinyin.'/'.$hot->id.'.html') }}">{{ $hot->title }}</a></li>
        @endforeach
    </ul>
</div>