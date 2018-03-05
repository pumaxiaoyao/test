<?php

/**
 * 
 */


class Lbcp{
    
        function main(){
            $page = array(
                makeHeader("index/main_header_metas","lbcp/lbcp_header_scripts"),
                makeNav(),
                readHtml("lbcp/lbcp"),
                readHtml("common/commonfooter")
            );
            return output(join("", $page));
        }
    }
?>