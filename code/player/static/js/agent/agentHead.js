var phoneinterval = null;
var phonetimesec = 60;
var mailinterval = null;
var mailtimesec = 60;

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
           window.location.replace("/agent/agents/index");
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

    if (pageName() == "agentAccount"){
        if (LastPhoneCode) {
            var btId = "#GetPhoneCodeBt";
            $(btId).hide();
            $("#GetPhoneTime").show();
            phonetimesec = PhoneCodeInterval;
            phoneinterval = setInterval(function () {
                setPhoneRemainingTime(btId)
            }, 1000);
        }
    
        if (LastUnPhoneCode) {
            var btId = "#GetUnPhoneCodeBt";
            $(btId).hide();
            $("#GetPhoneTime").show();
            phonetimesec = UnPhoneCodeInterval;
            phoneinterval = setInterval(function () {
                setPhoneRemainingTime(btId)
            }, 1000);
        }
    
        if (LastMailCode) {
            var btId = "#GetEmailCodeBt";
            $(btId).hide();
            $("#GetEmailTime").show();
            mailtimesec = MailCodeInterval;
            mailinterval = setInterval(function () {
                setMailRemainingTime(btId)
            }, 1000);
        }
    
        if (LastUnMailCode) {
            var btId = "#GetUnEmailCodeBt";
            $(btId).hide();
            $("#GetEmailTime").show();
            mailtimesec = UnMailCodeInterval;
            mailinterval = setInterval(function () {
                setMailRemainingTime(btId)
            }, 1000);
        }
    }
    
    if (!placeholderSupport()) { // 判断浏览器是否支持 placeholder
        $("#jpwd").attr("placeholder", "请输入密码 ");
        $('[placeholder]').focus(function () {
            var input = $(this);
            if (input.val() == input.attr('placeholder')) {
                input.val('');
                input.removeClass('placeholder');
            }
        }).blur(function () {
            var input = $(this);
            if (input.val() == '' || input.val() == input.attr('placeholder')) {
                input.addClass('placeholder');
                input.val(input.attr('placeholder'));
            }
        }).blur();
    };

    $("#setting_history_box").delegate('#choose', "change", function () {
        console.log(this.value);
        if (this.value == "ClearDate") {
            var s = '',
                e = '';
        }

        if (this.value == "month") {
            var s = GetDateStr(-30),
                e = GetDateStr(0);
        }

        if (this.value == "week") {
            var s = GetDateStr(-7),
                e = GetDateStr(0);
        }

        if (this.value == "3days") {
            var s = GetDateStr(-4),
                e = GetDateStr(0);
        }

        if (this.value == "today") {
            var s = GetDateStr(0),
                e = GetDateStr(0);
        }

        $('#setting_history_box').find('input#betstartdate').val(s);
        $('#setting_history_box').find('input#betenddate').val(e);
        console.log(s);
        console.log(e);
        console.log($('#setting_history_box').find('input#betstartdate').val());
        console.log($('#setting_history_box').find('input#betenddate').val());
    });

    $("#information_bt").click(function () {
        var firstName = $("#FirstName").val();
        var isFristName = $("#isFristName").val();
        if (firstName == null && firstName == "") {
            swal({
                title: "",
                text: "姓名不能为空",
                type: "warning"
            });
            return false;
        }
        $.post("/agent/agents/agentAccount", {
            "action": "updateinformation",
            "FirstName": firstName,
            "isFristName": isFristName
        }, function (data) {
            data = JSON.parse(data);
            if (data.code == 200) {
                swal({
                    title: "",
                    text: "修改成功",
                    type: "success"
                }, function () {
                    location.reload();
                });
            } else {
                errorHandler(data);
            }
        });
    });

    $("#setting_pwd_box_submit").click(function () {
        var oldpassword = $("#setting_pwd_box_oldpwd").val();
        var password = $("#setting_pwd_box_newpwd").val();
        var repassword = $("#setting_pwd_box_newpwd2").val();

        if (oldpassword == null || oldpassword == "") {
            swal({
                title: "",
                text: "请输入原密码",
                type: "warning"
            });
            return false;
        }
        if (password == null || password == "") {
            swal({
                title: "",
                text: "请输入新密码",
                type: "warning"
            });
            return false;
        }

        if (repassword == null || repassword == "") {
            swal({
                title: "",
                text: "请再次输入新密码",
                type: "warning"
            });
            return false;
        }

        var pwdreg = new RegExp("^.{8,20}$");
        if (!pwdreg.test(oldpassword) || !pwdreg.test(password) || !pwdreg.test(repassword)) {
            swal({
                title: "",
                text: "请输入8到20字符!",
                type: "warning"
            });
            return false;
        }

        if (password != repassword) {
            swal({
                title: "",
                text: "两次输入的密码不一致!",
                type: "warning"
            });
            return false;
        }
        $.ajax({
            type: "post",
            url: "agentAccount",
            contentType: "application/json; charset=utf-8",
            data: {
                "action": "UpdatePassword",
                "oldPassword": oldpassword,
                "Password": password,
                "rePassword": repassword
            },
            dataType: "json",
            success: function (data) {
                if (data.code == 200) {
                    swal({
                        title: "",
                        text: data.Message,
                        type: "success"
                    }, function () {
                        location.reload();
                    });
                } else {
                    errorHandler(data);
                }
            },
            error: function (err) {}
        }, 'json');
    });

    $("#GetPhoneCodeBt").click(function () {

        var phoneNumber = $("#setting_phone_box_phonenumber").val();
        if (phoneNumber == null || phoneNumber == "") {
            swal({
                title: "",
                text: "手机号码不能为空",
                type: "warning"
            });
            return false;
        }

        if (!(/^1[34578]\d{9}$/.test(phoneNumber))) {
            swal({
                title: "",
                text: "输入的手机格式不正确",
                type: "warning"
            });
            return false;
        }

        $.post("/agent/agents/agentAccount", {
            phoneNumber: phoneNumber,
            action: "getPhoneCode"
        }, function (recode) {
            recode = JSON.parse(recode);
            if (recode.code == 200) {
                var btId = "#GetPhoneCodeBt";
                $(btId).hide();
                $("#GetPhoneTime").show();
                phoneinterval = setInterval(function () {
                    setPhoneRemainingTime(btId)
                }, 1000);
                swal({
                    title: "",
                    text: recode.Message,
                    type: "success"
                });
            } else if (recode.code == 501) {
                swal({
                    title: "",
                    text: "该手机号码已绑定，请使用其他号码绑定！",
                    type: "warning"
                });
            } else if (recode.code == 502) {
                swal({
                    title: "",
                    text: "您的手机号是绑定状态,不需要再绑定",
                    type: "warning"
                });
            } else if (recode.code == 504) {
                swal({
                    title: "",
                    text: "手机号码不能为空",
                    type: "warning"
                });
            } else if (recode.code == 506) {
                swal({
                    title: "",
                    text: "输入的手机格式不正确",
                    type: "warning"
                });
            } else if (recode.code == 508) {
                swal({
                    title: "",
                    text: "申请失败",
                    type: "warning"
                });
            } else if (recode.code == 560) {
                swal({
                    title: "",
                    text: "60秒内只能发送一次验证码，请勿重复操作。",
                    type: "warning"
                });
            } else if (recode.code == 404) {
                var btId = "#GetPhoneCodeBt";
                $(btId).hide();
                $("#GetPhoneTime").show();
                phonetimesec = recode.Time;
                phoneinterval = setInterval(function () {
                    setPhoneRemainingTime(btId)
                }, 1000);
                swal({
                    title: "",
                    text: recode.Message,
                    type: "warning"
                });
            } else {
                errorHandler(recode);
            }
        });
    });

    $("#GetUnPhoneCodeBt").click(function () {
        $.post("/agent/agents/agentAccount", {
            action: "getUnPhoneCode"
        }, function (recode) {
            recode = JSON.parse(recode);
            if (recode.code == 200) {
                var btId = "#GetUnPhoneCodeBt";
                $(btId).hide();
                $("#GetPhoneTime").show();
                phoneinterval = setInterval(function () {
                    setPhoneRemainingTime(btId)
                }, 1000);
                swal({
                    title: "",
                    text: recode.Message,
                    type: "success"
                });
            } else if (recode.code == 509) {
                swal({
                    title: "",
                    text: "您还未绑定手机，请先绑定手机",
                    type: "warning"
                });
            } else if (recode.code == 504) {
                swal({
                    title: "",
                    text: "手机号码不能为空",
                    type: "warning"
                });
            } else if (recode.code == 506) {
                swal({
                    title: "",
                    text: "输入的手机格式不正确",
                    type: "warning"
                });
            } else if (recode.code == 508) {
                swal({
                    title: "",
                    text: "申请失败",
                    type: "warning"
                });
            } else if (recode.code == 560) {
                swal({
                    title: "",
                    text: "60秒内只能发送一次验证码，请勿重复操作。",
                    type: "warning"
                });
            } else if (recode.code == 404) {
                var btId = "#GetUnPhoneCodeBt";
                $(btId).hide();
                $("#GetPhoneTime").show();
                phonetimesec = recode.Time;
                phoneinterval = setInterval(function () {
                    setPhoneRemainingTime(btId)
                }, 1000);
                swal({
                    title: "",
                    text: recode.Message,
                    type: "warning"
                });
            } else {
                errorHandler(recode);
            }
        });
    });

    $("#GetUnEmailCodeBt").click(function () {

        $.post("agentAccount", {
            action: "getUnEmailCode"
        }, function (recode) {
            recode = JSON.parse(recode);
            if (recode.code == 200) {
                var btId = "#GetUnEmailCodeBt";
                $(btId).hide();
                $("#GetEmailTime").show();
                mailinterval = setInterval(function () {
                    setMailRemainingTime(btId)
                }, 1000);
                swal({
                    title: "",
                    text: recode.Message,
                    type: "success"
                });
            } else if (recode.code == 509) {
                swal({
                    title: "",
                    text: "您还未绑定邮箱，请先绑定邮箱",
                    type: "warning"
                });
            } else if (recode.code == 504) {
                swal({
                    title: "",
                    text: "邮箱不能为空",
                    type: "warning"
                });
            } else if (recode.code == 506) {
                swal({
                    title: "",
                    text: "输入的邮箱格式不正确",
                    type: "warning"
                });
            } else if (recode.code == 508) {
                swal({
                    title: "",
                    text: "申请失败",
                    type: "warning"
                });
            } else if (recode.code == 404) {
                var btId = "#GetUnEmailCodeBt";
                $(btId).hide();
                $("#GetEmailTime").show();
                mailinterval = setInterval(function () {
                    setMailRemainingTime(btId)
                }, 1000);
                swal({
                    title: "",
                    text: recode.Message,
                    type: "warning"
                });
            } else {
                errorHandler(recode);
            }
        });
    });

    $("#GetEmailCodeBt").click(function () {
        var mailnumber = $("#setting_mail_box_mailnumber").val();
        if (mailnumber == null || mailnumber == "") {
            swal({
                title: "",
                text: "邮箱号码不能为空",
                type: "warning"
            });
            return false;
        }
        var reg = new RegExp("^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$");
        if (!reg.test(mailnumber)) {
            swal({
                title: "",
                text: "输入的邮箱格式不正确",
                type: "warning"
            });
            return false;
        }

        $.post("agentAccount", {
            mailNumber: mailnumber,
            action: "getEmailCode"
        }, function (recode) {
            recode = JSON.parse(recode);
            if (recode.code == 200) {
                var btId = "#GetEmailCodeBt";
                $(btId).hide();
                $("#GetEmailTime").show();
                mailinterval = setInterval(function () {
                    setMailRemainingTime(btId)
                }, 1000);
                swal({
                    title: "",
                    text: recode.Message,
                    type: "success"
                });
            } else if (recode.code == 501) {
                swal({
                    title: "",
                    text: "该邮箱号码已绑定，请使用其他号码绑定！",
                    type: "warning"
                });
            } else if (recode.code == 502) {
                swal({
                    title: "",
                    text: "您的邮箱号是绑定状态,不需要再绑定",
                    type: "warning"
                });
            } else if (recode.code == 504) {
                swal({
                    title: "",
                    text: "邮箱号码不能为空",
                    type: "warning"
                });
            } else if (recode.code == 506) {
                swal({
                    title: "",
                    text: "输入的邮箱格式不正确",
                    type: "warning"
                });
            } else if (recode.code == 508) {
                swal({
                    title: "",
                    text: "申请失败",
                    type: "warning"
                });
            } else if (recode.code == 404) {
                var btId = "#GetEmailCodeBt";
                $(btId).hide();
                $("#GetEmailTime").show();
                mailtimesec = recode.Time;
                mailinterval = setInterval(function () {
                    setMailRemainingTime(btId)
                }, 1000);
                swal({
                    title: "",
                    text: recode.Message,
                    type: "warning"
                });
            } else {
                errorHandler(recode);
            }
        });
    });

    $("#setting_phone_box_submit").click(function () {
        var code = $("#setting_phone_box_code").val();

        if (code == null || code == "") {
            swal({
                title: "",
                text: "请输入验证码",
                type: "warning"
            });
            return;
        }

        $.ajax({
            type: "post",
            url: "agentAccount",
            contentType: "application/json; charset=utf-8",
            data: {
                phoneCode: code,
                action: "CheckPhoneCode"
            },
            dataType: "json",
            success: function (data) {
                if (data.code == 200) {
                    swal({
                        title: "",
                        text: data.Message,
                        type: "success"
                    }, function () {
                        window.location.href = "agentAccount?setting=phone";
                    });
                } else {
                    errorHandler(data);
                }
            },
            error: function (err) {}
        }, 'json');
    });

    $("#re_phone").click(function () {
        var code = $("#re_phone_code").val();

        if (code == null || code == "") {
            swal({
                title: "",
                text: "请输入验证码",
                type: "warning"
            });
            return;
        }

        $.ajax({
            type: "post",
            url: "agentAccount",
            contentType: "application/json; charset=utf-8",
            data: {
                action: "UnBindPhone",
                phoneCode: code
            },
            dataType: "json",
            success: function (data) {

                if (data.code == 200) {
                    swal({
                        title: "",
                        text: data.Message,
                        type: "success"
                    }, function () {
                        window.location.href = "agentAccount?setting=phone";
                    });
                } else {
                    errorHandler(data);
                }
            },
            error: function (err) {}
        }, 'json');
    });

    $("#setting_mail_box_submit").click(function () {
        var code = $("#setting_mail_box_code").val();

        if (code == null || code == "") {
            swal({
                title: "",
                text: "请输入验证码",
                type: "warning"
            });
            return;
        }

        $.ajax({
            type: "post",
            url: "agentAccount",
            contentType: "application/json; charset=utf-8",
            data: {
                action: "CheckEmailCode",
                emailCode: code
            },
            dataType: "json",
            success: function (data) {
                if (data.code == 200) {
                    swal({
                        title: "",
                        text: data.Message,
                        type: "success"
                    }, function () {
                        window.location.href = "agentAccount?setting=mail";
                    });
                } else {
                    errorHandler(data);
                }
            },
            error: function (err) {}
        }, 'json');
    });

    $("#re_email").click(function () {
        var code = $("#re_email_code").val();

        if (code == null || code == "") {
            swal({
                title: "",
                text: "请输入验证码",
                type: "warning"
            });
            return;
        }

        $.ajax({
            type: "post",
            url: "agentAccount",
            contentType: "application/json; charset=utf-8",
            data: {
                action: "UnBindEmail",
                emailCode: code
            },
            dataType: "json",
            success: function (data) {
                if (data.code == 200) {
                    swal({
                        title: "",
                        text: data.Message,
                        type: "success"
                    }, function () {
                        window.location.href = "agentAccount?setting=mail";
                    });
                } else {
                    errorHandler(data);
                }
            },
            error: function (err) {}
        }, 'json');
    });

    $("#change_phone_bt").click(function () {
        $("#ismobile_box").hide();
        $("#remobile_box").show();
    });

    $("#change_email_bt").click(function () {
        $("#isemail_box").hide();
        $("#reemail_box").show();
    });
});

function GetDateStr(AddDayCount) {     
    var dd = new Date();    
    dd.setDate(dd.getDate()+AddDayCount);//获取AddDayCount天后的日期    
    var y = dd.getFullYear();     
    var m = (dd.getMonth()+1)<10?"0"+(dd.getMonth()+1):(dd.getMonth()+1);//获取当前月份的日期，不足10补0    
    var d = dd.getDate()<10?"0"+dd.getDate():dd.getDate();//获取当前几号，不足10补0    
    return y+"-"+m+"-"+d;     
 }   

function setPhoneRemainingTime(btId) {
    phonetimesec--;
    if (phonetimesec < 0) {
        clearInterval(phoneinterval);
        phoneinterval = null;
        $(btId).show();
        $("#GetPhoneTime").hide();
        phonetimesec = 60;
        $("#phoneTiming").html(60);
        return;
    }

    $("#phoneTiming").html(phonetimesec);
}

function setMailRemainingTime(btId) {
    mailtimesec--;
    if (mailtimesec < 0) {
        clearInterval(mailinterval);
        mailinterval = null;
        $(btId).show();
        $("#GetEmailTime").hide();
        mailtimesec = 60;
        $("#emailTiming").html(60);
        return;
    }

    $("#emailTiming").html(mailtimesec);
}

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
        url: '/agent/agents/logout?r=' + Math.random(),
        type: 'post',
        dataType: 'json',
        success: function (da) {
            if (da.code == 200) {
                window.location.href = '/agent/agents/index';
            } else {
                swal({
                    title: "",
                    text: da.Message,
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
        url: '/agent/agents/login?r=' + Math.random(),
        type: 'post',
        dataType: 'json',
        data: data,
        error: function () {
            enable_login(login_btn, agent_login);
        },
        success: function (da) {
            enable_login(login_btn, agent_login);
            if (da.code == 200) {
                //window.location.reload();
                window.location.href = '/agent/agents/agentAccount';
            } else if (da.code == 1007) {
                swal({
                    title: "",
                    text: "用户名或密码错误，您还可以尝试" + da.m + "次。",
                    type: "error"
                });
            } else if (da.code == 1000) {
                swal({
                    title: "",
                    text: da.Message,
                    type: "error"
                });
            } else {
                swal({
                    title: "",
                    text: da.Message,
                    type: "error"
                });
            }
        }
    })
    // });
    // }
    // });
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


function searchMember() {

    var st = $('#setting_memberlist_box').find('input#startdate').val();
    var et = $('#setting_memberlist_box').find('input#enddate').val();
    
    var data = {
        "startdate": st,
        "enddate": et
    };
    console.log("data is " ,data);
    $.ajax({
        url: '/agent/agents/memberlistAjax',
        type: 'post',
        dataType: 'json',
        data: data,
        success: function (da) {
            if (da.code == 200) {
                $("#membercount").html(da.count);
                $("#MemberReportData").find("tbody").html(da.content);
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
        url: '/agent/agents/betHistoryAjax',
        type: 'post',
        dataType: 'json',
        data: data,
        success: function (da) {
            if (da.code == 200) {
                $("#historyRecordData").find("tbody").html(da.content);
            } else {
                $("#historyRecordData").find("tbody").html("");
            }
        }
    });
}
function searchAgentReport() {
    console.log("click on agent reports.");
    // $.ajax({
    //     url: '/agent/agents/wdHistoryAjax',
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
        url: '/agent/agents/wdHistoryAjax',
        type: 'post',
        success: function (da) {
            da = JSON.parse(da);
            if (da.code == 200) {
                $("#wdHistoryData").find("tbody").html(da.content);
            } else {
                $("#wdHistoryData").find("tbody").html("");
            }
        }
    });
}

function searchBenifitReport() {
    $.ajax({
        url: '/agent/agents/benifitreportAjax',
        type: 'post',
        success: function (da) {
            da = JSON.parse(da);
            if (da.code == 200) {
                $("#benifitreportData").find("tbody").html(da.content);
            } else {
                $("#benifitreportData").find("tbody").html("");
            }
        }
    });
}

function searchAgentInfo() {
    $.ajax({
        url: '/agent/agents/agentInfoAjax',
        type: 'post',
        success: function (da) {
            da = JSON.parse(da);
            if (da.code == 200) {
                $("#agentinfoData").find("tbody").html(da.content);
                $("#agentCode").text("合营代码：" + da.agentCode);
            } else {
                $("#agentinfoData").find("tbody").html("");
            }
        }
    });
}

function searchDailyReport() {
    var st = $('#startdate').val();
    var et = $('#enddate').val();
    var data = {
        "startdate": st,
        "enddate": et
    };
    $.ajax({
        url: '/agent/agents/dailyreportAjax',
        type: 'post',
        dataType: 'json',
        data: data,
        success: function (da) {
            if (da.code == 200) {
                $("#DailyReportData").find("thead").html(da.title);
                $("#DailyReportData").find("tbody").html(da.content);
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