<?php
/**
 * Nothing to say.
 */
require 'signstr.php';


function getdata($_k, $_v, $_a)
{
    return isset($_a[$_k])?$_a[$_k]:$_v;
}

/**
 * Calc md5 for lohin.
 *
 * @return void
 */
function login()
{
    $userno = getdata("uno", "alien44", $_POST);
    $passwd = getdata("pw", "alien44", $_POST);
    $refurl = getdata("refurl", "http://nbbet.com", $_POST);
    $signstr = md5($GLOBALS["key1"].$userno.$GLOBALS["key"].$passwd.$refurl.$GLOBALS["key2"]);
    return array($userno, $passwd, $refurl, $signstr);
}

/**
 * calc md5 for bm
 *
 * @return void
 */
function bm()
{
    $userno = getdata("uno", "alien44", $_POST);
    $passwd = getdata("pw", "alien44", $_POST);
    $opstyle = getdata("opstyle", "1", $_POST);
    $qty = getdata("qty", "1", $_POST);
    $orderid = getdata("orderid", time()+mt_rand(1, 10000), $_POST);
    $signstr = md5($GLOBALS["key1"].$userno.$GLOBALS["key"].$passwd.$opstyle.$qty.$GLOBALS["key2"].$orderid);
    
    return array($userno, $passwd, $opstyle, $qty, $orderid, $signstr);
}

/**
 * Calc md5 for reco.
 *
 * @return void
 */
function reco()
{
    // $userno = getdata("uno", "htest01", $_POST);
    $recoid = getdata("recoid", "8108", $_POST);
    $date = getdata("dt", strtotime('2017-11-23 00:00:00'), $_POST);
    $gametype = getdata("gametype", "pk", $_POST);
    $signstr = md5($GLOBALS["key1"].$GLOBALS["key"].$recoid.$date.$gametype.$GLOBALS["key2"]);
    // $signstr = md5($GLOBALS["key1"].$userno.$GLOBALS["key"].$recoid.$date.$gametype.$GLOBALS["key2"]);
    return array($recoid, $date, $gametype, $signstr);
}


$a = isset($_POST["a"])?$_POST["a"]:"";

switch ($a){
    case "login":
        $retJson = login();
        echo $retJson[3];
        break;
    case "bm":
        $retJson = bm();
        echo $retJson[5];
        break;
    case "reco":
        $retJson = reco();
        echo $retJson[4];
        break;
    default:
        //login();
        break;
}
?>