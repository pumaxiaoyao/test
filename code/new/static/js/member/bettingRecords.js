$(function () {
    pageInit()
});
function pageInit() {
    if (historyTime != "") {
        $("#history_" + historyTime).addClass('on');
    } else {
        $("#history_today").addClass('on');
    }

}
function searchHistory(time, productid) {
    if (productid == 12) {
        return;
    }
    time = time == "" ? historyTime : time;
    // productid = productid == "" ? historyid : productid;
    var linkurl = "BettingRecords?starttime=" + time + "&productid=" + productid;
    window.location.href = linkurl;
}