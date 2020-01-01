function FreshTime()
{
    var dateline = "2021/1/1,0:0:0";
    var endtime=new Date(dateline);//结束时间
    var starttime = new Date("2020/1/1,0:0:0");
    var nowtime = new Date();//当前时间
    var lefttime=parseInt((endtime.getTime()-nowtime.getTime())/1000);
    var finishtime = parseInt((nowtime.getTime()-starttime.getTime())/1000);
    var finishDay = parseInt(finishtime/3600/24);
    var d=parseInt(lefttime/3600/24);
    var h=parseInt((lefttime/3600)%24);
    var hh=checkTime(h)
    var m=parseInt((lefttime/60)%60);
    var mm=checkTime(m)
    var s=parseInt(lefttime%60);
    var ss=checkTime(s)
    document.getElementById("LeftTime").innerHTML="2020年已过 "+ finishDay +" 天 距离 2021 年还有:"+d+"天"+hh+"小时"+mm+"分"+ss+"秒";
    function checkTime(i){
        if (i<10){
            i="0" + i;
        }
        return i;
    }
    if(lefttime<=0){
        document.getElementById("LeftTime").innerHTML="hello 2021";
        clearInterval(sh);
    }
}
// FreshTime();

       var sh=setInterval(FreshTime,1000);
