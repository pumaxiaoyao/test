/**
 * Created by cz on 15/9/1.
 */

$(document).ready(function () {

    $('#gpid').on('change', function () {
        $('#s_submit').click();
    });

    $("#s_search").search({
        '_fnCallback': function (data) {
            $('#pageBet').text(data.page_bet);
            $('#pageDiv').text(data.page_div);
            $('#pageWin').text(data.page_win);
            $('#pageFlows').text(data.page_flows);
            $('#totalBet').text(data.total_bet);
            $('#totalDiv').text(data.total_div);
            $('#totalWin').text(data.total_win);
            $('#validFlows').text(data.total_flows);
            $('.showTitle').tipsy();
            bind_status_btn();

            $("font[pk]").each(function (i) {
                if (i < 150) {
                    var o = $(this);
                    $.ajax({
                        url: '/site/getTeamInfo',
                        type: 'get',
                        data: {type: $(o).attr("pk"), id: $(o).html()},
                        cache: true,
                        error: function () {

                        },
                        success: function (data) {
                            $(o).html(data);
                            $(o).attr("pk", null);
                        }
                    });
                }
            });

            $("font[pk=league]").each(function (i) {
                $(this).parent().click(function () {
                    $(this).find("font[pk]").each(function () {
                        var o = $(this);
                        $.ajax({
                            url: '/site/getTeamInfo',
                            type: 'get',
                            data: {type: $(o).attr("pk"), id: $(o).html()},
                            cache: true,
                            error: function () {

                            },
                            success: function (data) {
                                $(o).html(data);
                                $(o).attr("pk", null);
                            }
                        });
                    });
                });
            });

            $('label[sxing=sxing]').each(function () {
                var lbl = $(this);
                $.post('/flow/sxingInfo', {info: lbl.attr('info')}, function (data) {
                    if (data) {
                        lbl.html(data.teamInfo);
                        var code = $(lbl).nextAll("label[code=code]:first");
                        if (code.length > 0) {
                            var id = code.attr("id");
                            if (id in data) {
                                code.text(data[id]);
                            }
                        }
                    }
                });
            });
        }
    });
    
    /* testing by ws */
    $("#s_search2").search({
        'tbId':'data2',
        's_search':'s_search2',
        '_fnCallback': function (data) {

            $('#pageBet').text(data.page_bet);
            $('#pageDiv').text(data.page_div);
            $('#pageWin').text(data.page_win);
            $('#pageFlows').text(data.page_flows);
            $('#rstatistic > label.label').text('');
            $('#rstatistic > i').show();
            $('#rstatistic > i').hide();
            $('#totalBet').text(data.total_bet);
            $('#totalDiv').text(data.total_div);
            $('#totalWin').text(data.total_win);
            $('#validFlows').text(data.total_flows);

            $('.showTitle').tipsy();
            bind_status_btn();
            // getWagerTotalInfo();
            
            $("font[pk]").each(function (i) {
                if (i < 150) {
                    var o = $(this);
                    $.ajax({
                        url: '/site/getTeamInfo',
                        type: 'get',
                        data: {type: $(o).attr("pk"), id: $(o).html()},
                        cache: true,
                        error: function () {

                        },
                        success: function (data) {
                            $(o).html(data);
                            $(o).attr("pk", null);
                        }
                    });
                }
            });
			
			 $("font[cmd]").each(function (i) {
                if (i < 150) {
                    var o = $(this);
                    $.ajax({
                        url: '/site/getCMDTeamInfo',
                        type: 'get',
                        data: {type: $(o).attr("cmd"), id: $(o).html()},
                        cache: true,
                        error: function () {

                        },
                        success: function (data) {
                            $(o).html(data);
                            $(o).attr("cmd", null);
                        }
                    });
                }
            });
			
            $("font[pk=league]").each(function (i) {
                $(this).parent().click(function () {
                    $(this).find("font[pk]").each(function () {
                        var o = $(this);
                        $.ajax({
                            url: '/site/getTeamInfo',
                            type: 'get',
                            data: {type: $(o).attr("pk"), id: $(o).html()},
                            cache: true,
                            error: function () {

                            },
                            success: function (data) {
                                $(o).html(data);
                                $(o).attr("pk", null);
                            }
                        });
                    });
                });
            });

            $('label[sxing=sxing]').each(function () {
                var lbl = $(this);
                $.post('/flow/sxingInfo', {info: lbl.attr('info')}, function (data) {
                    if (data) {
                        lbl.html(data.teamInfo);
                        var code = $(lbl).nextAll("label[code=code]:first");
                        if (code.length > 0) {
                            var id = code.attr("id");
                            if (id in data) {
                                code.text(data[id]);
                            }
                        }
                    }
                });
            });
        },
        "aoColumnDefs": [{
            "aTargets": [1],
            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                if(oData[0]!=0){
                    $(nTd).html('<span class="label label-info" style="cursor:pointer;" onclick="custom_getBalance(\''+sData[0]+'\',\''+sData[1]+'\')">'+sData[1]+'</span>');
                }else{
                    $(nTd).html('<span class="label label-info">'+sData[1]+'</span>');
                }
            }
        },{
            "aTargets": [6,7,8,9],
            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                $(nTd).html('<label style="color: '+sData[0]+'">'+sData[1]+'</label>');
            }
        },{
            "aTargets": [10],
            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                $(nTd).html('<label id="jno_'+sData[0]+'">'+sData[1]+'</label>');
            }
	},{
            "aTargets": [11],
            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                if (sData) {
                    console.log(sData);
                    $(nTd).html('<a cs="cs" class="btn btn-xs '+sData[0]+'" status="'+sData[1]+'" betno="'+sData[2]+'" gpid="'+sData[3]+'">'+sData[4]+'</a>');
                }
            }
	}]
    });
});

/* testing by ws */
function getWagerTotalInfo(){
    $.ajax({
        url :"/flow/wageredTotalAjax2",
        type:'post',
        dataType:'json',
        data: $('#s_search2').serialize(),
        success : function(d) {
            $('#rstatistic > i').hide();
            $('#totalBet').text(d.total_bet);
            $('#totalDiv').text(d.total_div);
            $('#totalWin').text(d.total_win);
            $('#validFlows').text(d.total_flows);
        },
        cache : false
    });
}

function bind_status_btn() {
    $('a[cs=cs]').on('click', function () {
        var status = $(this).attr('status');
        console.log(status);
        // status = status == 66 ? 99 : 66;
        var betno = $(this).attr('betno');
        var jno = $(this).attr('jno');
        var gpid = $(this).attr('gpid');
        var obj = $(this);
        $.post('/flow/changeFlow', {gp_id: gpid, betid: betno, status: status}, function (data) {
            data = JSON.parse(data);
            console.log(data);
            if (data.code == 200) {
                if (status == 66) {
                    $(obj).html('设为无效');
                    $(obj).attr('status', 99);
                    $('#jno_' + betno).html('有效');
                    $(obj).removeClass("green").addClass("red");
                    $.notific8("已将该条流水设置为有效");
                } else {
                    $(obj).html('设为有效');
                    $(obj).attr('status', 66);
                    $('#jno_' + betno).html('无效');
                    $(obj).removeClass("red").addClass("green");
                    $.notific8("已将该条流水设置为无效");
                }
            }
        });
    });
}


$("#TimeFli").change(function () {
    if (this.value == "ClearDate") {
        $("#start").val('');
        $("#end").val('');
    }

    if (this.value == "LastWeek") {
        var s = getLastWeekStartDate() + " 00:00:00", e = getLastWeekEndDate() + " 23:59:59";
        $("#start").val(s);
        $("#end").val(e);
    }

    if (this.value == "LastMonth") {
        var s = getLastMonthStartDate() + " 00:00:00", e = getLastMonthEndDate() + " 23:59:59";
        $("#start").val(s);
        $("#end").val(e);
    }

    if (this.value == "Yesterday") {
        var s = getDate(0) + " 00:00:00", e = getDate(0) + " 23:59:59";
        $("#start").val(s);
        $("#end").val(e);
    }

    if (this.value == "Today") {
        var s = getDate(-1) + " 00:00:00", e = getDate(-1) + " 23:59:59";
        $("#start").val(s);
        $("#end").val(e);
    }
});
