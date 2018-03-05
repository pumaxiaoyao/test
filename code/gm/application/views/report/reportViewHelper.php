<?php

function showTrans(){
    $page = array(
        makeHeaderPage(""),
        readHtml("report/trans"),
        makeFooterPage("report_trans_footer"),
    );
    output(join("", $page));
}

function showcompanyDaily(){ 
    $page = array(
        makeHeaderPage(""),
        readHtml("report/companyDaily"),
        makeFooterPage(""),
    );
    output(join("", $page));
}

function showagentDaily(){
    $page = array(
        makeHeaderPage(""),
        readHtml("report/agentDaily"),
        makeFooterPage(""),
    );
    output(join("", $page));
}

function showplatform(){
    $page = array(
        makeHeaderPage(""),
        readHtml("report/platform"),
        makeFooterPage("report_platform_footer"),
    );
    output(join("", $page));
}

function showplayerActivity(){
    $page = array(
        makeHeaderPage(""),
        readHtml("report/playerActivity"),
        makeFooterPage("report_playeractivity_footer"),
    );
    output(join("", $page));
}

function showarbitrage(){
    $page = array(
        makeHeaderPage(""),
        readHtml("report/arbitrage"),
        makeFooterPage("report_arbitrage_footer"),
    );
    output(join("", $page));
}
?>