<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
           热搜
        </h3>
    </div>
    <ul class="list-group">
        @foreach($words as $k =>$word)
            <li class="list-group-item">
                <a href="{{ url('search?keywords='.$word->keywords) }}">{{ $word->keywords }}</a>
                @if($k < 3)
                    <span class="circle circle_{{$k}}">{{ $k+1 }}</span>
                @endif
            </li>
        @endforeach
    </ul>
</div>