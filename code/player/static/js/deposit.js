$(function () {
    selBankType("#setting_fastpay_bt", 'bank');

    $('#morebank').click(function () {
        if ($('.otherbank').is(':hidden')) {
            $(this).html("收起");
            $('.radio .otherbank').show();
        } else {
            $(this).html("展开所有银行");
            $('.radio .otherbank').hide();
        }
    });

    $("#deposit_bt").click(function () {

        var paymentType = $("#paymentType").val();
        if (paymentType == "third") {
            btnThird();
        } else if (paymentType == "wechat") {
            btnWechat();
        } else if (paymentType == "alipay") {
            btnAlipay();
        } else if (paymentType == "bank") {
            btnbank();
        } else if (paymentType == "qq") {
            btnQQ();
        } else if (paymentType == "bigalipay") {
            btnbigalipay()
        }

    });

    $("#goto_bankweb").click(function () {
        var bankurl = $('input[name="radiogroup2"]:checked').attr("data-url");
        window.open(bankurl);
    })
});

function setmoney(thisbt, howmoney) {
    $('.tk_num').find(".on").removeClass('on');
    $(thisbt).addClass('on');
    $("#depositMoney").val(howmoney).focus()
    if ($("#depositMoney").val() < 100) {
        $("#depositMoney_tips").addClass("redtext");
    } else {
        $("#depositMoney_tips").removeClass("redtext");
    }
}
//function selectSettingBox(type) {
//    //选中菜单动画控制
//    $(".as_menu_icon").attr("class", "as_triangle_down");
//    $(".as_info").attr("class", "as_info");
//    $("#setting_" + type + "_bt").attr("class", "as_info as_info_select");
//    $("#setting_" + type + "_icon").attr("class", "as_menu_icon zx_icon as_" + type);

//    $(".setting_box_div").hide();
//    $("#setting_" + type + "_box").show();
//}

var lastId = 0;
function thirdDeposit() {
    var url = "/Api/getlastdeposit.ashx?type=third&clienttype=1";
    $.ajaxSetup({ cache: false });
    $.getJSON(url, function (res) {
        if (res.success == false) { clearInterval(CountDown.timer); return; }
        var _lid = res.result.length > 0 ? res.result[0].DepositId : -1;
        if (lastId != 0 && lastId != _lid) {
            clearInterval(CountDown.timer);
            $(".bank_prompt .step-1").hide();
            $(".bank_prompt .step-3").show();
            $(".amount").html(res.result[0].DepositAmount.toFixed(2));
            $(".fee").html(res.result[0].BankCharge.toFixed(2));
            $(".netamount").html(res.result[0].NetAmount.toFixed(2));
            return;
        }
        lastId = _lid;
        setTimeout(function () { thirdDeposit(); }, 10000);
    });
}

var blastId = 0;
function bankDeposit() {
    var url = "/Api/getlastdeposit.ashx?type=fast&clienttype=1";
    $.ajaxSetup({ cache: false });
    $.getJSON(url, function (res) {
        if (res.success == false) { clearInterval(CountDown.timer); return; }
        var _lid = res.result.length > 0 ? res.result[0].DepositId : -1;
        if (blastId != 0 && blastId != _lid) {
            clearInterval(CountDown.timer);
            $(".bank_prompt").show();
            $("#setting_wybank_box").hide();
            $(".bank_prompt .step-1").hide();
            $(".bank_prompt .step-3").show();
            $(".amount").html(res.result[0].DepositAmount.toFixed(2));
            $(".fee").html(res.result[0].BankCharge.toFixed(2));
            $(".netamount").html(res.result[0].NetAmount.toFixed(2));
            return;
        }
        blastId = _lid;
        setTimeout(function () { bankDeposit(); }, 10000);
    });
}

function Count2() {
    $(".bank_prompt").show();
    $(".bank_prompt .step-2").hide(); $(".bank_prompt .step-3").hide(); $(".bank_prompt .step-1").show();
    clearInterval(CountDown.timer);
    CountDown.seconds = 1200;
    CountDown.timer = setInterval(function () {
        var $el = $(".bank_prompt .time"), v = $el.html();
        CountDown.seconds -= 1;
        if (CountDown.seconds < 0) { clearInterval(CountDown.timer); $el.hide(); $(".bank_prompt .step-2").show(); $(".bank_prompt .step-1").hide(); return; }
        $el.html(CountDown.Format());
    }, 1000);
}

//计时器
var CountDown = {
    timer: null, seconds: 1200,
    Format: function () { var seconds = this.seconds; var rs = "0:"; if (seconds >= 60) { rs = Math.floor(seconds / 60) + ":"; } var s = (seconds % 60).toString(); s = s.length == 1 ? "0" + s : s; rs += s; return rs },
};

function selBankType(thisbt, type) {
    $('.as_info_select').removeClass('as_info_select');
    $(".as_menu_icon").attr("class", "as_triangle_down");
    $(thisbt).addClass('as_info_select');
    $(thisbt).parent().attr("class", "as_menu_icon zx_icon ");
    $("#depositMoney_tips").removeClass("redtext");
    $("#depositMoney_tips").html("存款每次最低100");
    $("#ATMBankSelectRow").hide();
    $("#setting_wybank_box").hide();
    $("#setting_bigalipay_box").hide();
    $(".bank_prompt").hide();
    $('#setmoneyDiv').html('<span><b onclick="setmoney(this,100)">100</b><b onclick="setmoney(this,500)">500</b><b onclick="setmoney(this,1000)">1000</b><b onclick="setmoney(this,2000)">2000</b><b onclick="setmoney(this,5000)">5000</b></span>')
    if (type == "wechat") {
        $('#setmoneyDiv').html('<span><b onclick="setmoney(this,102)">102</b><b onclick="setmoney(this,503)">503</b><b onclick="setmoney(this,1005)">1005</b><b onclick="setmoney(this,2006)">2006</b><b onclick="setmoney(this,4998)">4998</b></span>')
        wechaInit();
        $("#depositMoney_tips").html("存款每次最低" + wechatTradeMin + "，个位和十位不能同时为0，如：101.00");
    } else if (type == "alipay") {
        $('#setmoneyDiv').html('<span><b onclick="setmoney(this,102)">102</b><b onclick="setmoney(this,503)">503</b><b onclick="setmoney(this,1005)">1005</b><b onclick="setmoney(this,2006)">2006</b><b onclick="setmoney(this,4998)">4998</b></span>')
        alipayInit();
        $("#depositMoney_tips").html("存款每次最低" + alipayTradeMin + "，个位和十位不能同时为0，如：101.00");
    } else if (type == "third") {
        thirdInit();
    } else if (type == "bank") {
        bankInit();
    } else if (type == "qq") {
        $('#setmoneyDiv').html('<span><b onclick="setmoney(this,102)">102</b><b onclick="setmoney(this,503)">503</b><b onclick="setmoney(this,1005)">1005</b><b onclick="setmoney(this,2006)">2006</b><b onclick="setmoney(this,4998)">4998</b></span>')
        qqInit();
        $("#depositMoney_tips").html("存款每次最低" + qqTradeMin + "，个位和十位不能同时为0，如：101.00");
    } else if (type = "bigalipay") {
        $("#depositMoney_tips").html("最低充值金额不能低于" + bigalipayTradeMin + "元，最高不超过" + bigalipayTradeMax);
        $('#setmoneyDiv').html('<span><b onclick="setmoney(this,1000)">1000</b><b onclick="setmoney(this,3000)">3000</b><b onclick="setmoney(this,5000)">5000</b><b onclick="setmoney(this,10000)">10000</b><b onclick="setmoney(this,20000)">20000</b></span>')
        bigalipay();
    }

    $("#paymentType").val(type);
}
function wechaInit() {

    $("#bankSelectRow").hide();
    if (wechatNotMaintain == 1) {
        $("#deposit_from").show();
        $(".deposit_not_available").hide();
    } else {
        $("#deposit_from").hide();
        $("#deposit_maintain").show();
    }
}

function alipayInit() {
    $("#bankSelectRow").hide();
    if (alipayNotMaintain == 1) {
        $("#deposit_from").show();
        $(".deposit_not_available").hide();
    } else {
        $("#deposit_from").hide();
        $("#deposit_maintain").show();
    }
}
function bigalipay() {
    $("#bankSelectRow").hide();
    if (bigalipayNotMaintain == 1) {
        $("#deposit_from").show();
        $(".deposit_not_available").hide();
    } else {
        //swal({ title: "大额支付宝", text: "每天开放时间下午4点到晚上12点"});
        $("#deposit_from").hide();
        $("#deposit_maintain").show();
    }

}

function qqInit() {
    $("#bankSelectRow").hide();
    if (qqNotMaintain == 1) {
        $("#deposit_from").show();
        $(".deposit_not_available").hide();
    } else {
        $("#deposit_from").hide();
        $("#deposit_maintain").show();
    }
}

function bankInit() {
    $("#ATMBankSelectRow").show();
    $("#bankSelectRow").hide();
    if (youBankAvailable == 1) {
        $("#deposit_from").show();
        $("#depositMoney_tips").html("存款每次最低100，请勿使用支付宝，微信等转账到以下银行账号");
        $(".deposit_not_available").hide();
    } else {
        $("#deposit_from").hide();
        $("#deposit_maintain").show();
    }
}
function thirdInit() {
    if (thirdAvailable == 1) {
        if (thirdNotMaintain == 1) {
            if (thirdBankList.indexOf(thirdPaymentId) >= 0) {
                $("#bankSelectRow").hide();
            } else {
                $("#bankSelectRow").show();
            }
            $("#deposit_from").show();
            $(".deposit_not_available").hide();
        } else {
            $("#deposit_from").hide();
            $("#deposit_maintain").show();
        }
    } else {
        $("#deposit_from").hide();
        $("#deposit_disabled").show();
    }
}

// bank payment
function btnbank() {
    console.log("bank here.");
    var depositMoney = $("#depositMoney").val();
    if (depositMoney == "") {
        $("#depositMoney").focus();
        $("#depositMoney_tips").addClass("redtext");
        $("#depositMoney_tips").html("请输入金额");
        return;
    }
    if (isNaN(depositMoney) || depositMoney < 100 || depositMoney > bankTradeMax) {
        $("#depositMoney").focus();
        $("#depositMoney_tips").addClass("redtext");
        $("#depositMoney_tips").html("存款每次最低100最高" + bankTradeMax + "，请输入正确的金额");
        return;
    }
    $("#depositMoney_tips").removeClass("redtext");
    $("#deposit_bt").html('<img src="/static/img/loading.gif" />');

    $.post("/API/common/DepositCash", { banktype: 3, mode: 2, amount: depositMoney, clienttype: 1 }, function (data) {
        $("#deposit_bt").html('立即存款');
        data = JSON.parse(data);
        if (data.code == 200) {
            swal({ title: "", text: "提交成功，存款申请在3-5分钟内处理完成！", type: "success" });
            return;
        }else{
            errorHandler(data);
            return;
        }
        if (typeof data.bankaccname == "undefined" || data.bankaccname.length == 0) { return; }

        $("#atm_bankname").html(data.bankname);
        $("#atm_name").html(data.bankaccname);
        $("#atm_money").html(data.depositamount);
        $("#atm_cardnumber").html(data.bankno);
        $("#atm_address").html(data.bankaddress);
        $("#atm_comments").html(data.comments);
        $("#bankIcon").addClass(data.bankcode)
        $("#setting_wybank_box").show();
        $("#deposit_from").hide();

        if ($('input[name="radiogroup2"]:checked').val() == "OTHER") {
            $("#goto_bankweb").hide();
        } else {
            $("#goto_bankweb").show();
        }
        $('#atm_name_copy').zclip({
            path: '/static/js/jquery-zclip-master/ZeroClipboard.swf',
            copy: function () {//复制内容
                return $("#atm_name").html();
            },
            afterCopy: function () {//复制成功
                swal({ title: "", text: "成功复制内容：" + $("#atm_name").html(), type: "success" });
            }
        });
        $('#atm_cardnumber_copy').zclip({
            path: '/static/js/jquery-zclip-master/ZeroClipboard.swf',
            copy: function () {//复制内容
                return $("#atm_cardnumber").html();
            },
            afterCopy: function () {//复制成功
                swal({ title: "", text: "成功复制内容：" + $("#atm_cardnumber").html(), type: "success" });
            }
        });
        $('#atm_money_copy').zclip({
            path: '/static/js/jquery-zclip-master/ZeroClipboard.swf',
            copy: function () {//复制内容
                return $("#atm_money").html();
            },
            afterCopy: function () {//复制成功
                swal({ title: "", text: "成功复制内容：" + $("#atm_money").html(), type: "success" });
            }
        });
        $('#atm_address_copy').zclip({
            path: '/static/js/jquery-zclip-master/ZeroClipboard.swf',
            copy: function () {//复制内容
                return $("#atm_address").html();
            },
            afterCopy: function () {//复制成功
                swal({ title: "", text: "成功复制内容：" + $("#atm_address").html(), type: "success" });
            }
        });
        $('#atm_comments_copy').zclip({
            path: '/static/js/jquery-zclip-master/ZeroClipboard.swf',
            copy: function () {//复制内容
                return $("#atm_comments").html();
            },
            afterCopy: function () {//复制成功
                swal({ title: "", text: "成功复制内容：" + $("#atm_comments").html(), type: "success" });
            }
        });
        bankDeposit();
    })
}
// third payment
function btnThird() {

    var amount = $("#depositMoney").val();
    var bankCode = $('input[name="radiogroup1"]:checked').val();
    var url = thirdPaymentUrl + "?SiteCode=" + thirdPaymentId;

    if (amount == "") {
        $("#depositMoney").focus();
        $("#depositMoney_tips").addClass("redtext");
        $("#depositMoney_tips").html("请输入金额");
        return;
    }
    if (isNaN(amount) || amount < 100 || amount > thirdTradeMax) {
        $("#depositMoney").focus();
        $("#depositMoney_tips").addClass("redtext");
        $("#depositMoney_tips").html("存款每次最低100最高" + thirdTradeMax + "，请输入正确的金额");
        return;
    }
    if (thirdBankList.indexOf(thirdPaymentId) < 0) {
        if (bankCode == "") {
            swal({ title: "", text: "请选择银行", type: "warning" });
            return;
        }
    }

    //ga存款
    //gaDepositGather(amount, '极速支付', bankCode);


    var url = url + "&payType=0&MemberName=" + loginMemberName + "&Amount=" + amount + "&BankCode=" + bankCode + "&client=1";
    window.open(url);
    $("#deposit_from").hide();
    Count2();
    thirdDeposit();


}

// wechat payment
function btnWechat() {
    var amount = $("#depositMoney").val();
    var url = wechatPaymentUrl + "?SiteCode=" + wechatPaymentId;

    if (amount == "") {
        $("#depositMoney").focus();
        $("#depositMoney_tips").addClass("redtext");
        $("#depositMoney_tips").html("请输入金额");
        return;
    }
    if (isNaN(amount) || amount < wechatTradeMin || amount > wechatTradeMax) {
        $("#depositMoney").focus();
        $("#depositMoney_tips").addClass("redtext");
        $("#depositMoney_tips").html("存款每次最低" + wechatTradeMin + "最高" + wechatTradeMax + "，请输入正确的金额");
        return;
    }

    amountarray = amount.split(".")

    if (amountarray[0].slice(-2) < 1) {
        var suggestamount = Number(amount) + 10;
        swal({
            title: "存款需要填写零钱",
            text: "个位和十位不能同时为0,建议您存款" + suggestamount + "元",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            cancelButtonColor: "#DD6B55",
            confirmButtonText: "好的",
            cancelButtonText: "自己输入",
            closeOnConfirm: false,
            closeOnCancel: true
        },
        function (isConfirm) {
            if (!isConfirm) {
                $("#depositMoney").val(suggestamount);
            } else {
                $("#depositMoney").focus();
            }
        });
        return;
    }

    //ga存款
    //gaDepositGather(amount, '微信', 'Wechat');

    var url = url + "&payType=0&MemberName=" + loginMemberName + "&Amount=" + amount + "&BankCode=ICBC" + "&client=1";
    window.open(url);
    $("#deposit_from").hide();
    Count2();

}

// alipay payment
function btnAlipay() {
    var amount = $("#depositMoney").val();
    var url = alipayPaymentUrl + "?SiteCode=" + alipayPaymentId;

    if (amount == "") {
        $("#depositMoney").focus();
        $("#depositMoney_tips").addClass("redtext");
        $("#depositMoney_tips").html("请输入金额");
        return;
    }
    if (isNaN(amount) || amount < alipayTradeMin || amount > alipayTradeMax) {
        $("#depositMoney").focus();
        $("#depositMoney_tips").addClass("redtext");
        $("#depositMoney_tips").html("存款每次最低" + alipayTradeMin + "最高" + alipayTradeMax + "，请输入正确的金额");
        return;
    }

    amountarray = amount.split(".")

    if (amountarray[0].slice(-2) < 1) {
        var suggestamount = Number(amount) + 10;
        swal({
            title: "存款需要填写零钱",
            text: "个位和十位不能同时为0,建议您存款" + suggestamount + "元",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            cancelButtonColor: "#DD6B55",
            confirmButtonText: "好的",
            cancelButtonText: "自己输入",
            closeOnConfirm: false,
            closeOnCancel: true
        },
        function (isConfirm) {
            if (!isConfirm) {
                $("#depositMoney").val(suggestamount);
            } else {
                $("#depositMoney").focus();
            }
        });
        return;
    }
    //ga存款
    //gaDepositGather(amount, '支付宝', 'Alipay');

    var url = url + "&payType=0&MemberName=" + loginMemberName + "&Amount=" + amount + "&BankCode=ICBC" + "&client=1";
    window.open(url);
    $("#deposit_from").hide();
    Count2();
    thirdDeposit();
}
// btnbigalipay payment
function btnbigalipay() {
    var amount = $("#depositMoney").val();
    //var url = bigalipayPaymentUrl + "?SiteCode=" + bigalipayPaymentId;

    if (amount == "") {
        $("#depositMoney").focus();
        $("#depositMoney_tips").addClass("redtext");
        $("#depositMoney_tips").html("请输入金额");
        return;
    }
    if (isNaN(amount) || amount < bigalipayTradeMin || amount > bigalipayTradeMax) {
        $("#depositMoney").focus();
        $("#depositMoney_tips").addClass("redtext");
        $("#depositMoney_tips").html("存款每次最低" + bigalipayTradeMin + "最高" + bigalipayTradeMax + "，请输入正确的金额");
        return;
    }

    $("#deposit_bt").html('<img src="/static/img/loading.gif" />');

    $.post("/Api/DepositThirdpay.ashx", { amount: amount, clienttype: 1 }, function (data) {
        $("#deposit_bt").html('立即存款');
        if (data.errcode > 0) {
            swal({ title: "", text: "存款异常，请稍后重试", type: "error" });
            return;
        }
        if (typeof data.comments == "undefined" || data.comments.length == 0) { return; }

        $('#bigalipay_money').html(amount);
        $('#bigalipay_comments').html(data.comments);
        $("#deposit_from").hide();
        $('#setting_bigalipay_box').show();
    });
}

// QQ payment
function btnQQ() {
    var amount = $("#depositMoney").val();
    var url = qqPaymentUrl + "?SiteCode=" + qqPaymentId;

    if (amount == "") {
        $("#depositMoney").focus();
        $("#depositMoney_tips").addClass("redtext");
        $("#depositMoney_tips").html("请输入金额");
        return;
    }
    if (isNaN(amount) || amount < qqTradeMin || amount > qqTradeMax) {
        $("#depositMoney").focus();
        $("#depositMoney_tips").addClass("redtext");
        $("#depositMoney_tips").html("存款每次最低" + qqTradeMin + "最高" + qqTradeMax + "，请输入正确的金额");
        return;
    }

    amountarray = amount.split(".")

    if (amountarray[0].slice(-2) < 1) {
        var suggestamount = Number(amount) + 10;
        swal({
            title: "存款需要填写零钱",
            text: "个位和十位不能同时为0,建议您存款" + suggestamount + "元",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            cancelButtonColor: "#DD6B55",
            confirmButtonText: "好的",
            cancelButtonText: "自己输入",
            closeOnConfirm: false,
            closeOnCancel: true
        },
        function (isConfirm) {
            if (!isConfirm) {
                $("#depositMoney").val(suggestamount);
            } else {
                $("#depositMoney").focus();
            }
        });
        return;
    }
    //ga存款
    //gaDepositGather(amount, 'QQ支付', 'QQ');

    var url = url + "&payType=0&MemberName=" + loginMemberName + "&Amount=" + amount + "&BankCode=ICBC" + "&client=1";
    window.open(url);
    $("#deposit_from").hide();
    Count2();
    thirdDeposit();
}