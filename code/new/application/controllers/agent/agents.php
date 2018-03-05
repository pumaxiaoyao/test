<?php
registerDataHelper(array("protoHelper"));
registerViewHelper(array(
        "agent/agentAccViewHelper"
    ));

class Agents{

    use agentAccViewHelper;
    
    /**
     * 检测申请的账号是否可以注册代理
     *
     * @param [type] $request
     * @return void
     */
    static function checkAgentName($request)
    {
        $agName = getArrayValue("aname", "", $request);
        if (empty("agName")) {
            return output("1");
        } else {
            $retJson = agentServerCaller("CheckAccount", array($agName));

            if (getArrayValue("code", "", $retJson) == 200){
                return output("true", "json");
            } elseif (getArrayValue("Message", "", $retJson) == "accountAlreadyExist") {
                return output("用户名已存在", "json");
            } else {
                return output($retJson, "json");
            }
        }
    }

    /**
     * 代理注册的接口
    *
    * @param [type] $request
    * @return void
    */
    static function agentReg($request)
    {
        $agName = getArrayValue("aname", "", $request);
        $agPwd = getArrayValue("apwd", "", $request);
        $agPwd1 = getArrayValue("password1", "", $request);
        $agRealname = getArrayValue("realname", "", $request);
        $agEmail = getArrayValue("email", "", $request);
        $agPhone = getArrayValue("aphone", "", $request);
        $agQQ = getArrayValue("qq", "", $request);
        $verifycode = getArrayValue("verifycode", "", $request);
        $iagree = getArrayValue("iagree", "", $request);

        $ret = array("code"=>500, "Message"=>"");
        if ($iagree != 1) {
            $ret["Message"] = "需要点击同意合营条款和条件才可继续操作";
        } elseif ( $agPwd != $agPwd1) {
            $ret["Message"] = "2次输入的密码不一致，请重新输入";
        } elseif ( $_SESSION['verifycode'] != $verifycode) {
            $ret["Message"] = "验证码校验失败，请重新输入";
        } elseif (empty($agName) || empty($agPwd) || empty($agRealname) || empty($agPhone) || empty($agEmail)) {
            $ret["Message"] = "信息输入不全";//不准发接口来Debug
        } else {
            $retJson = AgentServerCaller("Join", array($agName, $agPwd, $agRealname, $agEmail, $agPhone, $agQQ, getIp()));
            if (getArrayValue("code", "", $retJson) == 200) {
                $ret = $retJson;
            } else {
                $ret["Message"] = "注册失败";
            }
        }

        return output($ret, "json");
    }

    /**
     * 次级代理注册的接口
    *
    * @param [type] $request URI参数
    * @return void
    */
    static function agentClientReg($request)
    {
        $agName = getArrayValue("aname", "", $request);
        $agPwd = getArrayValue("apwd", "", $request);
        $agPwd1 = getArrayValue("password1", "", $request);
        $agRealname = getArrayValue("realname", "", $request);
        $agEmail = getArrayValue("email", "", $request);
        $agPhone = getArrayValue("aphone", "", $request);
        $agQQ = getArrayValue("qq", "", $request);
        $verifycode = getArrayValue("verifycode", "", $request);
        $iagree = getArrayValue("iagree", "", $request);

        $LoginStatus = checkAgentLoginStatus();
        if(!$LoginStatus[0]){
            AgentLoginReset();
            return output(array(), "json");
        }

        $ret = array("code"=>500, "Message"=>"");
        if ($iagree != 1) {
            $ret["Message"] = "需要点击同意合营条款和条件才可继续操作";
        } elseif ( $agPwd != $agPwd1) {
            $ret["Message"] = "2次输入的密码不一致，请重新输入";
        } elseif ( $_SESSION['verifycode'] != $verifycode) {
            $ret["Message"] = "验证码校验失败，请重新输入";
        } elseif (empty($agName) || empty($agPwd) || empty($agRealname) || empty($agPhone) || empty($agEmail)) {
            $ret["Message"] = "信息输入不全";//不准发接口来Debug
        } else {
            $retJson = AgentServerCaller("CreateChildAgent", array($LoginStatus[3], $agName, $agPwd, $agRealname, $agEmail, $agPhone, $agQQ, getIp()));
            if (getArrayValue("code", "", $retJson) == 200) {
                $ret = $retJson;
            } else {
                $ret["Message"] = "注册失败";
            }
        }

        return output($ret, "json");
    }
    /**
     * 代理登录
     *
     * @param [type] $request URI
     * 
     * @return void
     */
    static function login($request)
    {
        $reqAgentAcc = getArrayValue("aname", "", $request);
        $reqAgentPwd = getArrayValue("apwd", "", $request);
        if (empty($reqAgentAcc) || empty($reqAgentPwd)) {
            AgentLoginReset();
        }else{
            $retJson = doAgentLogin($reqAgentAcc, $reqAgentPwd);
            return output($retJson, "json");
        }
    }

    /**
     * 代理登出，清除缓存信息
     *
     * @param [type] $request
     * @return void
     */
    static function logout($request)
    {
        if (getSessionValue("AgentACC", "") == "True") {
            AgentServerCaller("Logout", array(getSessionValue("AgentSessionID", "")));
        }
        AgentLoginReset(false);
        return output(array("code"=>200), "json");
    }


    static function RefreshBalance($request)
    {
        /**
         * 刷新账号余额信息
         */
        $partner = getArrayValue("partnerCode", "", $request);
        if(count($request) == 0){
            $errorRet["Message"] = "未提交参数";
            return output($errorRet, "json");
        }
        if(empty($partner)){
            $errorRet["Message"] = "提交的参数错误";
            return output($errorRet, "json");
        }

        $LoginStatus = checkAgentLoginStatus();
        if(!$LoginStatus[0]){
            AgentLoginReset();
            return output(array(), "json");
        }

        $retJson = AgentServerCaller("GetBalanceAmount", array($LoginStatus[3]));//, $partner));
        // $retJson["GP"] = $partner;
        if ($retJson["code"] == 200){
            // if (!isset($_SESSION["Balance"])){
            //     $_SESSION["Balance"] = array();
            // }
            $_SESSION["Balance"] = $retJson["data"];
            // $_SESSION["Balance"][$partner] = $retJson["data"][1];
            
            return output($retJson, "json");
        }else{
            return output($retJson, "json");
        }   
    }

    /**
     * 每日报表界面的Ajax请求数据处理
     *
     * @param [type] $request
     * @return void
     */
    static function memberlistAjax($request)
    {
        $st = getArrayValue("startdate", "", $request);
        $st = empty($st)?time()-60*24*60*30:strtotime($st);
        $st = $st < 0?0:$st;

        $et = getArrayValue("enddate", "", $request);
        $et = empty($et)?time():strtotime($et);
        $et = $et < 0?0:$et;

        $LoginStatus = checkAgentLoginStatus();
        if(!$LoginStatus[0]){
            AgentLoginReset();
            return false;
        }

        $retJson = agentServerCaller("GetPlayer", array($LoginStatus[3], $st, $et, 1, 999));
        $retData = getArrayValue("data", array(), $retJson);
        $retData = getArrayValue(0, array(), $retData);
        unset($retJson["data"]);
        $content = self::showMemberRepHtml($retData);
        $retJson["content"] = $content;
        $retJson["count"] = getArrayValue("size", 0, $retData);
        return output($retJson, "json");
    }

    /**
     * 投注记录的Ajax数据处理
     *
     * @param [type] $request
     * 
     * @return void
     */
    static function wdHistoryAjax($request)
    {
        $st = getArrayValue("startdate", "", $request);
        $st = empty($st)?time()-60*24*60*30:strtotime($st);
        
        $et = getArrayValue("enddate", "", $request);
        $et = empty($et)?time():strtotime($et);

        $LoginStatus = checkAgentLoginStatus();
        if(!$LoginStatus[0]){
            AgentLoginReset();
            return false;
        }
        $retJson = agentServerCaller("GetBalanceRecord", array($LoginStatus[3], 1, $st, $et, 1, 999));
        $retData = getArrayValue("data", array(), $retJson);
        unset($retJson["data"]);
        $content = self::showwdHistoryRepHtml(getArrayValue(0, array(), $retData));
        $retJson["content"] = $content;
        return output($retJson, "json");
    }

    /**
     * 佣金记录的Ajax数据处理
     *
     * @param [type] $request
     * 
     * @return void
     */
    static function benifitreportAjax($request)
    {
        $LoginStatus = checkAgentLoginStatus();
        if(!$LoginStatus[0]){
            AgentLoginReset();
            return false;
        }
        $retJson = agentServerCaller("GetSettleStatement", array($LoginStatus[3]));
        $retData = getArrayValue("data", array(), $retJson);
        unset($retJson["data"]);
        $retJson["content"] = self::showBenifitReport(getArrayValue(0, array(), $retData));
        return output($retJson, "json");
    }

    /**
     * 合营信息的Ajax请求
     *
     * @return void
     */
    static function agentInfoAjax()
    {
        $LoginStatus = checkAgentLoginStatus();
        if(!$LoginStatus[0]){
            AgentLoginReset();
            return false;
        }
        $retJson = agentServerCaller("GetJointInfo", array($LoginStatus[3]));
        $retData = getArrayValue("data", array(), $retJson);
        unset($retJson["data"]);
        $content = self::showAgentInfoHtml(getArrayValue(0, array(), $retData));
        $retJson["content"] = getArrayValue(0, "", $content);
        $retJson["agentCode"] = getArrayValue(1, "", $content);
        return output($retJson, "json");
    }
    /**
     * 投注记录的Ajax数据处理
     *
     * @param [type] $request
     * 
     * @return void
     */
    static function betHistoryAjax($request)
    {
        $st = getArrayValue("startdate", "", $request);
        $st = empty($st)?time()-60*24*60*30:strtotime($st);
        
        $et = getArrayValue("enddate", "", $request);
        $et = empty($et)?time():strtotime($et);
        
        $LoginStatus = checkAgentLoginStatus();
        if(!$LoginStatus[0]){
            AgentLoginReset();
            return false;
        }

        $reqAcc = getArrayValue("account", "", $request);
        $reqPlat = getArrayValue("platform", "", $request);
        $reqChoose = getArrayValue("choose", "", $request);

        $retJson = agentServerCaller("GetPlayerBetRecord", array($LoginStatus[3], $reqAcc, $reqPlat, $st, $et, 1, 999));
        $retData = getArrayValue("data", array(), $retJson);
        unset($retJson["data"]);
        $content = self::showBetHistoryHtml(getArrayValue(0, array(), $retData));
        $retJson["content"] = $content;
        return output($retJson, "json");
    }


    /**
     * 每日报表的Ajax数据处理
     *
     * @param [type] $request
     * 
     * @return void
     */
    static function dailyreportAjax($request)
    {
        $st = getArrayValue("startdate", "", $request);
        $st = empty($st)?time()-60*24*60*30:strtotime($st);
        
        $et = getArrayValue("enddate", "", $request);
        $et = empty($et)?time():strtotime($et);

        
        $LoginStatus = checkAgentLoginStatus();
        if(!$LoginStatus[0]){
            AgentLoginReset();
            return false;
        }

        $retJson = agentServerCaller("GetDayStatement", array($LoginStatus[3], $st, $et));
        $retData = getArrayValue("data", array(), $retJson);
        unset($retJson["data"]);
        $retData = getArrayValue(0, array(), $retData);

        $gp_arr = array();
        $t_arr = array();
        foreach ($retData as $_ret) {
            $game = getArrayValue("game", "", $_ret);
            if (!in_array($game, $gp_arr)){
                array_push($gp_arr, $game);
            }
            $_date = (string)getArrayValue("day", "", $_ret);
            if (!array_key_exists($_date, $t_arr)) {
                $t_arr[$_date] = array();
            }

            if (!array_key_exists($game, $t_arr[$_date])) {
                $t_arr[$_date][$game] = array();
            }
            array_push($t_arr[$_date][$game], $_ret);
        }
        $_title = "<tr><th width=\"120px\">日期</th><th>合计<br/>投注/输赢</th>";
        foreach ($gp_arr as $_gp) {
            $_title .= "<th width=\"120px\">".$_gp."<br/>投注/输赢</th>";
        }
        $_title .= "</tr>";
        $html = "";

        ksort($t_arr);
        foreach ($t_arr as $_dt => $gd) {
            
            $tBet = 0;
            $tWin = 0;
            $_tds = "";
            foreach ($gd as $_gp=>$_td) {
                $_td_data = getArrayValue(0, array(), $_td);
                $bet = getArrayValue("stakeAmount", 0 , $_td_data);
                $win = getArrayValue("winLoseAmount", 0 , $_td_data);
                $tBet += $bet;
                $tWin += $win;
                $_tds .= "<td>". $bet. "/". $win . "</td>"; 
            }
            $_html = "<tr><td>". $_dt. "</td>";
            $_html .= "<td>". $tBet. "/". $tWin . "</td>";
            $_html .= $_tds . "</tr>";
            
            $html .= $_html;
        }

        $retJson["content"] = $html;//$content;
        $retJson["title"] = $_title;
        return output($retJson, "json");
    }

    /**
     * 用户中心界面及处理
     *
     * @param [type] $request URI
     * 
     * @return void
     */
    static function agentAccount($request)
    {
        $LoginStatus = checkAgentLoginStatus();
        if(!$LoginStatus[0]){
            AgentLoginReset();
            return false;
        }

        $action = getArrayValue("action", null, $request);
        if(count($request) == 0 || !isset($request["action"]) || empty($request["action"])){
            return self::showAgentAccount();
        }

        switch ($action){
            case "updateinformation":
                $FirstName = getArrayValue("FirstName", "", $request);
                $isFristName = getArrayValue("isFristName", "", $request);
                if (!empty($FirstName)){
                    $realname = $FirstName;
                }elseif(!empty($isFristName)){
                    $realname = $isFristName;
                }else{
                    AgentLoginReset();
                    return false;
                }
                $retJson = agentServerCaller("ModifyBaseInfo", array($LoginStatus[3], $realname));
                return output($retJson, "json");
                break;
            case "UpdatePassword":
                $oldPwd = getArrayValue("oldPassword", "", $request);
                $Pwd = getArrayValue("Password", "", $request);
                $rePwd = getArrayValue("rePassword", "", $request);
                $errorRet = $GLOBALS["errorRet"];
                if (empty($oldPwd)){
                    $errorRet["Message"] = "沙雕，旧的密码错了";
                    return output($errorRet, "json");
                }
                if (empty($Pwd) || empty($rePwd)){
                    $errorRet["Message"] = "沙雕，新的密码没填";
                    return output($errorRet, "json");
                }
                if ($Pwd != $rePwd){
                    $errorRet["Message"] = "沙雕，新的密码2次输入要一样";
                    return output($errorRet, "json");
                }
                $retJson = agentServerCaller("ModifyPwd", array($LoginStatus[3], $oldPwd, $Pwd));
                if (getArrayValue("code", "", $retJson) == 200) {
                    $retJson["Message"] = "密码已经更新，请及时重新登录";
                } else {
                    if (getArrayValue("Message", "", $retJson) == "pwdError") {
                        $retJson["Message"] = "密码错误，请重新输入";
                    } else {
                        $retJson["Message"] = "未识别错误内容，请联系客服";
                    }
                }
                return output($retJson, "json");
                break;
            case "getPhoneCode":
                $phoneNumber = getArrayValue("phoneNumber", "", $request);
                if(empty($phoneNumber)){
                    return output(array("code"=>506, "Message"=>"error."), "json");
                }else{
                    $interval = getSessionValue("GetPhoneCodeTime", 0) + 60 - time();
                    if ($interval < 0) {
                        $_SESSION["WaitedBindPlayerPhone"] = $phoneNumber;
                        $_SESSION["WaitedBindPhoneCode"] = (string)rand(1000, 9999);
                        $_SESSION["GetPhoneCodeTime"] = time();
                        return output(array("code"=>200, "Message"=>"你的验证码是".$_SESSION["WaitedBindPhoneCode"]), "json");
                    } else {
                        return output(array("code"=>404, "Message"=>"请等待".$interval."后再请求验证码", "Time"=>$interval), "json");
                    }
                }
                break;
            case "CheckPhoneCode":
                $phoneCode = getArrayValue("phoneCode", "", $request);
                
                if($phoneCode == $_SESSION["WaitedBindPhoneCode"]){
                    $_SESSION["GetPhoneCodeTime"] = 0;
                    //修改手机号码
                    $retJson = agentServerCaller("ModifyCellPhoneNo", array($LoginStatus[3], $_SESSION["WaitedBindPlayerPhone"]));
                    $retJson = array("code"=>200);
                    if(getArrayValue("code", "", $retJson) == 200){
                        $retJson = array("code"=>200,"Message"=>"绑定手机号码修改成功");
                    }else{
                        $retJson = array("code"=>400,"Message"=>"绑定手机号码修改失败","DEBUG"=>$retJson);
                    }
                }else{
                    $retJson = array("code"=>400,"Message"=>"验证失败，请重新输入您的验证码");
                }
                return output($retJson, "json");
                break;
            case "getUnPhoneCode":
                /**
                 * 下发校验码，缓存在session中
                 */
                $interval = getSessionValue("GetUnPhoneCodeTime", 0) + 60 - time();
                if ($interval < 0) {
                    $_SESSION["WaitedUnBindPhoneCode"] = (string)rand(1000, 9999);
                    $_SESSION["GetUnPhoneCodeTime"] = time();
                    return output(array("code"=>200, "Message"=>"解绑手机的验证码为".$_SESSION["WaitedUnBindPhoneCode"]), "json");
                } else {
                    return output(array("code"=>404, "Message"=>"请等待".$interval."后再请求验证码", "Time"=>$interval), "json");
                }
                break;
            case "UnBindPhone":
                /**
                 * 解绑手机号码，校验session中预存的验证码
                 */
                $phoneCode = getArrayValue("phoneCode", "", $request);
                if($phoneCode == $_SESSION["WaitedUnBindPhoneCode"]){
                    $_SESSION["GetUnPhoneCodeTime"] = 0;
                    $retJson = agentServerCaller("ModifyCellPhoneNo", array($LoginStatus[3], ""));
                    if(getArrayValue("code", "", $retJson) == 200){
                        $retJson = array("code"=>200,"Message"=>"解绑手机号码成功");
                    }else{
                        $retJson = array("code"=>400,"Message"=>"解绑手机号码失败，请联系客服","DEBUG"=>$retJson);
                    }
                }else{
                    $retJson = array("code"=>400,"Message"=>"验证失败，请重新输入您的验证码");
                }
                return output($retJson, "json");
                break;
            case "getUnEmailCode":
                /**
                 * 下发校验码，缓存在session中
                 */
                $interval = getSessionValue("GetUnMailCodeTime", 0) + 60 - time();
                if ($interval < 0) {
                    $_SESSION["WaitedUnBindEmailCode"] = (string)rand(1000, 9999);
                    $_SESSION["GetUnMailCodeTime"] = time();
                    return output(array("code"=>200, "Message"=>"解绑手机的验证码为".$_SESSION["WaitedUnBindEmailCode"]), "json");
                } else {
                    return output(array("code"=>404, "Message"=>"请等待".$interval."后再请求验证码", "Time"=>$interval), "json");
                }
                break;
            case "getEmailCode":
                $mailNumber = getArrayValue("mailNumber", "", $request);
                if(empty($mailNumber)){
                    return output(array("code"=>506, "Message"=>"error."), "json");
                }else{
                    $interval = getSessionValue("GetMailCodeTime", 0) + 60 - time();
                    if ($interval < 0) {
                        $_SESSION["WaitedBindPlayerEmail"] = $mailNumber;
                        $_SESSION["WaitedBindEmailCode"] = (string)rand(1000, 9999);
                        $_SESSION["GetMailCodeTime"] = time();
                        return output(array("code"=>200, "Message"=>"你的验证码是".$_SESSION["WaitedBindEmailCode"]), "json");
                    } else {
                        return output(array("code"=>404, "Message"=>"请等待".$interval."后再请求验证码", "Time"=>$interval), "json");
                    }
                }
                break;
            case "CheckEmailCode":
                $emailCode = getArrayValue("emailCode", "", $request);
                
                if($emailCode == $_SESSION["WaitedBindEmailCode"]){
                    //修改手机号码
                    $_SESSION["GetMailCodeTime"] = 0;
                    $retJson = agentServerCaller("ModifyEmail", array($LoginStatus[3], $_SESSION["WaitedBindPlayerEmail"]));
                    if(getArrayValue("code", "", $retJson) == 200){
                        $retJson = array("code"=>200,"Message"=>"绑定邮箱地址修改成功");
                    }else{
                        $retJson = array("code"=>400,"Message"=>"绑定邮箱地址修改失败","DEBUG"=>$retJson);
                    }
                }else{
                    $retJson = array("code"=>400,"Message"=>"验证失败，请重新输入您的验证码");
                }
                return output($retJson, "json");
                break;
            case "UnBindEmail":
                /**
                 * 解绑手机号码，校验session中预存的验证码
                 */
                $emailCode = getArrayValue("emailCode", "", $request);
                if($emailCode == $_SESSION["WaitedUnBindEmailCode"]){
                    $_SESSION["GetUnMailCodeTime"] = 0;
                    $retJson = agentServerCaller("ModifyEmail", array($LoginStatus[3], ""));
                    if(getArrayValue("code", "", $retJson) == 200){
                        $retJson = array("code"=>200,"Message"=>"解绑邮箱地址成功");
                    }else{
                        $retJson = array("code"=>400,"Message"=>"解绑邮箱地址失败，请联系客服","DEBUG"=>$retJson);
                    }
                }else{
                    $retJson = array("code"=>400,"Message"=>"验证失败，请重新输入您的验证码");
                }
                return output($retJson, "json");
                break;
            default:
                return false;
                break;
            }
    }

    
    function GetBankCode(){
        $_SESSION["WaitedBindCardCode"] = (string)rand(1000, 9999);
        return output(array("code"=>200, "Message"=>"你的验证码是".$_SESSION["WaitedBindCardCode"]), "json");
    }

    function AddBankCard($request){
        /**
         * 添加绑定用户的银行卡
         */
        
        $LoginStatus = checkAgentLoginStatus();
        if(!$LoginStatus[0]){
            AgentLoginReset(false);
            return false;
        }

        $RealName = getArrayValue("RealName", "", $request);
        $BankNo = getArrayValue("BankNo", "", $request);
        $BankType = getArrayValue("BankType", "", $request);
        $RegBank = getArrayValue("RegBank", "", $request);
        $code = getArrayValue("code", "", $request);
        if (empty($BankNo) || empty($BankType) || empty($RegBank) || empty($code) || empty($RealName)){
            return output(array("code"=>400, "Message"=>"参数提交错误"), "json");
        }

        if((int)$code != (int)getSessionValue("WaitedBindCardCode", 0)){
            return output(array("code"=>400, "Message"=>"请输入正确的验证码"), "json");
        }
        $retJson = agentServerCaller("AddBankCard", array($LoginStatus[3], $BankType, $RealName, $BankNo, $RegBank));
        
        return output($retJson, "json");
    }

    function DelBankCard($request){
        /** 
         * 删除用户绑定的银行卡
        */
        $LoginStatus = checkAgentLoginStatus();
        if(!$LoginStatus[0]){
            AgentLoginReset();
            return false;
        }
        $cardIndex = getArrayValue("index", "", $request);
        if (empty($cardIndex)){
            return false;
        }
        $retJson = agentServerCaller("DeleteBankCard", array($LoginStatus[3], (int)$cardIndex));
        return output($retJson, "json");
    }

}
?>