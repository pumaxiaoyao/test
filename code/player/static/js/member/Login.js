$(function () {

    $("#login_username").focus(function () {
        $("#login_username_error").hide();
    });
    $("#login_password").focus(function () {
        $("#login_password_error").hide();
    });
    $("#lg_submit").click(function () {
        var username = $("#login_username").val();
        var password = $("#login_password").val();
        if (username == null || username == "") {
            $("#login_username_error").show();
            return false;
        } else {
            $("#login_username_error").hide();
        }

        if (password == null || password == "") {
            $("#login_password_error").show();
            return false;
        } else {
            $("#login_password_error").hide();
        }
        $.post("/zh-cn/member/Login", { "action": 'login', "MemberName": username, "MemberPWD": password }, function (data) {
            //console.log(data);//{"d":{"status":{"code":"2","Message":"1111"},"row":null}}
            data = JSON.parse(data);
            if (data.code == 200) {
                cookiesEdit(username);
                window.top.location.href = "/zh-cn/index";
            }
            if (data.code == 500) {;
                swal({ title: "", text: data.Message, type: "error" });
            }
            if (data.code == 404) {;
                swal({ title: "", text: "无法从后台获取数据，请确认服务器是否开启", type: "error" });
            }
            if (data.code == "2" ) {
                swal({ title: "", text: "验证码错误", type: "error" });
            }
            if (data.code == "3") {
                swal({ title: "", text: "你已经输错3次密码，请1小时后再试", type: "error" });
            }
            if (data.code == "4") {
                swal({ title: "", text: "账号被锁,原因:" + status, type: "warning" });
            }
            if (data.code == "5") {;
                swal({ title: "", text: "用户名或密码错误，你还可以尝试 " + data.message + " 次", type: "error" });
            }
            
            
        });
    });

    $(document).keypress(function(e) {
        // 回车键事件
        if(e.which == 13) {

            if($("#login_username").val()!=''|| $("#login_password").val()!=''){
                    if($('.showSweetAlert').length!=1){
                        $("#lg_submit").click();
                    }



            }
        }
    });


});