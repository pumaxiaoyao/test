/**
 * Created by cz on 15/6/4.
 */


var nowano = 0;

$(function(){
    $('#change_pwd_form').validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block help-block-error', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "", // validate all fields including form hidden input
        rules: {
            newpwd: {
                required: true,
                password:true
            },pwd:{
                required: true,
                password:true,
                equalTo:'#newpwd'
            }
        },
        messages:{
            pwd:{
                equalTo:'确认密码必须和新密码一致'
            }
        },

        errorPlacement: function (error, element) { // render error placement for each input type
            var icon = $(element).parent('.input-icon').children('i');
            icon.removeClass('fa-check').addClass("fa-warning");
            icon.attr("data-original-title", error.text()).tooltip({'container': 'body'});
        },

        highlight: function (element) { // hightlight error inputs
            $(element)
                .closest('.form-group').removeClass("has-success").addClass('has-error'); // set error class to the control group
        },

        unhighlight: function (element) { // revert the change done by hightlight

        },

        success: function (label, element) {
            var icon = $(element).parent('.input-icon').children('i');
            $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
            icon.removeClass("fa-warning").addClass("fa-check");
        }
    });
});

function init_pwd_form(ano){
    nowano = ano;
    var form = $('#change_pwd_form');
    $(form).find('i.fa-warning').removeClass('fa-warning');
    $(form).find('div.has-error').removeClass('has-error');
    $(form).find('i.fa-check').removeClass('fa-check');
    $(form).find('div.has-success').removeClass('has-success');
    $('#newpwd').val('');
    $('#pwd').val('');
}

function changepwd(o) {
    var flag = $('#change_pwd_form').valid();
    if(!flag){
        return false;
    }

    if (nowano == 0) {
        $(o).next().click();
    }
    $.blockUI();
    $.ajax({
        url: '/kzb/admin/vpkey',
        error: function () {
            notify('未知错误！');
        },
        success: function (rs) {
            var pwd = $("#newpwd").val();
            var rsaKey = new RSAKey();
            rsaKey.setPublic(b64tohex(rs.modulus), b64tohex(rs.exponent));
            pwd = hex2b64(rsaKey.encrypt(pwd));

            $.ajax({
                url: "/kzb/admin/pwdr",
                type: 'post',
                dataType: 'json',
                data: {ano: nowano, pwd: pwd},
                error: function () {
                    $.unblockUI();
                    $.notific8('密码修改失败', {theme: 'ebony'});
                },
                success: function (da) {
                    $.unblockUI();
                    if (da.c == 0) {

                        $.notific8('密码修改成功!');

                        $.get("/settings/kick?id=" + nowano, function () {
                            if (nowano == "<?=$adminid?>") {
                                window.location.href = "/account/login";
                            }
                        });
                        $(o).next().click();
                    } else {
                        $.notific8('密码修改失败', {theme: 'ebony'});
                    }
                }
            });
        }
    });
}

function changeStatus(o, ano, status,name) {
    if(confirm("请确定是否将‘"+name+"’的账号的状态修改为‘"+status+"’")){
        $.blockUI();
        $.ajax({
            url: "/kzb/admin/status",
            type: 'post',
            dataType: 'json',
            data: {ano: ano, status: status},
            error: function () {
                $.unblockUI();
                $.notific8('修改失败', {theme: 'ebony'});
            },
            success: function (da) {
                $.unblockUI();
                if (da.c == 0) {
                    $.notific8('修改成功!');
                    window.location.reload();
                } else {
                    $.notific8('修改失败', {theme: 'ebony'});
                }
            }
        });
    }
}