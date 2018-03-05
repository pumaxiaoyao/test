<?php
/**
 * 工具类
 */
registerDataHelper(array("protoHelper"));

function getBankInfo($LoginStatus){
    $retJson = GmServerCaller("GetBankCardInfo", array($LoginStatus[3]));
    if ($retJson["code"] == 200){
        $records = getArrayValue(0, array(), $retJson["data"]);
    }else{
        $records = array();
    }
    return $records;
}


function getAgentBankInfo($LoginStatus){
    $retJson = agentServerCaller("GetBankCardInfo", array($LoginStatus[3]));
    if ($retJson["code"] == 200){
        $records = getArrayValue(0, array(), $retJson["data"]);
    }else{
        $records = array();
    }
    return $records;
}

function doLogin($account, $passwd){
    /**
     * 执行login操作
     */
    $retJson = GmServerCaller("Login", array($account, $passwd, session_id(), getIp(), $_SERVER['SERVER_NAME'], "HTML"));
    if ($retJson["code"] == 200){
        $_SESSION["MemberName"] = $account;
        $_SESSION["LoginStatus"] = "True";
        $_SESSION["SESSIONID"] = session_id();
    }else{
        LoginReset(false);
    }
    return $retJson;
}


function parseDate($timeTag = 0, $Ttype = 1){
    /**
     * 转时间格式
     */
    if ($timeTag === 0){
        $timeTag = time();
    }
    if ($Ttype == 1){
        return date("Y-m-d H:i:s", $timeTag);
    }else if ($Ttype == 2){
        return date("Y-m-d", $timeTag);
    } else {
        return date("Y-m-d", $timeTag)."<br/>".date("H:i:s", $timeTag);
    }
}


function LoginReset($needRefer = true){
    /**
     * 重置session数据
     */
    $_SESSION["MemberName"] = "";
    $_SESSION["LoginStatus"] = "False";
    $_SESSION["SESSIONID"] = "";
    $b=session_id();
    try{
        session_regenerate_id(true);
    }catch(Exception $e){
        var_dunmp($e);
    }
    if(session_status () !== PHP_SESSION_ACTIVE){
        session_start();
    }
    $a=session_id();
    if ($needRefer){
        header("location:/zh-cn/index");
    }
}

function checkLoginStatus(){
    /**
     * 获取登录校验变量
     */

    $LoginStatus = getSessionValue("LoginStatus", "False");
    $MemberName = getSessionValue("MemberName", "");
    $loginSession = getSessionValue("SESSIONID", "");
    if ($LoginStatus === "True" && !empty($MemberName) && !empty($loginSession)){
        return array(true, $LoginStatus, $MemberName, $loginSession);
    }else{
        return array(false, $LoginStatus, $MemberName, $loginSession);
    }
}

function parseRecodeTypes($codeID, $codeID1){
    /**
     * 解析日志状态码
     */
    $statusData = getArrayValue($codeID, array(), $GLOBALS["Record_Types"]);
    return getArrayValue($codeID1, "", $statusData);
}



function getTime($t_tag = "today"){
    if($t_tag == "today"){
        $s_st = time() - 24 * 60 * 60;
    }elseif ($t_tag == "3day"){
        $s_st = time() - 24 * 60 * 60 * 3;
    }elseif ($t_tag == "week"){
        $s_st = time() - 24 * 60 * 60 * 7;
    }elseif ($t_tag == "month"){
        $s_st = time() - 24 * 60 * 60 * 30;
    }else{
        $s_st = time() - 24 * 60 * 60 * 30;
    }

    return $s_st;
}
    

function writeServerConfig($request){
    $configs = array(
        "GM"=>array(
            "ServerHost"=>getArrayValue("gmHost", "localhost", $request),
            "ServerPort"=>getArrayValue("gmPort", "7878", $request),
            "ShowDebug"=>getArrayValue("gmDebug", "true", $request),
        ),
        "WEB"=>array(
            "ServerHost"=>getArrayValue("webHost", "localhost", $request),
            "ServerPort"=>getArrayValue("webPort", "7879", $request),
            "ShowDebug"=>getArrayValue("webDebug", "true", $request),
        )
    );
    $retJson = json_encode($configs);
    file_put_contents(getcwd(). "/../config.json", $retJson);
    return $retJson;
}


function refreshServerConfig(){
    $config = json_decode(file_get_contents(getcwd()."/../config.json"), true);
    $GMConfig = getArrayValue("WEB", array(), $config);
    $ServerHost = getArrayValue("ServerHost", "localhost", $GMConfig);
    $ServerPort = getArrayValue("ServerPort", "7878", $GMConfig);
    $ShowDebug = getArrayValue("ShowDebug", "true", $GMConfig);

    $GLOBALS["ServerHost"] = $ServerHost;
    $GLOBALS["ServerPort"] = $ServerPort;
    $GLOBALS["ShowDebug"] = $ShowDebug;
}


function getSessionValue($_key = "", $_value = ""){
    return (isset($_SESSION[$_key]) && !empty($_SESSION[$_key]))?$_SESSION[$_key] : $_value;
}


function getArrayValue($_key = "", $_value = "", $_arr = array(), $ifTrans = false){
    
    $ret = (!empty($_arr) && array_key_exists((string)$_key, $_arr) && $_arr[$_key] !== "")?$_arr[$_key]:$_value;
    
    if (is_string($ret) ){
        return urldecode($ret);
    }elseif(is_numeric($ret)){
        if ($ifTrans){
            return sprintf('%.2f', $ret);
        }else{
            return round($ret, 2);
        }
    }else{
        return $ret;
    }
}

function output($_data, $_type = "html"){
    if ($_type == "html"){
        $_data = str_replace("%STARTDATE%", parseDate(getTime("month"), 2), $_data);
        $_data = str_replace("%ENDDATE%", parseDate(time(), 2), $_data);
        echo $_data;
    }elseif ($_type == "json"){
        echo json_encode($_data);
    }else{
        print_r($_data);
    }
    return true;
}

function readHtml($_html){
    $filepath = "./static/html/".$_html.".html";
    if (is_file($filepath)){
        return file_get_contents($filepath);
    }
}

function refreshMemberInfo($loginStatus){
    //已经是登录状态时，就可以同步取一次后台数据
    $retJson = GmServerCaller("GetMainInfo", array($loginStatus[3]));
    if ($retJson["code"] == 200){
        $mainInfo = getArrayValue("data", array(), $retJson);
        if (count($mainInfo) > 0){
            $_SESSION["memberinfo"] = array(
                "RealName"=>$mainInfo[0],
                "Email"=>$mainInfo[1],
                "Phone"=>$mainInfo[2],
                "isBindCard"=>$mainInfo[3],
                "MessageCount"=>$mainInfo[4],
                "MainBalance"=>$mainInfo[5],
                "BankCards"=>array(),
                );
        }
        
    }else{
        // LoginReset();
        // return $GLOBALS["errorRet"];
    }
}

function makeHeader($_metas, $_scripts){
    //读取指定配置文件
    $metas_str = readHtml($_metas);
    $script_str = readHtml($_scripts);
    $loginStatus = checkLoginStatus();
    if ($loginStatus[0]){
        //已经是登录状态时，就可以同步取一次后台数据
        refreshMemberInfo($loginStatus);
    }

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
    $loginStatus = checkLoginStatus();
    $systemTime = date("Y,m-1,d,H,i,s", time());
    // 2017,10,20,19,07,21
    $page = str_replace("%LoginStatus%", $loginStatus[1], $page);
    $page = str_replace("%SystemTime%", $systemTime, $page);
    
    if ($loginStatus[0]){
        $memberinfo = getSessionValue("memberinfo", array());
        $MessageCount = getArrayValue("MessageCount", 0, $memberinfo);

        $loginPanel = readHtml("common/navigate_login");
        $loginPanel = str_replace("%LoginMemberName%", $loginStatus[2], $loginPanel);
        $loginPanel = str_replace("%MessageCount%", $MessageCount, $loginPanel);
        $loginPanel = str_replace("%MainBalance%", getArrayValue("MainBalance", 0, $memberinfo, true), $loginPanel);
    }else{
        $loginPanel = readHtml("common/navigate_logout");
    }
    return str_replace("%LoginPanel%", $loginPanel, $page);
}

function getIp() {
    //strcasecmp 比较两个字符，不区分大小写。返回0，>0，<0。
    if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
        $ip = getenv('HTTP_CLIENT_IP');
    } elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
        $ip = getenv('HTTP_X_FORWARDED_FOR');
    } elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
        $ip = getenv('REMOTE_ADDR');
    } elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    $res =  preg_match ( '/[\d\.]{7,15}/', $ip, $matches ) ? $matches [0] : '';
    return $res;
}

?>