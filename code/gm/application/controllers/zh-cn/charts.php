<?php  

registerViewHelper(array("GmViewHelper"));
registerDataHelper(array("protoHelper","dataHelper"));

class Charts  
{  
    function betdaily(){
        makeChartHtml("theBetdailyCharts", Base_GetBetDaily());
    }
    
    function dw(){  
        makeChartHtml("theDWCharts", Base_GetDw());
    }

    function cost(){
        makeChartHtml("theCostCharts", Base_GetCost());
    }

    function newplayer(){
        makeChartHtml("theNEWCharts", Base_GetNewPlayer());
    }

    function bet(){
        makeChartHtml("theBetCharts", Base_GetBet());
    }

    function wltotal(){
        makeChartHtml("theWinLoseTotalCharts", Base_GetWlTotal());
    }

    function getInfo(){
        Base_GetInfo();
    }
}  
  
  
?>  