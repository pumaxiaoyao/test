$(document).ready(function () {
    $("#s_search").search();
    ppp();

});

var d_lvl;
var d_asmonth;
var d_agc;
var d_dno;
var pppv = 100;
function ppp() {
    $("#proc").find("#info").html("请等待");
    var proc = setInterval(function () {
        $.ajax({
            url: '/agentfund/getAgentGrantList',
            type: 'post',
            dataType: 'json',
            success: function (data) {
                if (data.count == "0") {
                    $("#proc").hide();
                    clearInterval(proc);
                } else {
                    $("#proc").show();
                    if (data.pect == "100") {
                        $("#proc").find("#info").html("上月(" + data.asmonth + ")结算单已生成完毕。");
                        $("#proc").find(".progress").hide();
                        if (pppv != "100") {
                            target[1].fnReloadAjax();
                        }
                        clearInterval(proc);
                    } else {
                        $("#proc").find(".progress").show();
                        var o = $("#proc").find(".progress-bar");
                        o.attr("aria-valuenow", data.pect);
                        o.css("width", parseInt(data.pect) + "%");
                        $("#proc").find("#info").html("数据(" + data.asmonth + ")生成中，当前进度" + data.pect + "%");
                    }

                    pppv = data.pect;
                }
            },
            error: function (err) {
                $("#proc").hide();
                clearInterval(proc);
            },
            cache: false
        });
    }, 1000);
}

function showDetail(dno) {
    $.get("/agentfund/settleDetail?dno=" + dno, function (data) {
        $("#DetailModal").find("#detial").html(data);
    });
}

function showCbDetail(dno){
    $.get("/agentfund/settleDetail2?dno=" + dno, function (data) {
        $("#CbDetailModal").find("#detial").html(data);
    });
}

function starttask() {
    if($("#data").find("tbody").find("td:first").html()!="没有检索到数据"){
        $.notific8("请先将历史数据结算完成之后，才能创建新的月份结算", {theme: 'ebony'});
        return false;
    }
    // var lastMonthDate = new Date();
    // lastMonthDate.setDate(1);
    // lastMonthDate.setMonth(lastMonthDate.getMonth() - 1);
    // var month = formatDate(lastMonthDate);
    //-/kzb/monthly/agent/task 参数：month 格式 2015-03
    $.blockUI();
    $.ajax({
        url: '/agentfund/createSettle',
        type: 'post',
        success: function (data) {
            data = JSON.parse(data);
            if (data.code == 200) {
                $.notific8("结算单生成任务提交成功");
                ppp();
                target[1].fnReloadAjax();
            } else {
                $.notific8(data.Message, {theme: 'ebony'});
            }
            $.unblockUI();

        },
        error: function (err) {
            $.unblockUI();
        },
        cache: false
    });
}

function verifystart(lvl, dno) {
    d_lvl = lvl;
    d_dno = dno;
    var title = lvl == 2 ? "终审" : "初审";
    $("#verifyTitle").html(title);
    $("#verifyBtn").html(title + "通过");
}

function verify(o) {
    var remark = $("#verifyremark").val();
    $.blockUI();
    $.ajax({
        url: '/agentfund/settleCheck',
        data: {lvl: d_lvl, dno: d_dno},
        type: 'post',
        success: function (data) {
            data = JSON.parse(data);
            if (data.code == 200) {
                $.notific8("审核成功");
                target[1].fnReloadAjax();
                $(o).next().click();

            } else {
                $.notific8(data.Message, {theme: 'ebony'});
            }
            $.unblockUI();
        },
        error: function (err) {
            $.unblockUI();
        },
        cache: false
    });
}

function adjuststart(dno, adjust) {
    d_dno = dno;
    $("#adjust").val("");
    $("#adjust").val(adjust);
    $("#adjustRemark").val("");
}

function saveadjust(o) {
    var adjust = $("#adjust").val();
    var adjustNote = $("#adjustRemark").val();
    
    $.blockUI();
    $.ajax({
        url: '/agentfund/agentAdjust',
        data: {dno: d_dno, note: adjustNote, amount: adjust},
        type: 'post',
        success: function (data) {
            data = JSON.parse(data);
            if (data.code == 200) {
                $.notific8("保存成功");
                target[1].fnReloadAjax();
                $(o).next().click();
            } else {
                $.notific8(data.Message, {theme: 'ebony'});
            }
            $.unblockUI();
        },
        error: function (err) {
            $.unblockUI();
        },
        cache: false
    });
}

function acturalstart(dno, actural, max) {
    d_dno = dno;
    $("#actural").val("");
    $("#actural").val(actural);
    $("#acturalTitle").html(max);
    $("#acturalremark").val("");
}

function saveactural(o) {
    var max = parseFloat($("#acturalTitle").html());
    var note = $("#acturalremark").val();
    var actural = parseFloat($("#actural").val());

    if (actural > max) {
        $.notific8("实际发放不可以超过当期佣金", {theme: 'ebony'});
        return false;
    }
    $.blockUI();
    $.ajax({
        url: '/agentfund/agentActural',
        data: {dno: d_dno, amount: actural, note: note},
        type: 'post',
        success: function (data) {
            data = JSON.parse(data);
            if (data.code == 200) {
                $.notific8("保存成功");
                target[1].fnReloadAjax();
                $(o).next().click();

            } else {
                $.notific8(data.Message, {theme: 'ebony'});
            }
            $.unblockUI();
        },
        error: function (err) {
            $.unblockUI();
        },
        cache: false
    });
}

//格式化日期：yyyy-MM 
function formatDate(date) {
    var myyear = date.getFullYear();
    var mymonth = date.getMonth() + 1;
    if (mymonth < 10) {
        mymonth = "0" + mymonth;
    }
    return (myyear + "-" + mymonth);
}

function DPFstart() {
    $("#dpfinfo").removeClass("hide");
    $("#dpfproc").addClass("hide");
    $("#dpfcs").removeClass("hide");
    $("#dpffs").removeClass("hide");
    var status1 = $("input[name=groups][status=1]:checked").length;
    var status2 = $("input[name=groups][status=2]:checked").length;
    if (status1 == 0 && status2 == 0) {
        $("#dpfinfo").html("请先选择您要操作的内容。");
        $("#dpfcs").addClass("hide");
        $("#dpffs").addClass("hide");
        return;
    }
    if (status1 == 0) {
        $("#dpfcs").addClass("hide");
    }
    $("#dpfinfo").html("当前有条<font color=red>" + status1 + "</font>待初审，<font color=red>" + status2 + "</font>条待复审。请选择您要进行的操作");
}

var total = 0;
var chk = null;

$("#dpfcs").click(function () {
    $("#dpfproc").removeClass("hide");
    $("#dpfinfo").addClass("hide");
    total = $("input[name=groups][status=30]:checked").length;
    $("#dpfcs").addClass("hide");
    $("#dpffs").addClass("hide");
    $("#dpfclose").addClass("hide");
    $.blockUI({
        target: '#DPFModal',
        animate: true
    });
    dpfcs();
});

$("#dpffs").click(function () {
    $("#dpfproc").removeClass("hide");
    $("#dpfinfo").addClass("hide");
    total = parseInt($("input[name=groups][status=2]:checked").length * 2) + parseInt($("input[name=groups][status=1]:checked").length);
    $("#dpfcs").addClass("hide");
    $("#dpffs").addClass("hide");
    $("#dpfclose").addClass("hide");
    $.blockUI({
        target: '#DPFModal',
        animate: true
    });
    dpffs();
});

function dpfcs() {
    if ($("input[name=groups][status=1]:checked").length == 0) {
        $("#dpfinfo").removeClass("hide");
        $("#dpfproc").addClass("hide");
        $("#dpfinfo").html("操作已完成");
        $("#dpfcs").addClass("hide");
        $("#dpffs").addClass("hide");
        $("#dpfclose").removeClass("hide");
        $.unblockUI('#DPFModal');
        target[1].fnReloadAjax();
        return true;
    }

    var now = parseInt((total - $("input[name=groups][status=1]:checked").length) / total * 100);
    console.log(now);
    var o = $("#dpfproc").find(".progress-bar");
    o.attr("aria-valuenow", now);
    o.css("width", parseInt(now) + "%");

    chk = $("input[name=groups][status=1]:checked:first");
    var d_asmonth = chk.attr('asmonth');
    var dno = chk.attr('dno');
    $.ajax({
        url: '/agentfund/settleCheck',
        data: {lvl: 1, dno: dno},
        type: 'post',
        success: function (data) {
            chk.attr("checked", false);
            setTimeout(function () {
                dpfcs();
            }, 300);
        },
        error: function (err) {
            $("#dpfclose").click();
            $.notific8("未知错误，批量审核停止", {theme: 'ebony'});
            $.unblockUI('#DPFModal');
        },
        cache: false
    });
}

function dpffs() {
    if ($("input[name=groups][status=1]:checked").length == 0 && $("input[name=groups][status=2]:checked").length == 0) {
        $("#dpfinfo").removeClass("hide");
        $("#dpfproc").addClass("hide");
        $("#dpfinfo").html("操作已完成");
        $("#dpfcs").addClass("hide");
        $("#dpffs").addClass("hide");
        $("#dpfclose").removeClass("hide");
        $.unblockUI('#DPFModal');
        target[1].fnReloadAjax();
        return true;
    }
    if ($("input[name=groups][status=1]:checked:first").length > 0) {
        chk = $("input[name=groups][status=1]:checked:first");
    } else {
        chk = $("input[name=groups][status=2]:checked:first");
    }

    var now = parseInt((total - ($("input[name=groups][status=1]:checked").length * 2 + $("input[name=groups][status=2]:checked").length)) / total * 100);
    var o = $("#dpfproc").find(".progress-bar");
    o.attr("aria-valuenow", now);
    o.css("width", parseInt(now) + "%");

    var dno = chk.attr('dno');
    var d_lvl = parseInt(chk.attr("status"));
    $.ajax({
        url: '/agentfund/settleCheck',
        data: {lvl: d_lvl, dno: dno, remark: "批量处理"},
        type: 'post',
        success: function (data) {
            if (chk.attr("status") == "1") {
                chk.attr("status", 2);
            } else {
                chk.attr("checked", false);
            }
            setTimeout(function () {
                dpffs();
            }, 300);
        },
        error: function (err) {
            $("#dpfclose").click();
            $.notific8("未知错误，批量审核停止", {theme: 'ebony'});
            $.unblockUI('#DPFModal');
        },
        cache: false
    });
}

$("#selectall").change(function () {
    console.log($("#selectall").attr("checked"));
    if ($("#selectall").attr("checked") == "checked") {
        $("input[name=groups]").attr("checked", $(this).attr("checked"));
    } else {
        $("input[name=groups]").attr("checked", false);
    }
    
});

$(function(){
   $('#resettle').on('click',function(){
       if(confirm('是否确认进行上一月代理月结重算？对于已审过的数据将无法重算。')){
           $.ajax({
               url:'/agentfund/resettle',
               type:'post',
               error:function(){
                   $.notific8("未知错误，请联系管理员", {theme: 'ebony'});
               },
               success:function(data){
                   data = JSON.parse(data);
                   if(data.code == 200){
                       $.notific8("上月代理月结已经重算");
                       window.location.reload();
                   }else{
                       $.notific8(data.Message, {theme: 'ebony'});
                   }
               }
           });
       }
   });
});
