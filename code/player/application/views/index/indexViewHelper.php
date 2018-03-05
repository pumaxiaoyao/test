<?php

trait indexViewHelper{
    /**
     * index页面的viewHelper方法库
     */
    function main(){
        $page = array(
            makeHeader("index/main_header_metas","index/main_header_script"),
            makeNav(),
            readHtml("index/main"),
            readHtml("common/commonfooter")
        );
        return output(join("", $page));
    }
    
}
?>