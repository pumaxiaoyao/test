var nowlayerId = 0;
var now_agent_layerId = 0;
var rtype = 0;

function setadd() {
    nowlayerId = 0;
    $("#modaltitle").text("新增");
    $("#modaltitle").attr("action", "add");
    $("#name").val('');
    $("#remark").val('');
    $("#displayorder").val(0);
    $("#isdefault").attr("disabled", false);
}

function setedit(id, group, name, remark, displayorder) {
    $("#modaltitle").text("编辑");
    $("#modaltitle").attr("action", "edit");
    $("#modaltitle").attr("layerid", id);
    nowlayerId = id;
    $("#name").val(name);
    $("#remark").val(remark);
    $("#displayorder").val(displayorder);
    $('#playergroupid').find('option:selected').prop('selected', false);
    $('#playergroupid').find('option[value=' + group + ']').prop('selected', true);
}


function addagentlevel(o) {
    var action = $("#modaltitle").attr("action");
    var layerid = $("#modaltitle").attr("layerid");
    var name = $("#name").val();
    var remark = $("#remark").val();
    var displayorder = $("#displayorder").val() == "" ? 0 : $("#displayorder").val();
    var playergroupid = $('#playergroupid').find('option:selected').val();
    if (name == "") {
        $.notific8('层级名称不允许为空。', {
            theme: 'ebony'
        });
        return;
    }

    $.blockUI({
        baseZ: 20000
    });
    var data = {
        action: action,
        groupid: playergroupid,
        layerid: layerid,
        name: name,
        remark: remark,
        displayorder: displayorder
    };
    $.ajax({
        url: "/settings/editAgentLevel",
        type: 'post',
        data: data,
        dataType: "json",
        success: function (d) {
            if (d.c == 0) {
                $.unblockUI();
                if (action == "add") {
                    $.notific8("创建成功,页面即将刷新");
                } else {
                    $.notific8("修改成功,页面即将刷新");
                }

                $(o).next().click();
                setTimeout(function () {
                    window.location.reload();
                }, 1000);
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

function saveBrokerage(o) {
    var layerid  = $("#brokerageModalTitle").attr("layerid");
    var floatStr = $("#brokerageModalTitle").attr("commisionfloatstr");
    var gameData = {};

    $("#brokerageModalData tbody").find("tr").each(function(){
        var game = $(this).find("td:eq(1)").text();
        gameData[game] = {};
        var ct = $("#CommisionChoose" + game).val();
        gameData[game]["ct"] = ct;
        if (ct == 1) {
            var cts = $("#Commisionratedata" + game).val();
            gameData[game]["cts"] = (cts / 100).toFixed(4);
        }
        var wt = $("#WaterChoose" + game).val();
        gameData[game]["wt"] = wt;
        if (wt == 1) {
            gameData[game]["wts"] = ($("#Waterratedata" + game).val() / 100).toFixed(4);
        } else if (wt == 2) {
            gameData[game]["wfs"] = $("#brokerageFloat" + game).attr("waterfloatstr");
        }        
    });
    // 构建需要提交的数据
    var postData = {"cfs": floatStr, "game":JSON.stringify(gameData), "layerid": layerid};
    console.log(postData);
    //刷新外部新设置的抽佣比例
    $("#agentLayerCommon" + layerid).attr("floatStr", floatStr);

    $.post('/settings/saveBrokerage', postData, function (data) {
        data = JSON.parse(data);
        data = data.data;
        if (data.code == 200) {
            $.notific8('保存成功！');
            $(o).next().click();
        } else {
            $.notific8("保存失败！", {
                theme: 'ebony'
            });

        };
        $.unblockUI();

    });

}

function makeFLoatStr(sf){
    var _sf = [];
    for (_i in sf) {
        var rd = sf[_i];
        _sf.push(rd["amount"] + "_" + rd["rate"]);
    }
    return _sf.join("|");
}

function setBrokerage(name, layerid) {
    $("#brokerageModalTitle").text("抽佣结算分摊：" + name + "比例分摊");
    $("#brokerageModalTitle").attr("layerid", layerid);
    $.get("/settings/getbrokerage?layerid=" + layerid, function (data) {
        data = JSON.parse(data);
        var bData = data.data;
        var comFloat = makeFLoatStr(data.commisionFloat);
        $("#brokerageModalTitle").attr("CommisionfloatStr", comFloat);

        var html = "";
        $("#brokerageModalData").find("tbody").html("");
        for (game in bData) {
            console.log(bData[game]);
            var cData = bData[game];
            var pcData = cData["data"];
            $("#brokerageModalData").find("tbody").append(cData["html"]);
            
            var tags = ["Commision", "Water"];
            for (_t in tags) {
                var tName = tags[_t];
                var st = pcData["pumping" + tName + "RateType"];
                var sv = pcData["pumping" + tName + "FixedRate"];
                st = (typeof(st) === "undefined")?0:st;
                sv = (typeof(sv) === "undefined")?0:sv;
                if (st == 2){
                    var wfr = pcData["pumpingWaterFloatRate"];
                    wfr = (typeof(wfr)!= "undefined")?wfr:[];//避免出现取值为undefined情况
                    sv = (tName == "Water")?makeFLoatStr(wfr):comFloat;
                    if (tName == "Water") {
                        $("#brokerageFloat"+game).attr("WaterfloatStr", sv);
                    }
                }    
                updateBrokerageSelect(game, st, tName, sv);
            }
            
        }
        //modal通过数据生成新select，其对应的change事件统一委托在modal上
        $("#brokerageModal").delegate("select", "change", function(o){
            var sName = $(this).attr("id").split("Choose");
            var tName = sName[0];
            var game  = sName[1];
            var dataVal = "";
            var selVal = $(this).val();
            // 若type为2，则从dom中读取floatStr
            if (selVal == 2) {
                if (tName == "Commision") {
                    dataVal = $("#brokerageModalTitle").attr("CommisionfloatStr");
                } else {
                    dataVal = $("#brokerageFloat" + game).attr(tName + "floatStr");
                    dataVal = (typeof(dataVal) === "undefined")?"":dataVal;
                }
                
            }
            updateBrokerageSelect(game, $(this).val(), tName, dataVal);
        });

        $("#brokerageModal").delegate("a", "click", function(o){
            var game = $(this).attr("game");
            var modalTag = $(this).attr("modalTag");
            if (modalTag == "commision") {
                $("#brokerageModalTitle").attr("modalTag", "commision");
                var comFloatStr = $("#brokerageModalTitle").attr("CommisionfloatStr");;
                comFloatStr = (typeof(comFloatStr) == "undefined")?"":comFloatStr;
                setFloatData(comFloatStr);
            } else if (modalTag == "water") {
                $("#brokerageModalTitle").attr("modalTag", "water");
                var waterFloatStr = $("#brokerageFloat"+game).attr("waterfloatstr");
                waterFloatStr = (typeof(waterFloatStr) == "undefined")?"":waterFloatStr;
                $("#FloatSettingTitle").attr("gameTag", game);
                setFloatData(waterFloatStr);
            }
        });

       
    });
}


function updateBrokerageSelect(game, selval, tName, dataval){
    var seleObj = $("#"+ tName + "Choose" + game);
    var dataObj = $("#"+ tName + "ratedata" + game);
    var confObj = $("#"+ tName + "config" + game);

    seleObj.val(selval);

    if (selval == 0) {
        dataObj.hide();
        dataObj.attr("onblur", "");
        if (tName == "Water") {
            confObj.hide();
        }
    } else if (selval == 1) {
        dataObj.show();
        dataObj.attr("readonly", false);
        dataObj.css('background', '#ffffff');
        dataObj.attr("onblur", "overFormat(this)");
        dataObj.val((dataval * 100).toFixed(2));
        if (tName == "Water") {
            confObj.hide();
        }
    } else if (selval == 2) {
        dataObj.show();
        dataObj.attr("readonly", true);
        dataObj.css('background', '#C0C0C0');
        dataObj.attr("onblur", "");
        dataObj.val(showRate(dataval));
        if (tName == "Water") {
            confObj.show();
            confObj.attr("game", game);
        }
    }
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

function setupprectr() {
    var temp = $("#totalcstep").val();
    $("#t_waterprec").find("tbody").html("");
    if (temp == "") {
        addprectr();
    } else {
        temp = temp.split("||");
        for (var x = 0; x < temp.length; x++) {
            var v = temp[x].split("|");
            addprectr(v[0], v[1], v[2]);
        }
    }
}

function addlevertr(x, y) {
    if (!x) x = "0";
    if (!y) y = "0";
    var s = '如果输赢';
    if ($("#FloatSettingTitle").attr("settingtag") == "water") {
        s = '如果有效流水';
    } else {
        var s = '如果输赢';
    }
    
    var html = '<tr>';
    html += '<td>' + s + '>=</td>';
    html += '<td><input onkeyup="setRateVal(this)" name="max" class="form-control" type="text" value="' + x + '"></td>';
    html += '<td><input onkeyup="setRateVal(this, 100)" onblur="overFormat(this)" class="form-control" name="perc" type="text" value="' + y + '"></td>';
    html += '<td>不满足则下一步</td>';
    html += '<td><a href="javascript:void(0);" onclick="$(this).parent().parent().remove();" class="btn btn-xs blue">删除</a></td>';
    html += '</tr>';
    $("#t_waterlever").find("tbody").append(html);
}

function addprectr(x, y, z) {
    if (!x) x = "0";
    if (!y) y = "0";
    if (!z) z = "0";
    var html = '<tr>';
    html += '<td>如果总金额>=</td>';
    html += '<td><input onkeyup="setRateVal(this)" name="max" class="form-control" type="text" value="' + x + '"></td>';
    html += '<td><input onkeyup="setRateVal(this, 100)" class="form-control" name="perc" type="text" value="' + y + '"></td>';
    html += '<td><input onkeyup="setRateVal(this)" class="form-control" name="num" type="text" value="' + z + '"></td>';
    html += '<td>不满足则下一步</td>';
    html += '<td><a href="javascript:void(0);" onclick="$(this).parent().parent().remove();" class="btn btn-xs blue">删除</a></td>';
    html += '</tr>';
    $("#t_waterprec").find("tbody").append(html);
}


function savelevertr(o) {
    var flag = true;
    var ret = "";
    var perc = [];
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
            if (o.find('input[name=max]').val() != "") {
                perc.push(o.find('input[name=perc]').val());
            }
            ret = ret != "" ? ret + "|" : ret;
            if (o.find('input[name=max]').val() != "") ret += o.find('input[name=max]').val() + "_" + (o.find('input[name=perc]').val() / 100);
        }
    });
    
    if (flag == true) {
        if (perc.length > 0) {
            var maxV = Math.max.apply(null, perc);
            var minV = Math.min.apply(null, perc);
            var newfloatStr = minV + "% ~ " + maxV + "%";
        } else {
            var newfloatStr = "暂无数据";
        }
        
        var mtag = $("#brokerageModalTitle").attr("modalTag");
        var layerid = "";
        if (mtag == "linefee") {
            layerid = $("#apportionForm").attr("layerid")
            $("#agentLayerCommon" + layerid).attr("linefloatStr", ret);
            $("#linefeeratedata").val(newfloatStr);
        } else if (mtag == "commision") {
            layerid = $("#brokerageModalTitle").attr("layerid");
            // 需要在保存时，再刷新外面的浮动比例
            // $("#agentLayerCommon" + layerid).attr("linefloatStr", ret);
            // $("#linefeeratedata").val(newfloatStr);
            $("#brokerageModalTitle").attr("commisionfloatstr", ret);
            
            $("#brokerageModalData tbody").find("tr").each(function(){
                var game = $(this).find("td:eq(1)").text();
                if ($("#CommisionChoose" + game).val() == 2) {
                    $("#Commisionratedata" + game).val(newfloatStr);
                }
            });

        } else if (mtag == "water") {
            var game = $("#FloatSettingTitle").attr("gameTag");
            if ($("#WaterChoose" + game).val() == 2) {
                $("#Waterratedata" + game).val(newfloatStr);
                $("#brokerageFloat" + game).attr("waterfloatstr", ret);
                
            }
        }
        
        $(o).next().click();
        
    }
}


function saveApportion(o) {
    var layerid = $("#apportionForm").attr("layerid");

    var linefloatStr = $("#agentLayerCommon" + layerid).attr("linefloatStr");
    var floatStr = $("#agentLayerCommon" + layerid).attr("floatStr");

    var dt = $("#depositChoose").val();
    var dts = 0;
    if (dt == 1) {
        // 固定比例取值，其他在服务端处理
        dts = $("#depositratedata").val() / 100;
    }

    var rt = $("#rebateChoose").val();
    var rts = 0;
    if (rt == 1) {
        // 固定比例取值，其他在服务端处理
        rts = $("#rebateratedata").val() / 100;
    }

    var bt = $("#bonusChoose").val();
    var bts = 0;
    if (bt == 1) {
        // 固定比例取值，其他在服务端处理
        bts = $("#bonusratedata").val() / 100;
    }

    var lt = $("#linefeeChoose").val();
    var lts = 0;
    if (lt == 1) {
        // 固定比例取值，其他在服务端处理
        lts = $("#linefeeratedata").val() / 100;
    }

    var vb = $("#validBate").val();
    var vc = $("#validMember").val();

    var postdata = {
        layerid: layerid,
        dt: dt,
        dts: dts,
        rt: rt,
        rts: rts,
        bt: bt,
        bts: bts,
        lt: lt,
        lts: lts,
        vb: vb,
        vc: vc,
        fs: floatStr,
        lfs: linefloatStr
    };
    var btnArgs = [layerid, dt, dts, rt, rts, bt, bts, lt, lts, vb, vc];
    var btnStr = "setApportion(" + btnArgs.join(",") + ");";

    $("#apportionModallayer" + layerid).attr("onclick", btnStr);
    $.post('/settings/saveApportion', postdata, function (data) {
        data = JSON.parse(data);
        data = data.data;
        if (data.code == 200) {
            $.notific8('保存成功！');
            $(o).next().click();
        } else {
            $.notific8("aaaaa", {
                theme: 'ebony'
            });

        };
        $.unblockUI();

    });
}

function setApportion(layerid, dt, dts, rt, rts, bt, bts, lt, lts, vps, vpc) {
    $("#apportionForm").attr("layerid", layerid);
    updateSelect(dt, dts, "deposit");
    updateSelect(bt, bts, "bonus");
    updateSelect(rt, rts, "rebate");
    updateSelect(lt, lts, "linefee");
    $("#validBate").val(vps);
    $("#validMember").val(vpc);

}