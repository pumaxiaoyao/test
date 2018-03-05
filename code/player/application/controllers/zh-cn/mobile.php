<?php

class Mobile{
    function main(){
        $page = array(
            makeHeader("index/main_header_metas","mobile/mobile_header_scripts"),
            makeNav(),
            readHtml("mobile/mobile"),
            readHtml("common/commonfooter")
        );
        output(join("", $page));
    }
}

?>