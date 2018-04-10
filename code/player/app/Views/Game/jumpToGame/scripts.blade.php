<script type="text/javascript" src="/static/js/jquery/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/jquery/blockui/jquery.blockUI.js"></script>
<script type="text/javascript" src="/static/js/reveal/jquery.reveal.js"></script>
<link rel="stylesheet" type="text/css" href="/static/css/base.css"/>
<link rel="stylesheet" type="text/css" href="/static/style/main.css"/>
{{-- <iframe style="visibility:hidden;" src="https://logout.kzonlinegame.com/d.php?d=ly6199.com"></iframe> --}}
<script type="text/javascript">
var gpid = '350808494186211';
var url = '/liveCasino/bbin?page_site=live';
var accid = '350808494186201';
var aid = 'i12';
var enter = function(){
    $.ajax({
        url: "/game/enterCheck?act=webet&id="+gpid,
        type: 'post',
        dataType: 'json',
        success: function (data) {
            if(data.code==0){
                var s = data.data[0];
                if(s.status==1){
                    var gp = data.data[1];
                    if(gp && gp.status==1){
                        if(gp.c==1){
                            var bal = data.data[2];
                            if(bal.c == 0 ){
                                var amount = parseInt(bal.data.val);
                                balance(amount);
                            }else{
                                gosub();
                            }
                        }else{
                            reg();
                        }
                    }else{
                        $.blockUI({message:'系统维护中，当前无法进入游戏，请关闭本窗口。'});
                    }
                }else{
                    $.blockUI({message:'系统维护中('+s.s+'-'+s.e+')，当前无法进入游戏，请关闭本窗口。'});
                }
            } else {
                $.blockUI({message:'系统维护中，当前无法进入游戏，请关闭本窗口。'});
            }
            },
            cache: false,
            error: function () {
                $.blockUI({message:'未知错误，请联系管理员！错误代码'+data.code});
            }
            });
};

var reg = function(){
    $.blockUI({message:'读取平台信息中...'});
    $.ajax({
        url:'/game/reg?gpid='+accid + "&r="+Math.random(),
        type:'post',
        dataType:'json',
        success:function(reg){
            if(reg.c == 0){
                balance();
            }else if(reg.c == 1407){
                $.blockUI({message:'系统维护中，当前无法进入游戏，请关闭本窗口。'});
            }else{
                $.blockUI({message:'请先登陆系统再访问游戏！'});
            }
        },
        cache: false,
        error: function () {
            $.blockUI({message:'请先登陆系统再访问游戏！'});
        }
    });
}

var balance = function(amount){
    if(aid=="a1"||aid=="f36"||aid=="tf"){gosub();}else{
        if(!amount){
            amount=0;
        }

        if (isNaN(amount)) {
            amount = 0;
        }
        if (amount < 10) {
            $(document.body).append(makeModal(accid, url, '游戏账户余额不足(当前：￥'+amount+')'));
            getbalance();
            $('#GameModal').reveal({
                animation: 'fade',
                animation_speed: 500,
                closeonbackgroundclick: false,
                dismissmodalclass: 'close-reveal-modal'
            });
        } else {
            $.blockUI({message:'正在进入游戏。'});
            gosub();
        }
    }
}


}
var x = function(){
    $.ajax({
        url: "/home/gs",
        data:{g:gpid},
        type: 'post',
        success: function (data) {
            if(data.indexOf("true")!=-1){
                a();
            } else {
                $.blockUI({message:'系统维护中，当前无法进入游戏，请关闭本窗口。'});
            }
        },
        cache: false,
        error: function () {
            $.blockUI({message:'未知错误，请联系管理员！'});
        }
    });
};
var a = function(){
    $.ajax({
        url: "/kz/gp/mt?id=" + gpid,
        type: 'get',
        dataType: 'json',
        success: function (data) {
            if (data.code == 0 && data.data == true) {
                b();
            } else {
                $.blockUI({message:'系统维护中，当前无法进入游戏，请关闭本窗口。'});
            }
        },
        cache: false,
        error: function () {
            $.blockUI({message:'未知错误，请联系管理员！'});
        }
    });
};
var b = function(){
    $.blockUI({message:'读取平台信息中...'});
    $.ajax({
        url:'/kz/gp/reg?gpid='+accid + "&r="+Math.random(),
        type:'post',
        dataType:'json',
        success:function(reg){
            if(reg.c == 0){

                c();
            }else if(reg.c == 1407){
                $.blockUI({message:'系统维护中，当前无法进入游戏，请关闭本窗口。'});
            }else{
                $.blockUI({message:'请先登陆系统再访问游戏！'});
            }
        },
        cache: false,
        error: function () {
            $.blockUI({message:'请先登陆系统再访问游戏！'});
        }
    });
}
var c = function(){
    $.ajax({
        url: "/kz/gp/v1/balance?currency=CNY&gpid=" + accid,
        type: 'get',
        dataType: 'json',
        success: function (_gf) {
            $.unblockUI();
            if (_gf.code == 0) {
                var amount = parseInt(_gf.data.val);
                if (isNaN(amount)) {
                    amount = 0;
                }
                if (amount < 10) {
                    $(document.body).append(makeModal(accid, url, '游戏账户余额不足(当前：￥' + amount + ')'));
                    getbalance();
                    $('#GameModal').reveal({
                        animation: 'fade',
                        animation_speed: 500,
                        closeonbackgroundclick: false,
                        dismissmodalclass: 'close-reveal-modal'
                    });
                } else {
                    $.blockUI({message:'正在进入游戏。'});
                    gosub();
                }
            } else {
                $.blockUI({message:'正在进入游戏。'});
                gosub();
            }
        },
        cache: false,
        error: function () {
            $.unblockUI();
            gosub();
        }
    });
}
function makeModal(accid, url, title) {
    var html = '<div id="GameModal" class="modal" style="width:570px; margin-left:-285px;">';
    html += '<div class="modal-hd"><a id="closeM" onclick="gosub();" class="right modal-close close-reveal-modal"></a>';
    html += '<h2 id="title">' + title + '</h2>';
    html += '</div>';
    html += '<div class="modal-content">';
    html += '<div class="user-form" style="min-height:0;">';
    html += '<ul class="mod-forms clearfix">';
    html += '<li>';
    html += '<label>主账户</label>';
    html += '<div class="txt"><span id="t_balance" class="fl" style="font-size:22px; color:#ff7800;">0.00</span><span onclick="javascript:window.open(\'/wallet/deposit\');" title="充值" class="btn-deposit">去存款</span></div>';
    html += '</li>';
    html += '<li>';
    html += '<label>转账额</label>';
    html += '<div class="item-ipt">';
    html += '<input type="text" id="t_amount" onKeypress="return (/[\\d.]/.test(String.fromCharCode(event.keyCode)))" style="ime-mode:Disabled" value="100" name="amount" class="txt-ipt" placeholder="输入金额">';
    html += '</div>';
    html += '</li>';
    html += '</ul>';
        //html += '<div class="m-l-130 f14px"><span class="cRed">检测到您游戏余额不足，您可以 </span><!-- <a href="" target="_blank" class="a-td">前往充值 &gt;&gt;</a> --></div>';
        html += '<div class="forms-btn-g" style="margin-left:130px;">';
        html += '<a href="javascript:void(0);" onclick="desp(\'' + accid + '\',\'' + url + '\');" class="btn-sub">自动转账进入游戏</a>';
        html += '<a href="javascript:void(0);" onclick="gosub();" class="btn-reset">忽略提醒进入游戏</a>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        return html;
    }
    function desp(gpid, url) {
        var t_amount = $("#t_amount").val();
        var amount = parseInt($("#t_balance").html());
        if (t_amount <= 0 || t_amount == "" || isNaN(t_amount)) {
            $("#title").html("请填写正确的转账金额");
            return false;
        }
        if (amount == 0) {
            $("#title").html("当前主账户余额为0，请先去存款。");
            return false;
        }
        if (t_amount > amount)t_amount = amount;
        $.blockUI({message:'转入中'});
        $("#GameModal").remove();
        $.ajax(
        {
            url: "/kz/gp/transaction",
            data: {
                tout: "10000",
                tin: gpid,
                amount: t_amount
            },
            type: "POST",
            success: function (_gf) {
                $.blockUI({message:'转入成功，正在进入游戏。'});
                gosub();
            },
            error: function () {
                $.blockUI({message:'转入失败，请重新进入游戏。'});
            }
        });
    }
    function getbalance() {
        $.ajax({
            url: "/kz/gp/v1/balance?currency=CNY&gpid=10000",
            type: 'get',
            dataType: 'json',
            success: function (_gf) {
                if (_gf.code == 0) {
                    var amount = parseFloat(_gf.data.val);
                    if (isNaN(amount)) {
                        amount = "-";
                    } else {
                        amount = amount.toFixed(2);
                    }
                    $("#t_balance").html(amount);
                    $("#t_amount").val(amount);
                }
            },
            cache: false,
            error: function () {
                console.log("无法正确获取余额！");
            }
        });
    }
    function gosub(){
        $("#GameModal").remove();
        if(url.indexOf("bbin")!=-1||url.indexOf("fh")!=-1){
            window.location.href=url;
        }else{
            $("input[name=url]").val(url);
            $("#goto").submit();
        }
    }

    if(aid=="a1"||aid=="f36"){
        $.ajax({
                url: "/kz/gp/onekeyri",
                data: {toid:accid},
                cache:"false",
                type:"post",
                success: function (_gf) {
                     enter();
                },
                error: function () {
                     enter();
                }
        });
    }else{
         enter();
    }



    //x();


</script>