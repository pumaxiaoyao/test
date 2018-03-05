var nowgroupid=0;
var now_agent_groupId = 0;
var rtype = 0;
function setadd(){
	nowgroupid=0;
	$("#name").val('');
	$("#remark").val('');
	$("#displayorder").val(0);
	$("#isdefault").val(0);
	$("#status").val(2);
	$("#isdefault").attr("disabled",false);
}

function setedit(id,name,remark,isdefault,status,displayorder,playergroupid){
	nowgroupid=id;
	$("#name").val(name);
	$("#remark").val(remark);
	$("#displayorder").val(displayorder);
	$("#isdefault").val(isdefault);
    $('#playergroupid').find('option:selected').prop('selected',false);
    $('#playergroupid').find('option[value='+playergroupid+']').prop('selected',true);
	if(isdefault==1){
		$("#isdefault").attr("disabled",true);
	}else{
		$("#isdefault").attr("disabled",false);
	}
	$("#status").val(status);
}


function addagentlever(o){
	var name = $("#name").val();
	var remark = $("#remark").val();
	var displayorder = $("#displayorder").val()==""?0:$("#displayorder").val();
	var isdefault = $("#isdefault").val();
	var status = $("#status").val();
    var playergroupid = $('#playergroupid').find('option:selected').val();
	if(name==""){
		$.notific8('层级名称不允许为空。', {theme: 'ebony'});
		return;
	}

	$.blockUI({baseZ:20000});
	var data = {groupid:nowgroupid,name:name,remark:remark,displayorder:displayorder,isdefault:isdefault,status:status,playergroupid:playergroupid};
	$.ajax({
		url :"/settings/editAgentLever",
		type:'post',
		data:data,
		dataType: "json",
		success : function(d) {
			if(d.c==0){
				$.unblockUI();
				$.notific8("创建成功,页面即将刷新");
				$(o).next().click();
				setTimeout(function(){window.location.reload();},1000);
			}else{
				$.notific8(d.m, {theme: 'ebony'});
				$.unblockUI();
			}
		},
		error:function(err){
			$.notific8("系统错误，请重试或联系管理员", {theme: 'ebony'});
			$.unblockUI();
		},
		cache : false
	});
}

function saveBrokerage(o){
    $.unblockUI();

    $("#brokerageModal").find("tr").attr("issave", "false");
    $("#brokerageModal").find("tr").each(function (i) {
        var tr = $(this);
        var isnew = tr.attr("isnew");
        if (!isnew) {
            tr.attr("issave", "true");
        } else {
            var gpid = tr.attr("gpid");

            var rrlimit = tr.find("input[name=rrlimit]").val();
            var rrate = tr.find("input[name=rrate]").val();
            var stepcond = tr.find("td[name=stepped]").html() == "-" ? "" : tr.find("td[name=stepped]").html();
            var stepped = stepcond == "" ? 0 : 1;
            $.ajax({
                url: "/settings/saveAgrouprr",
                type: 'post',
                data: {
                    groupid: now_agent_groupId,
                    rtype:rtype,
                    gpid: gpid,
                    isnew: isnew,
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
                    if ($("#brokerageModal").find("tr[issave=false]").length == 0) {
                        $.notific8('设置已保存');
                    }

                    $(o).next().click();
                    if(rtype==1){
                        $("td[canrake="+now_agent_groupId+"]").html("是");
                    }else{
                        $("td[canwater="+now_agent_groupId+"]").html("是");
                    }
                },
                error: function (err) {
                    tr.attr("issave", "true");
                    $.unblockUI();
                    if ($("#brokerageModal").find("tr[issave=false]").length == 0) {
                        $.notific8('设置已保存');
                    }
                },
                cache: false
            });
        }
    });
}

function setBrokerage(id,type,rmname){
    now_agent_groupId = id;
    rtype = type;
    $('#rmname').html(rmname);
    $("#brokerageModal").find("tr[gpid]").each(function () {
        o = $(this);
        o.attr("isnew", "isnew");
         o.find("span[updated]").html('');
        o.find("select[name=rrperiod]").val(1);
        o.find("input[name=rrlimit]").val('');
        o.find("input[name=rrate]").val('');
        o.find("td[name=stepped]").html("-");
    });

    $.getJSON("/settings/getagrouprr",{groupid:id,type:type}, function (data) {
        $.each(data, function (i, v) {
            var o = $("#brokerageModal").find("tr[gpid=" + v.gpid + "]");
            o.attr("isnew", "notnew");
            var date = new Date(v.updated*1000);
            M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '-';
            D = date.getDate() + ' ';
            h = date.getHours() + ':';
            m = date.getMinutes();

            o.find("span[updated]").html(M+D+h+m);
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



function setuplevertr(gpid) {
    nowgpid = gpid;
    $("#t_waterlever").find("tbody").html("");
    var steped = $("tr[gpid="+gpid+"]").find("td[name=stepped]").html();
    if(steped=="-"){
        addlevertr();
    }else{
        steped = steped.split("||");
        for(var x=0;x<steped.length;x++){
            var v = steped[x].split("|");
            addlevertr(v[0],v[1]);
        }
    }
}

function setupprectr() {
    var temp = $("#totalcstep").val();
    $("#t_waterprec").find("tbody").html("");
    if(temp==""){
        addprectr();
    }else{
        temp = temp.split("||");
        for(var x=0;x<temp.length;x++){
            var v = temp[x].split("|");
            addprectr(v[0],v[1],v[2]);
        }
    }
}

function addlevertr(x,y) {
    if(!x)x="0";
    if(!y)y="0";

    var s = '如果输赢';
    if(rtype==2){
        s = '如果有效流水';
    }
    var html = '<tr>';
    html += '<td>'+s+'>=</td>';
    html += '<td><input onkeyup="clearNoNum(this)" name="max" class="form-control" type="text" value="'+x+'"></td>';
    html += '<td><input onkeyup="clearNoNum(this)" class="form-control" name="perc" type="text" value="'+y+'"></td>';
    html += '<td>不满足则下一步</td>';
    html += '<td><a href="javascript:void(0);" onclick="$(this).parent().parent().remove();" class="btn btn-xs blue">删除</a></td>';
    html += '</tr>';
    $("#t_waterlever").find("tbody").append(html);
}

function addprectr(x,y,z) {
    if(!x)x="0";
    if(!y)y="0";
    if(!z)z="0";
    var html = '<tr>';
    html += '<td>如果总金额>=</td>';
    html += '<td><input onkeyup="clearNoNum(this)" name="max" class="form-control" type="text" value="'+x+'"></td>';
    html += '<td><input onkeyup="clearNoNum(this)" class="form-control" name="perc" type="text" value="'+y+'"></td>';
    html += '<td><input onkeyup="clearNoNum(this)" class="form-control" name="num" type="text" value="'+z+'"></td>';
    html += '<td>不满足则下一步</td>';
    html += '<td><a href="javascript:void(0);" onclick="$(this).parent().parent().remove();" class="btn btn-xs blue">删除</a></td>';
    html += '</tr>';
    $("#t_waterprec").find("tbody").append(html);
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
    if( flag == true ) {
        $("tr[gpid=" + nowgpid + "]").find("td[name=stepped]").html(ret);
        $(o).next().click();
    }
}


function saveprectr(o) {
    var flag = true;
    var ret = "";
    $("#t_waterprec").find("tr").each(function (i) {
        var o = $(this);
        if (i != 0 && flag) {
            var n = parseInt(o.find('input[name=max]').val());
            var l = parseInt(o.prev().find('input[name=max]').val());
            var num = parseInt(o.prev().find('input[name=num]').val());
            if (n >= l) {
                alert(i + '参数设置错误！' + "n:" + n + ">=l:" + l);
                flag = false;
                return;
            }
            ret = ret != "" ? ret + "||" : ret;
            if (o.find('input[name=max]').val() != "")ret += o.find('input[name=max]').val() + "|" + o.find('input[name=perc]').val() + "|" + o.find('input[name=num]').val();
        }
    });
    if (ret == "") {
        ret = "";
    }
    if( flag == true ) {
        if(ret!=""){
            $("#totalstepped").val(1);
        }else{
            $("#totalstepped").val(0);
        }
        $("#totalcstep").val(ret);
        $(o).next().click();
    }
}


function saveApportion(o){
    var postdata = {
        groupid:now_agent_groupId, 
        dfeerate :  $('#dfeerate').val(),
        dfeelimit : $('#dfeelimit').val(),
        rkrate : $('#rkrate').val(),
        rklimit : $('#rklimit').val(),
        bonusrate : $('#bonusrate').val(),
        bonuslimit : $('#bonuslimit').val(),
        ueffbettotal : $('#ueffbettotal').val(),
        ueffbetc : $('#ueffbetc').val(),
        totalclimit : $('#totalclimit').val(),
        totalcrate : $('#totalcrate').val(),
        totalstepped : $('#totalstepped').val(),
        totalcstep : $('#totalcstep').val()
    };

    $.post('/settings/saveApportion',postdata,function(data){
        if(data.success){
            $.notific8('保存成功！');
            $("td[settleshare="+now_agent_groupId+"]").html("是");
            $(o).next().click();
        }else{
            $.notific8(data.msg, {theme: 'ebony'});
            $.unblockUI();
        }

    });
}

function setApportion(id){
    now_agent_groupId = id;
    $('#app_group_id').val(id);
    $.getJSON("/settings/getApportion",{groupid:id}, function (data) {

        var date = new Date(data.updated*1000);
            M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '-';
            D = date.getDate() + ' ';
            h = date.getHours() + ':';
            m = date.getMinutes();
        $('#apportionModal').find("span[updated]").html(M+D+h+m);
        $('#dfeerate').val(data.dfeerate);
        $('#dfeelimit').val(data.dfeelimit);
        $('#rkrate').val(data.rkrate);
        $('#rklimit').val(data.rklimit);
        $('#bonusrate').val(data.bonusrate);
        $('#bonuslimit').val(data.bonuslimit);

        $('#ueffbettotal').val(data.ueffbettotal);
        $('#ueffbetc').val(data.ueffbetc);
        $('#totalclimit').val(data.totalclimit);
        $('#totalcrate').val(data.totalcrate);
        $('#totalstepped').val(data.totalstepped);
        $('#totalcstep').val(data.totalcstep);

    });
}