/**
 * Created by cz on 16/3/2.
 */

$(document).ready(function () {

    $('#s_search').search({
        '_fnCallback': function () {
            $(".deleteDomain").on('click', function () {
                var a = $(this);
                var domainId = a.attr("domainId");
                var domainName = a.attr("domain");
                if (confirm('是否确定删除域名：' + domainName + '？')) {
                    $.post('/agent/deldomain', {
                        id: domainId
                    }, function (rep) {
                        data = JSON.parse(rep);
                        data = data.data;
                        if (data.code == 200) {
                            $('#s_submit').click();
                            $.notific8('删除代理域名成功！');
                        } else {
                            $.notific8(data.Message, {
                                theme: 'ebony'
                            });
                        }
                    })
                }
            });
        }
    });

    $('#addDomain').ajaxForm({
        beforeSubmit: function (arr, $form, options) {
            $.blockUI();
        },
        error: function () {
            $.unblockUI();
        },
        success: function (data) {
            $.unblockUI();
            
            data = JSON.parse(data);
            data = data.data;
            if (data.code == 200) {
                $('#s_submit').click();
                $('#addDomainModal').modal('hide');
                $.notific8('新增代理域名成功！');
            } else {
                $.notific8(data.Message, {
                    theme: 'ebony'
                });
            }
        }
    });
    $("#addDomainModal #save").click(function () {
        var agent = $.trim($("#addDomainModal #agent").val());
        var domain = $.trim($("#addDomainModal #domain").val());
        if (!agent) {
            $("#addDomainModal #agentInfo").text("账号不能为空！");
            return;
        }
        if (!domain) {
            $("#addDomainModal #domainInfo").text("域名不能为空！");
            return;
        }
        $("#addDomain").submit();
    });
});