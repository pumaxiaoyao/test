<?php
registerDataHelper(array("protoHelper"));
registerViewHelper(array(
        "member/register/registerViewHelper",
        "member/accountSettings/accsViewHelper",
        "member/funds/fundsViewHelper"
    ));
class Help{
    function default(){
        $recvJson = getSessionValue("QueryArgus", "");
        if(empty($recvJson)|| !isset($recvJson["subpage"])){
            $page = array(
                makeHeader("help/help_header_metas","help/help_header_scripts"),
                makeNav(),
                readHtml("help/help"),
                readHtml("common/commonfooter")
            );
            output(join("", $page));
        }
        
        // switch($recvJson["subpage"]){
        //     case 1:
        //         output(readHtml("help/sub1"));
        //         break;

        //     default:
        //         echo "22222";
        //         break;
        // }
        // return;
    }

    function helpText($request){
        $pageId = getArrayValue("subpage", "1", $request);

        return output(readHtml("help/sub" . $pageId));
    }
}

?>