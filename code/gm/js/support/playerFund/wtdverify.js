var nowdno = 0,
    wids = "",
    cks = 0,
    canEditGroup = 1,
    _now_uid = 0,
    nowamt = 0,
    nowwater = 0,
    nowcreated = 0,
    kindEditor1;

$(document).ready(function () {
    canEditGroup = $("#canEditGroup").val();
    $("#s_search").search({
        "_fnCallback": function (resp) {
            if ($('#cs_remark').val() == 1 || canEditGroup == undefined) {
                bind_cs_remark();
            }
            if ($('#fn_remark').val() == 1) {
                bind_fn_remark();
            }

            $("#total").text(resp.iTotalRecords);

        }
    });

    //初始化提款计算Func
    $("#pperc,#jj,#pfeetype,#jjnum").change(function () {
        passCalc();
    });

    //文本框设置
    $('#refuseModal').on('shown', function () {
        $(document).off('focusin.modal');
        kindEditor1 = KindEditor.create('textarea[name="messagecontent"]', {
            afterBlur: function () {
                this.sync();
            },
            minWidth: '500px',
            width: '538px',
            allowPreviewEmoticons: false,
            allowImageUpload: false,
            allowFlashUpload: false,
            allowMediaUpload: false,
            allowFileUpload: false,
            allowFileManager: false,
            items: [
                'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
                'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
                'insertunorderedlist', '|', 'emoticons', 'link'
            ]
        });
        changeMtype($("#defaultmsgid").val());
        KindEditor('#mtypes').change(function () {
            changeMtype(this.value);
        });
    });
    //文本框取消设置  
    $('#refuseModal').on('hidden', function () {
        KindEditor.remove('textarea[name="messagecontent"]');
    });

    //批量选项
    $("#mainCheckbox").change(function () {
        if ($("#mainCheckbox").prop("checked") == true) {
            $('input:checkbox[name=chk]').attr('checked', true);
        } else if ($("#mainCheckbox").prop("checked") == false) {
            $('input:checkbox[name=chk]').attr('checked', false);
        }
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
        $.blockUI({
            baseZ: 20000
        });
        var remark = $('#csremark').val();
        var dno = $('#cs_remark_dno').val();
        $.ajax({
            url: "/playerfund/wtdRemark",
            type: 'post',
            data: {
                dno: dno,
                remark: remark
            },
            dataType: 'json',
            success: function (data) {

                if (data.code == 200) {
                    $('#cs_' + dno).text(remark).attr('data-original-title', remark).tooltip();
                    $('#remarkModal').modal('hide');
                    $.notific8('备注成功！');
                } else {
                    $.notific8('备注失败！', {
                        theme: 'ebony'
                    });
                }
                $.unblockUI();
            },
            error: function () {
                $.unblockUI();
            },
            cache: false
        });


    });
}

//财务备注
function bind_fn_remark() {
    $('label[remark=fn]').tooltip();
    $('a[fnremark=fnremark]').unbind('click').on('click', function () {
        var dno = $(this).attr('dno');
        $('#fn_remark_dno').val(dno);
        $('#fnremark').val($('#fn_' + dno).attr('data-original-title'));
        $('#fnremarkModal').modal();
    });

    $('#fnremarkModal').find('button[save=save]').unbind('click').on('click', function () {
        $.blockUI({
            baseZ: 20000
        });
        var remark = $('#fnremark').val();
        var dno = $('#fn_remark_dno').val();
        $.ajax({
            url: "/playerfund/wtdFnRemark",
            type: 'post',
            data: {
                dno: dno,
                remark: remark
            },
            dataType: 'json',
            success: function (data) {

                if (data.success) {
                    $('#fn_' + dno).text(data.response.head).attr('data-original-title', remark).tooltip();
                    $('#fnremarkModal').modal('hide');
                    $.notific8('备注成功！');
                } else {
                    $.notific8('备注失败！', {
                        theme: 'ebony'
                    });
                }
                $.unblockUI();
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
    ppercresult = $("#pfeetype").val() == 1 ? amount.times(pperc) : new BigNumber(0);
    pwfee = $("#jj").val() == 1 ? ppercresult.plus(jjnum) : new BigNumber(0);;

    pactual = $("#pfeetype").val() == 1 ? amount.minus(pwfee) : amount;
    $("#ppercresult").val(ppercresult);
    $("#pwfee").val(pwfee);
    $("#pactual").val(pactual);
}

function cancelWtdBankInfo() {
    $("#outBankInfo").val('');
    $("#bmactual").val('');
}
//设置出款弹窗
function setbankModal(dno) {
    nowdno = dno;
    $.getJSON("/playerfund/wtdInfo?dno=" + dno, function (d) {

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
        $.notific8("请填写备注！", {
            theme: 'ebony'
        });
        return;
    }
    // console.log($("#bmbcid").find("option:selected").attr("balance"));
    // var balance = new BigNumber($("#bmbcid").find("option:selected").attr("balance"));
    // console.log($("#bmactual").val());
    // var bmactual = new BigNumber($("#bmactual").val());
    // console.log(wfee);
    // bmactual = bmactual.plus(new BigNumber(wfee));
    console.log($("#bmbcid").find("option:selected").attr("balance"));
    var balance = $("#bmbcid").find("option:selected").attr("balance");
    console.log($("#bmactual").val());
    var bmactual = $("#bmactual").val();
    console.log(wfee);
    bmactual = bmactual + wfee;
    // if (balance.lessThan(bmactual)) {
    if (balance < bmactual) {
        $.notific8("银行卡余额不足", {
            theme: 'ebony'
        });
        return;
    }

    $.ajax({
        url: "/playerfund/wtdComplete",
        type: 'post',
        data: {
            bcid: bcid,
            wfee: bmactual,
            dealremark: dealremark,
            dno: nowdno
        },
        success: function (data) {
            data = JSON.parse(data);
            if (data.c == 0) {
                $.notific8("提交出款信息成功");
            } else {
                $.notific8(errorMsg(data), {
                    theme: 'ebony'
                });
            }
            $(flag).next().click();
            target[1].fnReloadAjax();
        },
        cache: false
    });
}

//提交流水检查结果
function submitCheckResult(flag) {
    //cks:0-待检查，1-通过，2-未通过
    var submit = true;
    if (cks == 2) submit = confirm("确认要提交检查结果吗?流水检查结果一旦提交后将无法重新检查，若需要调整流水条件，请先关闭窗后玩家调整流水条件后，再重新检查流水。");

    if (submit) {
        $.ajax({
            url: "/playerfund/ckflows",
            type: 'post',
            data: {
                cks: cks,
                wids: wids,
                dno: nowdno
            },
            success: function (data) {
                data = JSON.parse(data);
                if (data.c == 0) {
                    $.notific8("提交流水检查结果成功");
                } else {
                    $.notific8("检查错误", {
                        theme: 'ebony'
                    });
                }
                $(flag).next().click();
                target[1].fnReloadAjax();
            },
            cache: false
        });
    } else {
        $(flag).next().click();
    }
}

//信息标题筛选
function changeMtype(mid) {
    $("#messagetitle").val("");
    $("#messagecontent").val("");
    kindEditor1.html("");


    $.ajax({
        url: "/playerfund/wtdGetMessageTemp",
        type: 'post',
        dataType: 'json',
        data: {
            mid: mid,
            amt: nowamt,
            water: nowwater,
            created: nowcreated
        },
        success: function (data) {
            var msgContent = data.response.content;
            kindEditor1.html(msgContent);
            $("#messagetitle").val(data.response.title);
        }
    });
}

//通过提款申请的前置设置
function refuseSet(dno, amt, water, created) {
    startverifytask(dno);
    nowdno = dno;
    nowamt = amt;
    nowwater = water;
    nowcreated = created;
    $("#refusedealremark").val("客服拒绝");
    if (canEditGroup == 1) {
        $('#mtypes option[value="' + $('#defaultmsgid').val() + '"]').attr('selected', 'selected');
    }
}
//拒绝提款申请
function refuse(flag) {

    var dealremark = $("#refusedealremark").val();

    if (dealremark == "") {
        $.notific8("请填写备注！", {
            theme: 'ebony'
        });
        return;
    }
    if (canEditGroup == 1) {
        $("#messagecontent").val(kindEditor1.text());
        var msg = '';
        var msgtitle = '';
        if ($("#messagecontent").val() == "" || $("#messagetitle").val() == "") {
            $.notific8("请完善消息标题和内容！", {
                theme: 'ebony'
            });
            return false;
        }
        msg = $("#messagecontent").val();
        msgtitle = $("#messagetitle").val();
        $.ajax({
            url: "/playerfund/withdrawRefuse",
            type: 'post',
            data: {
                dno: nowdno,
                dealremark: dealremark,
                msgtitle: msgtitle,
                msg: msg
            },
            success: function (data) {
                data = JSON.parse(data);
                if (data.c == 0) {
                    $.notific8("拒绝提款申请成功");
                } else {
                    $.notific8(errorMsg(data), {
                        theme: 'ebony'
                    });
                }
                $(flag).next().click();
                target[1].fnReloadAjax();
                // window.location.reload();
            },
            cache: false
        });
    } else {
        $.ajax({
            url: "/playerfund/withdrawRefuse",
            type: 'post',
            data: {
                dno: nowdno,
                dealremark: dealremark
            },
            success: function (data) {
                data = JSON.parse(data);
                if (data.c == 0) {
                    $.notific8("拒绝提款申请成功");
                    target[1].fnReloadAjax();
                } else {
                    $.notific8(errorMsg(data), {
                        theme: 'ebony'
                    });
                }
                $(flag).next().click();
                target[1].fnReloadAjax();
                // window.location.reload();
            },
            cache: false
        });
    }
}

//通过提款申请的前置设置
function passSet(dno, amount, a, b, c, uid) {
    $("#passinfo").html('');
    $("#passinfo").html('真实姓名：' + a + ' 银行：' + b + ' 卡号：' + c);

    $.ajax({
        url: "/playerfund/wtdTimes",
        type: 'post',
        data: {
            uid: uid,
            dno: dno
        },
        success: function (data) {
            $("#passinfo").append(' 今日取款次数：' + data.times);
            var dtpVal = parseFloat(data.dtpVal);
            var rate = parseInt(data.rate);
            var amount = parseFloat($('#pamount').val());
            var alertInfo = '';

            if (amount > dtpVal * rate) {
                alertInfo += '警告： 当前玩家取款申请额度，达到了新存款额度的' + rate + '倍（存：' + dtpVal + '），请注意检查！';
            }
            if (data.validName != '') {
                alertInfo += '<br/>' + data.validName;
            }
            $('#alertInfo').html(alertInfo);

        },
        cache: false
    });


    startverifytask(dno);
    nowdno = dno;
    $("#pamount").val(amount);
    $("#pfeetype").val(2);
    $("#pwfee").val(0);
    $("#pactual").val(amount);
    $("#pdealremark").val('客服通过');
}

//通过提款申请
function pass(flag) {
    var dealremark = $("#pdealremark").val();

    if (dealremark == "") {
        $.notific8("请填写备注！", {
            theme: 'ebony'
        });
        return;
    }


    var actual = $("#pactual").val();
    var wfee = $("#pwfee").val();
    var feetype = $("#pfeetype").val();
    //var bcid = $("#dealremark").val();
    $.ajax({
        url: "/playerfund/withdrawPass",
        type: 'post',
        data: {
            dno: nowdno,
            actual: actual,
            wfee: wfee,
            feetype: feetype,
            dealremark: dealremark
        },
        success: function (data) {
            data = JSON.parse(data);
            if (data.c == 0) {
                returnDistribute(nowdno);
                $.notific8("通过提款申请成功");
            } else {
                $.notific8(data.m, {
                    theme: 'ebony'
                });
            }
            $(flag).next().click();
            target[1].fnReloadAjax();
        },
        cache: false
    });
}

function showVerifybutton(isShow) {
    if (isShow == 1) {

        $("#WCheckVerify").show();
        $("#WCheckNoVerify").hide();
        $("#WCheckCancel").show();
        $("#WCheckNoCancel").hide();
        $("#submitCheckResult").show();

        $("#checkVerify").show();
        $("#noVerify").hide();
        $("#checkVerifyCancel").show();
        $("#noVerifyCancel").hide();
    } else {
        $("#WCheckVerify").css("display", "none");
        $("#WCheckNoVerify").css("display", "block");
        $("#WCheckCancel").hide();
        $("#WCheckNoCancel").show();
        $("#submitCheckResult").hide();
        $("#checkVerify").hide();
        $("#noVerify").show();
        $("#checkVerifyCancel").hide();
        $("#noVerifyCancel").show();
    }
}
var _a = new Array();
var checkdata;
var needPT = false;
var uid = 0;
var nowdno = 0;
//获取流水条件清单
function getWList(dno, id, isShow) {
    $("#waterDetialTable").hide();
    uid = id;
    _now_uid = id;
    nowdno = dno;
    checkdata = null;
    _a = new Array();
    nowdno = dno;
    if (isShow == 1) {
        startverifytask(dno);
    }
    showVerifybutton(isShow);
    $.ajax({
        url: "/playerfund/flowLimitOne?id=" + id,
        type: 'get',
        dataType: 'json',
        cache: false,
        success: function (data) {
            checkdata = data;
            checkdata.id = id;

            var html = "";
            console.log(1111);
            _a["gpidMAIN"] = new BigNumber(0);
            for (var x = 0; x < checkdata.data.length; x++) {
                var d = checkdata.data[x];
                console.log(d);
                var checkarr = ["MAIN", "IBC", "NB"];
                var gpid = (d['gpid'] == 0 || d['gpid'] == null) ? "MAIN" : d['gpid'];
                if ($.inArray(parseInt(gpid), checkarr) != -1) {
                    needPT = true;
                }
                gpid = gpid.toString();
                // console.debug(d);
                var amount = d['amount'] == null ? 0 : d['amount'];
                amount = new BigNumber(parseFloat(amount).toFixed(4));

                //初始化数组
                if (_a["gpid" + gpid]) {
                    var temp = new BigNumber(_a["gpid" + gpid]);
                    _a["gpid" + gpid] = temp.plus(amount);
                } else {
                    _a["gpid" + gpid] = amount;
                }
                if (gpid != "MAIN") {
                    var temp = new BigNumber(_a["gpidMAIN"]);
                    _a["gpidMAIN"] = temp.plus(amount);
                }

                var gpname = d['gpname'] == null ? "不限平台" : d['gpname'];
                var agentname = d['agentname'] == null ? "-" : d['agentname'];
                var actname = d['actname'] == null ? "-" : d['actname'];

                html += "<tr>";
                html += "<td>" + d['wid'] + "</td>";
                html += "<td>" + d['createdtoString'] + "</td>";
                html += "<td>" + d['btype'] + "</td>";
                html += "<td>" + d['ptype'] + "</td>";
                html += "<td>" + gpname + "</td>";
                html += "<td>" + actname + "</td>";
                html += "<td>" + amount + "</td>";
                html += "<td>" + d['leftAmount'] + "</td>";

                var endtime = '0';
                if (checkdata.data[x + 1]) {
                    endtime = checkdata.data[x + 1]['created'];
                }
                var flows = d["flows"];
                var flowsStr = "无数据";
                
                var flowArr = [];
                for (var _gp in flows){
                    console.log(_gp);
                    var _flow = flows[_gp];
                    flowArr.push("[" + _gp + "] : " + _flow["amount"] + " 剩" + _flow["leftAmount"]);
                }
                if (flowArr.length > 0) {
                    flowsStr = flowArr.join("<br>");
                }
                
                
                html += "<td index='" + x + "' wid='" + d['wid'] + "' ";
                html += "gpid='" + gpid + "' gpname='" + gpname + "' amount='" + amount + "'";
                html += " >" + flowsStr +"</td>";

                html += "<td>" + d['nowbalance'] + "</td>";

                var statusStr = "<td style='color:green'>已完成</td>";
                if (d['leftAmount'] > 0) {
                    statusStr = "<td style='color:red'>未完成</td>";
                }
                html += statusStr;
                html += "<td><a onclick='custom_endWater(" + d['wid'] + ",99);'>清除</a></td></tr>";
            }

            var limit = "";
            $("#wtable").find("tbody").html(html);
            cks = 0;
            wids = "";

            if (checkdata.data.length == 0) {
                cks = 1;
                reWList(dno, id);
                $.unblockUI();
            } else {
                // if (haspt == "true" && needPT == true) {
                //     $("#limit").html('<button class="btn btn-primary blue" onclick="getstatus();">如果PT流水不足导致检查，请点此刷新PT流水获取状态</button>');
                // }
                // setTimeout(function () {
                //     checkLimit(id);
                // }, 1000);
            }
        },
        error: function () {
            alert('流水条件获取失败，请重新获取');
        }
    });
}

function reWList(dno, id) {


    $.ajax({
        url: "/playerfund/flowLimitOne?id=" + id,
        type: 'get',
        dataType: 'json',
        cache: false,
        success: function (data) {
            if (data.length == 0) {
                $.notific8("当前用户没有流水条件");
                $("#submitCheckResult").click();
            } else {
                alert("流水条件获取错误，重新获取");
            }
        },
        error: function () {
            alert('流水条件获取失败，请重新获取');
        }
    });
}

var otd = null;

function checkLimit(id, type) {

    if (!$('#WCheck').is(':visible')) {
        console.log('取消弹窗，退出检查');
        return false;
    }

    //若已获取完毕则结束
    if ($("#wtable").find("tbody").find("td[needchecked=false]").length == 0) {
        checkwaternew();
        return false;
    }

    //初始化当前信息
    var pass = true;
    otd = $("#wtable").find("tbody").find("td[needchecked=false]:first");
    otd.attr("needchecked", "true");
    var stime = otd.attr("created");
    var etime = otd.attr("endtime");
    var uurl = etime == 0 ? "/playerfund/checkFlows?uid=" + id + "&stime=" + stime : "/playerfund/checkFlows?uid=" + id + "&stime=" + stime + "&etime=" + etime + "&r=" + Math.random();
    _b = new Array();
    _b["gpidMAIN"] = new BigNumber(0);

    $.getJSON(uurl, function (data) {
        if (data.ok == 1) {
            data = data.data;
            if (typeof (data[0]) == "undefined") {
                otd.find("a").html("<font color='red'>无数据</font>");
            } else {
                otd.find("a").html('');
                for (var i in data) {
                    var d = data[i];
                    var gpid = d.gpid;
                    if (!_b["gpid" + gpid]) _b["gpid" + gpid] = 0;
                    var gpname = d.gpname;
                    var out = "";
                    var total = new BigNumber(0);

                    if (d.water.length != 0) {
                        $.each(d.water, function (ii, dd) {
                            var amount = new BigNumber(parseFloat(dd.betamt).toFixed(4));
                            total = total.plus(amount);
                        });
                    }
                    total = total.toString();
                    if (total != 0) {
                        otd.find("a").append('<div gpidamount=' + gpid + '>' + gpname + '完成:' + total + ' 剩：<font>' + total + '</font></div>');
                    }
                }
                if (otd.find("a").html() == '') {
                    otd.find("a").html("<font color='red'>无数据</font>");
                }

            }
        } else {
            if (data.ok == 0) {
                if (typeof (data[0]) == "undefined") {
                    otd.find("a").html("<font color='red'>无数据</font>");
                }
            }
            // $.notific8("流水检查失败！数据未获取成功！");
            // return false;
        }
        if (otd.find("a").html() == "待检查") {
            otd.find("a").html('无数据');
        }
        checkLimit(id);
    });

}


//开始检查流水
function checkwaternew() {
    // var totalneed = new BigNumber(0);
    // $("#wtable").find("td[gpid]").each(function(){
    //       totalneed = totalneed.plus(new BigNumber($(this).attr('amount')));
    //    });
    // var calcneed = ""
    // $.each(a, function (i, v) {
    //     if (_a["gpid" + v]) {
    //         calcneed += v + ":" + _a["gpid" + v] + ",";
    //     }
    // });
    // alert('共需要流水:'+totalneed.toString()+',其中'+calcneed);
    checkwaternewdetail();
}


//首轮检查 专门检查非MAIN的情况
function checkwaternewdetail() {
    //若已获取完毕则结束
    if ($("#wtable").find("tbody").find("td[needchecked=true]").length == 0) {
        checkwaternewMAIN();
        return false;
    }

    otd = $("#wtable").find("tbody").find("td[needchecked=true]:first");
    otd.attr('needchecked', 'other');

    otd.find('div[gpidamount]').each(function () {
        gpid = $(this).attr('gpidamount');
        amount = parseFloat($(this).find("font").text());
        var ff = $(this).find("font");
        var index = otd.parent().index() + 1;
        if (gpid != "MAIN") {
            $("#wtable").find("tbody").find("tr:lt(" + index + ")").find("td[gpid=" + gpid + "]").each(function () {
                var a = parseFloat($(this).attr('amount')).toFixed(4);
                if (amount > 0 && a > 0) {
                    if (a > amount) {
                        a = a - amount;
                        amount = 0;
                    } else {
                        amount = amount - a;
                        a = 0;
                    }
                    $(this).attr('amount', a);
                    ff.text(amount);
                }
            });
        }
    });


    checkwaternewdetail();
}

function checkwaternewMAIN() {
    //若已获取完毕则结束
    if ($("#wtable").find("tbody").find("td[needchecked=other]").length == 0) {

        _a = new Array();
        var ntotal = 0;
        $("#wtable").find("tbody").find("tr").each(function () {
            wids = wids == "" ? $(this).find("td:last").attr("wid") : wids + "," + $(this).find("td:last").attr("wid");
            var amount = parseFloat($(this).find("td:last").attr("amount"));
            ntotal += amount;
            var gpname = $(this).find("td:last").attr("gpname");
            var gpid = $(this).find("td:last").attr("gpid");
            $(this).find('td:eq(6)').html(amount.toFixed(2));
            if (amount == 0) {
                $(this).find("td:last").prev().html('已完成').css('color', 'green');
            } else {
                $(this).find("td:last").prev().html('未完成').css('color', 'red');
            }
            if (amount > 0) {
                if (_a['g' + gpid]) {
                    var temp = new BigNumber(parseFloat(_a['g' + gpid]).toFixed(4));
                    _a['g' + gpid] = temp.plus(amount);
                } else {
                    _a['g' + gpid] = amount;
                }
            }
        });

        var calcneed = ""
        $.each(a, function (i, v) {
            if (_a["g" + v]) {
                calcneed += (b[i] == "主账户" ? "不限平台" : b[i]) + ":" + _a["g" + v] + ",";
            }
        });

        ntotal = ntotal.toFixed(2);
        var msg = '';
        if (ntotal == 0) {
            msg = '<h3 style="color:green;">流水检查通过</h3>';
            $.notific8('流水检查通过');
            $.unblockUI();
            cks = 1;
        } else {
            msg = '<h3 style="color:red;">该用户还需要流水:' + ntotal.toString() + ',其中' + calcneed + "</h3>";
            $.notific8('该用户还需要流水:' + ntotal.toString() + ',其中' + calcneed);
            $.unblockUI();
            cks = 2;
        }
        $("#waterDetialTable").html(msg).fadeIn();


        return false;
    }
    otd = $("#wtable").find("tbody").find("td[needchecked=other]:first");
    otd.attr('needchecked', 'true');

    otd.find('div[gpidamount]').each(function () {
        $(this).css('color', 'green');
        gpid = $(this).attr('gpidamount');
        amount = parseFloat($(this).find("font").text()).toFixed(4);
        var ff = $(this).find("font");
        var index = otd.parent().index() + 1;
        $("#wtable").find("tbody").find("tr:lt(" + index + ")").find("td[gpid=MAIN]").each(function () {
            var a = parseFloat($(this).attr('amount')).toFixed(4);
            if (amount > 0 && a > 0) {
                if (a > amount) {
                    a = a - amount;
                    amount = 0;
                } else {
                    amount = amount - a;
                    a = 0;
                }
                $(this).attr('amount', a);
                ff.text(amount);
            }
        });
    });
    checkwaternewMAIN();
}


function getptwater() {
    $.ajax({
        url: '/kzb/water/pt/member/' + uid + "?r=" + Math.random(),
        type: 'post',
        dataType: 'json',
        success: function (data) {
            //console.log(data);
            if (data.ok == 1) {
                //{ok:1, data: '1-进行中，5-玩家未参与PT平台，6-玩家不存在，0-提交成功'}

                if (data.data == 5) {
                    $("#limit").html('<button class="btn btn-primary green" onclick="getptwater();">获取该玩家PT流水</button><br>该用户还未获取过流水，或者还未创建PT账户');

                }
                if (data.data == 6) {
                    $("#limit").html('玩家不存在');

                }
                if (data.data == 0 || data.data == 1) {
                    $("#limit").html("提交成功");
                    //clearInterval(timer);
                    getstatus();
                }


            } else {
                $.notific8("流水获取提交失败");
            }
        },
        cache: false
    });
}

var timer = null;

function getstatus() {
    $("#limit").html("PT流水状态获取中");
    $.ajax({
        url: '/kzb/water/pt/member/status/' + uid,
        type: 'get',
        dataType: 'json',
        success: function (statusdt) {
            //{"ok":1,"statusdt":{"playerid":"277525237647100","status":1,"create":"2015-08-04 16:21:08","waterdate":"1970-01-01 08:00:00"}}
            if (statusdt.ok == 1) {
                if (statusdt.data != null) {
                    var status = "<font color=blue>进行中</font>";
                    if (statusdt.data.status == 2) {
                        status = "<font color=green>已完成</font>";
                        //clearInterval(timer);
                    }
                    var waterdate = statusdt.data.waterdate == "1970-01-01 08:00:00" ? "未获取" : statusdt.data.waterdate;

                    if (statusdt.data.status == 2) {
                        $("#limit").html('<button class="btn btn-primary grey-steel">刷新PT流水获取状态</button>,<button class="btn btn-primary green" onclick="getptwater();">获取该玩家PT流水</button>,<button class="btn btn-primary blue" onclick="getWList(nowdno, uid);">重新检查流水完成情况</button><br>上次获取状态：' + status + ' 上次申请更新时间<font color=red>' + statusdt.data.create + '</font> - PT流水最后更新时间 - <font color=red>' + waterdate + '</font>');

                    } else {
                        $("#limit").html('<button class="btn btn-primary blue" onclick="getstatus();">刷新PT流水获取状态</button>,<button class="btn btn-primary grey-steel">获取该玩家PT流水</button>,<button class="btn btn-primary grey-steel">重新检查流水完成情况</button><br>上次获取状态：' + status + ' 上次申请更新时间<font color=red>' + statusdt.data.create + '</font> - PT流水最后更新时间 - <font color=red>' + waterdate + '</font>');

                    }
                } else {
                    // $("#limit").html('<button class="btn btn-primary green" onclick="getptwater();">开始更新该用户PT流水</button><br>该用户还未获取过流水，或者还未创建PT账户');
                    getptwater();
                }
            } else {
                $("#limit").html('<button class="btn btn-primary grey-steel">刷新PT流水获取状态</button>,<button class="btn btn-primary green" onclick="getptwater();">获取该玩家PT流水</button><br>流水状态获取失败');
                //clearInterval(timer);
            }
        },
        cache: false
    });
}


function checkwater(o) {
    otd = $(o).parent();

    $("#WCheckDetial").find("div[name=check]").find("tbody").html('<tr><td colspan="3">无流水限制</td></tr>');
    $("#WCheckDetial").find("div[name=water]").find("tbody").html('<tr><td colspan="3">无投注流水</td></tr>');
    var html = "";
    var dhtml = "";
    for (var x = 0; x < parseInt(otd.attr("index")) + 1; x++) {
        var d = checkdata[x];
        var gpname = d['gpname'] == null ? "不限平台" : d['gpname'];
        var gpid = (d['gpid'] == null || d['gpid'] == 0) ? "MAIN" : d['gpid'];

        html += "<tr gpid='" + gpid + "' betamt='" + d['amount'] + "'>";
        html += "<td>" + gpname + "</td>";
        html += "<td>" + d['amount'] + "</td>";
        html += '<td><i gpid="' + gpid + '" class="fa fa-exclamation"></i></td>';
        html += "</tr>";
    }

    if (html != "") $("#WCheckDetial").find("div[name=check]").find("tbody").html(html);

    var thisid = checkdata.id;
    var thistime = checkdata[otd.attr("index")]['created'];

    $.get("/kzb/water/player/" + thisid + "/" + thistime, function (data) {
        //data = {"ok":1,"data":{"0":{"gpid":"38712217599873024","rtype":1,"gpname":"AG真人","water":[]},"1":{"gpid":"11964220589608960","rtype":1,"gpname":"MG电子游戏","water":[{"playerid":"286143374395136","betamt":"25.0000"}]},"2":{"gpid":"5707231341449216","rtype":1,"gpname":"Libianc快乐彩","water":[]},"3":{"gpid":"3277767810617344","rtype":1,"gpname":"GD真人","water":[{"playerid":"286143374395136","productid":"Baccarat","betamt":"100.00"}]},"4":{"gpid":"39500154618880","rtype":1,"gpname":"188真人","water":[]}}};

        if (data.ok == 1) {
            data = data.data;
            $.each(data, function (i, d) {
                $.each(d.water, function (ii, dd) {

                    dhtml += "<tr gpid='" + d.gpid + "' betamt='" + dd.betamt + "'>";
                    dhtml += "<td>" + d.gpname + "</td>";
                    dhtml += "<td>" + dd.betamt + "</td>";
                    dhtml += '<td><i class="fa fa-question"></i></td>';
                    dhtml += "</tr>";

                });
            });
            if (dhtml != "") $("#WCheckDetial").find("div[name=water]").find("tbody").html(dhtml);
            checkwaterDetial();
        } else {

            if (data.ok == 0) {
                if (typeof (data[0]) == "undefined") {
                    $("#WCheckDetial").find("div[name=water]").html("用户没有流水信息");
                } else {
                    $("#WCheckDetial").find("div[name=water]").html("没有数据，请重新检查。");
                }
            } else {
                $("#WCheckDetial").find("div[name=water]").html("没有数据，请重新检查。");
            }
        }
    });
}


function showWaterDetial() {
    otd = $("#wtable").find("tr:last").find("td:last");
    $("#waterDetialTable").find("div[name=water],div[name=check]").find("tbody").html('');
    var html = "";
    var dhtml = "";
    var arr = [];
    for (var x = 0; x < parseInt(otd.attr("index")) + 1; x++) {
        var d = checkdata[x];
        var gpname = d['gpname'] == null ? "不限平台" : d['gpname'];
        var gpid = (d['gpid'] == null || d['gpid'] == 0) ? "MAIN" : d['gpid'];
        if (!arr[gpid]) {
            arr[gpid] = [];
            arr[gpid]['name'] = gpname;
            arr[gpid]['gpid'] = gpid;
            arr[gpid]['amount'] = d['amount'];
        } else {
            arr[gpid]['amount'] = parseFloat(arr[gpid]['amount']) + parseFloat(d['amount']);
        }
        arr[gpid]['amount'] = parseFloat(arr[gpid]['amount']).toFixed(4);
    }

    for (var index in arr) {
        var t = arr[index];
        html += "<tr>";
        html += "<td>" + t['name'] + "</td>";
        html += "<td>" + t['amount'] + "</td>";
        html += "<td style='color:red;' gpid='" + t['gpid'] + "'>" + t['amount'] + "</td>";
        html += "</tr>";
    }


    $("#waterDetialTable").find("div[name=check]").find("tbody").append(html);

    var thisid = checkdata.id;
    var thistime = checkdata[otd.attr("index")]['created'];

    $.get("/kzb/water/player/" + thisid + "/" + thistime, function (data) {
        //data = {"ok":1,"data":{"0":{"gpid":"38712217599873024","rtype":1,"gpname":"AG真人","water":[]},"1":{"gpid":"11964220589608960","rtype":1,"gpname":"MG电子游戏","water":[{"playerid":"286143374395136","betamt":"25.0000"}]},"2":{"gpid":"5707231341449216","rtype":1,"gpname":"Libianc快乐彩","water":[]},"3":{"gpid":"3277767810617344","rtype":1,"gpname":"GD真人","water":[{"playerid":"286143374395136","productid":"Baccarat","betamt":"100.00"}]},"4":{"gpid":"39500154618880","rtype":1,"gpname":"188真人","water":[]}}};
        var brr = [];
        if (data.ok == 1) {
            data = data.data;
            $.each(data, function (i, d) {
                $.each(d.water, function (ii, dd) {


                    if (!brr[d.gpid]) {
                        brr[d.gpid] = [];
                        brr[d.gpid]['name'] = d.gpname;
                        brr[d.gpid]['gpid'] = d.gpid;
                        brr[d.gpid]['amount'] = dd.betamt;
                    } else {
                        brr[d.gpid]['amount'] = parseFloat(brr[d.gpid]['amount']) + parseFloat(dd.betamt);
                    }
                    brr[d.gpid]['amount'] = parseFloat(brr[d.gpid]['amount']).toFixed(4);
                });
            });

            for (var index in brr) {
                var t = brr[index];
                dhtml += "<tr>";
                dhtml += "<td>" + t['name'] + "</td>";
                dhtml += "<td>" + t['amount'] + "</td>";
                dhtml += "<td gpid='" + t['gpid'] + "'>" + t['amount'] + "</td>";
                dhtml += "</tr>";
            }

            $("#waterDetialTable").find("div[name=water]").find("tbody").append(dhtml);
            $("#waterDetialTable").show();

            var ckt = $("#waterDetialTable").find("div[name=check]");
            $("#waterDetialTable").find("div[name=water]").find("td[gpid]").each(function () {
                var tempo = $(this);
                var gpid = tempo.attr("gpid");
                var amt = parseFloat(tempo.html());

                if (ckt.find("td[gpid=" + gpid + "]").length > 0) {
                    var tempc = ckt.find("td[gpid=" + gpid + "]");
                    var jamt = parseFloat(tempc.html());
                    if (amt > jamt) {
                        amt = amt - jamt;
                        jamt = 0;
                        tempo.html(amt.toFixed(4));
                        tempc.html("总量已满足");
                        tempc.css("color", "green");
                    } else {
                        jamt = jamt - amt;
                        amt = 0;
                        tempc.html(jamt.toFixed(4));
                        tempo.html("0");
                        tempo.css("color", "red");
                    }
                }

                if (ckt.find("td[gpid=MAIN]").length > 0 && tempo.html() != "0") {
                    tempc = ckt.find("td[gpid=MAIN]");
                    if (tempc.html() != "总量已满足") {
                        jamt = parseFloat(tempc.html());
                        if (amt > jamt) {
                            amt = amt - jamt;
                            jamt = 0;
                            tempo.html(amt.toFixed(4));
                            tempc.html("总量已满足");
                            tempc.css("color", "green");
                        } else {
                            jamt = jamt - amt;
                            amt = 0;
                            tempc.html(jamt.toFixed(4));
                            tempo.html("0");
                            tempo.css("color", "red");
                        }
                    }
                }

            });


            // checkwaterDetial();
        } else {

            if (data.ok == 0) {
                if (typeof (data[0]) == "undefined") {
                    $.notific8("用户没有流水信息");
                } else {
                    $.notific8("没有数据，请重新检查。");
                }
            } else {
                $.notific8("没有数据，请重新检查。");
            }


        }
    });
}


function checkwaterDetial() {

    //while($("#WCheckDetial").find("div[name=check]").find("i.fa-exclamation").length>0||$("#WCheckDetial").find("div[name=water]").find("i.fa-question").length>0){
    doCheck();
    doCheck();
    doCheck();
    doCheck();
    doCheck();
    //}


    var alive = $("#WCheckDetial").find("div[name=check]").find("i.fa-exclamation");
    if (alive.length > 0) {
        alive.addClass("font-red");
    } else {
        $("#WCheckDetial").find("div[name=water]").find("i.fa-question").removeClass("fa-question").addClass("fa-check").addClass("font-green");
    }

}

function doCheck() {
    var trsa = $("#WCheckDetial").find("div[name=check]").find("tbody");
    var trsb = $("#WCheckDetial").find("div[name=water]").find("tbody").find("tr");

    trsb.each(function () {
        var tr = $(this);
        if (tr.find('td:first').attr('colspan') != "3") {
            var check_gpid = tr.attr("gpid");
            var check_betamt = tr.attr("betamt");
            var dick = trsa.find("tr[gpid='" + check_gpid + "'][betamt!='0']:first");
            if (dick.length == 0) {
                //dick = trsa.find("tr[gpid='MAIN'][check_betamt!='0']:first");
                dick = $("#WCheckDetial").find("div[name=check]").find("i.fa-exclamation[gpid='MAIN']:first").parent().parent();
            }

            var a = parseFloat(dick.attr("betamt"));
            var b = parseFloat(tr.attr("betamt"));

            if (a >= b) {
                tr.attr("betamt", 0);
                dick.attr("betamt", a - b);
                tr.find("td:last").html('<i class="fa fa-check font-green"></i>');
            } else {
                tr.attr("betamt", b - a);
                dick.attr("betamt", 0);
                dick.find("td:last").html('<i class="fa fa-check font-green"></i>');
            }
        }
    });

}


function startverifytask(dno) {
    //模式窗是自动弹出，这里只处理下赋值
    nowdno = dno;
    $.ajax({
        url: '/playerfund/receive',
        type: 'post',
        data: {
            tid: nowdno,
            type: 1310
        },
        success: function (data) {
            // data = JSON.parse(data);
            // // if (data.success) {
            // // } else {
            // // //alert(data.m);
            // // }
        },
        cache: false
    });
}

function istartverifytask(dno) {
    if (confirm("当前任务他人审核中,若您领走，其他人当前审核状态将被中断")) {
        nowdno = dno;
        $.ajax({
            url: '/task/receive',
            type: 'post',
            data: {
                tid: nowdno,
                type: 1310
            },
            success: function (data) {
                if (data.success) {
                    target[1].fnReloadAjax();
                } else {
                    $.notific8(data.m);
                }
            },
            cache: false
        });
    }
}

function endverifytask() {
    $.ajax({
        url: '/task/receive',
        type: 'post',
        data: {
            tid: nowdno,
            type: 1310
        },
        success: function (data) {
            if (data.success) {} else {
                //alert(data.m);
            }
        },
        cache: false
    });
}


//通过某条流水条件 或者重启某条流水条件
function custom_endWater(wid, status) {
    if (confirm("确定要清除本条流水条件？若需重启，需要到流水限制汇总操作。")) {
        $.ajax({
            url: "/playerfund/changeflows",
            type: 'post',
            data: {
                wid: wid,
                status: status,
                uid: _now_uid
            },
            success: function (data) {
                data = JSON.parse(data);
                if (data.c == 0) {
                    $.notific8("操作成功");
                } else {
                    $.notific8(errorMsg(data), {
                        theme: 'ebony'
                    });
                }
                getWList(nowdno, uid);
            },
            cache: false
        });
    }
}

//所有按钮
function searchAll() {
    //window.location.reload();
    $dstatus = 1;

    $.ajax({
        url: "/playerfund/wtdVerifyAjax",
        type: 'post',
        data: {
            status: $dstatus
        },
        success: function (data) {
            if (data.c == 0) {
                //$.notific8("操作成功");
            } else {
                //$.notific8(errorMsg(data), {theme: 'ebony'});
            }
            //getWList(nowdno, uid);
        },
        cache: false
    });
}

//批量流水检查
function progressCheckResult() {
    var totalSelected = $("input:checkbox[name=chk]:checked").length;
    console.log(totalSelected);
    if (totalSelected > 0) {
        var index = 0;
        var percentage = 0;
        var o = $("#proc").find(".progress-bar");
        $("#proc").show();
        $("#proc").find(".progress").show();

        $("input:checkbox[name=chk]:checked").each(function () {
            var id = $(this).attr("uid");
            var dno = $(this).attr("dno");
            startverifytask(dno);
            //nowdno = dno;
            $("#watercheckresult_").html("");
            $("#watercheckresult_" + dno).css("color", "");
            $("#watercheckresult_" + dno).text('流水检查中...');
            console.log("id" + " " + id + " dno: " + dno);
            $.ajax({
                url: "/playerfund/flowLimitOne?id=" + id,
                type: 'get',
                dataType: 'json',
                cache: false,
                success: function (data) {
                    cks = 0;
                    wids = "";
                    if (data.length == 0) {
                        cks = 1;
                        //reWList(dno, id);                        
                    } else {
                        //  if (haspt == "true" && needPT == true) {
                        //      $("#limit").html('<button class="btn btn-primary blue" onclick="getstatus();">如果PT流水不足导致检查，请点此刷新PT流水获取状态</button>');
                        //  }
                        var ntotal = 0;
                        for (var x = 0; x < data.length; x++) {
                            var d = data[x];
                            var amount = d['amount'] == null ? 0 : d['amount'];
                            ntotal += parseFloat(amount);
                            wids = wids == "" ? d['wid'] : wids + "," + d['wid'];
                        }

                        if (ntotal == 0) {
                            cks = 1;
                        } else {
                            cks = 2;
                        }
                    }

                    var submitresult = 1;
                    $.ajax({
                        url: "/playerfund/ckflows",
                        type: 'post',
                        data: {
                            cks: cks,
                            wids: wids,
                            dno: dno
                        },
                        success: function (data) {
                            console.log(data);
                            data = JSON.parse(data);
                            if (data.c == 0) {
                                submitresult = 1;
                                $.notific8("提交流水检查结果成功");
                            } else {
                                $.notific8(errorMsg(data), {
                                    theme: 'ebony'
                                });
                            }
                        },
                        cache: false
                    });
                    console.log("after java: " + dno + " result:" + submitresult);
                    //cks:0-待检查，1-通过，2-未通过
                    // if (submitresult == 1){
                    //     if (cks == 0){
                    //         $("#watercheckresult_" + dno).text('待检查');
                    //     }
                    //     else if (cks == 1){
                    //         $("#watercheckresult_" + dno).text('通过');
                    //     }
                    //     else if (cks == 2){
                    //         $("#watercheckresult_" + dno).text('未通过');
                    //         //$("#watercheckresult_" + dno).css("color", "red");
                    //     }
                    // }
                    // else{
                    //     $("#watercheckresult_" + dno).text('提交错误');
                    //     $("#watercheckresult_" + dno).css("color", "red");
                    // }


                    index = index + 1;
                    if (index <= totalSelected) {
                        percentage = ((index / totalSelected) * 100).toFixed(4);
                        console.log("progress.." + percentage);
                        o.attr("aria-valuenow", percentage);
                        o.css("width", parseInt(percentage) + "%");
                        $("#proc").find("#info").html("批量流水检查中，当前进度" + percentage + "%");
                    }

                    if (index >= totalSelected) {
                        $("#proc").find("#info").html("批量流水检查完成");
                        setTimeout(function () {
                            $("#proc").hide();
                            percentage = 0;
                            o.attr("aria-valuenow", percentage);
                            o.css("width", parseInt(percentage) + "%");
                            target[1].fnReloadAjax();
                        }, 5000);
                    }
                },
                error: function () {
                    index = index + 1;
                    if (index <= totalSelected) {
                        percentage = ((index / totalSelected) * 100).toFixed(4);
                        console.log("error:progress.." + percentage);
                        o.attr("aria-valuenow", percentage);
                        o.css("width", parseInt(percentage) + "%");
                        $("#proc").find("#info").html("批量流水检查中，当前进度" + percentage + "%");
                    }

                    if (index >= totalSelected) {
                        $("#proc").find("#info").html("批量流水检查完成");
                        setTimeout(function () {
                            $("#proc").hide();
                            percentage = 0;
                            o.attr("aria-valuenow", percentage);
                            o.css("width", parseInt(percentage) + "%");
                        }, 5000);
                    }
                }
            });
        });
    }

}

function returnDistribute(dno) {
    $.ajax({
        url: "/playerfund/WtdReturnDistribute",
        type: 'post',
        cache: false,
        dataType: 'json',
        data: {
            dno: dno
        },
        success: function (data) {
            if (data.success) {
                target[1].fnReloadAjax();
            } else {
                successReturn = 0;
            }
        },
        error: function (data) {
            successReturn = data;
        }
    });
}

function chgwstatus(status) {
    $("#w_type").val(status);
    $("#w_all").val('');
    $("#s_search").submit();
}

function chgwstatus2(allwtd) {
    $("#w_all").val(allwtd);
    $("#s_search").submit();
}

function chgValue() {
    $("#w_all").val('');
}

function addTypeValue(type) {
    $("#w_alltype").val(type);
    // if (type == 2)
    // {
    //     document.getElementById('waterchk').style.visibility = 'hidden';
    // }
    // else
    // {
    //     document.getElementById('waterchk').style.visibility = 'visible';
    // }
}