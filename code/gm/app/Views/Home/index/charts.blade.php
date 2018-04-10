<div id="{{ $chartName }}" style="width:100%;height:300px;font-size:11px;"></div>
<script type="text/javascript">
    var chart = AmCharts.makeChart("{{ $chartName }}", {!! $chartData !!});
</script>