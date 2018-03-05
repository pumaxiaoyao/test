/**
 * Created by R on 15/12/1.
 */
var _a = new Array();
var checkdata;
var needPT = false;
var otd = null;
var nowusername = null;
function showVerifybutton(isShow)
{
    if(isShow == 1){
       
      $("#WCheckVerify").show();
      $("#WCheckNoVerify").hide();
      $("#WCheckCancel").show();
      $("#WCheckNoCancel").hide();  
      $("#submitCheckResult").show();
      
      $("#checkVerify").show();
      $("#noVerify").hide();
      $("#checkVerifyCancel").show();
      $("#noVerifyCancel").hide();
    }else{
      $("#WCheckVerify").css( "display", "none");
      $("#WCheckNoVerify").css( "display", "block");
      $("#WCheckCancel").hide();
      $("#WCheckNoCancel").show();
      $("#submitCheckResult").hide();
      $("#checkVerify").hide();
      $("#noVerify").show();
      $("#checkVerifyCancel").hide();
      $("#noVerifyCancel").show();
    }
}
//绑定按钮
function bind_water_btn(){
    console.log("binding water btn");
    $('a[water=water]').on('click',function(){
        console.log("click water");
        _now_uid = $(this).attr('uid');
        nowusername =  $(this).attr('name');
        getWList();
        $('#WCheck').modal();
        showVerifybutton(2);
    });
}


//初始化流水条件
function getWList() {
    $("font[show=uname]").html(nowusername);
    $.blockUI({message:'正在进行流水检查，请稍候.'});
    $("#waterDetialTable").hide();
    checkdata = null;
    _a = new Array();
    $.getJSON("/playerfund/flowLimitOne?id=" + _now_uid, function (data) {
        console.log("checking flow");
        checkdata = data;
        checkdata.id = _now_uid;
        
        var html = "";
        _a["gpidMAIN"] = new BigNumber(0);
        for (var x = 0; x < data.length; x++) {
            var d = data[x];
            var checkarr = ["IBC","MAIN"];
            var gpid = (d['gpid'] == 0 || d['gpid'] == null) ? "MAIN" : d['gpid'];
            if($.inArray(parseInt(gpid),checkarr)!=-1){needPT=true;}
            gpid = gpid.toString();
            console.log(d);
            var amount = d['amount'] == null ? 0 : d['amount'];
            amount = new BigNumber(parseFloat(amount).toFixed(4));
            //初始化数组
            if (_a["gpid" + gpid]) {
                var temp = new BigNumber(_a["gpid" + gpid]);
                _a["gpid" + gpid] = temp.plus(amount);
            } else {
                _a["gpid" + gpid] = amount;
            }
            var gpname = d['gpname'] == null ? "不限平台" : d['gpname'];
            var agentname = d['agentname'] == null ? "-" : d['agentname'];
            var actname = d['actname'] == null ? "-" : d['actname'];

            html += "<tr>";
            html += "<td>" + d['wid'] + "</td>";
            html += "<td>" + d['createdtoString'] + "</td>";
            html += "<td>" + d['btype'] + "</td>";
            html += "<td>" + gpname + "</td>";
            html += "<td>" + d['nowbalance'] + "</td>";
            html += "<td>" + d['amount'] + "</td>";
            html += "<td>" + d['leftAmount'] + "</td>";
            html += "<td>" + agentname + "</td>";
            html += "<td>" + actname + "</td>";
            html += "<td>" + d['createdtoString'] + "</td>";
            html += "<td>待检查</td>";

            var endtime = '0';
            if(data[x+1]){
            	endtime = data[x+1]['created'];
            }

            html += "<td index='" + x + "' created='" + d['created'] + "' endtime='"+endtime+"' needchecked='false' wid='" + d['wid'] + "' ";
            html += "gpid='"+gpid+"' gpname='"+gpname+"' amount='"+amount+"'";
            html += " ><a href='#'>待检查</a></td>";
            html += "</tr>";
        }

        var limit = "";
        $("#wtable").find("tbody").html(html);
        cks = 0;
        wids = "";
        if (data.length == 0) {
            cks = 1;
            $.notific8("当前用户没有流水条件");
            $.unblockUI();
        } else {
            if(haspt=="true"&&needPT==true){
                $("#limit").html('<button class="btn btn-primary blue" onclick="getstatus();">如果PT流水不足导致检查，请点此刷新PT流水获取状态</button>');
            }
            checkLimit(_now_uid);
        }
    });
}

//获取流水
function checkLimit(id, type) {
	//若已获取完毕则结束
    if ($("#wtable").find("tbody").find("td[needchecked=false]").length == 0) {
        checkwaternew();
        return false;
    }

    //初始化当前信息
	var pass = true;
    otd = $("#wtable").find("tbody").find("td[needchecked=false]:first");
    otd.attr("needchecked", "true");
    var stime = otd.attr("created");
    var etime = otd.attr("endtime");
    var uurl = etime==0?"/playerfund/checkFlows?uid=" + id + "&stime=" + stime:"/playerfund/checkFlows?uid=" + id + "&stime=" + stime+"&etime="+etime;
    _b = new Array();
    _b["gpidMAIN"] = new BigNumber(0);

    $.getJSON(uurl, function (data) {
        if (data.ok == 1) {
            data = data.data;
            if (typeof(data[0]) == "undefined") {
                otd.find("a").html("<font color='red'>无数据</font>");
            }else{
                otd.find("a").html('');
	            for(var i in data){
	                var d = data[i];
	                var gpid = d.gpid;
	                if (!_b["gpid" + gpid])_b["gpid" + gpid] = 0;
	                var gpname = d.gpname;
	                var out = "";
            		var total = new BigNumber(0);

	                if (d.water.length != 0) {
	                    $.each(d.water, function (ii, dd) {
	                        var amount = new BigNumber(parseFloat(dd.betamt).toFixed(4));
	                        total = total.plus(amount);
	                    });
	                }
                    total = total.toString();
                    if(total!=0){
                    otd.find("a").append('<div gpidamount='+gpid+'>'+gpname + '完成:'+total+' 剩：<font>'+total+'</font></div>');
                    }
	            }
                if(otd.find("a").html()==''){
                    otd.find("a").html("<font color='red'>无数据</font>");
                }
	            
            }
        } else {
            if (data.ok == 0) {
                if (typeof(data[0]) == "undefined") {
                    otd.find("a").html("<font color='red'>无数据</font>");
                }
            }
            // $.notific8("流水检查失败！数据未获取成功！");
            // return false;
        }
        if(otd.find("a").html()=="待检查"){
            otd.find("a").html('无数据');
        }
        checkLimit(id);
    });
}

//开始检查流水
function checkwaternew(){
	// var totalneed = new BigNumber(0);
    // $("#wtable").find("td[gpid]").each(function(){
    //       totalneed = totalneed.plus(new BigNumber($(this).attr('amount')));
    //    });
    // var calcneed = ""
    // $.each(a, function (i, v) {
    //     if (_a["gpid" + v]) {
    //         calcneed += v + ":" + _a["gpid" + v] + ",";
    //     }
    // });
    // alert('共需要流水:'+totalneed.toString()+',其中'+calcneed);
    checkwaternewdetail();
}


//首轮检查 专门检查非10000的情况
function checkwaternewdetail(){
    //若已获取完毕则结束
    if ($("#wtable").find("tbody").find("td[needchecked=true]").length == 0) {
        checkwaternew10000();
        return false;
    }

    otd = $("#wtable").find("tbody").find("td[needchecked=true]:first");
    otd.attr('needchecked','other');

    otd.find('div[gpidamount]').each(function(){
        gpid= $(this).attr('gpidamount');
        amount = parseFloat(parseFloat($(this).find("font").text()).toFixed(4));
        var ff = $(this).find("font");
        var index = otd.parent().index()+1;
        if(gpid!="MAIN"){
        $("#wtable").find("tbody").find("tr:lt("+index+")").find("td[gpid="+gpid+"]").each(function(){
             var a = parseFloat(parseFloat($(this).attr('amount')).toFixed(4));
            if(amount>0&&a>0){
                if(a>amount){
                    a = a - amount;
                    amount=0;
                }else{
                    amount = amount - a;
                    a = 0; 
                }
                $(this).attr('amount',parseFloat(a).toFixed(4));
                ff.text(parseFloat(amount).toFixed(4));
            }
        });
        }
    });
    

    checkwaternewdetail();
}

function checkwaternew10000(){
    //若已获取完毕则结束
    if ($("#wtable").find("tbody").find("td[needchecked=other]").length == 0) {

        _a = new Array();
        var ntotal = 0;
        $("#wtable").find("tbody").find("tr").each(function(){
            var amount = parseFloat(parseFloat($(this).find("td:last").attr("amount")).toFixed(4));
            ntotal += amount;
            var gpname =  $(this).find("td:last").attr("gpname");
            var gpid =  $(this).find("td:last").attr("gpid");
            $(this).find('td:eq(6)').html($(this).find("td:last").attr("amount"));
            if(amount==0){
                 $(this).find("td:last").prev().html('已完成').css('color','green');
            }else{
                 $(this).find("td:last").prev().html('未完成').css('color','red');
            }
            if(amount>0){
                if (_a['g'+gpid]) {
                    var temp = new BigNumber(parseFloat(_a['g'+gpid]).toFixed(4));
                    _a['g'+gpid] = temp.plus(amount);
                } else {
                    _a['g'+gpid] = amount;
                }
            }
        });
       
        var calcneed = ""
        $.each(a, function (i, v) {
            if (_a["g" + v]) {
                calcneed += (b[i]=="主账户"?"不限平台":b[i]) + ":" + _a["g" + v] + ",";
            }
        });

        ntotal = parseFloat(parseFloat(ntotal).toFixed(4));
        var msg = '';
        if(ntotal==0){
            msg='<h3 style="color:green;">流水检查通过</h3>';
            $.notific8('流水检查通过');
            $.unblockUI();
             cks = 1;
        }else{
            msg='<h3 style="color:red;">该用户还需要流水:'+ntotal.toString()+',其中'+calcneed+"</h3>";
            $.notific8('该用户还需要流水:'+ntotal.toString()+',其中'+calcneed);
            $.unblockUI();
             cks = 2;
        }
        $("#waterDetialTable").html(msg).fadeIn();

        
        return false;
    }
    otd = $("#wtable").find("tbody").find("td[needchecked=other]:first");
    otd.attr('needchecked','true');

    otd.find('div[gpidamount]').each(function(){
        $(this).css('color','green');
        gpid= $(this).attr('gpidamount');
        amount = parseFloat(parseFloat($(this).find("font").text()).toFixed(4));
        var ff = $(this).find("font");
        var index = otd.parent().index()+1;
        $("#wtable").find("tbody").find("tr:lt("+index+")").find("td[gpid=MAIN]").each(function(){
            var a = parseFloat(parseFloat($(this).attr('amount')).toFixed(4));
            if(amount>0&&a>0){
                if(a>amount){
                    a = a - amount;
                    amount=0;
                }else{
                    amount = amount - a;
                    a = 0; 
                }
                $(this).attr('amount',parseFloat(a).toFixed(4));
                ff.text(parseFloat(amount).toFixed(4));
            }
        });
    });
    checkwaternew10000();
}

var timer = null;
function getstatus(){
    $("#limit").html("PT流水状态获取中");
    $.ajax({
        url: '/kzb/water/pt/member/status/'+_now_uid,
        type: 'get',
        dataType:'json',
        success: function (statusdt) {
            //{"ok":1,"statusdt":{"playerid":"277525237647100","status":1,"create":"2015-08-04 16:21:08","waterdate":"1970-01-01 08:00:00"}}
            if (statusdt.ok == 1) {
                if(statusdt.data!=null){
                    var status = "<font color=blue>进行中</font>";
                    if(statusdt.data.status==2){
                        status = "<font color=green>已完成</font>";
                        //clearInterval(timer);
                    }
                    var waterdate = statusdt.data.waterdate=="1970-01-01 08:00:00"?"未获取":statusdt.data.waterdate;

                    if(statusdt.data.status==2){
                        $("#limit").html('<button class="btn btn-primary grey-steel">刷新PT流水获取状态</button>,<button class="btn btn-primary green" onclick="getptwater();">获取该玩家PT流水</button>,<button class="btn btn-primary blue" onclick="getWList();">重新检查流水完成情况</button><br>上次获取状态：'+status+' 上次申请更新时间<font color=red>' + statusdt.data.create + '</font> - PT流水最后更新时间 - <font color=red>' + waterdate + '</font>');
                    }
                    else
                    {
                        $("#limit").html('<button class="btn btn-primary blue" onclick="getstatus();">刷新PT流水获取状态</button>,<button class="btn btn-primary grey-steel">获取该玩家PT流水</button>,<button class="btn btn-primary grey-steel">重新检查流水完成情况</button><br>上次获取状态：'+status+' 上次申请更新时间<font color=red>' + statusdt.data.create + '</font> - PT流水最后更新时间 - <font color=red>' + waterdate + '</font>');

                    }
                }else{
                    // $("#limit").html('<button class="btn btn-primary green" onclick="getptwater();">开始更新该用户PT流水</button><br>该用户还未获取过流水，或者还未创建PT账户');
                    getptwater();
                }
            } else {
                $("#limit").html('<button class="btn btn-primary grey-steel">刷新PT流水获取状态</button>,<button class="btn btn-primary green" onclick="getptwater();">获取该玩家PT流水</button><br>流水状态获取失败');
                //clearInterval(timer);
            }
        },
        cache: false
    });
}

function getptwater(){
    $.ajax({
        url: '/kzb/water/pt/member/'+_now_uid + "?r="+ Math.random(),
        type: 'post',
        dataType:'json',
        success: function (data) {
            //console.log(data);
            if (data.ok == 1) {
                //{ok:1, data: '1-进行中，5-玩家未参与PT平台，6-玩家不存在，0-提交成功'}

                if(data.data==5){
                    $("#limit").html('<button class="btn btn-primary green" onclick="getptwater();">获取该玩家PT流水</button><br>该用户还未获取过流水，或者还未创建PT账户');

                }
                if(data.data==6){
                    $("#limit").html('玩家不存在');

                }
                if(data.data==0||data.data==1){
                    $("#limit").html("提交成功");
                    //clearInterval(timer);
                    getstatus();
                }


            } else {
                $.notific8("流水获取提交失败");
            }
        },
        cache: false
    });
}

function checkwater(o) {
    otd = $(o).parent();

    $("#WCheckDetial").find("div[name=check]").find("tbody").html('<tr><td colspan="3">无流水限制</td></tr>');
    $("#WCheckDetial").find("div[name=water]").find("tbody").html('<tr><td colspan="3">无投注流水</td></tr>');
    var html = "";
    var dhtml = "";
    for (var x = 0; x < parseInt(otd.attr("index")) + 1; x++) {
        var d = checkdata[x];
        console.log(d['gpname']);
        var gpname = d['gpname'] == null ? "不限平台" : d['gpname'];
        var gpid = (d['gpid'] == null || d['gpid'] == 0) ? "MAIN" : d['gpid'];

        html += "<tr gpid='" + gpid + "' betamt='" + d['amount'] + "'>";
        html += "<td>" + gpname + "</td>";
        html += "<td>" + d['amount'] + "</td>";
        html += '<td><i gpid="' + gpid + '" class="fa fa-exclamation"></i></td>';
        html += "</tr>";
    }

    if(html!="")$("#WCheckDetial").find("div[name=check]").find("tbody").html(html);

    var thisid = checkdata.id;
    var thistime = checkdata[otd.attr("index")]['created'];

    $.get("/kzb/water/player/" + thisid + "/" + thistime, function (data) {
        //data = {"ok":1,"data":{"0":{"gpid":"38712217599873024","rtype":1,"gpname":"AG真人","water":[]},"1":{"gpid":"11964220589608960","rtype":1,"gpname":"MG电子游戏","water":[{"playerid":"286143374395136","betamt":"25.0000"}]},"2":{"gpid":"5707231341449216","rtype":1,"gpname":"Libianc快乐彩","water":[]},"3":{"gpid":"3277767810617344","rtype":1,"gpname":"GD真人","water":[{"playerid":"286143374395136","productid":"Baccarat","betamt":"100.00"}]},"4":{"gpid":"39500154618880","rtype":1,"gpname":"188真人","water":[]}}};

        if (data.ok == 1) {
            data = data.data;
            $.each(data, function (i, d) {
                $.each(d.water, function (ii, dd) {

                    dhtml += "<tr gpid='" + d.gpid + "' betamt='" + dd.betamt + "'>";
                    dhtml += "<td>" + d.gpname + "</td>";
                    dhtml += "<td>" + dd.betamt + "</td>";
                    dhtml += '<td><i class="fa fa-question"></i></td>';
                    dhtml += "</tr>";

                });
            });
            if(dhtml!="")$("#WCheckDetial").find("div[name=water]").find("tbody").html(dhtml);
            checkwaterDetial();
        } else {

            if (data.ok == 0) {
                if (typeof(data[0]) == "undefined") {
                    $("#WCheckDetial").find("div[name=water]").html("用户没有流水信息");
                } else {
                    $("#WCheckDetial").find("div[name=water]").html("没有数据，请重新检查。");
                }
            } else {
                $("#WCheckDetial").find("div[name=water]").html("没有数据，请重新检查。");
            }


        }
    });
}


function checkwaterDetial() {

    //while($("#WCheckDetial").find("div[name=check]").find("i.fa-exclamation").length>0||$("#WCheckDetial").find("div[name=water]").find("i.fa-question").length>0){
    doCheck();
    doCheck();
    doCheck();
    doCheck();
    doCheck();
    //}


    var alive = $("#WCheckDetial").find("div[name=check]").find("i.fa-exclamation");
    if (alive.length > 0) {
        alive.addClass("font-red");
    } else {
        $("#WCheckDetial").find("div[name=water]").find("i.fa-question").removeClass("fa-question").addClass("fa-check").addClass("font-green");
    }

}

function doCheck() {
    var trsa = $("#WCheckDetial").find("div[name=check]").find("tbody");
    var trsb = $("#WCheckDetial").find("div[name=water]").find("tbody").find("tr");

    trsb.each(function () {
        var tr = $(this);
        if(tr.find('td:first').attr('colspan')!="3"){
            var check_gpid = tr.attr("gpid");
            var check_betamt = tr.attr("betamt");
            var dick = trsa.find("tr[gpid='" + check_gpid + "'][betamt!='0']:first");
            if (dick.length == 0) {
                //dick = trsa.find("tr[gpid='10000'][check_betamt!='0']:first");
                dick = $("#WCheckDetial").find("div[name=check]").find("i.fa-exclamation[gpid='MAIN']:first").parent().parent();
            }

            var a = parseFloat(parseFloat(dick.attr("betamt")).toFixed(4));
            var b = parseFloat(parseFloat(tr.attr("betamt")).toFixed(4));

            if (a >= b) {
                tr.attr("betamt", 0);
                dick.attr("betamt", a - b);
                tr.find("td:last").html('<i class="fa fa-check font-green"></i>');
            } else {
                tr.attr("betamt", b - a);
                dick.attr("betamt", 0);
                dick.find("td:last").html('<i class="fa fa-check font-green"></i>');
            }
        }
    });

}

//通过某条流水条件 或者重启某条流水条件
function custom_endWater(wid,status){
    if(confirm("确定要清除本条流水条件？若需重启，需要到流水限制汇总操作。")){
        $.ajax({
        url :"/playerfund/changeflows",
        type:'post',
        data:{wid:wid,status:status,uid:_now_uid},
        success : function(data) {
                data = JSON.parse(data);
                if(data.c==0){
                    $.notific8("操作成功");
                }else{
                    $.notific8(errorMsg(data), {theme: 'ebony'});
                }
                getWList();
        },
        cache : false
        });
    }
}
