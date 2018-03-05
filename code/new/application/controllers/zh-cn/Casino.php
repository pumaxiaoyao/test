<?php


class Casino{

    function main(){
        $page = array(
            makeHeader("index/main_header_metas","casino/casino_header_scripts"),
            makeNav(),
            readHtml("casino/casino"),
            readHtml("common/commonfooter")
        );
        output(join("", $page));
    }
}

?>