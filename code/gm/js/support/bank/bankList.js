//-/kzb/bank/bankcard/reconciliation 
//属于miracle-bweb，
//参数：
//"outid" 转出卡ID, 
//"inid" 转入卡ID, 
//"tp" 转账类型 1-转账，2-股东, 
//"amount" 金额, 
//"fee" 手续费, 
//"remark" 备注
$(document).ready(function () {
    $("#s_search").search({
        "_fnCallback": function (resp) {
            $("#pageIn").text(resp.pageIn);
            $("#pageOut").text(resp.pageOut);
            $("#totalIn").text(resp.totalIn);
            $("#totalOut").text(resp.totalOut);
        }
    });
    $('#dateline').datetimepicker({
        timeFormat: 'yy-mm-dd hh:ii:ss'
    }).on('changeDate', function (ev) {
        $('#dateline').datetimepicker('hide');
    });
});
function startSelect() {
    $("#outid").find("option:first").attr("selected", true);
    $("#inid").find("option:first").attr("selected", true);
    $("#amount").val(0);
    $("#fee").val(0);

    var d = new Date();
    var vYear = d.getFullYear();
    var vMon = d.getMonth() + 1;
    var vDay = d.getDate();
    var h = d.getHours();
    var m = d.getMinutes();
    var se = d.getSeconds();
    var s = vYear + "-" + (vMon < 10 ? "0" + vMon : vMon) + "-" + (vDay < 10 ? "0" + vDay : vDay) + " " + (h < 10 ? "0" + h : h) + ":" + (m < 10 ? "0" + m : m) + ":" + (se < 10 ? "0" + se : se);
    $("#dateline").val(s);
}


function reconciliation() {

    if ($("#outid").val() == 0 && $("#inid").val() == 0) {
        $.notific8("转出卡和转入卡必须选择一个", {theme: 'ebony'});
        return;
    }

    if ($("#outid").val() == $("#inid").val()) {
        $.notific8("转出卡和转入卡不能是同一张", {theme: 'ebony'});
        return;
    }

    if ($("#amount").val() == 0 && $("#amount").val() == '') {
        $.notific8("请填写正确的金额", {theme: 'ebony'});
        return;
    }

    if ($("#fee").val() == "") {
        $("#fee").val(0);
    }


    var amt = parseInt($("#amount").val()) + parseInt($("#fee").val());
    if ($("#outid").val() != 0) {
        if (parseInt($("#outid").find("option:selected").attr("balance")) < amt) {
            $.notific8("转出卡余额不足", {theme: 'ebony'});
            return;
        }
    }

    var data = "";
    data += "tp=" + $("#tp").val();
    data += "&amount=" + $("#amount").val();
    data += "&fee=" + $("#fee").val();
    data += "&remark=" + $("#remark").val();
    data += "&dateline=" + $("#dateline").val();
    if ($("#outid").val() != 0)data += "&outid=" + $("#outid").val();
    if ($("#inid").val() != 0)data += "&inid=" + $("#inid").val();

    $.ajax({
        url: "/kzb/bank/bankcard/reconciliation",
        type: 'post',
        data: data,
        success: function (data) {
            if (data.c == 0) {
                $.notific8("操作成功");
                $(".close[data-dismiss=modal]").click();
                target[1].fnReloadAjax();
            } else {
                $.notific8(errorMsg(data), {theme: 'ebony'});
            }
        },
        cache: false
    });
}