<?php

function ShowDptVerify(){
    $html = readHtml("playerfund/dptVerify");
    $s_st = parseDate(time() - 24*60*60*30);
    $s_et = parseDate(time());
    $html = str_replace("%STARTTIME%", $s_st, $html);
    $html = str_replace("%ENDTIME%", $s_et, $html);
    $page = array(
        makeHeaderPage(""),
        $html,
        makeFooterPage("dptVerify_footer"),
    );
    output(join("", $page));
}

function ShowDptHistory(){
    $html = readHtml("playerfund/dptHistory");
    $s_st = parseDate(time() - 24*60*60*30);
    $s_et = parseDate(time());
    $html = str_replace("%STARTTIME%", $s_st, $html);
    $html = str_replace("%ENDTIME%", $s_et, $html);


    $page = array(
        makeHeaderPage(""),
        $html,
        makeFooterPage("dptHistory_footer"),
    );
    output(join("", $page));
}

function ShowDptCorrection(){
    $page = array(
        makeHeaderPage(""),
        readHtml("playerfund/dptCorrection"),
        makeFooterPage("dptCorrection_footer"),
    );
    output(join("", $page));
}

/**
 * 构建玩家取款审核界面
 *
 * @return void
 */
function ShowWtdVerify()
{
    $html = readHtml("playerfund/wtdVerify");
    
    $s_st = parseDate(time() - 24*60*60*30);
    $s_et = parseDate(time());
    $html = str_replace("%STARTTIME%", $s_st, $html);
    $html = str_replace("%ENDTIME%", $s_et, $html);

    $page = array(
        makeHeaderPage(""),
        $html,
        makeFooterPage(""),
    );

    $fullPage = join("", $page);
    // getGroupConfig
    $html = parseGroupHtml();
    $fullPage = str_replace("%GROUPDATA%", $html, $fullPage);
    

    return output($fullPage);
}

function ShowWtdHistory(){
    $html = readHtml("playerfund/wtdHistory");
    $s_st = parseDate(time() - 24*60*60*30);
    $s_et = parseDate(time());
    $html = str_replace("%STARTTIME%", $s_st, $html);
    $html = str_replace("%ENDTIME%", $s_et, $html);

    $page = array(
        makeHeaderPage(""),
        $html,
        makeFooterPage(""),
    );
    output(join("", $page));
}

function ShowFlowLimit(){
    $page = array(
        makeHeaderPage(""),
        readHtml("playerfund/flowLimit"),
        makeFooterPage(""),
    );
    output(join("", $page));
}

function ShowTransferList(){
    $html = readHtml("playerfund/transferList");
    $s_st = parseDate(time() - 24*60*60*30);
    $s_et = parseDate(time());
    $html = str_replace("%STARTTIME%", $s_st, $html);
    $html = str_replace("%ENDTIME%", $s_et, $html);

    $page = array(
        makeHeaderPage(""),
        $html,
        makeFooterPage("transferList_footer"),
    );
    output(join("", $page));
}
?>