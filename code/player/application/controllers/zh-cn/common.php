<?php
/*
工具类脚本
*/

include "./application/utilities/PublicArgus.php";
//工具库，必须引入
include_once "./application/utilities/utilities.php";

function getSessionValue($_key = "", $_value = ""){
    return isset($_SESSION[$_key])?$_SESSION[$_key] : $_value;
}


function getArrayValue($_key = "", $_value = "", $_arr = array()){
    return isset($_arr[$_key])?$_arr[$_key] : $_value;
}

function readHtml($_html){
    $filepath = "./static/html/".$_html.".html";
    if (is_file($filepath)){
        return file_get_contents($filepath);
    }else{
        return "";
    }
}

function makeHeader($_metas, $_scripts){
    //读取指定配置文件
    $metas_str = readHtml($_metas);
    $script_str = readHtml($_scripts);
    $LoginStatus = getSessionValue("LoginStatus", "False");
    $MemberName = getSessionValue("MemberName", "");
    // echo "LoginStatus - ".$LoginStatus." MemberName - ".$MemberName;
    if ($LoginStatus == "True"){
        //登陆成功，这里可以取服务器数据了
        $getMainInfoRequest = json_encode(array(
            "call"=>"GetMainInfo",
            "params"=>array($MemberName),
        ));
        
        $retJson = getServerJSon($getMainInfoRequest);
        //"$retJson is ".print_r($retJson);
        $retCode = json_decode($retJson, true);

        // return vals : base.name, base.email, base.cellPhoneNo, isBindBankCard, base.birthDate, 1, common.mainBalance
        $_SESSION["memberinfo"] = array(
            "Email"=>$retCode[1],
            "Phone"=>$retCode[2],
            "isBindCard"=>$retCode[3],
            "RealName"=>$retCode[0],
            "Birthday"=>$retCode[4],
            "BankCards"=>array(),
            "MessageCount"=>$retCode[5],
            "MainBalance"=>$retCode[6],
            );
    }

    $memberinfo = getSessionValue("memberinfo", array());
    
    $replaceWords = array(
        "%HeaderMetas%" => $metas_str,
        "%HeaderScripts%" => $script_str,
        "%WebTitle%" => $GLOBALS["Titles"][getSessionValue("PageClass","index")],//router里设置的标题名的tag
        "%LoginMemberName%"=>getSessionValue("MemberName",""), 
        "%WebKeyWords%" => $GLOBALS["WebKeyWords"],
        "%WebDescription%" => $GLOBALS["WebDescription"],
    );
    $page = readHtml("common/commonheader");
    foreach($replaceWords as $_key => $_value){
        $page = str_replace($_key, $_value, $page);
    }
    return $page;
}

function makeNav(){
    $page = readHtml("common/commonNavigate");
    $LoginStatus = getSessionValue("LoginStatus", "False");
    $page = str_replace("%LoginStatus%", $LoginStatus, $page);
    
    if ($LoginStatus == "True"){
        $memberinfo = getSessionValue("memberinfo", array());
        $MemberName = getSessionValue("MemberName","");
        $MessageCount = getArrayValue("MessageCount", 0, $memberinfo);

        $loginPanel = readHtml("common/navigate_login");
        $loginPanel = str_replace("%LoginMemberName%", $MemberName, $loginPanel);
        $loginPanel = str_replace("%MessageCount%", $MessageCount, $loginPanel);
        $loginPanel = str_replace("%MainBalance%", number_format(getArrayValue("MainBalance", 0, $memberinfo), 2), $loginPanel);
    }else{
        $loginPanel = readHtml("common/navigate_logout");
    }
    echo str_replace("%LoginPanel%", $loginPanel, $page);
}


?>