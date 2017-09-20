/**
 * Created by orinchen on 2017/1/10.
 */

/**
 * js 路由
 * */
var jsRoute = function jsRoute(routeUrl, param) {
    var append = [];

    for (var x in param) {
        var search = '{' + x + '}';

        if (routeUrl.indexOf(search) >= 0) {
            routeUrl = routeUrl.replace('{' + x + '}', param[x]);
        } else {
            append.push(x + '=' + param[x]);
        }
    }

    // var url = '/' + _.trimStart(routeUrl, '/');
    var url =  routeUrl;

    if (append.length == 0) {
        return url;
    }

    if (url.indexOf('?') >= 0) {
        url += '&';
    } else {
        url += '?';
    }

    url += append.join('&');

    return url;
};

/**
 * 保存当前滚动条位置
 * */
function saveScrollPos(){
    var scrollPos;
    if (typeof window.pageYOffset != 'undefined') {
        scrollPos = window.pageYOffset;
    }
    else if (typeof document.compatMode != 'undefined' &&
        document.compatMode != 'BackCompat') {
        scrollPos = document.documentElement.scrollTop;
    }
    else if (typeof document.body != 'undefined') {
        scrollPos = document.body.scrollTop;
    }
    document.cookie="scrollTop="+scrollPos; //存储滚动条位置到cookies中
}

/**
 * 恢复滚动条位置
 * */
function resetScrollPos() {
    if(document.cookie.match(/scrollTop=([^;]+)(;|$)/)!=null){
        var arr=document.cookie.match(/scrollTop=([^;]+)(;|$)/); //cookies中不为空，则读取滚动条位置
        document.documentElement.scrollTop=parseInt(arr[1]);
        document.body.scrollTop=parseInt(arr[1]);
    }
}

/**
 * 给 Select2 组件赋值
 * @param select2 select2 组件
 * @param data 可以是数组[{id:'id', text:'text'},...]也可以是单个对象，{id:'id', text:'text'}
 */
function select2SetValues(select2, data) {
    values = [];
    if(data instanceof Array){
        data.forEach(function (v) {
            if(isNullOrEmpty(v.id)){
                return;
            }
            select2.append("<option value='" + v.id + "'>" + v.text + "</option>")
            values.push(v.id);
        });
    }else{
        if(isNullOrEmpty(data.id)){
            return;
        }
        select2.append("<option value='" + data.id + "'>" + data.text + "</option>")
        values.push(data.id);
    }
    select2.val(values);
}

function isNullOrEmpty(value) {

    var isNull = (value == null || value == 'undefined');
    if(isNull){
        return isNull;
    } else if(value instanceof  Array){
        return value.length < 1;
    } else if((typeof value) == 'string'){
        return value.trim().length < 1;
    } else {
        return isNull;
    }
}

function isNullOrWhitespace(value) {
    return isNullOrEmpty(value)
}
//# sourceMappingURL=helper.js.map
