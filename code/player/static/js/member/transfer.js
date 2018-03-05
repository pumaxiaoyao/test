$(function () {
    $("#source-transfer").change(function () {
        var source = $("#source-transfer").val();
        if (source != "MAIN") {
            $("#desc-transfer").val("MAIN");
        }
    });
    $("#desc-transfer").change(function () {
        var dest = $("#desc-transfer").val();
        if (dest != "MAIN") {
            $("#source-transfer").val("MAIN");
        }
    });
    $("#transfer_submit").click(function () {
        var source = $("#source-transfer").val();
        var dest = $("#desc-transfer").val();
        var amount = parseFloat($("#transferMoney").val());

        if (source == "" || dest == "") {
            swal({ title: "", text: "请选择钱包", type: "warning" });
            return false;
        }
        if (source == dest) {
            swal({ title: "", text: "转出钱包和转入钱包不能相同", type: "warning" });
            return false;
        }

        if ($("#transferMoney").val() == "" || isNaN($("#transferMoney").val()) || parseFloat($("#transferMoney").val()) <= 0) {
            swal({ title: "", text: "请输入金额", type: "warning" });
            return false;
        }
        if (source != "MAIN") {
            sourceAmount = $("#" + source + "_balace").html();
            if (isNaN(sourceAmount)) {
                if (sourceAmount == '维护') {
                    swal({ title: "", text: "转出钱包正在维护请稍后再试", type: "warning" });
                    return;
                }
                swal({ title: "", text: "转出钱包还没加载完请稍后再试", type: "warning" });
                return;
            } else if (sourceAmount < amount) {
                swal({ title: "", text: "转出钱包余额不足", type: "warning" });
                return;
            }
        }
        if (dest != "MAIN") {
            destAmount = $("#" + dest + "_balace").html()
            if (isNaN(destAmount)) {
                if (destAmount == '维护') {
                    swal({ title: "", text: "转入钱包正在维护请稍后再试", type: "warning" });
                    return;
                }
                swal({ title: "", text: "转入钱包还没加载完请稍后再试", type: "warning" });
                return;
            }
        }

        $("#transfer_submit").html('<img src="/static/img/loading.gif" />').attr("disabled", "disabled");
        $.post(
            "/API/common/TransferCash", 
            { source: source, dest: dest, amount: amount, clienttype: 1 }, 
            function (result) {
                result = JSON.parse(result);
                $("#transfer_submit").html('立即转账').removeAttr('disabled');
                if (result.code == 200) {
                    swal({ title: "", text: "转账成功, 订单号请联系客服", type: "success" }, function () {
                        window.location.reload();
                    });
                } else  {
                    errorHandler(result);
                }
        });
    });

});