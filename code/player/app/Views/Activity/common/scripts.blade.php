<link href="/static/css/promotions.css" rel="stylesheet" />
<script type="/text/javascript" src="/static/js/promotions.js"></script>
<script type="text/javascript">
    function showMessage( msgId) {
        var url = "/zh-cn/promotions/detail.aspx?promotionid=" + msgId;
        $("#msgIframe").attr("src", url);
         $("#parentBorder").attr('style','');
             openMessage();
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