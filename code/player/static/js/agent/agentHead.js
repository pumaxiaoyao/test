
//全局的ajax访问，处理ajax清求时session超时
$.ajaxSetup({
    contentType:"application/x-www-form-urlencoded;charset=utf-8",
    complete:function(XMLHttpRequest,textStatus){
       //通过XMLHttpRequest取得响应结果
       var res = XMLHttpRequest.responseText;
       try{
         var jsonData = JSON.parse(res);
         if(jsonData.code == 999){
           //如果超时就处理 ，指定要跳转的页面(比如登录页)
           alert(jsonData.Message);
           window.location.replace("/agent/index");
         }
       }catch(e){
       }
     }
  });
 

$(function () {

    $("body").keydown(function () {
        if (event.keyCode == "13") { //keyCode=13是回车键
            $('#agentlogin').click();
        }
    });
    setTime();
    setInterval(function () {
        setTime();
    }, 1000);

});


function errorHandler(data){
    if (data.code == 400) {
        swal({ title: "", text: data.Message, type: "error" });
    } else if (data.code == 500) {
        swal({ title: "", text: data.Message, type: "warning" });
    }else if (data.code == 999) {
        swal({ title: "", text: data.Message, type: "warning" }, function(){
            window.location.href = "/";
        });
    }
}

function disable_login(btn) {
    btn.off('click');
    btn.removeClass('log-btn').addClass('log-btn-disabled');
}

function enable_login(btn, fn) {
    btn.on('click', fn);
    btn.removeClass('log-btn-disabled').addClass('log-btn');
}



var code = {
    "999": "未登录",
    "1000": "登录已关闭",
    "1001": "用户名或密码格式有误",
    "1002": "用户名不存在或密码错误",
    "1003": "用户已被锁定",
    "1004": "登录服务异常，请联系客服",
    "1005": "登录失败，请重试",
    "1006": "密码错误次数过多，已锁定",
    "1007": "用户名或密码错误-1",
    "1008": "您的账户还未审核通过，请稍后再试或联系客服！"
};

function agent_logout() {
    $.ajax({
        url: '/agent/logout?r=' + Math.random(),
        type: 'post',
        dataType: 'json',
        success: function (da) {
            var resp = da.data;
            if (resp[0]) {
                window.location.href = '/agent/index';
            } else {
                swal({
                    title: "",
                    text: "已退出，是否返回首页",
                    type: "error"
                });
            }
        }
    })
}

function agent_login() {
    var login_btn = $("#agentlogin");
    console.log("ready to login.");
    disable_login(login_btn);
    // $.ajax({
    // url: '/service/vpkey',
    // error: function () {
    //     notify('未知错误！');
    //     enable_login(login_btn, member_login);
    // },
    // success: function (rs) {
    var pwd = $('#head_agentpwd').val();
    var name = $('#head_agentaccount').val();
    // var rsaKey = new RSAKey();
    // rsaKey.setPublic(b64tohex(rs.modulus), b64tohex(rs.exponent));
    // var enPassword = hex2b64(rsaKey.encrypt(pwd));
    var data = {
        "apwd": pwd, //enPassword,
        "aname": name
    };
    console.log(data);
    $.ajax({
        url: '/agent/login?r=' + Math.random(),
        type: 'post',
        dataType: 'json',
        data: data,
        error: function () {
            enable_login(login_btn, agent_login);
        },
        success: function (da) {
            enable_login(login_btn, agent_login);
            var resp = da.data;
            if (resp[0]) {
                //window.location.reload();
                window.location.href = '/agent/AccountSetting';
            } else {
                swal({
                    title: "",
                    text: resp[1],
                    type: "error"
                });
            }
        }
    }, "json");
}
//打开站内信窗口
function openMessage() {
    var sbwidth = ScrollBarWidth();
    if (sbwidth == 0) {
        return;
    }

    $("body").css({
        "overflow": "hidden",
        "padding-right": sbwidth + "px"
    });
    //$(".m_pop").css({"display":"block"});
}

function openServiceBox() {
    window.open("https://lc.chat/now/8989490/", "beplay", "depended=yes,height=600,width=500");
}

//关闭站内信窗口
function closeMessage() {
    $("#popLoading").css({
        "display": "block"
    });
    $("#msgIframe").attr("src", "");
    $("body").css({
        "overflow": "auto",
        "padding-right": "0px"
    });
    $(".m_pop").css({
        "display": "none"
    });
}
//站内信

function ScrollBarWidth() {
    if (this.HasScrollBar() == false) {
        return 0;
    }

    if (typeof this.sbwidth != "undefined") {
        return this.sbwidth;
    }

    var inner = document.createElement('p');
    inner.style.width = "100%";
    inner.style.height = "200px";

    var outer = document.createElement('div');
    outer.style.position = "absolute";
    outer.style.top = "0px";
    outer.style.left = "0px";
    outer.style.visibility = "hidden";
    outer.style.width = "200px";
    outer.style.height = "150px";
    outer.style.overflow = "hidden";
    outer.appendChild(inner);

    document.body.appendChild(outer);
    var w1 = inner.offsetWidth;
    outer.style.overflow = 'scroll';
    var w2 = inner.offsetWidth;
    if (w1 == w2) w2 = outer.clientWidth;

    document.body.removeChild(outer);

    this.sbwidth = (w1 - w2)
    return this.sbwidth;
}

// function pageinit() {
//     var settingactive = GetQueryString("setting");
//     if (settingactive != null) {
//         selectSettingBox(settingactive);
//     }
//     if ($("#memberNamelab").html() != null && $("#memberNamelab").html() != "") {
//         $("#as_info_save_name").hide();
//         $("#FirstNamelab").html('注意：修改姓名请<a onclick="openServiceBox()">联系客服</a>');
//     } else {
//         $("#memberNamelab").hide();
//     }
// }

// function selectSettingBox(type) {
//     //选中菜单动画控制

//     $(".as_menu_icon").attr("class", "as_triangle_down");
//     $(".as_info").attr("class", "as_info");
//     $("#setting_" + type + "_bt").attr("class", "as_info as_info_select");
//     $("#setting_" + type + "_icon").attr("class", "as_menu_icon zx_icon as_" + type);

//     $(".setting_box_div").hide();
//     $("#setting_" + type + "_box").show();
// }


function searchMember() {

    var st = $('#setting_memberlist_box').find('input#startdate').val();
    var et = $('#setting_memberlist_box').find('input#enddate').val();
    
    var data = {
        "startdate": st,
        "enddate": et
    };
    console.log("data is " ,data);
    $.ajax({
        url: '/agent/memberlistAjax',
        type: 'post',
        dataType: 'json',
        data: data,
        success: function (da) {
            var resp = da.data;
            if (resp[0]) {
                $("#membercount").html(resp[1]);
                $("#MemberReportData").find("tbody").html(resp[2]);
            } else {
                $("#membercount").html(0);
                $("#MemberReportData").find("tbody").html("");
            }
        }
    });
}

function searchHistoryRecord() {
    
    var acct = $('#setting_history_box').find('input#account').val();
    var plat = $('#setting_history_box').find('select#platform').val();
    var choose = $('#setting_history_box').find('select#choose').val();
    var st = $('#setting_history_box').find('input#startdate').val();
    var et = $('#setting_history_box').find('input#enddate').val();
    var data = {
        "account": acct,
        "platform": plat,
        "choose": choose,
        "startdate": st,
        "enddate": et
    };
    console.log("data is ", data);
    $.ajax({
        url: '/agent/betHistoryAjax',
        type: 'post',
        dataType: 'json',
        data: data,
        success: function (da) {
            var resp = da.data;
            if (resp[0]) {
                $("#historyRecordData").find("tbody").html(resp[1]);
            } else {
                $("#historyRecordData").find("tbody").html("");
            }
        }
    });
}
function searchAgentReport() {
    console.log("click on agent reports.");
    // $.ajax({
    //     url: '/agent/wdHistoryAjax',
    //     type: 'post',
    //     success: function (da) {
    //         da = JSON.parse(da);
    //         if (da.code == 200) {
    //             $("#wdHistoryData").find("tbody").html(da.content);
    //         } else {
    //             $("#wdHistoryData").find("tbody").html("");
    //         }
    //     }
    // });
}

function searchwdHistoryRecord() {
    $.ajax({
        url: '/agent/wdHistoryAjax',
        type: 'post',
        success: function (da) {
            da = JSON.parse(da);
            var resp = da.data;
            if (resp[0]) {
                $("#wdHistoryData").find("tbody").html(resp[1]);
            } else {
                $("#wdHistoryData").find("tbody").html("");
            }
        }
    });
}

function searchBenifitReport() {
    $.ajax({
        url: '/agent/benifitreportAjax',
        type: 'post',
        success: function (da) {
            da = JSON.parse(da);
            var resp = da.data;
            if (resp[0]) {
                $("#benifitreportData").find("tbody").html(resp[1]);
            } else {
                $("#benifitreportData").find("tbody").html("");
            }
        }
    }, "json");
}

function searchAgentInfo() {
    $.ajax({
        url: '/agent/agentInfoAjax',
        type: 'post',
        success: function (da) {
            da = JSON.parse(da);
            var resp = da.data;
            if (resp[0]) {
                $("#agentinfoData").find("tbody").html(resp[1]);
                $("#agentCode").text("合营代码：" + resp[2]);
            } else {
                $("#agentinfoData").find("tbody").html("");
                $("#agentCode").text("合营代码：");
            }
        }
    }, "json");
}

function searchDailyReport() {
    var st = $('#startdate').val();
    var et = $('#enddate').val();
    var data = {
        "startdate": st,
        "enddate": et
    };
    $.ajax({
        url: '/agent/dailyreportAjax',
        type: 'post',
        dataType: 'json',
        data: data,
        success: function (da) {
            var resp = da.data;
            if (resp[0]) {
                $("#DailyReportData").find("thead").html(resp[1]);
                $("#DailyReportData").find("tbody").html(resp[2]);
            } else {
                $("#DailyReportData").find("thead").html("");
                $("#DailyReportData").find("tbody").html("");
            }
        }
    });
}

function HasScrollBar() {
    if (document.documentElement.clientHeight < document.documentElement.offsetHeight) return true;
    return false;
}



var browser = {
    versions: function () {
        var u = navigator.userAgent,
            app = navigator.appVersion;
        return { //移动终端浏览器版本信息
            trident: u.indexOf('Trident') > -1, //IE内核
            presto: u.indexOf('Presto') > -1, //opera内核
            webKit: u.indexOf('AppleWebKit') > -1, //苹果、谷歌内核
            gecko: u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1, //火狐内核
            mobile: !!u.match(/AppleWebKit.*Mobile.*/), //是否为移动终端
            ios: !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/), //ios终端
            android: u.indexOf('Android') > -1 || u.indexOf('Linux') > -1, //android终端或者uc浏览器
            iPhone: u.indexOf('iPhone') > -1, //是否为iPhone或者QQHD浏览器
            iPad: u.indexOf('iPad') > -1, //是否iPad
            webApp: u.indexOf('Safari') == -1 //是否web应该程序，没有头部与底部
        };
    }(),
    language: (navigator.browserLanguage || navigator.language).toLowerCase()
}

function placeholderSupport() {
    return 'placeholder' in document.createElement('input');
}

function imgdragstart() {
    return false;
}
for (i in document.images) document.images[i].ondragstart = imgdragstart;


//悬浮窗 在线客服
//$(function(){
//   $('#sideContact .side-contact-close').click(function(){
//        $(this).parent().fadeOut(200);
//   })
//})
//
//var scrollanimate = null;
//if($("#sideContact").length>0){
//    $(window).bind("resize", function(){ //绑定事件     
//        adscroll(); 
//    }).bind("scroll", function(){ 
//        adscroll(); 
//    }); 
//}
//function adscroll(){
//   clearTimeout(scrollanimate);
//   scrollanimate =  setTimeout(function(){
//       var top = $(document).scrollTop()+200;
//       $("#sideContact").animate({top:top+'px'});
//   },30);
//}

function SetCookie(name, value) {
    var Days = 30;
    var exp = new Date();
    exp.setTime(exp.getTime() + Days * 24 * 60 * 60 * 1000);
    document.cookie = name + "=" + escape(value) + ";expires=" + exp.toGMTString() + ";";
}

function delCookie(name) {
    var exp = new Date();
    exp.setTime(exp.getTime() - 1);
    var cval = getCookie(name);
    if (cval != null) document.cookie = name + "=" + cval + ";expires=" + exp.toGMTString();
}

function getCookie(name) {
    var arr = document.cookie.match(new RegExp("(^| )" + name + "=([^;]*)(;|$)"));
    if (arr != null)
        return unescape(arr[2]);
    return null;
}

function setTime() {
    var date = new Date();
    date.setTime(parseInt(Date.parse(beijingtime), 10) + 1000);
    beijingtime = date.toString();

    var year = date.getFullYear();
    var month = date.getMonth() + 1;
    var day = date.getDate() ;
    var hours = date.getHours();
    var min = date.getMinutes();
    var second = date.getSeconds();

    month = month < 10 ? "0" + month : month;
    day = day < 10 ? "0" + day : day;
    hours = hours < 10 ? "0" + hours : hours;
    min = min < 10 ? "0" + min : min;
    second = second < 10 ? "0" + second : second;

    var dateStr = "<span>" + year + "-" + month + "-" + day + "</span>";
    var timeStr = "<span> " + hours + ":" + min + ":" + second + "</span>";

    $("#system_datetime").html("GMT+8 " + dateStr + timeStr);
}

/**
* 实时动态强制更改用户录入
**/
function amount(th){
    var regStrs = [
        ['^0(\\d+)$', '$1'], //禁止录入整数部分两位以上，但首位为0
        ['[^\\d\\.]+$',''], //禁止录入任何非数字和点
        ['\\.(\\d?)\\.+', '.$1'], //禁止录入两个以上的点
        ['^(\\d+\\.\\d{2}).+', '$1'] //禁止录入小数点后两位以上

    ];
    for(var i=0; i<regStrs.length; i++){
        var reg = new RegExp(regStrs[i][0]);
        th.value = th.value.replace(reg, regStrs[i][1]);
    }
    $('.tk_num span').find('b').removeClass('on');
    if ($(th).val() < 100) {
        $("#withdrawalMoney_tips").addClass("redtext");
    } else {
        $("#withdrawalMoney_tips").removeClass("redtext");
    }
    
}

function pageName() {
    var strUrl = location.href;
    var arrUrl = strUrl.split("/");
    var strPage = arrUrl[arrUrl.length - 1];
    return strPage;
}


/**
* 录入完成后，输入模式失去焦点后对录入进行判断并强制更改，并对小数点进行0补全
**/
function overFormat(th){
    var v = th.value;
    if(v === ''){
       // v = '0.00';
    }else if(v === '0'){
        v = '0.00';
    }else if(v === '0.'){
        v = '0.00';
    }else if(/^0+\d+\.?\d*.*$/.test(v)){
        v = v.replace(/^0+(\d+\.?\d*).*$/, '$1');
        v = inp.getRightPriceFormat(v).val;
    }else if(/^0\.\d$/.test(v)){
        v = v + '0';
    }else if(!/^\d+\.\d{2}$/.test(v)){
        if(/^\d+\.\d{2}.+/.test(v)){
            v = v.replace(/^(\d+\.\d{2}).*$/, '$1');
        }else if(/^\d+$/.test(v)){
            v = v + '.00';
        }else if(/^\d+\.$/.test(v)){
            v = v + '00';
        }else if(/^\d+\.\d$/.test(v)){
            v = v + '0';
        }else if(/^[^\d]+\d+\.?\d*$/.test(v)){
            v = v.replace(/^[^\d]+(\d+\.?\d*)$/, '$1');
        }else if(/\d+/.test(v)){
            v = v.replace(/^[^\d]*(\d+\.?\d*).*$/, '$1');
            ty = false;
        }else if(/^0+\d+\.?\d*$/.test(v)){
            v = v.replace(/^0+(\d+\.?\d*)$/, '$1');
            ty = false;
        }else{
            v = '0.00';
        }
    }
    th.value = v;
}