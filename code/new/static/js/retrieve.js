var phoneinterval = null;
var phonetimesec = 60;
var mailinterval = null;
var mailtimesec = 60;
$(function () {

    if (LastPhoneCode) {
        var btId = "#GetPhoneCodeBt";
        $(btId).hide();
        $("#GetPhoneTime").show();
        phonetimesec = PhoneCodeInterval;
        phoneinterval = setInterval(function () { setPhoneRemainingTime(btId) }, 1000);
    }
 
    if (LastMailCode) {
        var btId = "#GetEmailCodeBt";
        $(btId).hide();
        $("#GetEmailTime").show();
        mailtimesec = MailCodeInterval;
        mailinterval = setInterval(function () { setMailRemainingTime(btId) }, 1000);
    }
 

    $("#GetPhoneCodeBt").click(function () {

        var phoneNumber = $("#rest_phonenumber").val();
        if (phoneNumber == null || phoneNumber == "") {
            swal({ title: "", text: "手机号码不能为空", type: "warning" });
            return false;
        }
        var reg = new RegExp("^1[0-9]{10}$");
        if (!reg.test(phoneNumber)) {
            swal({ title: "", text: "输入的手机格式不正确", type: "warning" });
            return false;
        }

        $.post("/zh-cn/member/Retrieve", { phoneNumber: phoneNumber, action: "getPhoneCode"}, function (recode) {
            recode = JSON.parse(recode);
            if (recode.code == 200) {
                var btId = "#GetPhoneCodeBt";
                $(btId).hide();
                $("#GetPhoneTime").show();
                phoneinterval = setInterval(function () { setPhoneRemainingTime(btId) }, 1000);
                swal({ title: "", text: recode.Message, type: "success" });

            } else if (recode.code == 404){
                var btId = "#GetPhoneCodeBt";
                $(btId).hide();
                $("#GetPhoneTime").show();
                phonetimesec = recode.Time;
                phoneinterval = setInterval(function () { setPhoneRemainingTime(btId) }, 1000);
                swal({ title: "", text: recode.Message, type: "warning" });
            } else {
                swal({ title: "", text: recode.Message, type: "warning" });
            }
        });
    });

    $("#check_phonenumber").click(function () {
        var phoneCode = $("#rest_phonecode").val();
        if (phoneCode == null || phoneCode == "") {
            swal({ title: "", text: "请输入验证码", type: "warning" });
            return false;
        }

        $.post("/zh-cn/member/Retrieve", { phoneCode: phoneCode, action: "CheckPhoneCode"}, function (recode) {
            recode = JSON.parse(recode);
            if (recode.code == 200) {
                $('.find_pwd_line div').eq(1).addClass('on').siblings().removeClass('on');
                $('.find_pwd_step_one').hide();
                $('.find_pwd_step_two').show()
                // swal({ title: "", text: recode.Message, type: "success" });
            } else {
                swal({ title: "", text: recode.Message, type: "warning" });
            }
        });
    }); 
    $("#restpwd_submit").click(function () {
        var password = $("#rest_password").val();
        var comfpassword = $("#rest_comfpassword").val();
        if (password == null || password == "") {
            swal({ title: "", text: "请输入新密码", type: "warning" });
            return false;
        }
        
        if (comfpassword == null || comfpassword == "") {
            swal({ title: "", text: "请再次输入新密码", type: "warning" });
            return false;
        }

        var pwdreg = new RegExp("^.{8,20}$");
        if (!pwdreg.test(password)) {
            swal({ title: "", text: "请输入8到20字符!", type: "warning" });
            return false;
        }

        if (password != comfpassword) {
            swal({ title: "", text: "两次输入的密码不一致!", type: "warning" });
            return false;
        }
        $.post("/zh-cn/member/Retrieve", {action: "UpdatePassword", Password: password, rePassword: comfpassword }, function (recode) {
            recode = JSON.parse(recode);
            if (recode.code == 200) {
                $('.find_pwd_line div').eq(2).addClass('on').siblings().removeClass('on');
                $('.find_pwd_step_two').hide();
                $('.find_pwd_step_three').show()
                swal({ title: "", text: recode.Message, type: "success" });
            } else {
                swal({ title: "", text: recode, type: "warning" });
            }
        });
    });

    $("#GetEmailCodeBt").click(function () {
        var mailnumber = $("#rest_emailnumber").val();
        if (mailnumber == null || mailnumber == "") {
            swal({ title: "", text: "邮箱号码不能为空", type: "warning" });
            return false;
        }
        var reg = new RegExp("^[\\w\\.]+([-]\\w+)*@[A-Za-z0-9-_]+[\\.][A-Za-z0-9-_]");
        if (!reg.test(mailnumber)) {
            swal({ title: "", text: "输入的邮箱格式不正确", type: "warning" });
            return false;
        }

        $.post("/zh-cn/member/Retrieve", {action: "getEmailCode", mailNumber: mailnumber }, function (recode) {
            recode = JSON.parse(recode);
            if (recode.code == 200) {
                var btId = "#GetEmailCodeBt";
                $(btId).hide();
                $("#GetEmailTime").show();
                mailinterval = setInterval(function () { setMailRemainingTime(btId) }, 1000);
                swal({ title: "", text: recode.Message, type: "success" });
            } else if (recode.code == 404){
                var btId = "#GetEmailCodeBt";
                $(btId).hide();
                $("#GetEmailTime").show();
                mailtimesec = recode.Time;
                mailinterval = setInterval(function () { setMailRemainingTime(btId) }, 1000);
                swal({ title: "", text: recode.Message, type: "warning" });
            } else {
                swal({ title: "", text: recode.Message, type: "warning" });
            }
        });
    });

    $("#check_emailnumber").click(function () {
        var emailCode = $("#rest_emailcode").val();
        if (emailCode == null || emailCode == "") {
            swal({ title: "", text: "请输入验证码", type: "warning" });
            return false;
        }

        $.post("/zh-cn/member/Retrieve", {action: "CheckEmailCode",  emailCode: emailCode }, function (recode) {
            recode = JSON.parse(recode);
            if (recode.code == 200) {
                $('.find_pwd_line div').eq(1).addClass('on').siblings().removeClass('on');
                $('.find_pwd_step_one').hide();
                $('.find_pwd_step_two').show()
            } else if (recode.code == 404){
                var btId = "#GetEmailCodeBt";
                $(btId).hide();
                $("#GetEmailTime").show();
                mailtimesec = recode.Time;
                mailinterval = setInterval(function () { setMailRemainingTime(btId) }, 1000);
                swal({ title: "", text: recode.Message, type: "warning" });
            } else {
                swal({ title: "", text: recode.Message, type: "warning" });
            }
        });
    });
});
 
function setPhoneRemainingTime() {
    phonetimesec--;
    if (phonetimesec < 0) {
        clearInterval(phoneinterval);
        phoneinterval = null;
        $("#GetPhoneCodeBt").show();
        $("#GetPhoneTime").hide();
        phonetimesec = 60;
        $("#phoneTiming").html(60);
        return;
    }

    $("#phoneTiming").html(phonetimesec);
}
 
function setMailRemainingTime() {
    mailtimesec--;
    if (mailtimesec < 0) {
        clearInterval(mailinterval);
        mailinterval = null;
        $("#GetEmailCodeBt").show();
        $("#GetEmailTime").hide();
        mailtimesec = 60;
        $("#emailTiming").html(60);
        return;
    }

    $("#emailTiming").html(mailtimesec);
}