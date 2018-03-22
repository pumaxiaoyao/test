var _gplist = null;
//获取用户转账过的平台列表
//var _urlgps = "/kzb/player/transfer_gps?playerid="+playerid;
var _urlgps = "/kzb/gp/v1/gps";
var _urlbalance = "/kzb/gp/v1/balance"; //playerid, playername, gpid
var _urlunsettled = "/kzb/gp/unsettled"; //playerid, playername, gpid
var _urlmcbalance = "/kzb/player/mcbalance";

// 客服获取玩家参与投注过的游戏平台列表
// /kzb/player/gps 端口 20444，所属应用-miracle-bmw，get方法，参数playername，返回 [ { gpid: 'gpid' }, { ... } ]
// 后台客服获取 自己的可用平台列表 接口
// /kzb/gp/gps 端口 20400，所属应用-app-gp，返回同前台站点列表

// 客服获取玩家 主账户余额和取款冻结金额 接口
// /kzb/player/mcbalance 端口20400，所属应用-app-gp，参数 playerid, 请求get，返回成功时：{gpid: 10000, val: {main: 主账户余额, withdraw: 取款冻结}}

//初始化游戏平台账户信息
// function initGpList() {
//     $.getJSON(_urlgps + "?playerid=" + playerid, function (data) {
//         var _thead = _tbody = "";
//         _gplist = data.data[0];
//         $.each(_gplist, function (idx, item) {
//             _thead += "<th>" + item.name + "</th>";
//             _tbody += "<td><span gp_id='" + item.id + "' balance='balance' gp='gp' flag='0' class='cGreen'>-</span></td>";
//         });
//         $("#_thead").html(_thead);
//         $("#_tbody").html(_tbody);
//         getGpFund();
//     });
// }

//获取余额 //playerid, playername, gpid
function getGpFund() {
    $(document).queue([]);
    $.each(_gplist, function (idx, item) {
        if (item.status == 0) {
            $("span[gp_id=" + item.id + "]").html("维护");
        } 
        else if(item.nb==1){
            $("span[gp_id=" + item.id + "]").html("0.00");
        }
        else {

                var url = _urlbalance + "?gpid=" + item.id + "&playerid=" + playerid + "&playername=" + playername + "&r=" + Math.random();
                if (item.id == 10000) {
                    url = _urlmcbalance + "?playerid=" + playerid + "&r=" + Math.random();
                }
                // if(item.id==167695449110||item.id==61005672349800){
                    url += "&gpn="+gpn;
                // }
                $.ajax(
                    {
                        url: url,
                        //async: false,
                        success: function (_gf) {
                            if (_gf.code == 0) {
                                if (_gf.data.gpid == "10000") {
                                    var amount1 = parseFloat(_gf.data.val.main);
                                    if (isNaN(amount1)) {
                                        amount1 = "-";
                                    } else {
                                        amount1 = amount1.toFixed(2);
                                    }

                                    var amount2 = parseFloat(_gf.data.val.withdraw);
                                    if (isNaN(amount2)) {
                                        amount2 = "-";
                                    } else {
                                        amount2 = amount2.toFixed(2);
                                    }

                                    $("span[gp_id=" + _gf.data.gpid + "]").html(amount1 + "-取款冻结：" + amount2);
                                } else {

                                    var amount = parseFloat(_gf.data.val);
                                    if (isNaN(amount)) {
                                        amount = "-";
                                    } else {
                                        amount = amount.toFixed(2);
                                    }

                                    $("span[gp_id=" + _gf.data.gpid + "]").html(amount);
                                }
                            }

                        },
                        error: function () {
                        }
                    });
        }


    });
}

var allbackstr = "";
//一键回收

function allback(uid, uname) {
    var start = true;
    var canback = false;
    $("span[gp_id][gp_id!=10000]").each(function () {
        if ($(this).html() == "-") {
            //start = false;
        } else {
            if (parseFloat($(this).html()) != 0 && $(this).html() != "维护") {
                canback = true;
            }
        }

    });
    if (start == false) {
        $.notific8("当前平台余额还未全部取回，暂时无法启动一键回收，请余额都读取到之后再尝试。");
        return false;
    }
    if (canback == false) {
        $.notific8("当前没有可以回收的平台余额。");
        return false;
    }

    allbackstr = "";
    $.blockUI();
    $(document).queue([]);
    $.each(_gplist, function (idx, item) {
        if (item.status == 0) {
            console.log(item.id + "维护");
        } else if (item.id == 10000) {
    //console.log();
        }
        else {
            $(document).queue("ajaxRequests", function () {
                var aa = $("span[gp_id=" + item.id + "]").text();
                // if(item.id=="38712217599873024"){
                //     aa = parseInt(amount);
                // }


                if (item.i == 1) {
                    if (allbackstr != "")allbackstr += ",";
                    allbackstr += item.name;
                    aa = parseInt(aa);
                }
                if (aa != 0 && $("span[gp_id=" + item.id + "]").text() != "-") {
                    $.ajax(
                        {
                            url: "/kzb/gp/fundreclaim",
                            data: {
                                uid: uid,
                                uname: uname,
                                gpid: item.id,
                                gpn:gpn
                            },
                            type: "POST",
                            success: function (_gf) {
                                if (_gf.c == 0) {
                                    if (item.i == 1) {
                                        var v = parseFloat($("span[gp_id=" + item.id + "]").text());
                                        v = v - parseInt(v);
                                        v = v.toFixed(2);
                                        $("span[gp_id=" + item.id + "]").text(v);
                                    } else {
                                        $("span[gp_id=" + item.id + "]").text("0.00");
                                    }
                                    $(document).dequeue("ajaxRequests");
                                } else {
                                    //失败的情况
                                    $(document).dequeue("ajaxRequests");
                                }
                            },
                            error: function () {
                                $(document).dequeue("ajaxRequests");
                            }
                        });
                } else {
                    $(document).dequeue("ajaxRequests");
                }
            });
        }
    });
    $(document).dequeue("ajaxRequests");
    $(document).queue("ajaxRequests", function () {
        if (allbackstr == "") {
            $.notific8("回收完成！现在刷新余额");
        } else {
            $.notific8("注意：<font color=red>" + allbackstr + "</font>平台只支持转出整数，所以不足1元的无法回收。<br>其他款项回收完成！现在刷新余额");
        }
        setTimeout(function () {
            getGpFund();
        }, 500);
        $.unblockUI();
    });
}

$('#ffstart').datetimepicker({
    showSecond: true,
    showMillisec: true,
    timeFormat: 'yyyy-mm-dd hh:ii:ss'
});

$('#ffend').datetimepicker({
    showSecond: true,
    showMillisec: true,
    timeFormat: 'yyyy-mm-dd hh:ii:ss'
});


$(function () {
    $('#ffs').on('click', function () {
        var btypes = '';
        $('input[name=btype][type=checkbox]:checked').each(function () {
            btypes += $(this).val() + ',';
        });
        var start = $('#s_StartTime').val();
        var end = $('#s_EndTime').val();
        var uid = $(this).attr('uid');
        var success = 1;
        var dno = 0;
        $.get('/player/fundList', {account: uid, btypes: btypes, start: start, end: end, success: success,dno: dno}, function (data) {
            data = data.data;
            console.log(data);
            $('#fftable tbody > tr').remove();
            $(data).each(function (i, n) {
                var html = '<tr>';
                html += '<td>' + n.index + '</td><td>' + n.btype + '</td><td>' + n.amount + '</td><td>' + n.remark + '</td><td>' + n.sname + '</td><td>' + n.created + '</td>';
                html += '</tr>';
                $('#fftable').append(html);
            });
        })
    });
});

$(function () {
    $('label[ipTag=ipTag]').each(function () {
        var ip = $(this).attr('ip');
        var obj = $(this);
        if (ip != "" && ip != null) {
            if (ip.indexOf(".") != -1) {
                ip = ip.split(".");
                ip = ip[0] + "." + ip[1] + "." + ip[2] + ".1";
                $.ajax({
                    url: '/site/getIpInfo',
                    type: 'get',
                    dataType: 'json',
                    data: {ip: ip},
                    cache: true,
                    error: function () {

                    },
                    success: function (data) {
                        var text = '获取IP信息失败!';
                        if (data.code == 0) {
                            text = data.data['country'] + data.data['region'] + data.data['city'];
                            if (data.data['region'] + data.data['city'] == "") {
                                    $.ajax({
                                        url: '/site/getIpInfoTB',
                                        type: 'get',
                                        dataType: 'json',
                                        data: {ip: ip},
                                        cache: true,
                                        error: function () {

                                        },
                                        success: function (data) {
                                            var text = '获取IP信息失败!';
                                            if (data.code == 0) {
                                                text = data.data['country'] + data.data['region'] + data.data['city'];
                                            }
                                            // var td = $(tip).parent();
                                            //$(td).css('width',180);
                                            // $(td).find('label[attr=addr]').html(text);
                                            $(obj).html(text);
                                        }
                                    });
                                }
                        }
                        $(obj).html(text);
                    }
                });
            }
        }
    });
});


// initGpList();