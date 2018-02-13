<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            友情链接
        </h3>
    </div>
    <div class="panel-body">
        @foreach($friend_links as $friend_link)
            <a href="{{ $friend_link->link_url }}" @if(!empty($friend_link->description)) title="{{ $friend_link->description }}" @endif>{{ $friend_link->name }}</a>
        @endforeach
    </div>
</div>