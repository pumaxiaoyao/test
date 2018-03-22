<?php

function showPlatformMsg(){
    $page = array(
        makeHeaderPage(""),
        readHtml("message/platform"),
        makeFooterPage(""),
    );
    output(join("", $page));
}

function showPlayerMsg(){
    $page = array(
        makeHeaderPage(""),
        readHtml("message/player"),
        makeFooterPage("message_player_footer"),
    );
    output(join("", $page));
}

function showAgentMsg(){
    $page = array(
        makeHeaderPage(""),
        readHtml("message/agent"),
        makeFooterPage("message_agent_footer"),
    );
    output(join("", $page));
}

?>