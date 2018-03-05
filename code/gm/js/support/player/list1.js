/**
 * Created by cz on 15/6/4.
 */
var __balance__;
var __limit__;
var _now_uid = 0;
var _now_acc = "";

$(document).ready(function () {
    $("#s_search").search({
        '_fnCallback': function (resp) {
            // bind_wd_pwd_btn();
            bind_pwd_btn();
            bind_layer_btn();
            bind_balance_btn();
            bind_bonus_btn();
            bind_lock_btn();
            bind_remark_btn();
            bind_water_btn();
            bind_message_btn();
            $('#selAll').prop('checked', false).parent().removeClass('checked');
            $('label[remark=remark]').tooltip();
            bind_agent_btn();
            bind_ip_event();
            bind_name_show();
            getdata();
            $('#data tbody > tr').find('td:eq(3)');//.css('text-align', 'right')
            $("#playerTotal").text(resp.iTotalRecords);
        }
    });
});


var loading = false;
function getdata() {
    if (loading == true) {
        return;
    }
    var u = $("#data").find("span[load=false]:first");
    if (u.length == 0)return;
    var uid = u.attr("uid");
    loading = true;
    $.ajax({
        url: '/player/playerWinloss?uid=' + uid + '&start=0&end=99999999999',
        type: 'get',
        dataType: 'json',
        success: function (data) {
            $("#data").find("span[uid=" + uid + "]").html(formatCurrency(data.winloss * -1)).css("color", data.winloss > 0 ? "red" : "green").attr("load", "true");
            loading = false;
            getdata();
        },
        error: function () {
            loading = false;
            getdata();
        },
        cache: false
    });
}



function formatCurrency(num) {
    num = num.toString().replace(/\$|\,/g, '');
    if (isNaN(num))
        num = "0";
    sign = (num == (num = Math.abs(num)));
    num = Math.floor(num * 100 + 0.50000000001);
    cents = num % 100;
    num = Math.floor(num / 100).toString();
    if (cents < 10)
        cents = "0" + cents;
    for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
        num = num.substring(0, num.length - (4 * i + 3)) + ',' +
            num.substring(num.length - (4 * i + 3));
    return (((sign) ? '' : '-') + num + '.' + cents);
}

function bind_name_show() {
    $(".fa-edit").on('click', function () {
        
    });
}

function bind_ip_event() {
    $('#data tbody > tr').find('label[attr=ip]').on('mouseover', function () {
        var tip = $(this);
        var flag = tip.attr('flag');
        if (flag != 1) {
            var ip = tip.html();
            if (ip != "" && ip != null) {
                if (ip.indexOf(".") != -1) {
                    console.log(ip);
                    ip = ip.split(".");
                    ip = ip[0] + "." + ip[1] + "." + ip[2] + "." + ip[3];
                    $.ajax({
                        url: '/site/getIpInfo',
                        type: 'get',
                        dataType: 'json',
                        data: {ip: ip},
                        cache: true,
                        error: function () {

                        },
                        success: function (data) {
                            tip.attr('flag', 1);
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
                                            tip.attr('flag', 1);
                                            var text = '获取IP信息失败!';
                                            if (data.code == 0) {
                                                text = data.data['country'] + data.data['region'] + data.data['city'];
                                            }
                                            var td = $(tip).parent();
                                            //$(td).css('width',180);
                                            $(td).find('label[attr=addr]').html(text);
                                        }
                                    });
                                }
                            }
                            var td = $(tip).parent();
                            //$(td).css('width',180);
                            $(td).find('label[attr=addr]').html(text);
                        }
                    });
                }
            }
        }
    });
}

//function get_ip_info(){
//    $('#data tbody > tr').each(function(){
//        var tip = $(this).find('label[attr=ip]');
//        var ip = tip.html();
//        if(ip!=""&&ip!=null){
//            if(ip.indexOf(".")!=-1){
//                ip = ip.split(".");
//                ip = ip[0]+"."+ip[1]+"."+ip[2]+".1";
//                $.ajax({
//                    url: '/site/getIpInfo',
//                    type: 'get',
//                    dataType: 'json',
//                    data:{ip:ip},
//                    cache:true,
//                    error: function () {
//
//                    },
//                    success: function (data) {
//                        var text = '获取IP信息失败!';
//                        if(data.code == 0){
//                            text = data.data['country']+data.data['region']+data.data['city'];
//                        }
//                        var td = $(tip).parent();
//                        //$(td).css('width',180);
//                        $(td).find('label[attr=addr]').html(text);
//                    }});
//            }
//        }
//    });
//}

$(function () {
    $('#selAll').on('click', function () {
        $('#data').find('input[layer=layer]').prop('checked', $(this).is(':checked'));
    });
});

function reset_form(form_id) {
    var form = $('#' + form_id);
    $(form).find('i.fa-warning').removeClass('fa-warning');
    $(form).find('div.has-error').removeClass('has-error');
    $(form).find('i.fa-check').removeClass('fa-check');
    $(form).find('div.has-success').removeClass('has-success');
}

/**
 * 修改玩家信息
 */
function editPlayerDetail(id) {
    window.location.href = "/player/playerDetail?id=" + id;
}


/**********重置密码相关***********/

$(function () {
    $('#change_pwd_form').validate({
        rules: {
            pwd: {
                required: true,
                password: true
            }, pwdck: {
                required: true,
                password: true,
                equalTo: '#pwd'
            }
        },
        messages: {
            pwdck: {
                equalTo: '确认密码必须和新密码一致'
            }
        }
    });
});


function bind_pwd_btn() {
    $('a[reset=reset]').on('click', function () {
        _now_uid = $(this).attr('uid');
        $("#npwd").val('');
        $("#npwdck").val('');
        reset_form('resetPwd');
        $('#resetPwd').modal();
    });
}


function resetPwd() {
    var pwd = $("#npwd").val();
    var pwdck = $("#npwdck").val();

    console.log("pwd is " + pwd);
    console.log("pwdck is " + pwdck);
    var flag = $('#change_pwd_form').valid();
    if (!flag) {
        return false;
    }



    $.ajax({
        url: '/kzb/admin/vpkey',
        error: function () {
            notify('未知错误！');
        },
        success: function (rs) {
            // var rsaKey = new RSAKey();
            // rsaKey.setPublic(b64tohex(rs.modulus), b64tohex(rs.exponent));
            // var enPassword = hex2b64(rsaKey.encrypt(pwd + ' ' + pwdck));
            $.ajax({
                url: '/player/resetpwd',
                type: 'post',
                data: {uid: _now_uid, pwd: pwd},
                dataType: "json",
                success: function (d) {
                    
                    if (d.code == 200) {
                        $.unblockUI();
                        $.notific8("密码更新成功");
                        $('#resetPwd').modal('hide');
                    } else {
                        $.notific8(d.Message, {theme: 'ebony'});
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
    });
}
/**********重置密码相关结束***********/


/**********重置取款密码相关***********/

$(function () {
    $('#change_wd_pwd_form').validate({
        rules: {
            pwd: {
                required: true,
                password: true
            }, pwdck: {
                required: true,
                password: true,
                equalTo: '#wdpwd'
            }
        },
        messages: {
            pwdck: {
                equalTo: '确认密码必须和新密码一致'
            }
        }
    });
});


function bind_wd_pwd_btn() {
    $('a[wdpwd=wdpwd]').on('click', function () {
        _now_uid = $(this).attr('uid');
        $("#wdpwd").val('');
        $("#wdpwdck").val('');
        reset_form('resetWdPwd');
        $('#resetWdPwd').modal();
    });
}


function resetWdPwd() {
    var flag = $('#change_wd_pwd_form').valid();
    if (!flag) {
        return false;
    }

    var pwd = $("#wdpwd").val();
    var pwdck = $("#wdpwdck").val();

    $.ajax({
        url: '/player/resetWdPwd',
        type: 'post',
        data: {uid: _now_uid, pwd: pwd},
        dataType: "json",
        success: function (d) {
            if (d.success) {
                $.unblockUI();
                $.notific8("取款密码更新成功");
                $('#resetWdPwd').modal('hide');
            } else {
                $.notific8('取款密码更新失败', {theme: 'ebony'});
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
/**********重置取款密码相关结束***********/


/**********玩家调层相关***********/
function bind_layer_btn() {
    $('a[layer=layer]').on('click', function () {
        var playerGroupid = $(this).attr("groupid");
        $.getJSON('/settings/getPlayerLevels', function (data) {
            var html1 = '';
            var data1 = data.t1;
            validGames =  data.gps;
            validBanks = data.banks;
            $(data1).each(function (i, v) {
                html1 = setGroupHtml(v, html1, playerGroupid);
            });
            $("#layerModal").find('table').find('tbody').html(html1);
        });
        
        $("#layerModal").attr("uid", $(this).attr("uid"))
        $("#layerModal").attr("roleid", $(this).attr("roleid"))
        var to = $(this).attr("uname");
        $('font[show=uname]').html(to);
       
        $('#layerModal').modal();
    });
}

function setGroupHtml(v, h, playerGroupid){
    var isDefaultStr = v.isDefault==1?"是":"不是";
    var isValidStr = v.isValid==1?"启用":"禁用";
    h += "<tr id='group" + v.id+"'><td tag=id value="+v.id+">" + v.id + "</td>";
    h += "<td tag=name>" + v.name + "</td>";
    h += "<td tag=isDefault value="+v.isDefault+">" + isDefaultStr + "</td>";
    h += "<td tag=isValid value="+v.isValid+">" + isValidStr + "</td>";
    h += "<td tag=note>" + v.note + "</td>";
    h += "<td><a href=\"javascript:void(0);\" group=\"group\" groupname=\"" + v.name + "\" groupid=\"" + v.id+"\" ";
    if (v.id == playerGroupid){
        h += "class=\"btn btn-xs red\">已选择</a>";
    } else {
        h += "class=\"btn btn-xs grey-cascade\">立即选择</a>";
    }
    
    h += "</td></tr>";
    return h;
}

$(function () {
    $('#layerModal').delegate('a[group=group]', "click", function(){
        if (!$(this).hasClass('red')) {
            var newGroupId = $(this).attr('groupid');
            var playerId = $("#layerModal").attr("roleid");
            var obj = this;
            $('#layerModal').find('a.red').removeClass('red').addClass('grey-cascade').html('立即选择');
            $(obj).removeClass('grey-cascade').addClass('red').html('已选择');
            var newtags = newGroupId + " - " + $(obj).attr('groupname') + '<i class="fa fa-edit"></i>';
            console.log(newtags);
            $('#' + playerId + '_group').html(newtags);
            $('#' + playerId + '_group').attr("groupid", newGroupId);
            $.post('/player/setGroup', {groupid: newGroupId, playerid: playerId}, function (data) {
                    if (data != undefined) {
                        data = JSON.parse(data);
                        if (data.code == 200) {
                            $.notific8(data.Message);
                        } else {
                            $.notific8(data.Message, {theme: 'ebony'});
                        }
                    } else {
                        $.notific8("未接受到服务器数据", {theme: 'ebony'});
                    }
                });
        }
    });
    
            // $.post('/player/setGroup', {groupid: groupid, playerid: _now_uid}, function (data) {
            //     if (data.success) {
            //         $.notific8(data.msg);
            //         $('#layerModal').find('a.red').removeClass('red').addClass('grey-cascade').html('立即选择');
            //         $(obj).removeClass('grey-cascade').addClass('red').html('已选择');
            //         $('#' + _now_uid + '_group').html($(obj).attr('groupname'));
            //     } else {
            //         $.notific8(data.msg, {theme: 'ebony'});
            //     }
            // });
});


/**
 * 批量调层
 */
$(function () {

    $('#batch_layer_btn').on('click', function () {
        $('#batchLayerModal').find('a[group=group]').removeClass('red').addClass('grey-cascade').html('立即选择');
        $('#batchLayerModal').modal();
    });

    $('#batchLayerModal').find('a[group=group]').on('click', function () {
        if (!$(this).hasClass('red')) {
            var ids = "";
            $('input[type=checkbox][layer=layer]:checked').each(function () {
                ids += $(this).val() + ',';
            });
            if (ids == "") {
                $.notific8("请选择玩家！", {theme: 'ebony'});
                return false;
            }
            var groupid = $(this).attr('groupid');
            var obj = this;
            $.post('/player/batchSetGroup', {groupId: groupid, playerIds: ids}, function (data) {
                if (data.success) {
                    $.notific8(data.msg);
                    $('#batchLayerModal').find('a.red').removeClass('red').addClass('grey-cascade').html('立即选择');
                    $(obj).removeClass('grey-cascade').addClass('red').html('已选择');
                    $('input[type=checkbox][layer=layer]:checked').each(function () {
                        $('#' + $(this).val() + '_group').html($(obj).attr('groupname'));
                    });
                } else {
                    $.notific8(data.msg, {theme: 'ebony'});
                }
            });
        }
    });
});

/**********玩家调层相关结束***********/


/***************调整玩家余额，红利*******************/

function bind_balance_btn() {
    $('a[balance=balance]').on('click', function () {
        _now_uid = $(this).attr('uid');
        $('#adjustBalance').modal();
    });
}


function bind_bonus_btn() {
    $('a[bonus=bonus]').on('click', function () {
        _now_uid = $(this).attr('uid');
        $('#adjustBonus').modal();
    });
}


$(function () {
    $("#atype1").change(function () {
        if ($("#atype1").val() == "1") {
            $("#bcidIn").removeClass("hide");
            $("#bcidOut").addClass("hide");
            $('#bcidIn').change();
        } else {
            $("#bcidOut").removeClass("hide");
            $("#bcidIn").addClass("hide");
            $('#showLimit').hide();
        }
    });


    $("input[id^=j],select[id^=j]").change(function () {
        var id = $(this).attr("id").replace("jb", "").replace("ja", "").replace("jz", "").replace("jj", "").replace("jv", "");
        if (id == 1) {
            if ($("#atype" + id).val() == 1) {
                $("#bcidIn").removeClass("hide");
                $("#bcidOut").addClass("hide");
            } else {
                $("#bcidOut").removeClass("hide");
                $("#bcidIn").addClass("hide");
            }
        }
        var a = getnum("#ja" + id);
        var b = getnum("#jb" + id);
        var jl = a.times(b);
        var jz = getnum("#jz" + id);
        var v = $("#jj" + id).val() == "1" ? jl.plus(jz) : jl.minus(jz);

        $("#jc" + id).val(jl);
        $("#jv" + id).val(v);
    });


    $('#cardId').change(function () {
        var option = $(this).find('option:selected');
        init_balance(option.attr('balance'), option.attr('limit'));
    });


    $('#ja1').change(function () {
        var option = $('#cardId').find('option:selected');
        init_balance(option.attr('balance'), option.attr('limit'))
    });

});

function getnum(o) {
    var v = $(o).val();
    if (v == "")v = 0;
    if (isNaN(v))v = 0;
    return new BigNumber(v);
}


function init_balance(balance, limit) {
    __balance__ = parseFloat(balance);
    __limit__ = parseFloat(limit);

    __balance__ = isNaN(__balance__) ? 0 : __balance__;
    __limit__ = isNaN(__limit__) ? 0 : __limit__;
    var amount = parseFloat($('#ja1').val());
    amount = isNaN(amount) ? 0 : amount;
    if (__limit__ > 0 && (__balance__ + amount) >= __limit__) {
        $('#showLimit').show();
        $('#showLimit').html('余额超限尽快转出，当前=' + __balance__ + '，限额=' + __limit__);
    } else {
        $('#showLimit').hide();
    }
}


function bind_lock_btn() {
    $('a[lock=lock]').on('click', function () {
        var url = '', str = '';
        _now_uid = $(this).attr('uid');
        var i = $(this).find('i.fa');
        var is_lock = $(i).hasClass('fa-unlock');
        url = '/player/lockPlayer';
        if (is_lock) {
            action = 'unlock';
            str = '解锁';
        } else {
            str = '锁定';
            action = 'lock';
        }
        var o = this;
        if (confirm('是否确定' + str + '该玩家？')) {
            $.ajax({
                type: 'POST',
                url: url,
                data: {playerid: _now_uid, action: action},
                success: function (data) {
                    if (data.code == 200) {
                        $.notific8("已" + str);
                        console.log(action);
                        if (action == "lock"){
                            $(o).parent().find("span").text("锁定");
                            $(o).parent().find("span").removeClass('label-success').addClass('label-danger');
                            $(o).parent().find("i.fa").removeClass('fa-lock').addClass('fa-unlock');
                            var ob = $(o).parent().next().children("#lock");
                            $(ob).find("i.fa").removeClass('fa-lock').addClass('fa-unlock');
                            $(ob).find("i.fa").text("解锁");
                            $(ob).removeClass("red").addClass("green");
                        }else{

                            $(o).parent().find("span").text("正常");
                            $(o).parent().find("span").removeClass('label-danger').addClass('label-success');
                            $(o).parent().find("i.fa").removeClass('fa-unlock').addClass('fa-lock');
                            var ob = $(o).parent().next().children("#lock");
                            $(ob).find("i.fa").removeClass('fa-unlock').addClass('fa-lock');
                            $(ob).find("i.fa").text("锁定");
                            $(ob).removeClass("green").addClass("red");
                        }
                    } else {
                        $.notific8(errorMsg(data), {theme: 'ebony'});
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    if (XMLHttpRequest.status == 403) {
                        top.window.location.href = "/account/login";
                    }
                },
                dataType: "JSON"
            });
        }
    });
}

/***************锁定，解锁玩家*******************/
function lockPlayer(o, id) {
    var key = $(o).text();
    var url = "/player/lockPlayer";
    var f = "解锁";
    var action = "lock";
    var fcolor = "red";
    var color = "green";
    if (key == "解锁") {
        url = "/player/lockPlayer";
        action = "unlock";
        f = "锁定";
        fcolor = "green";
        color = "red";
    }

    art.dialog({
        content: '确定要' + key + '该用户吗？',
        lock: true,

        button: [
            {
                name: key,
                callback: function () {
                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: {playerid: id, action: action},
                        success: function (data) {
                            if (data.code == 200) {
                                $.notific8("已" + key);
                                if (action == "lock"){
                                    $(o).find("i.fa").removeClass('fa-lock').addClass('fa-unlock');
                                    $(o).find("i.fa").text(f);
                                    $(o).removeClass("red").addClass("green");

                                    $(o).parent().prev().find("span").text("锁定");
                                    $(o).parent().prev().find("span").removeClass('label-success').addClass('label-danger');
                                    $(o).parent().prev().find("i.fa").removeClass('fa-lock').addClass('fa-unlock');
            
                                }else{
                                    $(o).find("i.fa").removeClass('fa-unlock').addClass('fa-lock');
                                    $(o).find("i.fa").text(f);
                                    $(o).removeClass("green").addClass("red");

                                    $(o).parent().prev().find("span").text("正常");
                                    $(o).parent().prev().find("span").removeClass('label-danger').addClass('label-success');
                                    $(o).parent().prev().find("i.fa").removeClass('fa-unlock').addClass('fa-lock');
                                }
                            } else {
                                $.notific8(errorMsg(data.Message), {theme: 'ebony'});
                            }
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            if (XMLHttpRequest.status == 403) {
                                top.window.location.href = "/account/login";
                            }
                        },
                        dataType: "JSON"
                    });
                },
            },
            {
                name: '取消'
            }
        ]
    });
}


/****玩家备注*****/
function bind_remark_btn() {
    $('a[remark=remark]').on('click', function () {
        _now_uid = $(this).attr('uid');
        $('#remark').val($(this).prev().attr('data-original-title'));
        $('#remarkModal').modal();
    });
}

function saveRemark() {
    var remark = $('#remark').val();
    var uid = _now_uid;
    $.post('/player/saveRemark', {uid: uid, remark: remark}, function (data) {
        data = JSON.parse(data);
        if (data.code == 200) {
            $('#remark_' + uid).text(remark).attr('data-original-title', remark).tooltip();
            $('#remarkModal').modal('hide');
            $.notific8('备注玩家成功！');
        } else {
            $.notific8('备注玩家失败！', {theme: 'ebony'});
        }
    });
}

/*******************修改玩家代理*************************/
function saveAgentCode() {
    var agentCode = $('#agentCode').val();
    var acc = _now_acc;
    var uid = _now_uid;
    $.post('/player/changeAgent', {playerId: uid, agentCode: agentCode}, function (data) {
        data = JSON.parse(data);
        if (data.code == 200) {
            $('#agentModal').modal('hide');
            $.notific8('所属代理更改已提交，预计十分钟后生效！');
            target[1].fnReloadAjax();
            // $.post('/player/changeagent?id=' + data.response.id + '&__pline=' + $('#__pline').val(), {}, function (d) {
            //     if (d.code == 200) {
            //         $('#agentModal').modal('hide');
            //         $.notific8('所属代理更改已提交，预计十分钟后生效！');
            //     } else {
            //         $.notific8('修改玩家代理失败！', {theme: 'ebony'});
            //     }
            // });
        } else {
            // if (data.response) {
            //     $.post('/player/changeagent?id=' + data.response + '&__pline=' + $('#__pline').val(), {}, function (d) {
            //         $('#agentModal').modal('hide');
            //     });
            // }
            $.notific8(data.Message, {theme: 'ebony'});
        }
    });
}


function bind_agent_btn() {
    $('a[agent=agent]').on('click', function () {
        _now_uid = $(this).attr('uid');
        acc = $(this).attr('acc');
        var code = $('#agent_' + acc).attr("agentId");
        var name = $('#agent_' + acc).attr("agentName");
        console.log(code + ':' + name);
        $('#curAgent').text(code + ':' + name);
        $('#agentModal').modal();
    });
}


/****************发送玩家消息*******************/

function bind_message_btn() {
    $('a[message=message]').on('click', function () {
        _now_uid = $(this).attr('uid');
        $("#PlayerMessageTitle").val('');
        $("#PlayerMessageContent").val('');
        $('#messageModal').modal();
    });
}

function sendMessage() {
    if ($("#PlayerMessageContent").val() == "" || $("#PlayerMessageTitle").val() == "") {
        $.notific8("请完善消息标题和内容！", {theme: 'ebony'});
        return false;
    }
    $.blockUI();
    $.ajax({
        url: "/message/addPlayerMessage",
        type: 'post',
        dataType: 'json',
        data: {playerid: _now_uid, content: $("#PlayerMessageContent").val(), title: $("#PlayerMessageTitle").val()},
        success: function (data) {
            $.unblockUI();
            if (data.code == 200) {
                $('#messageModal').modal('hide');
                $.notific8("消息发送成功！");
            } else {
                $.notific8(data.Message, {theme: 'ebony'});
            }
        },
        cache: false
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

                if (ckt.find("td[gpid=10000]").length > 0 && tempo.html() != "0") {
                    tempc = ckt.find("td[gpid=10000]");
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
                if (typeof(data[0]) == "undefined") {
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
