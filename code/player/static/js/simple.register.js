$(document).ready(function () {

    //       代理用户名"aname"
    //       密码"apwd"
    //       代理类型"atype"
    //       真名"realname"
    //       "email"
    //       性别"gender"
    //       "birthyear", "birthmonth", "birthday",
    // 手机"aphone"
    // 问题"qid"
    // 答案"aanswer"
    // 验证码"verifycode"
    // 计划"aplan",
    // 目标市场"amarket"
    // 推广站点"awebs"
    if (agentboss != "") {
        console.log($("#agentBoss").find("bossAname").attr("maxLength"));
        console.log(agentboss);
        $("#agentBoss").find("input#bossAname").val(agentboss);
        $("#agentBoss").find("input#bossAname").attr("readonly","readonly");
        $("#agentBoss").show();
        
    } else {
        $("#agentBoss").hide();
    }

    $('#agentReg').validate({
        ignore: '.ignore',
        rules: {
            //aname:{required:true,username:true,remote:'/home/enableName'},
            aname: {
                required: true,
                username: true,
                remote: {
                    url: '/agent/agents/checkAgentName',
                    type: "post",
                    data: {
                        agentName: function() {
                            return $("#aname").val();
                        }
                    }
                }
            },
            apwd: {
                required: true,
                password: true
            },
            password1: {
                required: true,
                equalTo: '#apwd'
            },
            aanswer: {
                required: true
            },
            realname: {
                required: true,
                realname: true
            },
            //email:{required:true,email:true,remote:'/home/enableEmail'},
            email: {
                required: true,
                email: true
            },
            aphone: {
                required: true,
                phone: true
            },
            qq: {
                required: true,
                qq: true
            },
            verifycode: {
                required: true,
                captcha: true
            },
        },
        messages: {
            //aname:{required:'用户名不能为空！',username:'用户名格式错误！',remote:'用户名已经被注册！'},
            aname: {
                required: '用户名不能为空！',
                username: '用户名格式错误！'
            },
            apwd: {
                required: '密码不能为空！',
                password: '密码格式有误！'
            },
            password1: {
                required: '确认密码不能为空！',
                equalTo: '两次输入的密码必须一致！'
            },
            aanswer: {
                required: '安全提问及答案不能为空！'
            },
            realname: {
                required: '真实姓名不能为空！',
                realname: '真实姓名格式有误！'
            },
            //email:{required:'邮箱不能为空！',email:'邮箱格式有误！',remote:'邮箱已经被注册！'},
            email: {
                required: '邮箱不能为空！',
                email: '邮箱格式有误！'
            },
            aphone: {
                required: '手机号不能为空！',
                phone: '手机号格式有误！'
            },
            qq: {
                required: 'QQ号不能为空！'
            },
            verifycode: {
                required: '验证码不能为空！'
            },
        },
        errorPlacement: function (error, element) {
            var where = element.attr('where');
            if (where == 'pa') {
                element.parent().append(error);
            } else if (where == 'ppa') {
                element.parent().parent().append(error);
            } else if (where == 'na') {
                error.insertAfter(element.next());
            } else {
                error.insertAfter(element);
            }
        }
    });
});

function get_captcha() {
    $('#captcha').attr('src', '/api/common/verifycode');
}

function reg_agent(agentboss) {

    if ($('#agentReg').valid()) {
        var data = $('#agentReg').serialize();
        console.log("agentboss is " + agentboss);
        if (agentboss == "") {
            $.post('/agent/agents/agentReg', data, function (d) {
                d = JSON.parse(d);
                if (d.code == 200) {
                    swal({
                        title: "",
                        text: "注册成功！请等待审核！",
                        type: "success"
                    });;
                    window.location.href="/agent/agents/index";
                } else {
                    swal({
                        title: "",
                        text: d.Message,
                        type: "warning"
                    });;
                    get_captcha();
                }
            });
        } else {
            $.post('/agent/agents/agentClientReg', data, function (d) {
                d = JSON.parse(d);
                if (d.code == 200) {
                    swal({
                        title: "",
                        text: "注册成功！请等待审核！",
                        type: "success"
                    });;
                    window.location.href="/agent/agents/agentReports";
                } else {
                    swal({
                        title: "",
                        text: d.Message,
                        type: "warning"
                    });;
                    get_captcha();
                }
            });
        }
        
    }
    return false;
}