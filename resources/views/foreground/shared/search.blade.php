<div class="panel panel-default">
    <div class="panel-body">
        <div >
            <form class="keywords_search" action="{{ url('search') }}" method="get">
                <div class="input-group">
                    <input type="text" name="keywords" id="search_input"  autocomplete="off" class="form-control">
                    <span class="input-group-btn">
                     <input class="btn btn-info" type="submit" value="搜索"></input>
                    </span>
                </div><!-- /input-group -->
            </form>
        </div><!-- /.col-lg-6 -->
    </div>
</div>
