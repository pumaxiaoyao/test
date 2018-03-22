$(document).ready(function () {
    $("#s_search").search();
    $("#atype,input[id^=j],select[id^=j]").change(function () {
        calc();
    });

    $("#cc").change(function () {
        $("#amount").val($("#cc").val());
        $("#jz").val($("#cc").val());
        calc();
    });

    $("[calc=calc]").change(function () {
        calc1();
    });

    $("#selectall").click(function () {
        if ($(this).parent().hasClass("checked")) {
            $("#data").find("input[name=list]").attr("checked", true);
        } else {
            $("#data").find("input[name=list]").attr("checked", false);
        }
    });
});

function batchPass() {

    if ($("#batchPassRemark").val() == "") {
        $.notific8("请认真填写通过信息", {theme: 'ebony'});
        return false;
    }

    var ids = '';
    $("#data").find("input[name=list]:checked").each(function () {
        ids += $(this).attr('dno') + ',';
    });
    ids =  ids.length > 0 ? ids.slice(0,-1) : ids;
    if(ids.length == 0){
        $.notific8("请选择要审核的申请", {theme: 'ebony'});
        return false;
    }
    var gpid = $("#gpid1").val();
    var atype = $("#atype1").val();
    var amount = $("#ja1").val();
    var remark = $('#batchPassRemark').val();

    if (parseFloat(amount) <= 0) {
        $.notific8("红利金额不正确", {theme: 'ebony'});
        return false;
    }
    var flows = $("#jv1").val();
    if (parseFloat(flows) < 0) {
        $.notific8("流水额度不正确", {theme: 'ebony'});
        return false;
    }
    $.blockUI();
    $.ajax({
        url: '/kzb/playeractivity/batchpass',
        data:{dnos: ids,
            gpid: gpid,
            atype: atype,
            amount: amount,
            flows: flows,
            remark: remark
        },
        type: 'post',
        dataType: 'json',
        error:function(){
            $.unblockUI();
        },
        success:function(data){
            $.unblockUI();
            if(data.c == 0){
                target[1].fnReloadAjax();
                $('#batchPassModal').modal('hide');
                $.notific8('批量审核通过');
            }else{
                $.notific8('批量审核失败！', {theme: 'ebony'});
            }

        }
    });
}

$(function () {
    $('#batchPass').on('click', function () {
        $('#batchPassModal').modal();
    });
});


function refuseAll() {
    var o = $("#data").find("input[name=list]:checked:first");
    nowdno = o.attr("dno");
    o.attr("checked", false);
    if (o.length == 0) {
        $.unblockUI();
        $.notific8('批量拒绝完毕，现在刷新页面。');
        target[1].fnReloadAjax();
        return false;
    }
    $.ajax({
        url: '/task/receive',
        type: 'post',
        data: {tid: nowdno, type: 2011},
        success: function (data) {
            if (data.success) {
                $.ajax({
                    url: '/kzb/playeractivity/refuse',
                    type: 'post',
                    data: {dno: nowdno, remark: '客服批量处理'},
                    success: function (data) {
                        if (data.c == 0) {
                            //window.location.reload();
                        }
                        else {
                            $.notific8(errorMsg(data), {theme: 'ebony'});
                        }
                        refuseAll();
                    },
                    cache: false
                });
            } else {
                refuseAll();
            }
        },
        cache: false
    });
}


var nowdno = 0;
function setPass(dno, uid) {
    nowdno = dno;
    $("#cc").html("<option ddno='0' value='0'>不选择存款</option>");
    $.getJSON("/activity/gPDlist?u=" + uid, function (data) {
        var html = '';
        if (data.c != -1) {
            data = data.m;
            $.each(data, function (i, v) {
                if (v[1])html += "<option ddno='" + v[4] + "' value='" + v[1] + "'>" + v[0] + "-" + v[1] + "-" + v[3] + "</option>";
            });
            $("#cc").append(html);

            calc();
        }
    });
    $("#jb").val(1);
}
function setRefuse(dno) {
    nowdno = dno;
}
//https://github.com/MikeMcl/bignumber.js +-*/ plus minus times dividedBy
function calc() {
    if (!$("#cc").val()) {
        return false;
    }

    var amount = getnum($("#cc").val());
    var ja = getnum($("#ja").val());
    if ($("#atype").val() == "1") {
        amount = amount.plus(ja);
    } else {
        amount = amount.minus(ja);
    }

    var jb = getnum($("#jb").val());
    amount = amount.times(jb);
    $("#jc").val(amount);
    var jz = getnum($("#jz").val());
    if ($("#jj").val() == 1) {
        amount = amount.plus(jz);
    } else {
        amount = amount.minus(jz);
    }
    $("#jv").val(amount);
}

//批量
function calc1() {
    var amount = getnum($("#cc1").val());
    var ja = getnum($("#ja1").val());
    if ($("#atype1").val() == "1") {
        amount = amount.plus(ja);
    } else {
        amount = amount.minus(ja);
    }

    var jb = getnum($("#jb1").val());
    amount = amount.times(jb);
    $("#jc1").val(amount);
    var jz = getnum($("#jz1").val());
    if ($("#jj1").val() == 1) {
        amount = amount.plus(jz);
    } else {
        amount = amount.minus(jz);
    }
    $("#jv1").val(amount);
}

function freetask() {
    $.ajax({
        url: '/kzb/playeractivity/freetask',
        data: {dno: nowdno},
        type: 'post',
        dataType: 'json',
        success: function (data) {
        },
        cache: false
    });
}
function refuse(o) {
    if ($("#refusedealremark").val() == "") {
        $.notific8("请认真填写拒绝的理由", {theme: 'ebony'});
        return false;
    }
    $.blockUI();
    $.ajax({
        url: '/task/receive',
        data: {tid: nowdno, type: 2011},
        type: 'post',
        dataType: 'json',
        success: function (data) {
            if (data.success) {
                $.ajax({
                    url: '/kzb/playeractivity/refuse',
                    data: {dno: nowdno, remark: $("#refusedealremark").val()},
                    type: 'post',
                    dataType: 'json',
                    success: function (data) {
                        $.unblockUI();
                        if (data.c == 0) {
                            target[1].fnReloadAjax();
                            $("#refuseModal").modal('hide');
                            $.notific8("该申请已拒绝", {theme: 'ebony'});
                        } else {
                            $.notific8(errorMsg(data), {theme: 'ebony'});
                        }
                    },
                    error: function () {
                        $.unblockUI();
                    },
                    cache: false
                });
            } else {
                $.unblockUI();
                //$.notific8(errorMsg(data), {theme: 'ebony'});
            }
        },
        error: function () {
            $.unblockUI();
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
            data: {tid: nowdno, type: 2011},
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


function pass(o) {
    if ($("#passremark").val() == "") {
        $.notific8("请认真填写通过信息", {theme: 'ebony'});
        return false;
    }
    var ddno = 0;
    if ($("#cc").find("option").length > 0) {
        ddno = $("#cc").find("option:selected").attr("ddno");
    }
    var gpid = $("#gpid").val();
    var atype = $("#atype").val();
    var amount = $("#ja").val();
    if (parseFloat(amount) <= 0) {
        $.notific8("红利金额不正确", {theme: 'ebony'});
        return false;
    }
    var flows = $("#jv").val();
    if (parseFloat(flows) < 0) {
        $.notific8("流水额度不正确", {theme: 'ebony'});
        return false;
    }
    var remark = $("#passremark").val();
    $.blockUI();
    $.ajax({
        url: '/task/receive',
        data: {tid: nowdno, type: 2011},
        type: 'post',
        dataType: 'json',
        success: function (data) {
            $.unblockUI();
            if (data.success) {
                $.ajax({
                    url: '/kzb/playeractivity/pass',
                    data: {
                        dno: nowdno,
                        ddno: ddno,
                        gpid: gpid,
                        atype: atype,
                        amount: amount,
                        flows: flows,
                        remark: remark
                    },
                    type: 'post',
                    dataType: 'json',
                    success: function (data) {
                        if (data.c == 0) {
                            target[1].fnReloadAjax();
                            $("#passModal").modal('hide');
                            $.notific8("该申请已通过");
                        } else {
                            $.notific8(errorMsg(data), {theme: 'ebony'});
                        }
                    },
                    error: function () {
                        $.unblockUI();
                    },
                    cache: false
                });
            } else {
                $.unblockUI();
                //$.notific8(errorMsg(data), {theme: 'ebony'});
            }
        },
        error: function () {
            $.unblockUI();
        },
        cache: false
    });
}
function getnum(v) {
    if (v == "")v = 0;
    if (isNaN(v))v = 0;
    return new BigNumber(v);
}