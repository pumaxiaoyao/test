<script type="text/javascript" src="/static/js/support/agent.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#s_search").search();
    });

    function showCbDetail(dno) {
        $.get("/agentfund/settleDetail2?dno=" + dno, function (data) {
            $("#CbDetailModal").find("#detial").html(data);
        });
    }

    function showDetail(dno) {
        $.get("/agentfund/settleDetail?dno=" + dno, function (data) {
            $("#DetailModal").find("#detial").html(data);
        });
    }
</script>