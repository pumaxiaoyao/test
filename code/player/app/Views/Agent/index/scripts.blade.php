{{--  <link href="/static/css/promotions.css" rel="stylesheet" />
<script type="text/javascript" src="/static/js/promotions.js"></script>  --}}
<script src="/static/js/raphael-min.js"></script>
<script src="/static/js/jquery.easing.1.3.js"></script>
<script src="/static/js/iview.js"></script>
<link href="/static/css/bootstrap.min.css" rel="stylesheet" />
<link href="/static/css/keno.css" rel="stylesheet" />


<div id="keno_code" style="display: none"></div>
<script>
    $(function () {
        $('#iview').iView({
            pauseTime: 7000,
            directionNav: false,
            controlNav: false,
            tooltipY: 0,
            timerOpacity: 0,
            startSlide:{{ $pageid }}
        });
    })
</script>
<!--<img src="/static/img/keno/code.png" />-->