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
function show( $userno, $passwd, $refurl, $signstr)
{
    $argus = array("uno=".$userno, "pw=".$passwd, "refurl=".$refurl, "signstr=".$signstr);
    $urlall = join("&", $argus);
    $url= $GLOBALS["gs_url"].'login.php';
    $html = file_get_contents("Login.html");
    $html = str_replace("%URLALL%", $url."?".$urlall, $html);
    $html = str_replace("%URL%", $url, $html);
    $html = str_replace("%UNO%", $userno, $html);
    $html = str_replace("%PW%", $passwd, $html);
    $html = str_replace("%REF%", $refurl, $html);
    $html = str_replace("%SIGN%", $signstr, $html);
    echo $html;
}

$retJson = login();
show($retJson[0], $retJson[1], $retJson[2], $retJson[3]);
?>
