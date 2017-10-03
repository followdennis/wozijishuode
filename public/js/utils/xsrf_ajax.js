/**
 * Created by lotus on 16/11/21.
 */
$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-XSRF-TOKEN': $.cookie('XSRF-TOKEN')
        }
    });
});