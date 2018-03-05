$(function () {
    pageInit();
    $(".wfail").mouseenter(function () {
        $(this).nextAll('i').show();
    }).mouseout(function () {
        $(this).nextAll('i').hide();
    });
});
function pageInit() {
    if (historyType != "") {
        $("#history_" + historyType).addClass('on');
    } else {
        $("#history_All").addClass('on');
    }
    if (historyTime != "") {
        $("#history_" + historyTime).addClass('on');
    } else {
        $("#history_Month").addClass('on');
    }
    
}
function searchHistory(type, time) {
    var linkurl = "History?";
    if (type != "") {
        linkurl += "TransferType=" + type;
    }
    if (time != "") {
        if (type != "") {
            linkurl += "&&";
        }
        linkurl += "starttime=" + time;
    }
    
    window.location.href = linkurl;
}