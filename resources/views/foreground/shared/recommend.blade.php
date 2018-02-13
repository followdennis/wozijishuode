<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            相关推荐
        </h3>
    </div>
    <div class="panel-body">
       为您推送相关的文章！
    </div>
    <ul class="list-group">
        @foreach($recommend as $article)
            <li class="list-group-item"><a href="{{ url($article->cate_pinyin.'/'.$article->id.'.html') }}">{{ $article->title }}</a></li>
        @endforeach
    </ul>
</div>