
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
function show($recoid, $date, $gameType, $signstr)
{
    $argus = array( "recoid=".$recoid, "dt=".$date, "gametype=".$gameType,"signstr=".$signstr);
    // $argus = array("uno=".$userno, "recoid=".$recoid, "dt=".$date, "gametype=".$gameType,"signstr=".$signstr);
    $urlall = join("&", $argus);
    $url= $GLOBALS["gs_url"].'reco.php';
    $html = file_get_contents("Reco.html");
    $html = str_replace("%URLALL%", $url."?".$urlall, $html);
    $html = str_replace("%URL%", $url, $html);
    // $html = str_replace("%UNO%", $userno, $html);
    $html = str_replace("%RECOID%", $recoid, $html);
    $html = str_replace("%DATE%", $date, $html);
    $html = str_replace("%GAMETYPE%", $gameType, $html);
    $html = str_replace("%SIGN%", $signstr, $html);
    echo $html;
}

$retJson = reco();
show($retJson[0], $retJson[1], $retJson[2], $retJson[3]);
?>


