<?php  

session_start();

include "./application/utilities/utilities.php";


class Charts  
{  
    function MakeChartHtml($chartname, $chartdata){
        $HtmlTemlate = file_get_contents("./html/charts/chartsTemplate.html");
        $page = str_replace("%CHARTNAME%", $chartname, $HtmlTemlate);
        $page = str_replace("%CHARTDATA%", $chartdata, $page);
        return $page;
    }

    function betdaily(){  
        $betdaily_json = getServerJSon("index/betdaily", $_POST);
        echo self::MakeChartHtml("theBetdailyCharts" ,$betdaily_json);
    }
    
    function dw(){  
        $dw_json = getServerJSon("index/dw", $_POST);
        echo self::MakeChartHtml("theDWCharts" ,$dw_json);
    }

    function cost(){
        $cost_json = getServerJSon("index/cost", $_POST);
        echo self::MakeChartHtml("theCostCharts" ,$cost_json);
    }

    function newplayer(){
        $newplayer_json = getServerJSon("index/newplayer", $_POST);
        echo self::MakeChartHtml("theNEWCharts" ,$newplayer_json);
    }

    function bet(){
        $bet_json = getServerJSon("index/bet", $_POST);
        echo self::MakeChartHtml("theBetCharts" ,$bet_json);
    }

    function wltotal(){
        $wltotal_json = getServerJSon("index/wltotal", $_POST);
        echo self::MakeChartHtml("theWinLoseTotalCharts" ,$wltotal_json);
    }

    function getInfo(){
        echo getServerJSon("index/getInfo", $_POST);
    }
}  
  
  
?>  