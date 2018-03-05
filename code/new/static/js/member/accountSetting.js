var phoneinterval = null;
var phonetimesec = 60;
var mailinterval = null;
var mailtimesec = 60;
$(function () {
    pageinit();
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


    $("#information_bt").click(function () {

        // var byear = $("#BYear").val();
        // var bmonth = $("#BMonth").val();
        // var bday = $("#BDay").val();

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
        // if (byear == null || byear == "") { swal({ title: "", text: "请输入年份", type: "warning" }); return false; }
        // if (bmonth == 0) { swal({ title: "", text: "请选择月份", type: "warning" }); return false; }
        // if (bday == null || bday == "") { swal({ title: "", text: "请输入日期", type: "warning" }); return false; }
        // if (isNaN(byear) || byear < 1900) { swal({ title: "", text: "请输入正确的年份", type: "warning" }); return false; }
        // if (isNaN(bday)) { swal({ title: "", text: "请输入正确的日期", type: "warning" }); return false; }

        $.post("/zh-cn/member/AccountSetting", {
            "action": "updateinformation",
            "FirstName": firstName,
            "isFristName": isFristName
        }, function (data) {
            // "BYear": byear, "BMonth": bmonth, "BDay": bday, "isFristName": isFristName }, function (data) {
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
            url: "AccountSetting",
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

        $.post("/zh-cn/member/AccountSetting", {
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
        $.post("/zh-cn/member/AccountSetting", {
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

        $.post("AccountSetting", {
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

        $.post("AccountSetting", {
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
            url: "AccountSetting",
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
                        window.location.href = "AccountSetting?setting=phone";
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
            url: "AccountSetting",
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
                        window.location.href = "AccountSetting?setting=phone";
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
            url: "AccountSetting",
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
                        window.location.href = "AccountSetting?setting=mail";
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
            url: "AccountSetting",
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
                        window.location.href = "AccountSetting?setting=mail";
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


function GetQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);
    if (r != null) return unescape(r[2]);
    return null;
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

function pageinit() {
    var settingactive = GetQueryString("setting");
    if (settingactive != null) {
        selectSettingBox(settingactive);
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