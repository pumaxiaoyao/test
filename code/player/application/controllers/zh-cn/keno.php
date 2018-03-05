<?php

class Keno{

    function main(){
        $page = array(
            makeHeader("index/main_header_metas","keno/keno_header_scripts"),
            makeNav(),
            readHtml("keno/keno"),
            readHtml("common/commonfooter")
        );
        output(join("", $page));
    }
}

?>