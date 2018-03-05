<?php

class Sportsbook{

    function main(){
        $page = array(
            makeHeader("index/main_header_metas","sportsbook/sportsbook_header_scripts"),
            makeNav(),
            readHtml("sportsbook/sportsbook"),
            readHtml("common/commonfooter")
        );
        return output(join("", $page));
    }
}
?>