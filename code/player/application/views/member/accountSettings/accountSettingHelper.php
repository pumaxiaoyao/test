<?php
include "./application/utilities/utilities.php";
function initAccountSettingPage($pageName){
    $names = array("", "kodo");
    $sexy  = array("1", "2");
    $mails = array("", "tencent.qq.com");
    $phone = array("", "13800138000");
    $cards = array("", "8198561595684458");
    $_SESSION["UserBasicInfo"] = array(
        "userId"=>"loginTest",
        "password"=>"password",
        "basicInfo"=>array(
                            "username"=>$names[array_rand($names)],
                            "sex"=>$sexy[array_rand($sexy)],//1-male,2-female
                            "birthday"=>"1997-7-1",
                            "address"=>array(
                                        "province"=>"1",
                                        "city"=>"1",
                                        "area"=>"1"
                            ),
                            "street"=>"美国有达州",
                        ),
        "email"=>$mails[array_rand($mails)],
        "phone"=>$phone[array_rand($phone)],
        "bankCard"=>$cards[array_rand($cards)],
        "mainBalance"=>(float)rand(100, 10000)/1.0,
        );

    echo makeHeader("member/accountsetting/accountsetting_header_metas","");
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
    $page = file_get_contents("./html/member/accountsetting/accountsetting_common.html");
    $names = array("", "kodo");
    
    $basicInfo = getSessionValue("UserBasicInfo", "False");
    
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
    

    if ($basicInfo != "False"){
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
    $page = file_get_contents("./html/member/accountsetting/accountsetting_basicinfo.html");

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
            // "AccountSafetyLevel"=>$SafetyLevelWords,
            // "PhoneBindStatus"=>!empty($basicInfo["phone"])?"on":"",
            // "EmailBindStatus"=>!empty($basicInfo["email"])?"on":"",
            // "UserinfoBindStatus"=>!empty($basicInfo["basicInfo"]["username"])?"on":"",
            // "BankcardBindStatus"=>!empty($basicInfo["bankCard"])?"on":"",
            // "MainBalance"=>$basicInfo["mainBalance"],

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
            $page = file_get_contents("./html/member/accountsetting/accountsetting_unBindPhone.html");
        }else{
            $page = file_get_contents("./html/member/accountsetting/accountsetting_BindPhone.html");
            $page = str_replace("%BindPhoneNumber%", $basicInfo["phone"], $page);

        }
    }
    return $page;
}

function makeAccsMailPage(){
    $basicInfo = getSessionValue("UserBasicInfo", "False");
    if ($basicInfo != "False"){
        if (empty($basicInfo["email"])){
            $page = file_get_contents("./html/member/accountsetting/accountsetting_unBindMail.html");
        }else{
            $page = file_get_contents("./html/member/accountsetting/accountsetting_BindMail.html");
            $page = str_replace("%BindEmailAddr%", $basicInfo["email"], $page);
        }
    }
    return $page;
}

function makeReceiveBoxMailPage($receivemails){
    $page = file_get_contents("./html/member/accountsetting/accountsetting_receivebox.html");
    $allmails = '';
    foreach($receivemails as $_mail){
        $_html = file_get_contents("./html/member/accountsetting/accountsetting_singlemail.html");
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
    $page = file_get_contents("./html/member/accountsetting/accountsetting_sendbox.html");
    $allmails = '';
    foreach($sendmails as $_mail){
        $_html = file_get_contents("./html/member/accountsetting/accountsetting_singlemail.html");
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
    return file_get_contents("./html/member/accountsetting/accountsetting_writemessage.html");
}

function makebettingRecordsPage($bettingrecords){
    $page = file_get_contents("./html/member/accountsetting/accountsetting_bettingrecord.html");
    $allrecords = '';
    $totalCounts = 0;
    $totalAmount = 0;
    $totalResult = 0;
    foreach($bettingrecords as $_record){
        $totalCounts += $_record["counts"];
        $totalAmount += $_record["amount"];
        $totalResult += $_record["result"];
        $_html = file_get_contents("./html/member/accountsetting/accountsetting_singlerecord.html");
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