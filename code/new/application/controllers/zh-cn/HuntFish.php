<?php

class Huntfish{
    function main(){
        $page = array(
            makeHeader("index/main_header_metas","keno/keno_header_scripts"),
            makeNav(),
            readHtml("huntfish/huntfish"),
            readHtml("common/commonfooter")
        );
        output(join("", $page));
    }
}

?>