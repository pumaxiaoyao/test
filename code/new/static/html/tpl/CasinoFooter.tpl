
    <div class="hidden">
        <!-- casino js -->
        <!-- <script type="text/javascript" src="/static/js/turn.js"></script>
    <script type="text/javascript" src="/static/js/casino.js"></script> -->
        <script type="text/javascript" src="/static/js/draggble.min.js"></script>
        <script type="text/javascript" src="/static/js/teenmax.min.js"></script>
            <link href="/static/css/promotions.css" rel="stylesheet" />
         <!--<script type="text/javascript" src="/static/js/promotions.js"></script>-->

        <script>

            jQuery(document).ready(function ($) {
                $(function () {
                    var $dragMe = $("#dragme");
                    var $beforeAfter = $("#before-after");
                    var $viewAfter = $(".view-after");
                    var $wrapperafter = $(".wrapper-after");
                    if ($("#dragme").length == 0)
                        return;
                    Draggable.create($dragMe, {
                        type: "left",
                        bounds: $beforeAfter,
                        onDrag: updateImages
                    });
                    //Intro Animation
                    $(window).resize(function () {
                        var windowWidth = $(window).width(),
                            haft_win = windowWidth / 2;
                        $wrapperafter.width($(window).width())
                        $viewAfter.width($wrapperafter.width()/ 2)
                        animateTo(windowWidth / 2)
                    });
                    function updateImages() {
                        //   var logo = $('.wrapper-logo').offset().left,
                        drag = $('#dragme').offset().left;
                        //   if (drag < $(window).width() * 0.7)

                        //    { $('.content-right').fadeIn(1000) }
                        //    if (drag > $(window).width() * 0.7)
                        //    { $('.content-right').fadeOut(1000) }
                        //    console.log($(window).width() * 0.7)
                        TweenLite.set($viewAfter, { width: $dragMe.css("left") });		//or this.x if only dragging
                       
                    }
                    function animateTo(_left) {
                        TweenLite.to($dragMe, 1, { left: _left, onUpdate: updateImages });

                    }

                    //V2 Click added
                    $beforeAfter.on("click", function (event) {
                        var eventLeft = event.clientX - $beforeAfter.offset().left;
                        animateTo(eventLeft);
                    });
                    if (document.documentElement && document.documentElement.clientHeight && document.documentElement.clientWidth) {
                        winHeight = document.documentElement.clientHeight;
                        winWidth = document.documentElement.clientWidth;
                    }
                    $beforeAfter.show(1000)
                    $wrapperafter.width(document.body.offsetWidth)

                    animateTo($wrapperafter.width() / 2)
                });//end jQuery wrapper
                //init rating score
                
            });
            

        </script>
    </div>
