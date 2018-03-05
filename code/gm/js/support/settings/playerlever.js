var nowgroupid = 0;
var nowgpid = 0;
function setadd() {
    nowgroupid = 0;
    $("#name").val('');
    $("#remark").val('');
    $("#displayorder").val(0);
    $("#isdefault").val(0);
    $("#status").val(2);
    $("#isdefault").attr("disabled", false);
}
function setedit(id, name, remark, isdefault, status, displayorder) {
    nowgroupid = id;
    $("#name").val(name);
    $("#remark").val(remark);
    $("#displayorder").val(displayorder);
    $("#isdefault").val(isdefault);
    if (isdefault == 1) {
        $("#isdefault").attr("disabled", true);
    } else {
        $("#isdefault").attr("disabled", false);
    }
    $("#status").val(status);
}
function setwateredit(id) {
    nowgroupid = id;

    $("#waterModal").find("tr[gpid]").each(function () {
        o = $(this);
        o.attr("isnew", "isnew");
        o.find("span[updated]").html('');
        o.find("select[name=rrperiod]").val(1);
        o.find("input[name=rrlimit]").val('');
        o.find("input[name=rrate]").val('');
        o.find("td[name=stepped]").html("-");
    });

    $.getJSON("/settings/getmgrouprr?groupid=" + id, function (data) {
        $.each(data, function (i, v) {
            var o = $("#waterModal").find("tr[gpid=" + v.gpid + "]");

            var date = new Date(v.updated * 1000);
            M = addTimePad(date.getMonth() + 1) + '-';
            D = addTimePad(date.getDate()) + ' ';
            h = addTimePad(date.getHours()) + ':';
            m = addTimePad(date.getMinutes());

            o.find("span[updated]").html(M + D + h + m);
            o.attr("isnew", "notnew");
            o.find("select[name=rrperiod]").val(v.rrperiod);
            o.find("input[name=rrlimit]").val(v.rrlimit);
            o.find("input[name=rrate]").val(v.rrate);
            if (v.stepcond != "") {
                o.find("td[name=stepped]").html(v.stepcond);
            } else {
                o.find("td[name=stepped]").html("-");
            }
        });
    });
}

function addTimePad(num) {
    if (num < 10) {
        return '0' + num;
    } else {
        return num;
    }
}

function getCardList(id) {
    nowgroupid = id;
    $("#cardModal").find("input[type=checkbox]").attr("disabled", true);
//$("input[bcid]").attr("checked",false);
    $("span.checked").removeClass("checked");
    $("span[ischecked=true]").attr("ischecked", null);
    $.getJSON("/settings/getMgCardList?groupid=" + id, function (data) {
        $.each(data, function (i, v) {
            $("input[bcid=" + v.bcid + "]").parent().addClass("checked").attr("ischecked", "true");
        });
        $("#cardModal").find("input[type=checkbox]").attr("disabled", false);
    });
}
function submitBanklist(o) {
    var add = del = "";
//新增
    $("#cardModal").find("span.checked").each(function () {
        if ($(this).attr("ischecked") != "true") {
            $(this).attr("ischecked", null);
            var b = $(this).find('input').attr('bcid');
            add += add == "" ? b : "," + b;
        }
    });
//删除被取消的
    $("#cardModal").find("span[ischecked=true]").each(function () {
        if (!$(this).hasClass("checked")) {
            $(this).attr("ischecked", null);
            var b = $(this).find('input').attr('bcid');
            del += del == "" ? b : "," + b;
        }
    });
//获取所有选中的bankcode
    var bankcode = [];
    $("#cardModal").find("span.checked").each(function () {
        var b = $(this).find('input').attr('code');
        if (bankcode.indexOf(b) == -1)bankcode.push(b);
    });
    var data = {add: add, del: del, groupid: nowgroupid, bankcode: bankcode.toString()};
    $.ajax({
        url: "/settings/setMgCard",
        type: 'post',
        data: data,
        dataType: "json",
        success: function (d) {
            if (d.c == 0) {
                $.unblockUI();
                $.notific8("银行卡修改成功");
                $(o).next().click();
            } else {
                getCardList(nowgroupid);
                $.notific8(d.m, {theme: 'ebony'});
                $.unblockUI();
            }
        },
        error: function (err) {
            getCardList(nowgroupid);
            $.notific8("系统错误，请重试或联系管理员", {theme: 'ebony'});
            $.unblockUI();
        },
        cache: false
    });

}
function addplayerlever(o) {
    var name = $("#name").val();
    var remark = $("#remark").val();
    var displayorder = $("#displayorder").val() == "" ? 0 : $("#displayorder").val();
    var isdefault = $("#isdefault").val();
    var status = $("#status").val();
    if (name == "") {
        $.notific8('层级名称不允许为空。', {theme: 'ebony'});
        return;
    }
    $.blockUI({baseZ: 20000});
    var data = {
        groupid: nowgroupid,
        name: name,
        remark: remark,
        displayorder: displayorder,
        isdefault: isdefault,
        status: status
    };
    $.ajax({
        url: "/settings/editPlayerLever",
        type: 'post',
        data: data,
        dataType: "json",
        success: function (d) {
            if (d.c == 0) {
                $.unblockUI();
                $.notific8("创建成功,页面即将刷新");
                $(o).next().click();
                setTimeout(function () {
                    window.location.reload();
                }, 1000);
            } else {
                $.notific8(d.m, {theme: 'ebony'});
                $.unblockUI();
            }
        },
        error: function (err) {
            $.notific8("系统错误，请重试或联系管理员", {theme: 'ebony'});
            $.unblockUI();
        },
        cache: false
    });
}
function savewaterconfig(o) {
    $.unblockUI();
    $("#waterModal").find("tr").attr("issave", "false");
    $("#waterModal").find("tr").each(function (i) {
        var tr = $(this);
        var isnew = tr.attr("isnew");
        if (!isnew) {
            tr.attr("issave", "true");
        } else {
            var gpid = tr.attr("gpid");
            var rrperiod = tr.find("select[name=rrperiod]").val();
            var rrlimit = tr.find("input[name=rrlimit]").val();
            var rrate = tr.find("input[name=rrate]").val();
            var stepcond = tr.find("td[name=stepped]").html() == "-" ? "" : tr.find("td[name=stepped]").html();
            var stepped = stepcond == "" ? 0 : 1;

            $.ajax({
                url: "/settings/saveWaterConfig",
                type: 'post',
                data: {
                    groupid: nowgroupid,
                    gpid: gpid,
                    isnew: isnew,
                    rrperiod: rrperiod,
                    rrlimit: rrlimit,
                    rrate: rrate,
                    stepcond: stepcond,
                    stepped: stepped,
                    stepcond: stepcond
                },
                dataType: "json",
                success: function (d) {
                    if (d.c == 0) {
                        tr.attr("issave", "true");
                        $.unblockUI();
                    } else {
                        tr.attr("issave", "true");
                        $.unblockUI();
                    }
                    if ($("#waterModal").find("tr[issave=false]").length == 0) {
                        $.notific8('设置已保存');
                    }
                    $(o).next().click();
                },
                error: function (err) {
                    tr.attr("issave", "true");
                    $.unblockUI();
                    if ($("#waterModal").find("tr[issave=false]").length == 0) {
                        $.notific8('设置已保存');
                    }
                },
                cache: false
            });
        }
    });
}


function setuplevertr(gpid) {
    nowgpid = gpid;
    $("#t_waterlever").find("tbody").html("");
    var steped = $("tr[gpid=" + gpid + "]").find("td[name=stepped]").html();
    if (steped == "-") {
        addlevertr();
    } else {
        steped = steped.split("||");
        for (var x = 0; x < steped.length; x++) {
            var v = steped[x].split("|");
            addlevertr(v[0], v[1]);
        }
    }
}
function addlevertr(x, y) {
    if (!x)x = "0";
    if (!y)y = "0";
    var html = '<tr>';
    html += '<td>如果有效流水>=</td>';
    html += '<td><input onkeyup="clearNoNum(this)" name="max" class="form-control" type="text" value="' + x + '"></td>';
    html += '<td><input onkeyup="clearNoNum(this)" class="form-control" name="perc" type="text" value="' + y + '"></td>';
    html += '<td>不满足则下一步</td>';
    html += '<td><a href="javascript:void(0);" onclick="$(this).parent().parent().remove();" class="btn btn-xs blue">删除</a></td>';
    html += '</tr>';
    $("#t_waterlever").find("tbody").append(html);
}

function savelevertr(o) {
    var flag = true;
    var ret = "";
    $("#t_waterlever").find("tr").each(function (i) {
        var o = $(this);
        if (i != 0 && flag) {
            var n = parseInt(o.find('input[name=max]').val());
            var l = parseInt(o.prev().find('input[name=max]').val());
            if (n >= l) {
                alert(i + '参数设置错误！' + "n:" + n + ">=l:" + l);
                flag = false;
                return;
            }
            ret = ret != "" ? ret + "||" : ret;
            if (o.find('input[name=max]').val() != "")ret += o.find('input[name=max]').val() + "|" + o.find('input[name=perc]').val();
        }
    });
    if (ret == "") {
        ret = "-";
    }
    $("tr[gpid=" + nowgpid + "]").find("td[name=stepped]").html(ret);
    $(o).next().click();
}