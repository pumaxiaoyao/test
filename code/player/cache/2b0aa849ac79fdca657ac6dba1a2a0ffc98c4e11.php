    <link rel="stylesheet" href="/static/css/BaseCss.css" />
    <link rel="stylesheet" href="/static/css/public.css" />
    <link rel="stylesheet" href="/static/css/head.css" />

    <script src="/static/js/jquery-1.10.2.min.js"></script>
    <script src="/static/js/common.js?201803142317"></script>
    <script src="/static/js/head.js?20170911.js"></script>
    <script src="/static/js/qrcode.min.js"></script>
    <script>
        var IsLogin = '<?php echo e(isset($LoginStatus) ? $LoginStatus : 'False'); ?>';
        var systime = '<?php echo date("Y,m-1,d,H,i,s", time()); ?>';
        var beijingtime = eval("new Date(" + systime + ")");
    </script>

