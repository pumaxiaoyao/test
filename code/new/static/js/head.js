
$(function () {
    $("#btn-logout").click(function () {
        $.post("/zh-cn/member/Login", { action: "logout" }, function (data) {
            window.location.reload();
        });
    });

    setTime();
    setInterval(function () {
        setTime();
    }, 1000);
    $(document).keypress(function (e) {
        // 回车键事件
        if (e.which == 13) {
            if ($("#head_username").val() != '' && $('#head_pwd').val() != '') {
                $("#head_btn_login").click();
            }
        }
    });
    $("#head_btn_login").click(function () {
        var username = $("#head_username").val();
        var password = $("#head_pwd").val();
        if (username == null || username == "") {
            swal({ title: "", text: "用户名不能为空", type: "warning" });
            return false;
        }
        if (password == null || password == "") {
            swal({ title: "", text: "密码不能为空", type: "warning" });
            return false;
        }
        $.post("/zh-cn/member/Login", { "action": 'login', "MemberName": username, "MemberPWD": password }, function (datas) {
            datas = JSON.parse(datas);
            console.log(datas);
            if (datas.code == 200) {
                cookiesEdit(username);
                window.top.location.href = "/zh-cn/index";
            }
            if (datas.code == 999 ) {
                swal({ title: "", text: datas.Message, type: "error" });
            }

            if (datas.code == 500 ) {
                swal({ title: "", text: datas.Message, type: "error" });
            }
            if (datas.code == 404) {
                swal({ title: "", text: "无法从后台获取数据，请确认服务器是否开启", type: "error" });
            }
            if (datas.code == 800) {
                swal({ title: "", text: "账号被锁,原因:" + status, type: "warning" });
            }
            if (datas.code == 888) {;
                swal({ title: "", text: "用户名或密码错误，你还可以尝试 " + datas.Message + " 次", type: "error" });
            }
        });
    });
});


//打开站内信窗口
function openMessage() {
    var sbwidth = ScrollBarWidth();
    if (sbwidth == 0) { return; }

    $("body").css({ "overflow": "hidden", "padding-right": sbwidth + "px" });
    //$(".m_pop").css({"display":"block"});
}

function openServiceBox() {
    window.open("https://lc.chat/now/8989490/", "beplay", "depended=yes,height=600,width=500");
}

//关闭站内信窗口
function closeMessage() {
    $("#popLoading").css({ "display": "block" });
    $("#msgIframe").attr("src", "");
    $("body").css({ "overflow": "auto", "padding-right": "0px" });
    $(".m_pop").css({ "display": "none" });
}
//站内信

function ScrollBarWidth() {
    if (this.HasScrollBar() == false) { return 0; }

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

function HasScrollBar() {
    if (document.documentElement.clientHeight < document.documentElement.offsetHeight) return true;
    return false;
}

jQuery(document).ready(function () {

    var qcloud = {};

    $('[_t_nav]').hover(function () {

        var _nav = $(this).attr('_t_nav');

        clearTimeout(qcloud[_nav + '_timer']);

        qcloud[_nav + '_timer'] = setTimeout(function () {

            $('[_t_nav]').each(function () {

                $(this)[_nav == $(this).attr('_t_nav') ? 'addClass' : 'removeClass']('on');

            });

            $('#' + _nav).stop(true, true).slideDown();

        }, 150);

    }, function () {

        var _nav = $(this).attr('_t_nav');

        clearTimeout(qcloud[_nav + '_timer']);

        qcloud[_nav + '_timer'] = setTimeout(function () {

            $('[_t_nav]').removeClass('on');

            $('#' + _nav).stop(true, true).slideUp();

        }, 150);

    });

});

function setTime() {
    var date = new Date();
    date.setTime(parseInt(Date.parse(beijingtime), 10) + 1000);
    beijingtime = date.toString();


    var year = date.getFullYear();
    var month = date.getMonth() + 1;
    var day = date.getDate();
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

function qrcode(name, url) {


}

