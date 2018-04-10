$(document).ready(function () {
    $("#s_search").search({
        "_fnCallback": function (resp) {
            $('#data tbody > tr').find('td:eq(4)').css('text-align', 'right');
            $("#dc").text(resp.dc);
            $("#ac").text(resp.ac);
        }
    });
});

//设置出款弹窗
function setbankModal(dno) {
    nowdno = dno;

    // $.ajax({
    //     url: '/task/receive',
    //     type: 'post',
    //     data: {tid: dno, type: 1310},
    //     cache: false
    // });

    $.getJSON("/playerfund/wtdInfo?dno=" + dno, function (d) {
        $("#outBankInfo").val(d['bankname'] + "-" + d['realname'] + "-" + d['cardnum']);
        $("#bmactual").val(d['actual']);
        $("#bmwfee").val(d['wfee']);
        // $("#bmwfee").val(0);
        $("#dealremark").val();
    });
}

//提交银行出款信息
function submitWtdBankInfo(flag) {
    var bcid = $("#bmbcid").val();
    var wfee = $("#bmwfee").val() == "" ? 0 : $("#bmwfee").val();
    var dealremark = $("#bmremark").val();
    if (dealremark == "") {
        $.notific8("请填写备注！", {theme: 'ebony'});
        return;
    }
    var balance = new BigNumber($("#bmbcid").find("option:selected").attr("balance"));

    var bmactual = new BigNumber($("#bmactual").val());
    bmactual = bmactual.plus(new BigNumber(wfee));

    if (balance.lessThan(bmactual)) {
        $.notific8("银行卡余额不足", {theme: 'ebony'});
        return;
    }

    $.ajax({
        url: "/playerfund/completewtd",
        type: 'post',
        data: {bcid: bcid, wfee: wfee, dealremark: dealremark, dno: nowdno},
        success: function (data) {
            data = JSON.parse(data);
            data = data.data;
            if (data.code == 0) {
                $.notific8("提交出款信息成功");
            } else {
                $.notific8(data.Message, {theme: 'ebony'});
            }
            $(flag).next().click();
            target[1].fnReloadAjax();
        },
        cache: false
    });
}