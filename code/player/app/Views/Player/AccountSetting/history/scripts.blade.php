<style>
    .history_popobox {
        text-align: left;
        font-style: normal;
        font-weight: normal;
        position: absolute;
        background: url(/static/img/player/qipao_03.png) no-repeat;
        width: 252px;
        height: 85px;
        padding: 20px;
        font-size: 12px;
        left: -160px;
        top: -60px;
        line-height: 18px;
        display: none;
    }
    .wfail {
        color: red;
        text-decoration: underline;
    }
</style>
<script>
    var historyType = "{{ $historyType }}";
    var historyTime = "{{ $historyTime }}";
</script>
<script src="/static/js/player/History.js"></script>