    <link rel="stylesheet" href="/static/css/BaseCss.css" />
    <link rel="stylesheet" href="/static/css/public.css" />
    <link rel="stylesheet" href="/static/css/head.css" />

    <script src="/static/js/jquery-1.10.2.min.js"></script>
    <script src="/static/js/common.js?2018031423217"></script>
    <script src="/static/js/head.js?201803142317.js"></script>
    <script src="/static/js/qrcode.min.js"></script>
    <script>
        var IsLogin = '{{ $LoginStatus or 'False' }}';
        var systime = '{!! date("Y,m-1,d,H,i,s", time()) !!}';
        var beijingtime = eval("new Date(" + systime + ")");
    </script>

