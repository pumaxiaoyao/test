    $(document).ready(function () {
    	$("#s_search").search({
    		"_fnCallback": function (resp) {
    			$('#data tbody > tr').find('td:eq(3)').css('text-align', 'right');
    			$("#total").text(resp.iTotalRecords);
    		}
    	});
    });

    function checkWater(_amount, _gpid, dno, uid, _gpname, _type) {
    	$("#WCheckDetial").find("div[name=water],div[name=check]").find("tbody").html('');
    	var html = "";
    	var dhtml = "";

    	var gpname = (_gpname == null || _gpname == '') ? "不限平台" : _gpname;
    	var _gpid = (_gpid == null || _gpid == 0) ? "MAIN" : _gpid;

    	html += "<tr gpid='" + _gpid + "' betamt='" + _amount + "'>";
    	html += "<td>" + gpname + "</td>";
    	html += "<td>" + _amount + "</td>";
    	html += '<td><i gpid="' + _gpid + '" class="fa fa-exclamation"></i></td>';
    	html += "</tr>";

    	$("#WCheckDetial").find("div[name=check]").find("tbody").append(html);

    	$.get("/playerfund/flowLimitOne?id=" + uid + "&dno=" + dno + "&ftype=" + _type, function (data) {
    		//data = {"ok":1,"data":{"0":{"gpid":"38712217599873024","rtype":1,"gpname":"AG真人","water":[]},"1":{"gpid":"11964220589608960","rtype":1,"gpname":"MG电子游戏","water":[{"playerid":"286143374395136","betamt":"25.0000"}]},"2":{"gpid":"5707231341449216","rtype":1,"gpname":"Libianc快乐彩","water":[]},"3":{"gpid":"3277767810617344","rtype":1,"gpname":"GD真人","water":[{"playerid":"286143374395136","productid":"Baccarat","betamt":"100.00"}]},"4":{"gpid":"39500154618880","rtype":1,"gpname":"188真人","water":[]}}};
    		data = JSON.parse(data);
    		if (data.ok == 1) {
    			data = data.data;
    			$.each(data, function (i, d) {
    				$.each(d.flows, function (ii, dd) {

    					dhtml += "<tr gpid='" + d.gpid + "' betamt='" + dd.betamt + "'>";
    					dhtml += "<td>" + d.gpname + "</td>";
    					dhtml += "<td>" + dd.betamt + "</td>";
    					dhtml += '<td><i class="fa fa-question"></i></td>';
    					dhtml += "</tr>";

    				});
    			});
    			$("#WCheckDetial").find("div[name=water]").find("tbody").append(dhtml);
    			checkwaterDetial();
    		} else {
    			$("#WCheckDetial").find("div[name=water]").html("没有数据，请重新检查。");
    		}
    	});
    }

    function checkwaterDetial() {
    	//while($("#WCheckDetial").find("div[name=check]").find("i.fa-exclamation").length==0||$("#WCheckDetial").find("div[name=water]").find("i.fa-question").length==0){
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
    		var check_gpid = tr.attr("gpid");
    		var check_betamt = tr.attr("betamt");
    		var dick = trsa.find("tr[gpid='" + check_gpid + "'][betamt!='0']:first");
    		if (dick.length == 0) {
    			//dick = trsa.find("tr[gpid='10000'][check_betamt!='0']:first");
    			dick = $("#WCheckDetial").find("div[name=check]").find("i.fa-exclamation[gpid='10000']:first").parent().parent();
    		}

    		var a = parseFloat(dick.attr("betamt"));
    		var b = parseFloat(tr.attr("betamt"));

    		if (a >= b) {
    			tr.attr("betamt", 0);
    			dick.attr("betamt", a - b);
    			tr.find("td:last").html('<i class="fa fa-check font-green"></i>');
    		} else {
    			tr.attr("betamt", b - a);
    			dick.attr("betamt", 0);
    			dick.find("td:last").html('<i class="fa fa-check font-green"></i>');
    		}
    	});

    }




    //通过某条流水条件 或者重启某条流水条件
    function endWater(wid, uid, status) {
    	$.ajax({
    		url: "/playerfund/changeflows",
    		type: 'post',
    		data: {
    			wid: wid,
    			uid: uid,
    			status: status
    		},
    		success: function (data) {
				data = JSON.parse(data);
    			if (data.c == 0) {
    				$.notific8("操作成功");
    			} else {
    				$.notific8(data.m, {
    					theme: 'ebony'
    				});
    			}
    			target[1].fnReloadAjax();
    		},
    		cache: false
    	});
    }



    function startEndAll(status) {
    	if ($("#data").find("input[name=list]:checked").length == 0) {
    		return false;
    	}
    	if (confirm("确定要操作这些流水条件吗？")) {
    		$.blockUI();
    		refuseAll(status);
    	}
    }

    function refuseAll(status) {
    	var o = $("#data").find("input[name=list]:checked:first");
		var wid = o.attr("wid");
		var uid = o.attr("uid");
		console.log(uid);
    	o.attr("checked", false);
    	if (o.attr('status') == status) {
    		refuseAll(status);
    		return false;
    	}
    	if (o.length == 0) {
    		$.unblockUI();
    		$.notific8('批量操作完毕，现在刷新页面。');
			target[1].fnReloadAjax();
			// window.location.reload();
    		return false;
    	}
    	$.ajax({
    		url: "/playerfund/changeflows",
    		type: 'post',
    		data: {
    			wid: wid,
    			uid: uid,
    			status: status
    		},
    		success: function (data) {
				data = JSON.parse(data);
    			if (data.c == 0) {
    				//window.location.reload();
    			} else {
    				$.notific8(data.m, {
    					theme: 'ebony'
    				});
    			}
    			refuseAll(status);
    		},
    		cache: false
    	});
    }

    $("#selectall").click(function () {
    	if ($(this).parent().hasClass("checked")) {
    		$("#data").find("input[name=list]").attr("checked", false);
    	} else {
    		$("#data").find("input[name=list]").attr("checked", true);
    	}
    });