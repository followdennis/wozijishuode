window.onscroll=function(){
    var topScroll = document.documentElement.scrollTop;//滚动的距离,距离顶部的距离
    var bignav  = document.getElementById("navbar");//获取到导航栏id
//      var brand = document.getElementById('site-brand');
    if(topScroll > 50){  //当滚动距离大于250px时执行下面的东西
        $(bignav).addClass('nav-brand');
    }else{//当滚动距离小于50的时候执行下面的内容，也就是让导航栏恢复原状
        $(bignav).removeClass('nav-brand');
    }
}

$(document).ready(function(){
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
    $("#search_input").bigAutocomplete({
            width:228,
            url:'/search/auto',
        callback:function(data){
        //alert(data.title);
    }
});
})