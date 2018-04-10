    <link href="/static/css/homepg.css" rel="stylesheet" />
    <link href="/static/css/bootstrap.min.css" rel="stylesheet" />
    <link href="/static/css/index.css" rel="stylesheet" />
    <link href="/static/css/picstyle.css" rel="stylesheet" />
    <script src="/static/js/jquery.knob.js"></script>
    <script src="/static/js/raphael-min.js"></script>
    <script src="/static/js/jquery.easing.1.3.js"></script>
    <script src="/static/js/iview.js"></script>
    <script src="/static/js/banner.js"></script>
    <script src="/static/js/jquery.pj.js"></script>
    <script src="/static/js/jquery.liMarquee.js"></script>
    <script src="/static/js/bootstrap.min.js"></script>
    <script src="/static/js/countUp.js"></script>
    <script src="/static/js/plugins/bootstrap-progressbar.js"></script>
    <script src="/static/js/player/Index.js"></script>
    <script src="/static/js/plugins/jquery.marquee.min.js"></script>

    <script>

        //$('.carousel').pause();
        $(document).ready(function () {
            Index.init();
            $("#index").css({ "color": "#0099ff", "background": "#e0efff" });
            $('#iview').iView({
                pauseTime: 10000,
                directionNav: false,
                controlNav: true,
                tooltipY: 0
            });
            $('.noticelist').liMarquee({
                drag: false
            });
            //2017/8/10 iphone
            //imgloding
            dwitemimg();
            function dwitemimg() {
            var url = $('#iphone-fade img').attr('src');
            var img = new Image();
            img.src = url;
            var num = $('.pj-Carousel-active ').find('div'),$item = $('#dw-item .pj-Carousel-item'),fen = 0,interval,setTime,mssetTime;
            //
            function smallitem(num, fen) {
                clearTimeout(interval);
                clearTimeout(mssetTime);
                mssetTime= setTimeout(function() {
                    if (fen < 4) {
                        $('.pj-Carousel-active div').eq(num).find('strong i').eq(fen).addClass('on').siblings().removeClass('on');
                        interval = setTimeout(function() {
                            fen++;
                            smallitem(num, fen)
                        },
                        1000);
                    } else {
                        if(num<=1){
                            $('.pj-Carousel-active div').eq(num+1).click();
                            $item.eq(num+1).show().addClass('active').siblings().removeClass('active').hide();

                        }else{
                            $('.pj-Carousel-active div').eq(0).click();
                                $item.eq(0).show().addClass('active').siblings().removeClass('active').hide();
                        }
                    }
                },1000)
            };
            function clicknum (num) {
                clearTimeout(interval);
                clearTimeout(mssetTime)
                var nums = 0;
                var smallinterval;
                console.log(num);
                $('.pj-Carousel-active div').click(function() {
                    var id = $(this).index();
                    $(this).addClass('on').siblings().removeClass('on').find('i').removeClass('on');
                        $item.eq(id).show().addClass('active').siblings().removeClass('active').hide();
                    var ci = $(this).find('strong i').length;
                    smallitem(id, 0)
                });
                $('.pj-Carousel-active div').eq(num).click();
                $item.eq(num).show().addClass('active').siblings().removeClass('active').hide();

            };

            //imgcomplete
            if (img.complete) {
                clicknum(0)
                } else {
                    img.onload = function() {
                        clicknum(0)
                    }
                }
            }
        });
    </script>