var __balance__;
var __limit__;
$(document).ready(function () {
    $("#s_search").search({
        "_fnCallback": function (resp) {
            $('#data tbody > tr').find('td:eq(5)').css('text-align','right');
            $('#data tbody > tr').find('td:eq(8)').css('text-align','left');
            $('#dpt').text(resp.dpt);
            $('#wtd').text(resp.wtd);
            $('#bonus').text(resp.bonus);
            $('#pdpt').text(resp.pdpt);
            $('#pwtd').text(resp.pwtd);
            $('#pbonus').text(resp.pbonus);
        }
    });
});
$("input[name=fs_ptype]:checked").on('click',function(){
    var ptype = "";
    $("input[name=fs_ptype]:checked").each(function(){
        if(ptype!=""){ptype=ptype+",";}
        ptype = ptype + $(this).val();
    });
    $("#ptype").val(ptype);
});
var nowtype = 0;
function selectUser(a, b) {
    $("#user" + nowtype).html("&nbsp;&nbsp;&nbsp;&nbsp;当前选择：" + b);
    $("#user" + nowtype).attr("userid", a);
}
function selectid(i) {
    nowtype = i;
    $('#remark'+i).val('客服操作');
}
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
//https://github.com/MikeMcl/bignumber.js +-*/ plus minus times dividedBy
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
function getnum(o) {
    var v = $(o).val();
    if (v == "")v = 0;
    if (isNaN(v))v = 0;
    return new BigNumber(v);
}
function SaveConfig(t, o) {
    var url = t == 1 ? "/kzb/fund/adjust" : "/kzb/fund/bouns", data;
    var uid = $("#user" + t).attr("userid");
    var atype = $("#atype" + t).val();
    var remark = $("#remark" + t).val();
    var amount = $("#ja" + t).val();
    var flows = $("#jv" + t).val();
    var gpid = $("#gpid" + t).val();
    var actid = t == 1 ? "" : $("#actid" + t).val();
    data = {atype:atype,uid:uid,remark:remark,amount:amount,flows:flows,gpid:gpid,actid:actid};
    if (t == 1) {
        data.bcid = $('#cardId').val();
    }

    if(uid == ""){
        $.notific8("请选择要操作的账号", {theme: 'ebony'});
        return false;
    }
    if(remark==""){
        $.notific8("请填写备注信息", {theme: 'ebony'});
        return false;
    }
    $.blockUI({baseZ: 20000});
    $.ajax({
        url: url,
        type: 'post',
        data: data,
        success: function (data) {
            data = JSON.parse(data);
            $.unblockUI();
            if (data.c == 0) {
                $.notific8("成功");
                $(o).next().click();
                $("#s_submit").click();
            } else {
                $.notific8(data.m, {theme: 'ebony'});
            }
        },
        error:function(){
            $.blockUI();
        },
        cache: false
    });
}
/*银行卡限额提醒*/
$(function(){
    $('#cardId').change(function(){
        var option = $(this).find('option:selected');
        init_balance(option.attr('balance'),option.attr('limit'));
    });
})
$(function(){
    $('#ja1').change(function(){
        var option = $('#cardId').find('option:selected');
        init_balance(option.attr('balance'),option.attr('limit'))
    });
});
function init_balance(balance,limit){
    __balance__ = parseFloat(balance);
    __limit__ = parseFloat(limit);
    __balance__ = isNaN(__balance__) ? 0 : __balance__;
    __limit__ = isNaN(__limit__) ? 0 : __limit__;
    var amount = parseFloat($('#ja1').val());
    amount = isNaN(amount) ? 0 : amount;
    if(__limit__ > 0 && (__balance__ + amount) >= __limit__){
        $('#showLimit').show();
        $('#showLimit').html('余额超限尽快转出，当前='+__balance__+'，限额='+__limit__);
    }else{
        $('#showLimit').hide();
    }
}

//批量红利
var listaddresults = new Array();
var listaddresultr = new Array();
function listadd(data,o) {

    //组织参数
    console.log(data);
    var url = "/kzb/fund/bouns";
    var t = 3;
    var atype = $("#atype" + t).val();
    var remark = $("#remark" + t).val();
    var amount = $("#ja" + t).val();
    var flows = $("#jv" + t).val();
    var gpid = $("#gpid" + t).val();
    var actid = $("#actid" + t).val();
    if(remark==""){
        $.notific8("请填写备注信息", {theme: 'ebony'});
        return false;
    }

    udata = data.split('\n');
    listaddresults = new Array();
    listaddresultr = new Array();
    //开始
    $.blockUI({baseZ: 20000});
    $(document).queue([]);

    $(udata).each(function(i,v){
        $(document).queue("ajaxRequests", function () {
            var uid = udata[i].split(':')[0];
            var uname = udata[i].split(':')[1];
            if(uid=='未找到该用户'){
                listaddresultr.push(udata[i]);
                $(document).dequeue("ajaxRequests");
            }else{
                data = {atype:atype,uid:uid,remark:remark,amount:amount,flows:flows,gpid:gpid,actid:actid};
                $.ajax({
                    url: url,
                    type: 'post',
                    data: data,
                    success: function (data) {
                        data = JSON.parse(data);
                        $.unblockUI();
                        if (data.c == 0) {
                            listaddresults.push(uname);
                            $(document).dequeue("ajaxRequests");
                        } else {
                            listaddresultr.push(uname);
                            $(document).dequeue("ajaxRequests");
                        }
                    },
                    error:function(){
                        listaddresultr.push(uname);
                        $(document).dequeue("ajaxRequests");
                    },
                    cache: false
                });
            }
        });
    });

    $(document).dequeue("ajaxRequests");
    $(document).queue("ajaxRequests", function () {
        if(listaddresultr.length>0){
            $('#usernames').val(listaddresultr.toString().replace(/,/g,'\n'));
            alert('共成功'+listaddresults.length+'个用户,已将失败用户重新填写到用户输入框');
        }else{
            alert('共成功'+listaddresults.length+'个用户');
            $(o).next().click();
        }
        $("#s_submit").click();
        $.unblockUI();
    });
    
}
//用户名检查
function CheckUsername(o){
    var usernames = $('#usernames').val().toLowerCase();
    if(usernames==""){
        $.notific8("请输入正确的用户名列表", {theme: 'ebony'});
        return false;
    }
    $.blockUI({baseZ: 20000});
    usernames = usernames.split('\n');
    $(usernames).each(function(i,v){
        usernames[i] = v.replace(/ /g,'');
        if(v.indexOf(":")!=-1&&v!=""){
            usernames[i] = v.split(":")[0];
        }
    });
    usernames = uniq(usernames);
    $.ajax({
        url: '/player/findplayerbynames',
        type: 'post',
        data: "usernames="+usernames.toString(),
        dataType:'json',
        success: function (data) {
            var reallist = new Array();
            if(data.length==0){
                 $.notific8("未找到有效的用户", {theme: 'ebony'});
                 $.unblockUI();
                 return false;
            }

            $(usernames).each(function(i,v){
                reallist[i] = new Array();
                reallist[i]['name'] = 0;
                reallist[i]['id'] = v;
                $(data).each(function(ii,vv){
                    if(v==data[ii]['playerid']){
                        reallist[i]['id'] = data[ii]['playerid'];
                        reallist[i]['name'] = data[ii]['playername'];
                    }
                });
            });
            console.log(reallist);
            var out = '';
            reallist = reallist.sort();
            $(reallist).each(function(i,v){
                var d = reallist[i];
                var name = d['name']==0?'未找到该用户':d['name'];
                out += out==''? (d['id']+':'+name):('\n'+d['id']+':'+name);
            });
            $('#usernames').val(out);
            $.unblockUI();
            if(out.indexOf(":未找到该用户")>0){
                $.notific8("请输入正确的用户名列表", {theme: 'ebony'});
            }else{
                listadd(out,o);
            }
        },
        error:function(){
            $.unblockUI();
            $.notific8("查询用户失败，请稍后再试", {theme: 'ebony'});
        },
        cache: false
    });
}
//数组去重
var uniq = function (arr) {
    var a = [],
    o = {},
    i,
    v,
    len = arr.length;
    if (len < 2) {
        return arr;
    }
    for (i = 0; i < len; i++) {
        v = arr[i];
        if (o[v] !== 1) {
            a.push(v);
            o[v] = 1;
        }
    }
    return a;
}