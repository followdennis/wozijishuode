<div class="panel panel-default" id="another_batch">
    <div class="panel-heading">
        <h3 class="panel-title" style="display:inline">
            相关推荐
        </h3>
        <span class="change-one" onclick="another_batch()">
            换一批
        </span>
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