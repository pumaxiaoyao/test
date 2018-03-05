function showMessage(e, msgId) {
    var $target = $(e);
    var url = "/zh-cn/member/MessageDetail?type=1&aid=" + msgId;
    $("#msgIframe").attr("src", url);
    SetRead($target);
    openMessage();
}

function writeMessage(e, msgId, typeid) {
    var $target = $(e);
    var url = "/zh-cn/member/MsDetail?type="+ typeid +"&messageid=" + msgId;;
    $("#msgIframe").attr("src", url);
    SetRead($target);
    openMessage();
}

function showAgentMessage(e, msgId) {
    var $target = $(e);
    var url = "/agent/agents/MessageDetail?type=1&aid=" + msgId;
    $("#msgIframe").attr("src", url);
    SetRead($target);
    openMessage();
}

function writeAgentMessage(e, msgId, typeid) {
    var $target = $(e);
    var url = "/agent/agents/MsDetail?type="+ typeid +"&messageid=" + msgId;;
    $("#msgIframe").attr("src", url);
    SetRead($target);
    openMessage();
}


function SetRead($el) {
    //if ($el.hasClass('sl_table_row_read')) {
    //    return;
    //}
    $el.parent().siblings(".message_isView").html("已读");
    //$el.removeClass('sl_table_row_unread').addClass('sl_table_row_read');
}
$(function () {
    //iframe 加载事件 站内信
    var iframe = $("#msgIframe")[0];
    if (iframe != null) {
        if (iframe.attachEvent) {
            iframe.attachEvent("onload", function () {
                //以下操作必须在iframe加载完后才可进行  
                $("#popLoading").css({ "display": "none" });
            });
        } else {
            iframe.onload = function () {
                //以下操作必须在iframe加载完后才可进行  
                $("#popLoading").css({ "display": "none" });
            };
        }
    }


    // $("#agent_message_submit").click(function () {

    //     var subject = $("#messagetitle_text").val();
    //     var message = $("#messagecontent_text").val();
    //     if (subject == "") {
    //         swal({ title: "", text: "标题不能为空", type: "warning" });
    //         return false;
    //     } 
    //     if (message == "") {
    //         swal({ title: "", text: "内容不能为空", type: "warning" });
    //         return false;
    //     }
    //     if (message.length < 20) {
    //         swal({ title: "", text: "内容不得少于20字", type: "warning" });
    //         return false;
    //     }
    //     $.post("writeMessage", { action: 'create', subject: subject, message: message }, function (recode) {
    //         if (recode == 200) {
    //             swal({ title: "", text: "发送成功", type: "success" }, function () {
    //                 window.location.href = "/zh-cn/member/sendbox";
    //             });
                
    //         } else {
    //             swal({ title: "", text: "发送失败", type: "warning" });
    //         }
    //     });
    // })

    // $("#agent_message_submit").click(function () {

    //     var subject = $("#messagetitle_text").val();
    //     var message = $("#messagecontent_text").val();
    //     if (subject == "") {
    //         swal({ title: "", text: "标题不能为空", type: "warning" });
    //         return false;
    //     } 
    //     if (message == "") {
    //         swal({ title: "", text: "内容不能为空", type: "warning" });
    //         return false;
    //     }
    //     if (message.length < 20) {
    //         swal({ title: "", text: "内容不得少于20字", type: "warning" });
    //         return false;
    //     }
    //     $.post("writeMessage", { action: 'create', subject: subject, message: message }, function (recode) {
    //         if (recode == 200) {
    //             swal({ title: "", text: "发送成功", type: "success" }, function () {
    //                 window.location.href = "/agent/agents/sendbox";
    //             });
                
    //         } else {
    //             swal({ title: "", text: "发送失败", type: "warning" });
    //         }
    //     });
    // })
});
