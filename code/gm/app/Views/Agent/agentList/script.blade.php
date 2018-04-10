<script type="text/javascript" src="/static/js/support/agent/list.js?201801261434">
</script>
<script type="text/javascript" src="/static/js/support/agent.js"></script>
<script type="text/javascript" src="/static/js/rsa/jsbn.js"></script>
<script type="text/javascript" src="/static/js/rsa/prng4.js"></script>
<script type="text/javascript" src="/static/js/rsa/rng.js"></script>
<script type="text/javascript" src="/static/js/rsa/rsa.js"></script>
<script type="text/javascript" src="/static/js/rsa/base64.js"></script>
<script type="text/javascript">
    var now_uid = 0;
    
    function resetPwdModal(obj) {
        $("#pwd").val('');
        $("#pwdck").val('');
        now_uid = $(obj).attr('aid');
        $("#resetPwd").attr("aid", now_uid);

    }

    function resetPwd(o) {
        var aid = $("#resetPwd").attr("aid");
        if ($("#pwd").val() == "") {
            $.notific8("请填写密码", {
                theme: 'ebony'
            });
            return false;
        }
        if ($("#pwd").val() != $("#pwdck").val()) {
            $.notific8("两次输入的密码不一致", {
                theme: 'ebony'
            });
            return false;
        }

        var pwd = $("#pwd").val();
        var pwdck = $("#pwdck").val();
        $.ajax({
            url: '/agent/resetpwd',
            type: 'post',
            data: {
                aid: aid,
                pwd: pwdck
            },
            dataType: "json",
            success: function (d) {
                d = d.data;
                if (d.code == 200) {
                    $.unblockUI();
                    $.notific8("密码更新成功");
                    $(o).next().click();
                    $("#s_search").submit();
                } else {
                    $.notific8(d.Message, {
                        theme: 'ebony'
                    });
                    $.unblockUI();
                }
            },
            error: function (err) {
                $.notific8("系统错误，请重试或联系管理员", {
                    theme: 'ebony'
                });
                $.unblockUI();
            },
            cache: false
        });
        // $.ajax({
        //     url: '/kzb/admin/vpkey',
        //     error: function () {
        //         notify('未知错误！');
        //     },
        //     success: function (rs) {
        //         var rsaKey = new RSAKey();
        //         rsaKey.setPublic(b64tohex(rs.modulus), b64tohex(rs.exponent));
        //         var enPassword = hex2b64(rsaKey.encrypt(pwd+' '+pwdck));

        //         $.ajax({
        //             url :'/kzb/agent/resetpwd',
        //             type:'post',
        //             data:{aid:now_uid,pwd:enPassword},
        //             dataType: "json",
        //             success : function(d) {
        //                 if(d.c==0){
        //                     $.unblockUI();
        //                     $.notific8("密码更新成功");
        //                     $(o).next().click();
        //                     $("#s_search").submit();
        //                 }else{
        //                     $.notific8(d.m, {theme: 'ebony'});
        //                     $.unblockUI();
        //                 }
        //             },
        //             error:function(err){
        //                 $.notific8("系统错误，请重试或联系管理员", {theme: 'ebony'});
        //                 $.unblockUI();
        //             },
        //             cache : false
        //         });
        //     }
        // });
    }

    function handleEditModal(obj) {

    }
</script>