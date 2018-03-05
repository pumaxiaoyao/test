var nowgroupid = 0;
var attrJsonData = {};
var nowgpid = 0;
var validGames = new Array();
var validBanks = new Array();
$(document).ready(function () {
    $.getJSON('/settings/getPlayerLevels', function (data) {
        var html1 = '';
        var html2 = '';
        var data1 = data.t1;
        var data2 = data.t2;
        validGames =  data.gps;
        validBanks = data.banks;
        $(data1).each(function (i, v) {
            html1 = setPlHtml(v, html1);
        });
        $("#portlet_tab1").find('table').find('tbody').html(html1);
        
        $(data2).each(function (i, v) {
            html2 = setPlHtml(v, html2);
        });
        $("#portlet_tab2").find('table').find('tbody').html(html2);
    });
});

function setPlHtml(v, h){
    if (v.layerSetting != undefined && v.layerSetting != "" && v.layerSetting != "{}") {
        attrJsonData[v.id] = JSON.parse(v.layerSetting);
    } else {
        attrJsonData[v.id] = [];
    }

    var isDefaultStr = v.isDefault==1?"是":"不是";
    var isValidStr = v.isValid==1?"启用":"禁用";
    h += "<tr id='group" + v.id+"'><td tag=id value="+v.id+">" + v.id + "</td>";
    h += "<td tag=name>" + v.name + "</td>";
    h += "<td tag=note>" + v.note + "</td>";
    h += "<td tag=isDefault value="+v.isDefault+">" + isDefaultStr + "</td>";
    h += "<td tag=isValid value="+v.isValid+">" + isValidStr + "</td>";
    h += "<td tag=orderVal value="+v.orderVal+">" + v.orderVal + "</td>";
    h += "<td tag=lastModifyTime lastModifyTime="+v.lastModifyTime+">" + v.lastModifyTime + "</td>";
    h += "<td><a href=\"#editModal\" onclick=\"setedit('"+v.id+"');\"";
    h += "data-toggle=\"modal\" class=\"btn btn-xs green\">编辑</a>";
    h += "<a href=\"javascript:void(0)\" onclick=\"editPlayerAttr('"+v.id+"');\" data-toggle=\"modal\" class=\"btn btn-xs blue\">属性设置</a></td></tr>";
    return h;
}

function editPlayerAttr(id){
    var name = $("#group" + id).find("td[tag=name]").text();
    var note = $("#group" + id).find("td[tag=note]").text();
    var orderVal = $("#group" + id).find("td[tag=orderVal]").attr("value");
    var isDefault = $("#group" + id).find("td[tag=isDefault]").attr("value");
    var isValid = $("#group" + id).find("td[tag=isValid]").attr("value");
    var groupAttrs = attrJsonData[id];
    $("#attrModal").modal();
    console.log(groupAttrs);
    $("#attrTitle").html("<i class=\"fa fa-gift\"></i> 玩家组 - " + name);
    $("#attrTitle").attr("gpname", name);
    $("#attrTitle").attr("gpid", id);

    var maxlayer = groupAttrs.length;
    $("#tab_groupattribute").attr("maxlayer", maxlayer);
    var rowHtml = "";
    $("#tab_groupattribute").find('table').find('tbody').html("");
    for (layerid in groupAttrs) {
        var layerJson = groupAttrs[layerid];
        rowHtml += "<tr groupid=\"" + id + "\" layerid=\"" + layerid +"\"><td >如果存款总额 >= </td>";
        rowHtml += "<td><input type='text' name='dptamount' onkeyup='setRateVal(this)' value='"+ layerJson.minDeposit +"' class='form-control input-sm' placeholder=''></td>";
        rowHtml += "<td><input type='text' name='groupname' value='"+ layerJson.name +"' class='form-control input-sm' placeholder=''></td>";
        rowHtml += "<td>不满足则下一步</td>";
        rowHtml += '<td><a href="javascript:void(0);" onclick="setwateredit('+layerid+');" class="btn btn-xs blue">返水设置</a>';        
        rowHtml += '<a href="javascript:void(0);" onclick="getCardList('+layerid+');" class="btn btn-xs blue">选银行卡</a>';
        rowHtml += "<a href=\"javascript:void(0);\" onclick=\"delattrrow('"+ layerid +"', '" + id + "')\" class=\"btn btn-xs red\">删除</a></td></tr>";
    }
    $("#tab_groupattribute").find('table').find('tbody').append(rowHtml);
}


function setadd(){
    $("#emTitle").text("新增");
    nowgroupid = 0;
    $("#name").val('');
    $("#remark").val('');
    $("#displayorder").val(0);
    $("#isdefault").val(0);
    $("#status").val("1");
    $("#isdefault").attr("disabled", false);
    $("#status").attr("action", "add");
}

function setedit(id) {
    $("#emTitle").text("编辑");
    nowgroupid = id;
    var name = $("#group" + id).find("td[tag=name]").text();
    var note = $("#group" + id).find("td[tag=note]").text();
    var orderVal = $("#group" + id).find("td[tag=orderVal]").attr("value");
    var isDefault = $("#group" + id).find("td[tag=isDefault]").attr("value");
    var isValid = $("#group" + id).find("td[tag=isValid]").attr("value");

    $("input#name").val(name);
    $("input#remark").val(note);
    $("input#displayorder").val(orderVal);
    $("#isdefault").val(isDefault);
    if (isDefault == 1) {
        $("#isdefault").attr("disabled", true);
    } else {
        $("#isdefault").attr("disabled", false);
    }
    $("#status").val(isValid);
    $("#status").attr("action", "edit");
}
