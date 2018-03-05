<?php

function showHeader(){
    $page = file_get_contents('./html/header.html');
    echo $page;
}

function showFooter(){
    $page = file_get_contents('./html/footer.html');
    echo $page;
}
function showSportsBook(){
    $url = "./html/sportsbook.html";
    echo file_get_contents($url, 'r');
}

function test(){
    $header = showHeader();

    $page = showSportsBook();
    
    showFooter();
}

test();

?>  