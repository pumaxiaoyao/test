$(function () {
    $("#withdrawal_submit").click(function () {

        var bank = $('input[name="bankradiogroup"]:checked').val();
        var amount = $("#withdrawalMoney").val();

        if (amount == "" || isNaN(amount) || parseInt(amount) < 100) {
            $("#withdrawalMoney").focus();
            $("#withdrawalMoney_tips").addClass("redtext");
            $("#withdrawalMoney_tips").html("提款每次最低100，请输入正确的金额");
            return;
        }

        if (bank == "") {
            swal({ title: "", text: "请选择银行卡", type: "warning" });
            return false;
        }
        $("#withdrawal_submit").html('<img src="/static/img/loading.gif" />').attr("disabled", "disabled");
        $.post("/API/common/WithdrawalCash", { bank: bank, amount: amount, action: "create" }, function (result) {
            $("#withdrawal_submit").html('提交提款').removeAttr('disabled');
            result = JSON.parse(result);
            if (result.code == 200) {
                swal({ title: "", text: result.Message, type: "success" });

            } else  {
                errorHandler(result);
            }

        });
    });
});