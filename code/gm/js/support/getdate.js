/**
 * 获取本周、本季度、本月、上月的开始日期、结束日期
 */
var now = new Date(); //当前日期
var nowDayOfWeek = now.getDay(); //今天本周的第几天
var nowDay = now.getDate(); //当前日
var nowMonth = now.getMonth(); //当前月
var nowYear = now.getYear(); //当前年
nowYear += (nowYear < 2000) ? 1900 : 0; //
var lastMonthDate = new Date(); //上月日期
lastMonthDate.setDate(1);
lastMonthDate.setMonth(lastMonthDate.getMonth() - 1);
var lastYear = lastMonthDate.getFullYear();
var lastMonth = lastMonthDate.getMonth();
//格式化日期：yyyy-MM-dd
function formatDate(date) {
    var myyear = date.getFullYear();
    var mymonth = date.getMonth() + 1;
    var myweekday = date.getDate();
    if (mymonth < 10) {
        mymonth = "0" + mymonth;
    }
    if (myweekday < 10) {
        myweekday = "0" + myweekday;
    }
    return (myyear + "-" + mymonth + "-" + myweekday);
}
//格式化日期：yyyy-MM-dd
function formatDateD(date) {
    var myyear = date.getFullYear();
    var mymonth = date.getMonth() + 1;
    var myweekday = date.getDate();
    var hour = date.getHours();
    var minute = date.getMinutes();
    var second = date.getSeconds();
    if (mymonth < 10) {
        mymonth = "0" + mymonth;
    }
    if (myweekday < 10) {
        myweekday = "0" + myweekday;
    }
    if (hour < 10) {
        hour = "0" + hour;
    }
    if (minute < 10) {
        minute = "0" + minute;
    }
    if (second < 10) {
        second = "0" + second;
    }
    var ret = (myyear + "-" + mymonth + "-" + myweekday + " " + hour + ":" + minute + ":" + second);

    return ret;
}

//格式化日期：yyyy-MM-dd
function formatDateDW(date) {
    var myyear = date.getFullYear();
    var mymonth = date.getMonth() + 1;
    var myweekday = date.getDate();
    var hour = date.getHours();
    var minute = date.getMinutes();
    var second = date.getSeconds();

    var wd = date.getDay() //注:0-6对应为星期日到星期六 
    var xingqi;
    switch (wd) {
        case 0:
            xingqi = "星期日";
            break;
        case 1:
            xingqi = "星期一";
            break;
        case 2:
            xingqi = "星期二";
            break;
        case 3:
            xingqi = "星期三";
            break;
        case 4:
            xingqi = "星期四";
            break;
        case 5:
            xingqi = "星期五";
            break;
        case 6:
            xingqi = "星期六";
            break;
        default:
            xingqi = "系统错误！"
    }

    if (mymonth < 10) {
        mymonth = "0" + mymonth;
    }
    if (myweekday < 10) {
        myweekday = "0" + myweekday;
    }
    if (hour < 10) {
        hour = "0" + hour;
    }
    if (minute < 10) {
        minute = "0" + minute;
    }
    if (second < 10) {
        second = "0" + second;
    }
    if (second < 10) {
        second = "0" + second;
    }
    var ret = (myyear + "-" + mymonth + "-" + myweekday + " " + hour + ":" + minute + " " + xingqi);
    if (ret == "1970-01-01 星期四 08:00") ret = "";
    return ret;
}

//获得某月的天数
function getMonthDays(myMonth) {
    var monthStartDate = new Date(nowYear, myMonth, 1);
    var monthEndDate = new Date(nowYear, myMonth + 1, 1);
    var days = (monthEndDate - monthStartDate) / (1000 * 60 * 60 * 24);
    return days;
}
//获得本季度的开始月份
function getQuarterStartMonth() {
    var quarterStartMonth = 0;
    if (nowMonth < 3) {
        quarterStartMonth = 0;
    }
    if (2 < nowMonth && nowMonth < 6) {
        quarterStartMonth = 3;
    }
    if (5 < nowMonth && nowMonth < 9) {
        quarterStartMonth = 6;
    }
    if (nowMonth > 8) {
        quarterStartMonth = 9;
    }
    return quarterStartMonth;
}
//获得本周的开始日期
function getWeekStartDate() {
    var weekStartDate = new Date(nowYear, nowMonth, nowDay - nowDayOfWeek);
    return formatDate(weekStartDate);
}
//获得本周的结束日期
function getWeekEndDate() {
    var weekEndDate = new Date(nowYear, nowMonth, nowDay + (6 - nowDayOfWeek));
    return formatDate(weekEndDate);
}
//获得上周的开始日期
function getLastWeekStartDate() {
    var weekStartDate = new Date(nowYear, nowMonth, nowDay - nowDayOfWeek - 7);
    return formatDate(weekStartDate);
}
//获得上周的结束日期
function getLastWeekEndDate() {
    var weekEndDate = new Date(nowYear, nowMonth, nowDay - nowDayOfWeek - 1);
    return formatDate(weekEndDate);
}
//获得本月的开始日期
function getMonthStartDate() {
    var monthStartDate = new Date(nowYear, nowMonth, 1);
    return formatDate(monthStartDate);
}
//获得本月的结束日期
function getMonthEndDate() {
    var monthEndDate = new Date(nowYear, nowMonth, getMonthDays(nowMonth));
    return formatDate(monthEndDate);
}
//获得上月开始时间
function getLastMonthStartDate() {
    var lastMonthStartDate = new Date(lastYear, lastMonth, 1);
    return formatDate(lastMonthStartDate);
}
//获得上月结束时间
function getLastMonthEndDate() {
    var lastMonthEndDate = new Date(lastYear, lastMonth, getMonthDays(lastMonth));
    return formatDate(lastMonthEndDate);
}
//获得本季度的开始日期
function getQuarterStartDate() {
    var quarterStartDate = new Date(nowYear, getQuarterStartMonth(), 1);
    return formatDate(quarterStartDate);
}
//或的本季度的结束日期
function getQuarterEndDate() {
    var quarterEndMonth = getQuarterStartMonth() + 2;
    var quarterStartDate = new Date(nowYear, quarterEndMonth,
        getMonthDays(quarterEndMonth));
    return formatDate(quarterStartDate);
}

function getDate(day) {
    var zdate = new Date();
    var sdate = zdate.getTime() - (1 * 24 * 60 * 60 * 1000);
    var edate = new Date(sdate - (day * 24 * 60 * 60 * 1000));
    return formatDate(edate);
}
$(document).ready(function () {
    $('#s_StartTime').datetimepicker({
        format: 'yyyy-mm-dd hh:ii:ss',
        minView: 2
    }).on('changeDate', function (ev) {
        // $('#s_StartTime').val($('#s_StartTime').val() + " 00:00:00");
        var s_StartTime = $('#s_StartTime').val();
        $('#s_EndTime').datetimepicker('setStartDate', s_StartTime).datetimepicker('show');
        $('#s_StartTime').datetimepicker('hide');
        $('#s_StartTime').val($('#s_StartTime').val().split(" ")[0] + " 00:00:00");
    });
    $('#s_EndTime').datetimepicker({
        format: 'yyyy-mm-dd hh:ii:ss',
        minView: 2
    }).on('changeDate', function (ev) {
        $('#s_EndTime').datetimepicker('hide');
        $('#s_EndTime').val($('#s_EndTime').val().split(" ")[0] + " 23:59:59");
    });
    $("#s_TimeFli").change(function () {
        if (this.value == "ClearDate") {
            $("#s_StartTime").val('');
            $("#s_EndTime").val('');
        }
        if (this.value == "LastWeek") {
            var s = getLastWeekStartDate() + " 00:00:00",
                e = getLastWeekEndDate() + " 23:59:59";
            $("#s_StartTime").val(s);
            $("#s_EndTime").val(e);
            //$('#s_StartTime').datetimepicker('setEndDate',s);
            $('#s_EndTime').datetimepicker('setStartDate', e);
        }
        if (this.value == "LastMonth") {
            var s = getLastMonthStartDate() + " 00:00:00",
                e = getLastMonthEndDate() + " 23:59:59";
            $("#s_StartTime").val(s);
            $("#s_EndTime").val(e);
            //$('#s_StartTime').datetimepicker('setEndDate',s);
            $('#s_EndTime').datetimepicker('setStartDate', e);
        }
        if (this.value == "Yesterday") {
            var s = getDate(0) + " 00:00:00",
                e = getDate(0) + " 23:59:59";
            $("#s_StartTime").val(s);
            $("#s_EndTime").val(e);
            //$('#s_StartTime').datetimepicker('setEndDate',s);
            $('#s_EndTime').datetimepicker('setStartDate', e);
        }
        if (this.value == "Today") {
            var s = getDate(-1) + " 00:00:00",
                e = getDate(-1) + " 23:59:59";
            $("#s_StartTime").val(s);
            $("#s_EndTime").val(e);
            //$('#s_StartTime').datetimepicker('setEndDate',s);
            $('#s_EndTime').datetimepicker('setStartDate', e);
        }
    });
});

function set_btype(v) {
    var btype = "";
    $("input[name=fs_btype]:checked").each(function () {
        if (btype != "") {
            btype = btype + ",";
        }
        btype = btype + $(this).val();
    });
    $("#s_btype").val(btype);
}