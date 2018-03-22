<?php

/**
 * 构建展示在线玩家的html
 *
 * @param [type] $_name classname
 * 
 * @return void
 */
function showOnline($_name)
{

    $page = array(
        makeHeaderPage(""),
        readHtml("player/online"),
        makeModalHtml(),
        makeFooterPage("list_footer"),
    );
    output(join("", $page));
}

/**
 * 构建展示所有玩家的html
 *
 * @param [type] $_name classname
 * 
 * @return void
 */
function showList($_name)
{
    
    
    $page = array(
        makeHeaderPage(""),
        readHtml("player/list"),
        makeModalHtml(),
        makeFooterPage("list_footer"),
    );
    $fullPage = join("", $page);
    // getGroupConfig
    $html = parseGroupHtml();
    $fullPage = str_replace("%GROUPDATA%", $html, $fullPage);
    output($fullPage);
}

/**
 * 构建展示当日注册玩家的html
 *
 * @param [type] $_name classname
 * 
 * @return void
 */
function showRegDaily($_name)
{
    $html = readHtml("player/regDaily");
    $tDate = date("Y-m-d", time());
    $html = str_replace("%TODAY%", $tDate, $html);
    $page = array(
        makeHeaderPage(""),
        $html,
        makeModalHtml(),
        makeFooterPage("list_footer"),
    );
    output(join("", $page));
}

/**
 * 构建展示资金流水的html
 *
 * @param [type] $_name classname
 * 
 * @return void
 */
function showFundFlow($_name)
{
    $html = readHtml("player/fundFlow");
    $s_st = parseDate(time() - 24 * 60 * 60 * 30);
    $s_et = parseDate(time());
    $html = str_replace("%STARTTIME%", $s_st, $html);
    $html = str_replace("%ENDTIME%", $s_et, $html);
    $page = array(
        makeHeaderPage(""),
        $html,
        makeFooterPage("fundFlow_footer"),
    );
    output(join("", $page));
}

/**
 * 构建player各种弹窗的modal页面
 * 处理时，会将group数据存入session，方便同一请求中继续使用
 *
 * @return void
 */
function makeModalHtml()
{
    $html = readHtml("player/player_models");
    
    // $retJson = gmServerCaller("GetAllPlayerGroup", array());

    // $_SESSION["GROUPDATAS"] = $retJson;

    // $retJson = getArrayValue(0, array(), $retJson);
    
    // $html = "";
    // for ($x=0;$x<count($retJson);$x++) {
    //     $html = $html . "<option value='".$retJson[$x] ."'>". $retJson[$x]. "</option>";
    // }
    
    $html = str_replace("%GroupModal%", readHtml("player/player_modal_group"), $html);
    return $html;
}


function makePlayerListHtml($datas){
    $html = readHtml("player/playerListModel");
    $_html = "";
    
    foreach($datas as $_data){
        $_opt = "<option value=\"". $_data["account"]."\">".$_data["account"]."-".$_data["name"]."</option>";
        $_html = $_html . $_opt;
    }
    $html = str_replace("%PlayerOptions%", $_html, $html);
    return $html;

}
?>