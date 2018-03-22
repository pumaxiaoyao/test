$(document).ready(function () {
	$("#s_search").search({
		"_fnCallback": function (resp) {
			$("#page_rake").text(resp.page_rake);
			$("#total_rake").text(resp.total_rake);
		}
	});

	// ppp();
});

function ppp() {
	$("#proc").find("#info").html("请等待");
	var proc = setInterval(function () {
		$.ajax({
			url: '/flow/getGrantList',
			type: 'post',
			dataType: 'json',
			success: function (data) {
				if (data.count == "0") {
					$("#proc").hide();
					clearInterval(proc);
				} else {
					$("#proc").show();
					if (data.pect == "100") {
						$("#proc").find("#info").html("上期(" + data.date + ")数据已生成完毕。");
						$("#proc").find(".progress").hide();
						clearInterval(proc);
					} else {
						$("#proc").find(".progress").show();
						var o = $("#proc").find(".progress-bar");
						o.attr("aria-valuenow", data.pect);
						o.css("width", parseInt(data.pect) + "%");
						$("#proc").find("#info").html("数据(" + data.date + ")生成中，当前进度" + data.pect + "%");
					}
				}
			},
			error: function (err) {
				$("#proc").hide();
				clearInterval(proc);
			},
			cache: false
		});
	}, 1000);
}



//生成返水单 /kzb/rakeback/player/task 参数 periodtype 值 1-表示按天，2-按周，先按天
function makewaterlist() {
	$.blockUI();
	$.ajax({
		url: '/flow/grantTask',
		type: 'post',
		success: function (data) {
			$.notific8("返水单生成任务提交成功");
			target[1].fnReloadAjax();
			// ppp();
			$.unblockUI();
		},
		error: function (err) {
			$.unblockUI();
		},
		cache: false
	});
}

//进行返水
//-/kzb/rakeback/player/rake 参数 sid - 上面1中生成的结算单ID，uid-玩家ID，ar- 1表示发放，0表示归零 ,2表示发放且不增加流水限制
function rake(sid, uid, gpid, ar) {
	var mul = 1;
	if (ar == 2) {
		mul = 0;
		ar = 1;
	}
	$.blockUI();
	$.ajax({
		url: '/flow/rake',
		data: {
			sid: sid,
			uid: uid,
			ar: ar,
			gpid: gpid,
			mul: mul
		},
		type: 'post',
		success: function (data) {
			$.unblockUI();
			if (ar == 1) {
				$.notific8("发放完成");
			} else {
				$.notific8("已返零", {
					theme: 'ebony'
				});
			}

			target[1].fnReloadAjax();
		},
		error: function (err) {
			$.unblockUI();
			target[1].fnReloadAjax();
		},
		cache: false
	});
}

$("#selectchk").click(function () {
	if ($(this).parent().hasClass("checked")) {
		$("input[name=rakes]").attr("checked", false);
	} else {
		$("input[name=rakes]").attr("checked", true);
	}
});

//批量支付
function rakeall() {
	$.blockUI();
	if ($("input[name=rakes]:checked").length == 0) {
		$.notific8("请选择需要发放的条目。", {
			theme: 'ebony'
		});
		$.unblockUI();
	} else {
		rakeone();
	}
}

function rakeone() {
	var o = $("input[name=rakes]:checked:first");
	if (o.length == 0) {
		$.unblockUI();
		$.notific8("发放完成");
		target[1].fnReloadAjax();
	} else {
		o.attr("checked", false);
		var ar = 1;
		var sid = o.attr("sid");
		var uid = o.attr("uid");
		var gpid = o.attr("gpid");
		$.ajax({
			url: '/flow/rake',
			data: {
				sid: sid,
				uid: uid,
				ar: ar,
				gpid: gpid
			},
			type: 'post',
			success: function (data) {
				rakeone();
			},
			error: function (err) {
				rakeone();
			},
			cache: false
		});
	}
}

function rakezeroall() {
	var o = $("input[name=rakes]:checked:first");
	if (o.length == 0) {
		$.unblockUI();
		$.notific8("返零处理完成", {
			theme: 'ebony'
		});
		$("#s_search").submit();
	} else {
		o.attr("checked", false);
		var ar = 0;
		var sid = o.attr("sid");
		var uid = o.attr("uid");
		var gpid = o.attr("gpid");
		$.ajax({
			url: '/flow/rake',
			data: {
				sid: sid,
				uid: uid,
				ar: ar,
				gpid: gpid
			},
			type: 'post',
			success: function (data) {
				rakezeroall();
			},
			error: function (err) {
				rakezeroall();
			},
			cache: false
		});
	}
}

function rakeallnopage(action) {
	var actionname = action == 1 ? '返水' : '返零';

	$.blockUI({
		message: "返水记录获取中"
	});
	if (confirm('确定要对当前所选用户层级的所有记录进行' + actionname + '操作吗，该行为不可逆。请确认。')) {
		$.ajax({
			url: '/flow/getRakeBackListALL',
			data: {
				groupid: $("#groupid").val()
			},
			type: 'post',
			dataType: 'json',
			success: function (data) {
				if (data.code == 200) {
					$.notific8("发放完成");
				} else {
					$.notific8("返水处理失败", {
						theme: 'ebony'
					});
				}
			}
		});

	}
	$.notific8("批量操作完成。");
	target[1].fnReloadAjax();
	$.unblockUI();
}



var alldata = 0;
var nowdata = 0;

function rakeallnopage11(action) {
	var actionname = action == 1 ? '返水' : '返零';
	nowdata = 0;

	$.blockUI({
		message: "返水记录获取中"
	});
	if (confirm('确定要对当前所选用户层级的所有记录进行' + actionname + '操作吗，该行为不可逆。请确认。')) {
		$.ajax({
			url: '/flow/getRakeBackListALL',
			data: {
				groupid: $("#groupid").val()
			},
			type: 'post',
			dataType: 'json',
			success: function (data) {
				alldata = data.length;
				$(data).each(function (i, v) {
					var sid = v.sid;
					var uid = v.playerid;
					var gpid = v.gpid;
					$(document).queue("ajaxRequests", function () {

						$.ajax({
							url: '/flow/rake',
							data: {
								sid: sid,
								uid: uid,
								ar: action,
								gpid: gpid
							},
							type: "POST",
							dataType: "json",
							success: function (_gf) {
								nowdata++;
								$(".blockPage").html("正在处理第" + nowdata + "条，共" + alldata + "条");
								$(document).dequeue("ajaxRequests");
							},
							error: function () {
								nowdata++;
								$(".blockPage").html("正在处理第" + nowdata + "条，共" + alldata + "条");
								$(document).dequeue("ajaxRequests");
							}
						});
					});
				});


				$(document).dequeue("ajaxRequests");
				$(document).queue("ajaxRequests", function () {
					$.notific8("批量操作完成。");
					target[1].fnReloadAjax();
					$.unblockUI();
				});


			},
			error: function (err) {
				$.unblockUI();
				$.notific8("获取返水数据失败。", {
					theme: 'ebony'
				});
			},
			cache: false
		});
	}
}