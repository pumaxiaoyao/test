<?php

class Promotions{
    function main(){
        $page = array(
            makeHeader("index/main_header_metas","promotions/promotions_header_scripts"),
            makeNav(),
            readHtml("promotions/promotions"),
            readHtml("common/commonfooter")
        );
        output(join("", $page));
    }
}

?>