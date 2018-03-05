<?php
/**
 * 工具类
 */
registerDataHelper(array("protoHelper"));

/**
 * 重置登录相关的缓存session数据
 *
 * @param boolean $needRefer 是否需要跳转
 * 
 * @return void
 */
function AgentLoginReset($needRefer = true){
    /**
     * 重置session数据
     */
    $_SESSION["AgentACC"] = "";
    $_SESSION["AgentLogin"] = "False";
    $_SESSION["AgentSessionID"] = "";
    try{
        session_regenerate_id();
    }catch(Exception $e){
        
    }
    if(session_status () !== PHP_SESSION_ACTIVE){
        session_start();
    }
    
    if ($needRefer){
        header("sessionstatus: sessioninvalid");
        header("location:/agent/agents/Index");
    }
}


function checkAgentLoginStatus(){
    /**
     * 获取登录校验变量
     */

    $LoginStatus = getSessionValue("AgentLogin", "False");
    $MemberName = getSessionValue("AgentACC", "");
    $loginSession = getSessionValue("AgentSessionID", "");
    if ($LoginStatus === "True" && !empty($MemberName) && !empty($loginSession)){
        return array(true, $LoginStatus, $MemberName, $loginSession);
    }else{
        return array(false, $LoginStatus, $MemberName, $loginSession);
    }
}



function makeAgentNav()
{
    $page = readHtml("agents/common/commonNavigate");
    $loginStatus = checkAgentLoginStatus();
    $systemTime = date("Y,m-1,d,H,i,s", time());
    // 2017,10,20,19,07,21   
    $page = str_replace("%LoginStatus%", $loginStatus[1], $page);
    $page = str_replace("%SystemTime%", $systemTime, $page);
    if ($loginStatus[0]){
        $agentInfos = getSessionValue("agentInfos", array());
        $MessageCount = getArrayValue("MessageCount", 0, $agentInfos);

        $loginPanel = readHtml("agents/common/navigate_login");
        $loginPanel = str_replace("%LoginMemberName%", $loginStatus[2], $loginPanel);
        $loginPanel = str_replace("%MessageCount%", $MessageCount, $loginPanel);
        $loginPanel = str_replace("%MainBalance%", getArrayValue("MainBalance", 0, $agentInfos, true), $loginPanel);
    }else{
        $loginPanel = readHtml("agents/common/navigate_logout");
    }
    return str_replace("%LoginPanel%", $loginPanel, $page);
}


function makeAgentHeader($_metas, $_scripts){
    //读取指定配置文件
    $metas_str = readHtml($_metas);
    $script_str = readHtml($_scripts);
    $loginStatus = checkAgentLoginStatus();
    if ($loginStatus[0]){
        //已经是登录状态时，就可以同步取一次后台数据
        refreshAgentInfo($loginStatus);
    }

    $replaceWords = array(
        "%HeaderMetas%" => $metas_str,
        "%HeaderScripts%" => $script_str,
        "%WebTitle%" => $GLOBALS["Titles"][getSessionValue("PageClass","index")],//router里设置的标题名的tag
        "%LoginMemberName%"=>$loginStatus[2], 
        "%WebKeyWords%" => $GLOBALS["WebKeyWords"],
        "%WebDescription%" => $GLOBALS["WebDescription"],
    );
    $page = readHtml("common/commonheader");
    foreach($replaceWords as $_key => $_value){
        $page = str_replace($_key, $_value, $page);
    }
    return $page;
}


function refreshAgentInfo($loginStatus){
    //已经是登录状态时，就可以同步取一次后台数据
    $retJson = agentServerCaller("GetMainInfo", array($loginStatus[3]));
    if ($retJson["code"] == 200){
        $mainInfo = getArrayValue("data", array(), $retJson);
        $mainInfo = getArrayValue(0, array(), $mainInfo);
        if (count($mainInfo) > 0){
            // print_r($mainInfo);
            $_SESSION["agentInfos"] = array(
                "RealName"=>getArrayValue("name", "", $mainInfo),
                "Email"=>getArrayValue("email", "", $mainInfo),
                "Phone"=>getArrayValue("cellPhoneNo", "", $mainInfo),
                "isBindCard"=>getArrayValue("isBindBankCard", false, $mainInfo),
                "MessageCount"=>(int)getArrayValue("newMessageCount", 0, $mainInfo),
                "MainBalance"=>(float)getArrayValue("balance", 0, $mainInfo),
                "BankCards"=>array(),
                "Level"=>(int)getArrayValue("lvl", 1, $mainInfo),
                );
                // print_r( $_SESSION["agentInfos"]);
        }
        
    }else{
        // LoginReset();
        // return $GLOBALS["errorRet"];
    }
}

function doAgentLogin($account, $passwd){
    /**
     * 执行login操作
     */
    $retJson = AgentServerCaller("Login", array($account, $passwd, session_id(), getIp()));
    if ($retJson["code"] == 200){
        $_SESSION["AgentACC"] = $account;
        $_SESSION["AgentLogin"] = "True";
        $_SESSION["AgentSessionID"] = session_id();
    }else{
        AgentLoginReset(false);
    }
    return $retJson;
}

/**
 * 初始化账号管理界面的角色数据页面，该页面应该仅在有数据时显示
*/
function initAgentInfoPage()
{
    
    $page = readHtml("agents/agentInfo/agentInfo_common");
    $LoginStatus = checkAgentLoginStatus();
    if ($LoginStatus[0]){
        $agentInfos = getSessionValue("agentInfos", array());
        $_phone = getArrayValue("Phone", "", $agentInfos);
        $_email = getArrayValue("Email", "", $agentInfos);
        $_name = getArrayValue("RealName", "", $agentInfos);
        $_card = getArrayValue("isBindCard", "", $agentInfos);
        $_balance = getArrayValue("MainBalance", 0, $agentInfos, true);
        
        $replaceWords = array(
            "LoginMemberName"=>$LoginStatus[2],
            "MainBalance"=>$_balance,
        );

        foreach($replaceWords as $_key=>$_val){
            $page = str_replace('%'.$_key.'%', $_val, $page);
        }
        
    }else{
        AgentLoginReset();
    }
    return $page;
}

function setOnShowAgentPageName($page, $pageName){
    /**
     * 根据传入的参数，为页面的名字pageName, 以及页面head区域的不同js配置
     * 此方法只能用于accountsetting页面，其他页面不生效
     */
    $pageSwitchs = array(
        "memberReportsSwitch", "agentReportsSwitch", "benifitReportsSwitch", "agentWithdrawlSwitch", "bankManagerSwitch",
        "agentAccountSwitch", "agentInfoSwitch", "receiveboxSwitch"
    );
    foreach($pageSwitchs as $_pageswitch){
        if (strtolower($_pageswitch) == strtolower($pageName)."switch"){
            $page = str_replace('%'.$_pageswitch.'%', "on", $page);
        }else{
            $page = str_replace('%'.$_pageswitch.'%', "", $page);
        }
    }
    return $page;
}

?>