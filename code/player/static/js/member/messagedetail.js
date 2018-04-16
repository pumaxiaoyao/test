$(function () {

    setParentHeight();

    //关闭
    $(".close,.closebut").click(function () {
        parent.closeMessage();
        $('body').removeAttr("style");
    });

    $("#mess_del").click(function () {
        if (messagetype == 1) {
            var aid = messageid;
            $.post("receivebox.aspx?action=delete&type=1", { aids: aid }, function (res) {
                if (res == "200") {
                    parent.$(".ms_table_row[value='" + aid + "']").closest('.ms_table_row').slideUp();
                    parent.closeMessage();
                    return;
                }
                swal({ title: "", text: "删除失败", type: "warning" });
            });
        }
        else if (messagetype == 2) {
            var mid = messageid;
            $.post("receivebox.aspx?action=delete&type=2", { mids: mid }, function (res) {
                if (res == "200") {
                    parent.$(".ms_table_row[value='" + mid + "']").closest('.ms_table_row').slideUp();
                    parent.closeMessage();
                    return;
                }
                swal({ title: "", text: "删除失败", type: "warning" });
            });
        }
    });

    $("#replyBT").click(function () {
        var mstype = messagetype
        msid = messageid,
        mscontent = $("#replyContent").val();

        if (msid == 0) {
            swal({ title: "", text: "发送失败请刷新页面后重新发送", type: "warning" });
            return false;
        }

        if (mscontent.length < 10) {
            swal({ title: "", text: "信息内容长度最少10个字符", type: "warning" });
            return false;
        }

        if (mstype == 1) {
            $.post("MsDetail.aspx", { action: "replyann", aid: msid, message: mscontent }, function (res) {
                if (res == "200") {
                    swal({ title: "", text: "消息发送成功", type: "success" }, function () {
                        window.location.reload();
                    });
                    
                    return;
                }

                if (res == "509") {
                    swal({ title: "", text: "您回复太快了，请先休息会稍后才能回复", type: "warning" });
                    return;
                }
                swal({ title: "", text: "消息发送失败", type: "warning" });
            });
        } else if (mstype == 2) {
            $.post("MsDetail.aspx", { action: "replymsg", mid: msid, message: mscontent }, function (res) {
                if (res == "200") {
                    swal({ title: "", text: "消息发生成功", type: "success" }, function () {
                        window.location.reload();
                    });
                    return;
                }

                if (res == "509") {
                    swal({ title: "", text: "您回复太快了，请先休息会稍后才能回复", type: "warning" });
                    return;
                }
                swal({ title: "", text: "消息发送失败", type: "warning" });
            });
        }
        

    });
});

//设置parent高度
function setParentHeight() {
    $(".m_pop", parent.document).css({ "display": "block" });
    var height = $("body").height();

    if (this != parent) {
        $("#parentBorder", parent.document).height(height);
    }
}

