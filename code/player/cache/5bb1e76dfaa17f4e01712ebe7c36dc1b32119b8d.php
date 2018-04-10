<link href="/static/css/agent/reveal.css?201801082025" rel="stylesheet" />
    
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.6.min.js"></script>
    
    <script type="text/javascript" src="/static/js/reveal/jquery.reveal.js?201801"></script>
    <script type="text/javascript">
        function detail(month, rate) {
            $.post('/agent/settleDetail', {
                month: month,
                rate: rate
            }, function (data) {
                data = JSON.parse(data);
                var resp = data.data;
                $("#detailModal").find("#detail").html(resp[1]);
                // $('#detailModal').reveal("{data-animation:'none'}");
                $('#detailModal').reveal({
                    animation: 'fade',
                    animation_speed: 500,
                    closeonbackgroundclick: false,
                    dismissmodalclass: 'close-reveal-modal'
                });
    
            })
        }
    
        function detail2(month, rate) {
            $.post('/agent/settleDetail2', {
                month: month,
                rate: rate
            }, function (data) {
                var data = JSON.parse(data);
                
                var resp = data.data;
                $("#detailModal2").find("#detail").html(resp[1]);
                // $('#detailModal').reveal("{data-animation:'none'}");
                $('#detailModal2').reveal({
                    animation: 'fade',
                    animation_speed: 500,
                    closeonbackgroundclick: false,
                    dismissmodalclass: 'close-reveal-modal'
                });
            })
        }
    </script>