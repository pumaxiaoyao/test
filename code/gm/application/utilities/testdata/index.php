<?php
session_start();

class Index{

    function bet(){
        echo file_get_contents("./testdata/chartdata/bet.json");
    }

    function betdaily(){
        echo file_get_contents("./testdata/chartdata/betdaily.json");
    }

    function dw(){
        echo file_get_contents("./testdata/chartdata/dw.json");
    }

    function cost(){
        echo file_get_contents("./testdata/chartdata/cost.json");
    }

    function newplayer(){
        echo file_get_contents("./testdata/chartdata/newplayer.json");
    }

    function wltotal(){
        echo file_get_contents("./testdata/chartdata/wltotal.json");
    }

    function getInfo(){
        echo file_get_contents("./testdata/chartdata/getInfo.json");
    }
}



?>