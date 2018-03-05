 <link href="/static/css/bootstrap.min.css" rel="stylesheet" />
    <link href="/static/css/keno.css" rel="stylesheet" />
    <div id="keno_code"  style="display: none"></div>
<!--<img src="/static/img/keno/code.png" />-->


    <script>
        $(function () {
         $('#iview').iView({
             pauseTime: 7000,
             directionNav: false,
             controlNav: true,
             tooltipY: 0,
             timerOpacity:0
               
            });
            var tiemer=0;
        if($('#keno_code').find('img').length==1){

         if (tiemer == 0) {
                             tiemer = 10;
                             var index = setInterval(function(){
                                 tiemer--;
                                 if (tiemer == 0) {
                                     clearInterval(index);
               var src = $('#keno_code').find('img').attr('src');

                $('#keno_code_copy').attr('src',src)
                                       $('.iphone-fanye').fadeIn();
                                 }
                             }, 10);

                           //  alert('按钮事件被触发');
                         }
        }

        })
    </script>
