<?php

function showActivity($_name){
    $page = array(
        makeHeaderPage(""),
        readHtml("activity/activity"),
        makeFooterPage(""),
    );
    output(join("", $page));
}

function showActCateList($_name){
    $page = array(
        makeHeaderPage(""),
        readHtml("activity/actCateList"),
        makeFooterPage(""),
    );
    output(join("", $page));
}

function showActVerify($_name){
    $page = array(
        makeHeaderPage(""),
        readHtml("activity/activityVerify"),
        makeFooterPage("activityVerify_footer"),
    );
    output(join("", $page));
}

function showActHistory($_name){
    $page = array(
        makeHeaderPage(""),
        readHtml("activity/activityHistory"),
        makeFooterPage("activityHistory_footer"),
    );
    output(join("", $page));
}

function showActFund($_name){
    $page = array(
        makeHeaderPage(""),
        readHtml("activity/activityFund"),
        makeFooterPage("activityFund_footer"),
    );
    output(join("", $page));
}
?>