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
        $.post("/player/login", { "action": 'login', "MemberName": username, "MemberPWD": password }, function (data) {
            var data = data.data;
            if (data[0]) {
                // cookiesEdit(username);
                window.top.location.href = "/index";
            } else {
                swal({ title: "", text: data[1], type: "error" });
            }
        }, "json");
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