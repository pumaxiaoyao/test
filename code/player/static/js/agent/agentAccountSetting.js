var phoneinterval = null;
var phonetimesec = 60;
var mailinterval = null;
var mailtimesec = 60;
$(function () {
    sidebarinit();
    pageinit();
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
        $.post("/agent/AccountSetting", {
            "action": "updateinformation",
            "FirstName": firstName,
            "isFristName": isFristName
        }, function (data) {
            var resp = data.data;
            if (resp[0]) {
                swal({
                    title: "",
                    text: "修改成功",
                    type: "success"
                }, function () {
                    location.reload();
                });
            } else {
                swal({ title: "", text: resp[1], type: "warning" });
            }
        }, "json");
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
            url: "AccountSetting",
            contentType: "application/json; charset=utf-8",
            data: {
                "action": "updatePassword",
                "oldPassword": oldpassword,
                "Password": password,
                "rePassword": repassword
            },
            dataType: "json",
            success: function (data) {
                var resp = data.data;
                if (resp[0]) {
                    swal({
                        title: "",
                        text: "修改成功",
                        type: "success"
                    }, function () {
                        location.reload();
                    });
                } else {
                    swal({ title: "", text: resp[1], type: "warning" });
                }
            },
            error: function (err) { }
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

        $.post("/agent/AccountSetting", {
            phoneNumber: phoneNumber,
            action: "getPhoneCode"
        }, function (recode) {
            var resp = recode.data;
            if (resp[0]) {
                var btId = "#GetPhoneCodeBt";
                $(btId).hide();
                $("#GetPhoneTime").show();
                phoneinterval = setInterval(function () {
                    setPhoneRemainingTime(btId)
                }, 1000);
                swal({
                    title: "",
                    text: resp[1],
                    type: "success"
                });
            } else {
                swal({
                    title: "",
                    text: resp[1],
                    type: "warning"
                });
            }
        }, "json");
    });

    $("#GetUnPhoneCodeBt").click(function () {
        $.post("/agent/AccountSetting", {
            action: "getUnPhoneCode"
        }, function (recode) {
            var resp = recode.data;
            if (resp[0]) {
                var btId = "#GetUnPhoneCodeBt";
                $(btId).hide();
                $("#GetPhoneTime").show();
                phoneinterval = setInterval(function () {
                    setPhoneRemainingTime(btId)
                }, 1000);
                swal({
                    title: "",
                    text: resp[1],
                    type: "success"
                });
            } else {
                swal({
                    title: "",
                    text: resp[1],
                    type: "warning"
                });
            }
        }, "json");
    });

    $("#GetUnEmailCodeBt").click(function () {

        $.post("AccountSetting", {
            action: "getUnEmailCode"
        }, function (recode) {
            var resp = recode.data;
            if (resp[0]) {
                var btId = "#GetUnEmailCodeBt";
                $(btId).hide();
                $("#GetEmailTime").show();
                mailinterval = setInterval(function () {
                    setMailRemainingTime(btId)
                }, 1000);
                swal({
                    title: "",
                    text: resp[1],
                    type: "success"
                });
            } else {
                swal({
                    title: "",
                    text: resp[1],
                    type: "warning"
                });
            }
        }, "json");
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

        $.post("AccountSetting", {
            mailNumber: mailnumber,
            action: "getEmailCode"
        }, function (recode) {
            var resp = recode.data;
            if (resp[0]) {
                var btId = "#GetEmailCodeBt";
                $(btId).hide();
                $("#GetEmailTime").show();
                mailinterval = setInterval(function () {
                    setMailRemainingTime(btId)
                }, 1000);
                swal({
                    title: "",
                    text: resp[1],
                    type: "success"
                });
            } else {
                swal({
                    title: "",
                    text: resp[1],
                    type: "warning"
                });
            }
        }, "json");
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
            url: "AccountSetting",
            contentType: "application/json; charset=utf-8",
            data: {
                phoneCode: code,
                action: "CheckPhoneCode"
            },
            dataType: "json",
            success: function (data) {
                var resp = data.data;
                if (resp[0]) {
                    swal({
                        title: "",
                        text: resp[1],
                        type: "success"
                    }, function () {
                        window.location.href = "AccountSetting?setting=phone";
                    });
                } else {
                    swal({
                        title: "",
                        text: resp[1],
                        type: "warning"
                    });
                }
            },
            error: function (err) { }
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
            url: "AccountSetting",
            contentType: "application/json; charset=utf-8",
            data: {
                action: "UnBindPhone",
                phoneCode: code
            },
            dataType: "json",
            success: function (data) {
                var resp = data.data;
                if (resp[0]) {
                    swal({
                        title: "",
                        text: resp[1],
                        type: "success"
                    }, function () {
                        window.location.href = "AccountSetting?setting=phone";
                    });
                } else {
                    swal({
                        title: "",
                        text: resp[1],
                        type: "warning"
                    });
                }
            },
            error: function (err) { }
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
            url: "AccountSetting",
            contentType: "application/json; charset=utf-8",
            data: {
                action: "CheckEmailCode",
                emailCode: code
            },
            dataType: "json",
            success: function (data) {
                var resp = data.data;
                if (resp[0]) {
                    swal({
                        title: "",
                        text: resp[1],
                        type: "success"
                    }, function () {
                        window.location.href = "AccountSetting?setting=mail";
                    });
                } else {
                    swal({
                        title: "",
                        text: resp[1],
                        type: "warning"
                    });
                }
            },
            error: function (err) { }
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
            url: "AccountSetting",
            contentType: "application/json; charset=utf-8",
            data: {
                action: "UnBindEmail",
                emailCode: code
            },
            dataType: "json",
            success: function (data) {
                var resp = data.data;
                if (resp[0]) {
                    swal({
                        title: "",
                        text: resp[1],
                        type: "success"
                    }, function () {
                        window.location.href = "AccountSetting?setting=mail";
                    });
                } else {
                    swal({
                        title: "",
                        text: resp[1],
                        type: "warning"
                    });
                }
            },
            error: function (err) { }
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


function sidebarinit() {
    var pathname = window.location.pathname;
    var paths = pathname.split("/");
    var cpath = null;
    if (paths.length > 0) {
        cpath = paths[paths.length - 1];
    }
    if (cpath != null) {
        selectSidebar(cpath);
    }
}

function selectSidebar(path) {
    var sidebars1 = {
        "memberReports": "left_nav_ck",
        "agentReports": "left_nav_tk",
        "benifitReports": "left_nav_zz"
    };
    var sidebars2 = {
        "agentWithdrawl": "left_nav_ck",
        "bankManager": "left_nav_tk"
    };
    var sidebars3 = {
        "AccountSetting": "left_nav_ck",
        "agentInfo": "left_nav_tk",
        "receivebox": "left_nav_zz"
    };

    for (var pname in sidebars1) {
        if (pname == path) {
            $(".left_nav_one").find("." + sidebars1[pname]).toggleClass("on");
        } else {
            $(".left_nav_one").find("." + sidebars1[pname]).removeClass("on");
        }
    }
    for (var pname in sidebars2) {
        if (pname == path) {
            $(".left_nav_two").find("." + sidebars2[pname]).toggleClass("on");
        } else {
            $(".left_nav_two").find("." + sidebars2[pname]).removeClass("on");
        }
    }

    for (var pname in sidebars3) {
        if (pname == path) {
            $(".left_nav_three").find("." + sidebars3[pname]).toggleClass("on");
            console.log("toggle on : " + sidebars3[pname] + " - " + pname);
        } else {
            $(".left_nav_three").find("." + sidebars3[pname]).removeClass("on");
        }
    }
}

function GetQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);
    if (r != null) return unescape(r[2]);
    return null;
}

function pageinit() {
    var settingactive = GetQueryString("setting");
    if (settingactive != null) {
        selectSettingBox(settingactive);
    } else {
        selectSettingBox("basicinfo");
    }
    if ($("#memberNamelab").html() != null && $("#memberNamelab").html() != "") {
        $("#as_info_save_name").hide();
        $("#FirstNamelab").html('注意：修改姓名请<a onclick="openServiceBox()">联系客服</a>');
    } else {
        $("#memberNamelab").hide();
    }
}

function selectSettingBox(type) {
    //选中菜单动画控制

    $(".as_menu_icon").attr("class", "as_triangle_down");
    $(".as_info").attr("class", "as_info");
    $("#setting_" + type + "_bt").attr("class", "as_info as_info_select");
    $("#setting_" + type + "_icon").attr("class", "as_menu_icon zx_icon as_" + type);

    $(".setting_box_div").hide();
    $("#setting_" + type + "_box").show();
}