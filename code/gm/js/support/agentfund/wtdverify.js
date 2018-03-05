$(document).ready(function () {
    $("#s_search").search({
        "_fnCallback": function (resp) {
            $("#total").text(resp.iTotalRecords);
            bind_cs_remark();
        }
    });


    //初始化提款计算Func
    $("#pperc,#jj,#pfeetype,#jjnum").change(function () {
        passCalc();
    });
});


function bind_cs_remark() {
    $('label[remark=cs]').tooltip();
    $('a[csremark=csremark]').unbind('click').on('click', function () {
        var dno = $(this).attr('dno');
        $('#cs_remark_dno').val(dno);
        $('#csremark').val($('#cs_' + dno).attr('data-original-title'));
        $('#remarkModal').modal();
    });

    $('#remarkModal').find('button[save=save]').unbind('click').on('click', function () {
        $.blockUI({baseZ: 20000});
        var remark = $('#csremark').val();
        var dno = $('#cs_remark_dno').val();
        $.ajax({
            url: "/agentfund/wtdRemark",
            type: 'post',
            data: {dno: dno, remark: remark},
            dataType: 'json',
            success: function (data) {
                if (data.code == 200) {
                    $('#cs_' + dno).text(remark).attr('data-original-title', remark).tooltip();
                    $('#remarkModal').modal('hide');
                    $.notific8('备注成功！');
                } else {
                    $.notific8('备注失败！', {theme: 'ebony'});
                }
                $.unblockUI();
                $(this).next().click();
                target[1].fnReloadAjax();
            },
            error: function () {
                $.unblockUI();
            },
            cache: false
        });
    });
}


//计算提款数据
function passCalc() {
    var amount, pperc, ppercresult, jjnum, pwfee, pactual;

    amount = $("#pamount").val() == "" ? 0 : $("#pamount").val();
    pperc = $("#pperc").val() == "" ? 0 : $("#pperc").val();
    jjnum = $("#jjnum").val() == "" ? 0 : $("#jjnum").val();
    amount = new BigNumber(amount);
    pperc = new BigNumber(pperc);
    jjnum = new BigNumber(jjnum);

    ppercresult = $("#pfeetype").val() == 1 ? amount.times(pperc) : 0;
    pwfee = $("#jj").val() == 1 ? ppercresult.plus(jjnum) : 0;
    pactual = $("#pfeetype").val() == 1 ? amount.minus(pwfee) : amount;
    $("#ppercresult").val(ppercresult);
    $("#pwfee").val(pwfee);
    $("#pactual").val(pactual);
}


//设置出款弹窗
function setbankModal(dno) {
    nowdno = dno;
    // startverifytask(dno);
    $.getJSON("/agentfund/wtdInfo?dno=" + dno, function (d) {
        d = d[0];
        $("#outBankInfo").val(d['bankname'] + "-" + d['realname'] + "-" + d['cardnum']);
        $("#bmactual").val(d['actual']);
        //$("#bmwfee").val(d['wfee']);
        $("#bmwfee").val(0);
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
    console.log(bcid, wfee,dealremark,dno);
    $.ajax({
        url: "/agentfund/completewtd",
        type: 'post',
        data: {bcid: bcid, wfee: wfee, dealremark: dealremark, dno: nowdno},
        success: function (data) {
            data = JSON.parse(data);
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

//通过提款申请的前置设置
function refuseSet(dno) {
    // startverifytask(dno);
    nowdno = dno;
    $("#refusedealremark").val("");
}

//拒绝提款申请
function refuse(flag) {
    var dealremark = $("#refusedealremark").val();
    $.ajax({
        url: "/agentfund/wtdrefuse",
        type: 'post',
        data: {dno: nowdno, dealremark: dealremark},
        success: function (data) {
            data = JSON.parse(data);
            if (data.code == 200) {
                $.notific8("操作成功");
            } else {
                $.notific8(data.Message, {theme: 'ebony'});
            }
            $(flag).next().click();
            target[1].fnReloadAjax();
        },
        cache: false
    });
}


//通过提款申请的前置设置
function passSet(dno, amount, feetype, fee) {
    // startverifytask(dno);
    nowdno = dno;
    $("#pamount").val(amount);
    $("#pfeetype").val(feetype);
    $("#pwfee").val(fee);
    $("#pactual").val(amount);
    $("#pperc").empty();
    $("#pperc").append("<option value='" + 0 + "'>无</option>");
    if (fee > 0) {
        var feeTag = (fee * 100) +"%";
        $("#pperc").append("<option value='" + fee + "'> " + feeTag + "</option>");
    } else {
        $("#pperc").append("<option value='0.012'>1.2%</option>");
    }
    
    //$("#pdealremark").val(amount);
}

//通过提款申请
function pass(flag) {
    var dealremark = $("#pdealremark").val();
    var actual = $("#pactual").val();
    var wfee = $("#pwfee").val();
    var feetype = $("#pfeetype").val();
    //var bcid = $("#dealremark").val();
    $.ajax({
        url: "/agentfund/wtdpass",
        type: 'post',
        data: {dno: nowdno, actual: actual, wfee: wfee, feetype: feetype, dealremark: dealremark},
        success: function (data) {
            data = JSON.parse(data);
            if (data.code == 200) {
                $.notific8("提款申请通过成功");
            } else {
                $.notific8(data.Message, {theme: 'ebony'});
            }
            $(flag).next().click();
            target[1].fnReloadAjax();
        },
        cache: false
    });
}


function startverifytask(dno) {
//模式窗是自动弹出，这里只处理下赋值
    nowdno = dno;
    $.ajax({
        url: '/task/receive',
        type: 'post',
        data: {tid: nowdno, type: 1350},
        success: function (data) {
            if (data.success) {
            } else {
//alert(data.m);
            }
        },
        cache: false
    });
}

function endverifytask() {
    $.ajax({
        url: '/kzb/fund/withdraw/freetask',
        type: 'post',
        data: {dno: nowdno},
        success: function (data) {
            if (data.c == 0) {
            } else {
//alert(data.m);
            }
        },
        cache: false
    });
}