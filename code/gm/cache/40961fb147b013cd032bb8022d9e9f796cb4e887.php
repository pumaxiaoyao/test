<script src="/static/incloud/global/plugins/amcharts/amcharts/amcharts.js" type="text/javascript"></script>
<script src="/static/incloud/global/plugins/amcharts/amcharts/serial.js" type="text/javascript"></script>
<script src="/static/incloud/global/plugins/amcharts/amcharts/pie.js" type="text/javascript"></script>
<script src="/static/incloud/global/plugins/amcharts/amcharts/funnel.js" type="text/javascript"></script>
<script src="/static/incloud/global/plugins/amcharts/amcharts/themes/light.js" type="text/javascript"></script>
<script type="text/javascript">
    $("#theDWChartsPages").load("/home/dw?daterandom="+Math.random());
    $("#theCostChartsPages").load("/home/cost?daterandom="+Math.random());
    $("#theNewChartsPages").load("/home/newplayer?daterandom="+Math.random());
    $("#theBETDChartsPages").load("/home/betdaily?daterandom="+Math.random());
    $("#theBETChartsPages").load("/home/bet?daterandom="+Math.random());
    $("#theWLTotalChartsPages").load("/home/wltotal?daterandom="+Math.random());
    $.getJSON("/home/getInfo?daterandom="+Math.random(),function(data){
    $("#firstAmt").html(data.firstAmt);
    $("#dptAmt").html(data.dptAmt);
    $("#wtdAmt").html(data.wtdAmt);
    $("#betAmt").html(data.betAmt);
    $("#winLoss").html(data.winLoss);
    $("#fee").html(data.fee);
    });
</script>