var box_gplist = null;
var box_urlgps = "/kzb/gp/gps";
var box_urlbalance = "/kzb/gp/balance";
//var box_urlgps = "/kzb/gp/v1/gps";
//var box_urlbalance = "/kzb/gp/v1/balance";
var box_urlunsettled = "/kzb/gp/unsettled";
var box_urlmcbalance = "/kzb/player/mcbalance";
var box_playerid = 0;
var box_playergpn = 0;
var box_playername = '';


var box_allbackstr = "";
//一键回收
function box_allback(uid, uname) {
    var start = true;
    var canback = false;
    $("span[inbox=true][gp_id][gp_id!=10000]").each(function () {
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
    box_allbackstr = "";
    $.blockUI();
    $(document).queue([]);
    $.each(box_gplist, function (idx, item) {
        if (item.status == 0) {
            console.log(item.id + "维护");
        } else if (item.id == 10000) {
    //console.log();
        }
        else {
            $(document).queue("ajaxRequests", function () {
                var aa = $("span[inbox=true][gp_id=" + item.id + "]").text();
    // if(item.id=="38712217599873024"){
    //     aa = parseInt(amount);
    // }
                if (item.i == 1) {
                    if (box_allbackstr != "")box_allbackstr += ",";
                    box_allbackstr += item.name;
                    aa = parseInt(aa);
                }
                if (aa != 0 && $("span[inbox=true][gp_id=" + item.id + "]").text() != "-") {
                    $.ajax(
                        {
                            url: "/kzb/gp/fundreclaim",
                            data: {
                                uid: uid,
                                uname: uname,
                                gpid: item.id,
                                gpn:box_playergpn
                            },
                            type: "POST",
                            success: function (_gf) {
                                if (_gf.c == 0) {
                                    if (item.i == 1) {
                                        var v = parseFloat($("span[inbox=true][gp_id=" + item.id + "]").text());
                                        v = v - parseInt(v);
                                        v = v.toFixed(2);
                                        $("span[inbox=true][gp_id=" + item.id + "]").text(v);
                                    } else {
                                        $("span[inbox=true][gp_id=" + item.id + "]").text("0.00");
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
        if (box_allbackstr == "") {
            $.notific8("回收完成！现在刷新余额");
        } else {
            $.notific8("注意：<font color=red>" + box_allbackstr + "</font>平台只支持转出整数，所以不足1元的无法回收。<br>其他款项回收完成！现在刷新余额");
        }
        setTimeout(function () {
            box_getZZH();
        }, 500);
        $.unblockUI();
    });
}

function box_getZZH() {
    $.ajax({
        url: box_urlmcbalance + "?playerid=" + box_playerid + "&r=" + Math.random(),
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
        }
    });
}

function box_playerTransRecord() {
    var btypes = '';
    $('input[inbox=btype][type=checkbox]:checked').each(function () {
        btypes += $(this).val() + ',';
    });
    
    var status = document.getElementById("box_StatusFli").value;
    var start = $('#box_StartTime').val();
    var end = $('#box_EndTime').val();
    var dno = $('#box_DnoNo').val();
    var uid = $(this).attr('uid');
    $.get('/player/fundList', {account: account, dno: dno , status: status, btypes: btypes, start: start, end: end}, function (datas) {
        datas = JSON.parse(datas);
        refresTransRecords(datas);
    })
}

function box_playerMessage() {
    $.getJSON('/player/playerMessage?account=' + box_playerid, function (data) {
        var html = '';
        data = data.data;
        $(data).each(function (i, v) {
            console.log(v);
            console.log(i);
            html += '<tr><td style="text-align:left;">' + v.title + '</td>';
            html += '<td style="text-align:left;">' + v.content + '</td>';
            html += '<td style="text-align:left;">' + v.created + '</td>';
            html += '<td style="text-align:left;">' + (v.readed == 1 ? '已读' : '未读') + '</td></tr>';
        });
        $("#tab_4").find('table').find('tbody').html(html);
    });
}

function box_playrtLoginInfo(){
    $.getJSON('/player/playerLoginRecord?account=' + box_playerid, function (data) {
        var html = "";
        data = data.data;
        $(data).each(function (i, v) {
            html += '<tr><td>' + v.index + '</td>';
            html += '<td style="text-align:left;"><label attr="ip">' + v.loginIp + '</label><br /><label attr="addr">&nbsp;</label></td>';
            html += '<td>' + v.timestr + '</td>';
            html += '<td>' + v.way + '</td>';
            html += '<td>' + v.domain + '</td></tr>';
        })
        $("#tab_5").find('table').find('tbody').html(html);
    });
}

function box_playerBankInfo(){
    $.getJSON('/player/playerBankInfo?account=' + box_playerid, function (data) {
        var html = "";
        data = data.data;
        $(data).each(function (i, v) {
            console.log(v);
            var _idx = v.idx;
            html += '<tr id="_wdbandkid_' + _idx + '"><td bankcode="bankcode">' + v.sn + '</td>';
            html += '<td bankname="bankname">' + v.bname + '</td>';
            html += '<td account="account">' + box_playername + '</td>';
            html += '<td card="card">' + v.card + '</td>';
            html += '<td banknode="banknode">' + v.bank + '</td>';
            html += '<td status="status"><a href="javascript:void(0);" onclick="changeStatus(' + _idx + ')">'+ v.status + '</a></td>';
            html += '<td><a href="javascript:void(0);" class="btn btn-xs green" onclick="edit_user_wd_card(' + _idx + ')">编辑</a></td></tr>';
        })
        $("#tab_7").find('table').find('tbody').html(html);
    });
}

function box_playerCSInfo(){
    $.getJSON('/player/getCsLog?account=' + box_playerid, function (data) {
        if(data!=""){
            $("#tab_8").find("tbody").html(data);
            $("#cslogitem").show();
        }
    });
}

$(document).ready(function(){
    var _user_wd_card = '';
    _user_wd_card += '<div class="modal fade" id="_user_wd_card" tabindex="-1" role="basic" aria-hidden="true">';
    _user_wd_card += '<div class="modal-dialog">';
    _user_wd_card += '    <div class="modal-content">';
    _user_wd_card += '        <div class="modal-header">';
    _user_wd_card += '            <button class="close" type="button" data-dismiss="modal">×</button>';
    _user_wd_card += '            <h3>玩家取款银行卡</h3>';
    _user_wd_card += '        </div>';
    _user_wd_card += '        <div class="modal-body">';
    _user_wd_card += '        </div>';
    _user_wd_card += '         <div class="modal-footer">';
    _user_wd_card += '            <button class="btn btn-primary green" onclick="save_user_wd_card()">保存</button>';
    _user_wd_card += '            <button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>';
    _user_wd_card += '        </div>';
    _user_wd_card += '    </div>';
    _user_wd_card += '</div>';
    _user_wd_card += '</div>';
    $(document.body).append(_user_wd_card);
});

function changeStatus($wdbankid){
    $.get('/player/withdrawCard?wdbankid=' + wdbankid,function(data){
        $('#_user_wd_card').find('.modal-body').html(data);
        $('#_user_wd_card').modal();
    });
}

function edit_user_wd_card(wdbankid) {
    
    $.get('/player/withdrawCard?wdbankid=' + wdbankid + '&account=' + box_playerid,function(data){
        $('#_user_wd_card').find('.modal-body').html(data);
        $('#_user_wd_card').modal();
    });
}

function save_user_wd_card(){
    $('#_user_wd_card').find('form').submit();
}

function custom_getUserModel(uid, name) {
    box_playerid = uid;
    box_playername = name;
    if ($("#custom_UserModal").length > 0) {
        $("#custom_UserModal").remove();
    }
    if ($("#custom_UserModelbtn").length == 0) {
        $(document.body).append('<a href="#custom_UserModal" id="custom_UserModelbtn" data-toggle="modal" class="hide btn btn-xs green">查看</a>');
    }
    var html = '';
    html += '<div class="modal fade" id="custom_UserModal" tabindex="-1" role="basic" aria-hidden="true">';
    html += '<div class="modal-dialog modal-full">';
    html += '    <div class="modal-content">';
    html += '        <div class="modal-header">';
    html += '            <button class="close" type="button" data-dismiss="modal">×</button>';
    html += '            <h3>玩家信息：' + name + '</h3>';
    html += '        </div>';
    html += '        <div class="modal-body">';
    html += '        </div>';
    html += '         <div class="modal-footer">';
    html += '            <button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>';
    html += '        </div>';
    html += '    </div>';
    html += '</div>';
    html += '</div>';
    html += ''


    $(document.body).append(html);

    $.get("/player/playerDetailBox?id=" + uid, function (data) {
        $("#custom_UserModal").find('.modal-body').html(data);
        $("#custom_UserModelbtn").click()
        //box_initGpList();
        $('label[inbox=ipTag]').each(function () {
            var ip = $(this).attr('ip');
            var obj = $(this);
            if (ip != "" && ip != null) {
                if (ip.indexOf(".") != -1) {
                    ip = ip.split(".");
                    ip = ip[0] + "." + ip[1] + "." + ip[2] + ".1";
                    $.ajax({
                        url: '/home/getIpInfo',
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
                            if (data.data['region'] + data.data['city'] == "") {
                                    $.ajax({
                                        url: '/home/getIpInfoTB',
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
                                            $(obj).html(text);
                                        }
                                    });
                                }
                            $(obj).html(text);
                        }
                    });
                }
            }
        });
        $('#box_StartTime').datetimepicker({
            showSecond: true,
            showMillisec: true,
            timeFormat: 'yyyy-mm-dd hh:ii:ss'
        });
        $('#box_EndTime').datetimepicker({
            showSecond: true,
            showMillisec: true,
            timeFormat: 'yyyy-mm-dd hh:ii:ss'
        });

        $.get("/player/playerActiveTable?uid=" + uid, function (data) {
            $('#box_activeinfo').html(data);
        });

        var wd_status = {1:{name:'无效',btn:'设为有效'},2:{name:'有效',btn:'设为无效'}}
        $('a[inbox=wdbank]').on('click', function () {
            var wdbankid = $(this).attr('wdbankid');
            var obj = this;
            var status = $(this).attr('status');
            $.post('/player/editWithdrawCard',{wdbankid:wdbankid,status:status},function(data){
                if(data.success){
                    $(obj).attr('status',data.response.status);
                    $(obj).text(wd_status[status].btn);
                    if(status == 1){
                        $(obj).addClass('green').removeClass('red');
                        $(obj).parent().prev().html('<span class="label label-danger">'+wd_status[status].name+'</span>');
                    }else{
                        $(obj).addClass('red').removeClass('green');
                        $(obj).parent().prev().html('<span class="label label-success">'+wd_status[status].name+'</span>');
                    }

                    $.notific8("银行卡状态设置成功！");
                }else{
                    $.notific8(data.msg, {theme: 'ebony'});
                }
            });
        });
        $('#box_ffs').on('click', function () {
            var btypes = '';
            $('input[inbox=btype][type=checkbox]:checked').each(function () {
                btypes += $(this).val() + ',';
            });
            console.log(btypes);
            var status = document.getElementById("box_StatusFli").value;
            var start = $('#box_StartTime').val();
            var end = $('#box_EndTime').val();
            var dno = $('#box_DnoNo').val();
            var uid = $(this).attr('uid');
            $.get('/player/fundList', {account: uid, dno: dno , status: status, btypes: btypes, start: start, end: end}, function (datas) {
                datas = JSON.parse(datas);
                refresTransRecords(datas);
            })
        });
        });
}
function custom_getBalance(uid, name) {
    custom_getUserModel(uid, name);
}

function refresTransRecords(datas){
    $('#box_fftable tbody > tr').remove();
    if (datas.size > 0){
        $(datas.data).each(function (i, n) {
            var html = '<tr>';
            html += '<td>' + n.index + '</td><td>' + n.btype + '</td><td>' + n.dno + '</td><td>' + n.amount + 
            '</td><td>' + n.remark + '</td><td>' + n.sname + '</td><td>' + n.created + '</td><td>' + n.status + "</td>";
            html += '</tr>';
            $('#box_fftable').append(html);
        });
    };
}