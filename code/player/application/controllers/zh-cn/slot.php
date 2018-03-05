<?php

class Slot{
    function main(){
        $page = array(
            makeHeader("index/main_header_metas","slots/slots_header_scripts"),
            makeNav(),
            readHtml("slots/slots"),
            readHtml("common/commonfooter")
        );
        output(join("", $page));
    }
}

?>