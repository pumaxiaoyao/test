<?php
/**
 * Docs
 */
require 'genmd5.php';
/**
 * Docs
 * 
 * @return mixed
 */
function show( $userno, $passwd, $opstyle,$qty,$orderid, $signstr)
{
    $argus = array("uno=".$userno, "pw=".$passwd, "opstyle=".$opstyle, "qty=".$qty, "orderid=".$orderid, "signstr=".$signstr);
    $urlall = join("&", $argus);
    $url= $GLOBALS["gs_url"].'bm.php';
    $html = file_get_contents("BM.html");
    $html = str_replace("%URL%", $url, $html);
    $html = str_replace("%URLALL%", $url."?".$urlall, $html);
    $html = str_replace("%UNO%", $userno, $html);
    $html = str_replace("%PWD%", $passwd, $html);
    $html = str_replace("%opstyle%", $opstyle, $html);
    $html = str_replace("%qty%", $qty, $html);
    $html = str_replace("%orderid%", $orderid, $html);
    $html = str_replace("%SIGN%", $signstr, $html);
    echo $html;
}

$retJson = bm();
show($retJson[0], $retJson[1], $retJson[2], $retJson[3], $retJson[4], $retJson[5]);
?>
