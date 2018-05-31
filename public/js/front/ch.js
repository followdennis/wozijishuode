window.onscroll=function(){
    var topScroll =document.documentElement.scrollTop;//滚动的距离,距离顶部的距离
    var bignav  = document.getElementById("navbar");//获取到导航栏id
    if(topScroll > 50){  //当滚动距离大于250px时执行下面的东西
        $(bignav).addClass('nav-brand');
    }else{//当滚动距离小于250的时候执行下面的内容，也就是让导航栏恢复原状
        $(bignav).removeClass('nav-brand')
    }
}
var resizeTimer = undefined;
$(document).ready(function(){
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
    $("#search_input").bigAutocomplete({
        width:228,
        url:'/search/auto',
        callback:function(data){
            //alert(data.title);
        }
    });
    var winH = $(window).height();//生命了doctype时的，浏览器可视区的高度
    var winW = $(window).width();
    var scrollHeight=document.getElementById("right").offsetHeight;//div的真实高度 好像只能原生
    var initRightTop = scrollHeight + $("#right").offset().top;//这是高度加上偏移高度
    var init_W = $("#right").width()+30;
    var init_L = $("#right").offset().left;//动态获取偏移量

    $(window).scroll(function(){
        var scrollT = $(window).scrollTop();//滚动条top
        //下拉到底部时，固定右侧
        if(scrollT > initRightTop -winH){
            $(window).resize(function () {
                $('#right').width($('#right').width());
                var newWinW = $(window).width();
                clearTimeout(resizeTimer); //清楚时间，解决resize执行两次的问题
                resizeTimer = setTimeout(function () {
                    var new_offset = (newWinW - winW)/2;
                    var left = $("#right").offset().left + new_offset; //还动到底部的时候加偏移量
                    winW = newWinW;
                    $('body,html').animate({'scrollTop':scrollT+1},10);//模拟滚动条滚动一个像素
                    init_L = left;
                }, 100);
            });
            //动态赋值
            $("#right").css({'position':'fixed','left':init_L,'bottom':'5px','width':init_W});
        }else{
            $(window).resize(function () {
                $('#right').width($('#right').width());
                var newWinW = $(window).width();
                clearTimeout(resizeTimer);//
                resizeTimer = setTimeout(function () {
                    var new_offset = (newWinW - winW)/2;
                    console.log(parseInt(new_offset));
                    var left = $("#right").offset().left; //未滑动到底部的时候，不加偏移量
                    winW = newWinW;
                    init_L = left;
                }, 100);
//             $("#right").offset({"left":left});
            });
            $("#right").css({'position':'','left':'','bottom':'','width':''});
            $("#right").addClass("col-md-3 ");
        }
    })

})