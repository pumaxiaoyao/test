<link href="/static/css/promotions.css" rel="stylesheet" />
<script src="/static/js/promotions.js"></script>
<script type="text/javascript">
    function showMessage( msgId) {
        var url = "/activity/showDetail?actId=" + msgId;
        $("#msgIframe").attr("src", url);
         $("#parentBorder").attr('style','');
             openMessage();
    }

    function joinActivity( actId ){
        var url = "/activity/joinActivity";
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            data: { actId:actId },
            success: function (data) {
                resp = data.data;
                if (resp[0]) {
                    swal({
                        title: "",
                        text: "提交成功，请等待客服审批！",
                        type: "success"
                    });
                } else {
                    swal({
                        title: "",
                        text: resp[1],
                        type: "warning"
                    })
                }
            }
        });
    }
    $(function () {
        //iframe 加载事件 站内信
        var iframe = $("#msgIframe")[0];
        if (iframe != null) {
            if (iframe.attachEvent) {
                iframe.attachEvent("onload", function () {
                    //以下操作必须在iframe加载完后才可进行  
                    $("#popLoading").css({ "display": "none" });
                      var mainheight = $(this).contents().find("body").height() + 30;
                      var mainwidth = $(this).contents().find("body").width() + 30;
                      $('#parentBorder').height(mainheight).width(mainwidth).css({"margin-top":-mainheight/2,"margin-left":-mainwidth/2," position":"fixed;",'left':"50%","top":'50%'})

                });
            } else {
                iframe.onload = function () {
                    //以下操作必须在iframe加载完后才可进行  
                 //   $("#popLoading").css({ "display": "none" })

                     var mainheight = $(this).contents().find("body").height() + 30;
                     var mainwidth = $(this).contents().find("body").width() + 30;

                     $('#parentBorder').height(mainheight).width(mainwidth).css({"margin-top":-mainheight/2,"margin-left":-mainwidth/2," position":"fixed;",'left':"50%","top":'50%'})



                };
            }
        }
    });

</script>