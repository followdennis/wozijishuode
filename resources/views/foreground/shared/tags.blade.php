<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            标签云
        </h3>
    </div>
    <div class="panel-body label_style">
        @foreach($tags as $tag)
            <a href="{{ url('search/t/'.$tag->name) }}" class="{{ $tag->style }}">{{ $tag->name }}</a>
        @endforeach
    </div>
</div>