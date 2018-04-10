    <link href="/static/css/player/registered.css" rel="stylesheet" />
    <script src="/static/js/player/Login.js?20170910.js"></script>
    <script>
        (function(){
                var height = window.innerHeight,
                width = document.body.clientWidth;
                if(typeof height != 'number'){
                height = document.body.clientHeight;
                }
                var ratio = height/width;
                document.write('<style>.video-head-wrap{padding-bottom:' + ratio*100 + '% !important;}.body-wrap{padding-top:' + ratio*100 + '%;}</style>');
                //背景视频为1280*720
                if(ratio>(720/1280)){
                $('#video-bg').attr('style','').css({'height':height})
                var leftOffset = -(height*1280/720 - width)/2;
            
                $(window).resize(function() {
                        $('#video-bg').attr('style','').css({'height':height})
            
                })
            
                }else{
                var topOffset = -(width*720/1280 - height)/2;
                $('#video-bg').attr('style','').css({'width':width});
                $(window).resize(function() {
                    $('#video-bg').attr('style','').css({'width':width})
            
                })
                }
            })();
    </script>