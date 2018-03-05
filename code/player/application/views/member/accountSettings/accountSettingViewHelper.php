<?php
include_once "./application/controllers/zh-cn/common.php";

function initAccountSettingPage($pageName, $pageScripts=""){
    
    echo makeHeader("member/accountsetting/accountsetting_header_metas", $pageScripts);
    echo makeNav();
    $page = makeAccsCommonPage();
    $pageSwitchs = array(
        "depositSwitch", "withdrawalSwitch", "transferSwitch", "historySwitch", "bankmanagerSwitch",
        "basicinfoSwitch", "receiveboxSwitch", "bettingrecordsSwitch"
    );
    foreach($pageSwitchs as $_pageswitch){
        if (strtolower($_pageswitch) == strtolower($pageName)."switch"){
            $page = str_replace('%'.$_pageswitch.'%', "on", $page);
        }else{
            $page = str_replace('%'.$_pageswitch.'%', "", $page);
        }
    }
    echo $page;
        
}

function makeAccsCommonPage(){
    $page = readHtml("member/accountsetting/accountsetting_common");
    
    $basicInfo = getSessionValue("UserBasicInfo", "False");
    if ($basicInfo != "False"){
        $safetyInfos = array();
            foreach (array($basicInfo["phone"],$basicInfo["email"],$basicInfo["basicInfo"]["username"],$basicInfo["bankCard"]) as $_value){
                if (!empty($_value)){
                    array_push($safetyInfos, true);
                }
            }
            $safetyCounts = count($safetyInfos);
            if ($safetyCounts == 4){
                $SafetyLevelWords = "高";
            }elseif($safetyCounts > 1){
                $SafetyLevelWords = "中";
            }else{
                $SafetyLevelWords = "低";
            }
        $replaceWords = array(
            "LoginMemberName"=>$basicInfo["userId"],
            "AccountSafetyLevel"=>$SafetyLevelWords,
            "PhoneBindStatus"=>!empty($basicInfo["phone"])?"on":"",
            "EmailBindStatus"=>!empty($basicInfo["email"])?"on":"",
            "UserinfoBindStatus"=>!empty($basicInfo["basicInfo"]["username"])?"on":"",
            "BankcardBindStatus"=>!empty($basicInfo["bankCard"])?"on":"",
            "MainBalance"=>$basicInfo["mainBalance"],
            "SafetyRate"=>$safetyCounts * 100 /4,
        );

        foreach($replaceWords as $_key=>$_val){
            $page = str_replace('%'.$_key.'%', $_val, $page);
        }
    }
    return $page;
}

function makeAccsBasicInfoPage(){
    $page = readHtml("member/accountsetting/accountsetting_basicinfo");

    $basicInfo = getSessionValue("UserBasicInfo", "False");

    if ($basicInfo != "False"){

        $IsFirstName = empty($basicInfo["basicInfo"]["username"]);
        if ($IsFirstName){
            $IsFirstName = 1;
            $isFirstName_Html = '<input name="FirstName" type="text" id="FirstName" placeholder="真实姓名" class="r_inptut inputwd300" style="width: 150px" />';
        }else{
            $IsFirstName = 0;
            $isFirstName_Html = '';
        }
        if ($basicInfo["basicInfo"]["sex"] == "1"){
            $MaleHtml = 'selected="selected"';
            $FemaleHtml = "";
        }else{
            $MaleHtml = '';
            $FemaleHtml = 'selected="selected"';
        }
        $bInfo = explode("-", $basicInfo["basicInfo"]["birthday"]);

        $bYear = $bInfo[0];
        $bMon = $bInfo[1];
        $bDay = $bInfo[2];
        $bMonHtml = '';
        for($m=1;$m<13;$m++){
            if ((string)$m == $bMon){
                $bMonHtml = $bMonHtml.'<option selected="selected" value="'.$m.'">'.$m.'月</option>';
            }else{
                $bMonHtml = $bMonHtml.'<option value="'.$m.'">'.$m.'月</option>';
            }
        }


        $replaceWords = array(
            "IsFirstNameHtml"=>$isFirstName_Html,
            "MemberName"=>$basicInfo["basicInfo"]["username"],
            "MaleSelected"=>$MaleHtml,
            "FemaleSelected"=>$FemaleHtml,
            "BirthYear"=>$bYear,
            "BirthMonHtml"=> $bMonHtml,
            "BirthaDay"=>$bDay,
            "StreetAddr"=>$basicInfo["basicInfo"]["street"],
        );

        foreach($replaceWords as $_key=>$_val){
            $page = str_replace('%'.$_key.'%', $_val, $page);
        }
    }
    return $page;
}

function makeAccsPhonePage(){
    $basicInfo = getSessionValue("UserBasicInfo", "False");
    if ($basicInfo != "False"){
        if (empty($basicInfo["phone"])){
            $page = readHtml("member/accountsetting/accountsetting_unBindPhone");
        }else{
            $page = readHtml("member/accountsetting/accountsetting_BindPhone");
            $page = str_replace("%BindPhoneNumber%", $basicInfo["phone"], $page);
        }
    }
    return $page;
}

function makeAccsMailPage(){
    $basicInfo = getSessionValue("UserBasicInfo", "False");
    if ($basicInfo != "False"){
        if (empty($basicInfo["email"])){
            $page = readHtml("member/accountsetting/accountsetting_unBindMail");
        }else{
            $page = readHtml("member/accountsetting/accountsetting_BindMail");
            $page = str_replace("%BindEmailAddr%", $basicInfo["email"], $page);
        }
    }
    return $page;
}

function makeReceiveBoxMailPage($receivemails){
    $page = readHtml("member/accountsetting/accountsetting_receivebox");
    $allmails = '';
    foreach($receivemails as $_mail){
        $_html = readHtml("member/accountsetting/accountsetting_singlemail");
        $_html = str_replace("%mailid%", $_mail["mailid"], $_html);
        $_html = str_replace("%mailtime%", $_mail["recvtime"], $_html);
        $_html = str_replace("%mailstatus%", $_mail["status"], $_html);
        $_html = str_replace("%mailmessage%", $_mail["message"], $_html);
        $allmails = $allmails.$_html;
    }
    $page = str_replace("%allreceivemails%", $allmails, $page);
    return $page;
}

function makeSendBoxMailPage($sendmails){
    $page = readHtml("member/accountsetting/accountsetting_sendbox");
    $allmails = '';
    foreach($sendmails as $_mail){
        $_html = readHtml("/member/accountsetting/accountsetting_singlemail");
        $_html = str_replace("%mailid%", $_mail["mailid"], $_html);
        $_html = str_replace("%mailtime%", $_mail["recvtime"], $_html);
        $_html = str_replace("%mailstatus%", $_mail["status"], $_html);
        $_html = str_replace("%mailmessage%", $_mail["message"], $_html);
        $allmails = $allmails.$_html;
    }
    $page = str_replace("%allsendmails%", $allmails, $page);
    return $page;
}

function makewriteMessagePage(){
    return readHtml("/member/accountsetting/accountsetting_writemessage");
}

function makebettingRecordsPage($bettingrecords){
    $page = readHtml("member/accountsetting/accountsetting_bettingrecord");
    $allrecords = '';
    $totalCounts = 0;
    $totalAmount = 0;
    $totalResult = 0;
    foreach($bettingrecords as $_record){
        $totalCounts += $_record["counts"];
        $totalAmount += $_record["amount"];
        $totalResult += $_record["result"];
        $_html = readHtml("member/accountsetting/accountsetting_singlerecord");
        $_html = str_replace("%productName%", $_record["name"], $_html);
        $_html = str_replace("%bettingCount%", $_record["counts"], $_html);
        $_html = str_replace("%bettingAmount%", $_record["amount"], $_html);
        $_html = str_replace("%BettingResult%", $_record["result"], $_html);
        $allrecords = $allrecords.$_html;
    }
    $page = str_replace("%AllBettingRecords%", $allrecords, $page);
    $page = str_replace("%TotalCounts%", $totalCounts, $page);
    $page = str_replace("%TotalAmount%", $totalAmount, $page);
    $page = str_replace("%TotalResult%", $totalResult, $page);
    return $page;
}

?>