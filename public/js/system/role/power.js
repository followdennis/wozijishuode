/**
 * Created by lotus on 16/11/22.
 */

//选择的功能
function checknode(obj) {
    var chk = $("input[type='checkbox']");
    var count = chk.length;
    var num = chk.index(obj);
    var level_top = level_bottom = chk.eq(num).attr('level');
    for (var i = num; i >= 0; i--) {
        var le = chk.eq(i).attr('level');
        if (eval(le) < eval(level_top)) {
            chk.eq(i).prop("checked", true);
            var level_top = level_top - 1;
        }
    }

    for (var j = num + 1; j < count; j++) {
        var le = chk.eq(j).attr('level');
        if (chk.eq(num).is(':checked')) {
            if (eval(le) > eval(level_bottom))
                chk.eq(j).prop("checked", true);
            else if (eval(le) == eval(level_bottom))
                break;
        } else {
            if (eval(le) > eval(level_bottom))
                chk.eq(j).prop("checked", false);
            else if (eval(le) == eval(level_bottom))
                break;
        }
    }
}

$(document).ready(function () {

    $("#dnd-example").treetable({
        indent: 20,
        expandable:true
    });

    $("input[type='checkbox']").selectCheckBox();

    var form = $('.form-horizontal');
    form.ajaxForm({success: showResponse});

    // post-submit callback
    function showResponse(data, statusText)  {

        if(data.status == 1){
            swal({
                title: '权限设置',
                text: "操作成功!",
                type: "success",
                closeOnConfirm: false
            }).then(function () {
                var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                parent.layer.close(index); //再执行关闭
                // parent.window.location.href='/back/role';
            });
        }else {
            swal({
                title: '权限设置',
                text: "操作失败!",
                type: "error",
            });
        }
    }

})