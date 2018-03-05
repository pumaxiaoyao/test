var rebateSetting = [];

function addattr() {
    var groupid = $("#attrTitle").attr("gpid");
    var newlayer = parseInt($("#tab_groupattribute").attr("maxlayer"));
    attrJsonData[groupid][newlayer] = {name:"", minDeposit:0,rebateSetting:new Array(), bankCardSetting:[]};
    console.log(attrJsonData);
    var rowHtml = "<tr groupid=\"" + groupid + "\" layerid=\"" + newlayer + "\"><td >如果存款总额 >= </td>";
    rowHtml += "<td><input type='text' name='dptamount' onkeyup='setRateVal(this)' value='' class='form-control input-sm' placeholder=''></td>";
    rowHtml += "<td><input type='text' name='groupname' value='' class='form-control input-sm' placeholder=''></td>";
    rowHtml += "<td>不满足则下一步</td>";
    rowHtml += '<td><a href="javascript:void(0);" id="rebateJson' + newlayer + '" rebatejson="" onclick="setwateredit(' + newlayer + ');" class="btn btn-xs blue">返水设置</a>';
    rowHtml += '<a href="javascript:void(0);" id="bankJson' + newlayer + '" bankjson=""  onclick="getCardList(' + newlayer + ');" class="btn btn-xs blue">选银行卡</a>';
    rowHtml += "<a href=\"javascript:void(0);\" onclick=\"delattrrow('" + newlayer + "', '" + groupid + "')\" class=\"btn btn-xs red\">删除</a></td></tr>";
    $("#tab_groupattribute").find('table').find('tbody').append(rowHtml);
    $("#tab_groupattribute").attr("maxlayer", parseInt(newlayer) + 1);
}

function delattrrow(layerid, groupId) {
    // 删除指定行
    // 若是旧数据，则添加del标签
    // 若是新数据，则直接remove

    $("#tab_groupattribute").find('table').find('tbody tr').each(function () {
        if ($(this).attr("layerid") == layerid && $(this).attr("groupid") == groupId) {
            $(this).remove();
        }
    });
}

function savePLAttr() {
    var groupid = $("#attrTitle").attr("gpid");
    var dataRows = $("#tab_groupattribute").find('table').find('tbody tr');
    var layerGP = "";
    var layerDPT = "";
    var saveAttr = new Array();
    dataRows.each(function () {
        var layerid = $(this).attr("layerid");
        layerGP = $(this).find("input[name=groupname]").val();
        layerDPT = $(this).find("input[name=dptamount]").val();
        var rebateStr = attrJsonData[groupid][layerid].rebateSetting;
        var bankStr = attrJsonData[groupid][layerid].bankCardSetting;
        if (layerGP !== null && layerGP !== undefined && layerGP !== "") {
            if (layerDPT !== null && layerDPT !== undefined && layerDPT !== "") {
                var data = {
                    "name": layerGP,
                    "minDeposit": parseFloat(layerDPT),
                    "rebateSetting": rebateStr,
                    "bankCardSetting": bankStr
                };
                saveAttr.push(data);
            }
        }
    });

    $.ajax({
        url: "/settings/setPlayerLevelAttrs",
        type: 'post',
        data: {
            attr: JSON.stringify(saveAttr),
            groupId: groupid
        },
        contentType: "multipart/form-data",
        dataType: "json",
        success: function (d) {
            if (d.c == 0) {
                $.unblockUI();
                $.notific8("玩家组属性保存成功");
                $("#attrModal").modal("hide");
                window.location.reload();
            } else {
                $.notific8(d.m, {
                    theme: 'ebony'
                });
                $.unblockUI();
            }
        },
        error: function (err) {
            $.notific8("系统错误，请重试或联系管理员", {
                theme: 'ebony'
            });
            $.unblockUI();
        },
        cache: false
    });

}

function setwateredit(layerid) {
    var groupname = $("#attrTitle").attr("gpname");
    var groupid = $("#attrTitle").attr("gpid");
    $("#waterTitle").text("返水设置 - 【层级：" + groupname + "】");
    $("#waterTitle").attr("layerid", layerid);
    var gameRebate = validGames.data;
    
    var gpRebate = attrJsonData[groupid][layerid].rebateSetting;
    gameDict = {};
    for (var gp in gameRebate) {
        var gps = gameRebate[gp];
        gameDict[gps.code] = gps.name;
    }
    if (gpRebate == "" || gpRebate == "undefined" || gpRebate == null || gpRebate.length == 0) {
        attrJsonData[groupid][layerid].rebateSetting = {};
        for (var gp in gameRebate) {
            var gps = gameRebate[gp];
            var gpname = gps.code;
            attrJsonData[groupid][layerid].rebateSetting[gpname] = {floatRate: {},fixRate:0};
        }
        gpRebate = attrJsonData[groupid][layerid].rebateSetting;
    }
    console.log(attrJsonData);
    var html = "";
    for (var gp in gpRebate) {
        var gpd = gpRebate[gp];
        html += "<tr gpid=\"" + gp + "\" layerid=\"" + layerid + "\">";
        html += "<td>" + gp + "</td>";
        html += "<td gpname=gpname>" + gameDict[gp] + "</td>";
        html += '<td><input name="rrate" onkeyup="setRateVal(this, 100)" class="form-control" type="text" value="' + gpd.fixRate + '"></td>';
        var fstr = new Array();
        for (var nd in gpd.floatRate) {
            var _fstr = gpd.floatRate[nd].amount + "_" + gpd.floatRate[nd].rate * 100;
            fstr.push(_fstr);
        }

        html += '<td name="stepped">' + fstr.join("|") + '</td>';
        html += '<td><a href="#waterLeverModal" onclick="setuplevertr(\'' + gp + '\', \'' + gameDict[gp] + '\', \'' + groupname + '\');" data-toggle="modal" class="btn btn-xs blue">返水设置</a></td></tr>';
    }
    $("#waterModal").modal();
    $("#waterTable").find("tbody").html(html);

}

function getCardList(layerid) {

    var groupname = $("#attrTitle").attr("gpname");
    var groupid = $("#attrTitle").attr("gpid");
    $("#bankModalTitle").text("选择银行卡 - 【层级：" + groupname + "】");
    $("#bankModalTitle").attr("layerid", layerid);

    var gameBanks = validBanks.data;
    var gpCards = attrJsonData[groupid][layerid].bankCardSetting;
    if (gpCards == undefined) gpCards = {};
    var html = "";
    for (var bk in gameBanks) {
        var bks = gameBanks[bk];
        html += "<tr><td><input name=bankcard code='" + bks.CODE + "' bcid='" + bks.ID + "' layerid='" + layerid + "' type='checkbox'";
        var check = false;
        for (var cid in gpCards) {
            if (parseInt(gpCards[cid]) == parseInt(bks.ID)) {
                check = true;
            }
        }
        if (check) {
            html += "checked ></td>";
        } else {
            html += "></td>";
        }
        html += "<td>" + bks.BANKNAME + "</td>";
        html += "<td>" + bks.NAME + "</td>";
        html += "<td>" + bks.CARD + "</td>";
        html += "<td>" + bks.REGBANK + "</td>";
        html += "<td>" + bks.DESC + "</td>";
        html += "<td>" + bks.TYPE + "</td></tr>";
    }

    $("#cardModal").modal();
    $("#bankcardList").find("tbody").html(html);
}

function submitBanklist(o) {
    var groupname = $("#attrTitle").attr("gpname");
    var groupid = $("#attrTitle").attr("gpid");

    var bankcode = new Array();
    var layerid = $("#cardModal").find('input[name=bankcard]').attr("layerid");
    $("#cardModal").find('input[name=bankcard]').each(function () {
        var b = $(this).attr('bcid');
        if ($(this).prop("checked")) bankcode.push(b);
    });
    attrJsonData[groupid][layerid].bankCardSetting = bankcode;
    $(o).next().click();
}

function addplayerlever(o) {
    var name = $("#name").val();
    var remark = $("#remark").val();
    var displayorder = $("#displayorder").val() == "" ? 0 : $("#displayorder").val();
    var isdefault = $("#isdefault").val();
    var status = $("#status").val();
    var action = $("#status").attr("action");
    if (name == "") {
        $.notific8('参数错误', {theme: 'ebony'});
        return;
    }
    $.blockUI({baseZ: 20000});
    var data = {
        groupid: nowgroupid,
        name: name,
        remark: remark,
        displayorder: displayorder,
        isdefault: isdefault,
        status: status,
        action: action
    };
    $.ajax({
        url: "/settings/editPlayerLevels",
        type: 'post',
        data: data,
        dataType: "json",
        success: function (d) {
            if (d.c == 0) {
                $.unblockUI();
                $.notific8("创建成功，页面即将刷新");
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
            $.notific8("系统错误，请联系管理员", {theme: 'ebony'});
            $.unblockUI();
        },
        cache: false
    });
}

function savewaterconfig(o) {
    $.unblockUI();
    var groupid = $("#attrTitle").attr("gpid");
    var layerid = $("#waterTitle").attr("layerid");
    var waterData = {};
    $("#waterTable").find("tbody").find("tr").each(function (i) {
        var tr = $(this);
        var gpid = tr.attr("gpid");
        var gpname = tr.find("td[gpname=gpname]").text();
        var rrate = tr.find("input[name=rrate]").val();
        var stepcond = tr.find("td[name=stepped]").html() == "-" ? "" : tr.find("td[name=stepped]").html();
        var stepData = new Array();
        if (stepcond != "") {
            steped = stepcond.split("|");
            for (var x = 0; x < steped.length; x++) {
                var v = steped[x].split("_");
                stepData.push({
                    "amount": parseFloat(v[0]),
                    "rate": parseFloat(v[1])
                });
            }
        };
        var gameconfig = {
            "fixRate": rrate != null && rrate != undefined ? parseFloat(rrate)  : 0,
            "floatRate": stepData
        };
        waterData[gpid] = gameconfig;
    });
    attrJsonData[groupid][layerid].rebateSetting = waterData;
    $(o).next().click();
}


function setuplevertr(gpid, gpname, gamename) {
    var groupid = $("#attrTitle").attr("gpid");
    var layerid = $("#waterTitle").attr("layerid");

    var rebateCfg = attrJsonData[groupid][layerid].rebateSetting;
    console.log(rebateCfg);
    var floatRate = rebateCfg[gpid].floatRate;
    $("#waterlevelTitle").attr("gpid", gpid);
    $("#waterlevelTitle").text("阶梯比例设置 - 【" + gpname + " : " + gamename + "】");
    $("#t_waterlever").find("tbody").html("");
    if (floatRate == "" || floatRate == undefined || floatRate == null || floatRate.length == 0) {
        addlevertr();
    } else {
        for (nrate in floatRate) {
            addlevertr(floatRate[nrate].amount, floatRate[nrate].rate * 100);
        }
    }
}

function addlevertr(x, y) {
    if (!x) x = "0";
    if (!y) y = "0";
    var html = '<tr>';
    html += '<td>如果有效流水>=</td>';
    html += '<td><input onkeyup="setRateVal(this)" name="max" class="form-control" type="text" value="' + x + '"></td>';
    html += '<td><input onkeyup="setRateVal(this, 100)" class="form-control" name="perc" type="text" value="' + y + '"></td>';
    html += '<td>不满足则下一步</td>';
    html += '<td><a href="javascript:void(0);" onclick="$(this).parent().parent().remove();" class="btn btn-xs blue">删除</a></td>';
    html += '</tr>';
    $("#t_waterlever").find("tbody").append(html);
}

function savelevertr(o) {
    var gpid = $("#waterlevelTitle").attr("gpid");
    var flag = true;
    var ret = "";
    $("#t_waterlever").find("tbody").find("tr").each(function (i) {
        var o = $(this);
        if (flag) {
            var n = parseInt(o.find('input[name=max]').val());
            var l = parseInt(o.prev().find('input[name=max]').val());
            if (n >= l) {
                alert(i + '参数设置错误！' + "n:" + n + ">=l:" + l);
                flag = false;
                return;
            }
            ret = ret != "" ? ret + "|" : ret;
            var amount = o.find('input[name=max]').val();
            if (parseInt(amount) != amount) {
                amount = parseFloat(amount).toFixed(2);
            } else {
                amount = parseInt(amount);
            }
            var rate = o.find('input[name=perc]').val();
            if (parseInt(rate) != rate) {
                rate = ( parseFloat(rate) / 100 ).toFixed(2);
            } else {
                rate = ( parseInt(rate) / 100 );
            }
            if (o.find('input[name=max]').val() != "") ret += amount + "_" + rate;
        }
    });
    if (ret == "") {
        ret = "-";
    }
    var rateShowEl = $("#waterTable").find("tr[gpid=" + gpid + "]").find("td[name=stepped]");
    rateShowEl.html(ret);
    $(o).next().click();
}

function setRateVal(obj, maxVal) {
    obj.value = obj.value.replace(/[^\d.]/g, ""); //清除“数字”和“.”以外的字符  
    obj.value = obj.value.replace(/^\./g, ""); //验证第一个字符是数字而不是. 
    obj.value = obj.value.replace(/\.{2,}/g, "."); //只保留第一个. 清除多余的.   
    obj.value = obj.value.replace(".", "$#$").replace(/\./g, "").replace("$#$", ".");
    if (obj.value == "") obj.value = 0;
    if (maxVal != undefined && obj.value > maxVal) obj.value = maxVal;
    if (obj.value != parseInt(obj.value)) {
        obj.value = parseFloat(obj.value).toFixed(2);
    }
    
     
    
}