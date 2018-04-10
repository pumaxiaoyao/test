<link href="/static/css/bootstrap.min.css" rel="stylesheet" />
<link href="/static/css/help/help.css" rel="stylesheet" />
<body style="background: url(../../static/img/player/regok_bg.jpg) repeat;">
<script type="text/javascript">
    $(function(){
        $('.panel-heading').on("click",function () {
            $id = $(this).attr('href');
            id = '#' + $(this).attr('aria-controls');
            if ($id == id) {
                if ($($id).is(':hidden')) {
                    $('.panel-collapse').slideUp();
                    $($id).slideDown();
                    $('.panel-heading').find('img').attr('src', "/static/img/help/arrows-1-r.png");
                    $('#' + this.id).find('img').attr('src', "/static/img/help/arrows-1-d.png");
                } else {
                    //$($id).slideUp();
                }
            }else{
            $('.panel-collapse').slideUp();
            }
        });
        $('.nav_text_2').click(function () {
        $('.nav_text_2').removeClass('on');
            $(this).addClass('on')
        });
        var num = GetQueryString("?");
        switch(num)
        {
        case "1":clickMenu(2);nowNum (2);  break;
        case "2":clickMenu(3);nowNum (3);  break;
        case "3":clickMenu(8);nowNum(8);listNum(2);  break;
        case "4":clickMenu(19);nowNum(19);listNum(6);  break;
        case "5":clickMenu(21);nowNum(21);listNum(6);  break;
        case "6":clickMenu(18);nowNum(18);listNum(6);  break;
        case "7":clickMenu(22);listNum(2);   $('.panel-collapse').slideUp(); break;
        case "8":clickMenu(22);nowNum(23);listNum(6);  break;
        default:clickMenu(1);nowNum (1);
        }
})
    function collapseArrow1(imgId) {
        if ($('#nav_arrow_' + imgId).attr('src').indexOf("-1-r.png") > 0) {
            $('#nav_arrow_' + imgId).attr('src', "/static/img/help/arrows-1-d.png");
        }
        else {
            $('#nav_arrow_' + imgId).attr('src', "/static/img/help/arrows-1-r.png");
        }
    }
    function iframeAutoFit(iframeObj) {
        setTimeout(function () { if (!iframeObj) return; iframeObj.height = (iframeObj.Document ? iframeObj.Document.body.scrollHeight + 100 : iframeObj.contentDocument.body.offsetHeight + 100); }, 200)
    }
    function clickMenu(menuId) {
        $("#contentFrame").attr("src", "helpText?subpage=" + menuId);
    }
    function GetQueryString(name)
    {
         var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
         var r = window.location.search.substr(1).match(reg);
         if(r!=null)return  unescape(r[2]); return null;
    }
    
    function nowNum (id){
        $('.nav_text_2').eq(id-1).click(function() {
            $('.nav_text_2').removeClass('on');
            $(this).addClass('on');
        });
         $('.nav_text_2').eq(id-1).click();
    }
    function listNum(nowId){
            var nowId= nowId-1;
            $('.panel-heading').eq(nowId).click(function () {
                $id = $(this).attr('href');
                id = '#' + $(this).attr('aria-controls');
                if ($id == id) {
                    if ($($id).is(':hidden')) {
                        $('.panel-collapse').slideUp();
                        $($id).slideDown();
                        $('.panel-heading').find('img').attr('src', "/static/img/help/arrows-1-r.png");
                        $('#' + this.id).find('img').attr('src', "/static/img/help/arrows-1-d.png");
                    } else {
                    // $($id).slideUp();
                    }
                }else{
                }
                collapseArrow1(nowId);
            });
        $('.panel-heading').eq(nowId).click();
    }
    </script>