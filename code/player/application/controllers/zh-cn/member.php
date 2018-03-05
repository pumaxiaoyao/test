<?php
/**
 * 处理用户相关页面
 */
registerDataHelper(array("protoHelper"));
registerViewHelper(array(
        "member/register/registerViewHelper",
        "member/accountSettings/accsViewHelper",
        "member/funds/fundsViewHelper"
    ));

class Member{
    //class中只直接定义一些公用接口方法
    //实际的操作层级接口，均放入各个页面对应的trait中定义，便于管理
    //加载trait中定义的方法
    use registerViewHelper;
    use accsViewHelper;
    use fundsViewHelper;

    static function namecheck($request){
        /**
         * 检查玩家的账户名是否有效，是否可以注册
         */
        $account = getArrayValue("MemberName", "", $request);
        if (empty($account)){
            return false;
        }
        return output(GmServerCaller("CheckAccount", array($account)), "json");
    }
    

    function registerTest(){
        $MemberNames = array("kodo", "alien", "joker", "alex", "fucker");
        
        $MemberPWD = "joker123";
        for($x=1;$x<500;$x++){
            $requestIP = getIp();
            $NameID = array_rand($MemberNames, 1);
            $retJson = GmServerCaller("Join", array($MemberNames[$NameID].$x, $MemberPWD, $requestIP, $_SERVER['SERVER_NAME'], "HTML"));
            
            doLogin($MemberNames[$NameID].$x, $MemberPWD);
        }     
    }


    function MemberRegistered($request){
        /**
         * 玩家账户注册，并初始化登录状态，缓存到session中
         */
        $MemberName = getArrayValue("MemberName", "", $request);
        $MemberPWD = getArrayValue("Password", "", $request);
        if (!empty($MemberName) && !empty($MemberPWD)){
            $requestIP = getIp();
            $retJson = GmServerCaller("Join", array($MemberName, $MemberPWD, $requestIP));//, $_SERVER['SERVER_NAME'], "HTML"));
            if ($retJson["code"] == 200){
                doLogin($MemberName, $MemberPWD);
            }else{
                LoginReset(false);
            }
            return output($retJson, "json");
        }else{
            return false;
        }
    }

    

    function Login(){
        /**
         * 玩家登录
         */
        $recvJson = getSessionValue("PostJsons", array());
        if(count($recvJson) == 0){
            //参数为空，则不予登录
            self::reglogin();
        }
        $action = getArrayValue("action", null, $recvJson);

        if ($action == "logout"){
            $LoginStatus = checkLoginStatus();
            if(!$LoginStatus[0]){
                LoginReset();
                return false;
            }
            GmServerCaller("Logout", array($LoginStatus[3]));
            LoginReset();
        }elseif($action === "login"){
            $account = getArrayValue("MemberName", "", $recvJson);
            $passwd = getArrayValue("MemberPWD", "", $recvJson);
            if (empty($account) || empty($passwd)){
                LoginReset();
            }else{
                $retJson = doLogin($account, $passwd);
                return output($retJson, "json");
            }
        }else{
            self::reglogin();
        }
    }

    static function AccountSetting($request){
        /**
         * 用户中心界面及处理
         */
        //print_r($request);
        $LoginStatus = checkLoginStatus();
        if(!$LoginStatus[0]){
            LoginReset();
            return false;
        }

        $action = getArrayValue("action", null, $request);
        if(count($request) == 0 || !isset($request["action"]) || empty($request["action"])){
            return self::showAccountSetting();
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
                    LoginReset();
                    return false;
                }
                $requestData = array($LoginStatus[3], urldecode($realname));//, join("-", array($request["BYear"], $request["BMonth"], $request["BDay"])));
                return output(GmServerCaller("ModifyBaseInfo", $requestData), "json");
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
                $retJson = GmServerCaller("ModifyPwd", array($LoginStatus[3], $oldPwd, $Pwd));
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
                    $retJson = GmServerCaller("ModifyCellPhoneNo", array($LoginStatus[3], $_SESSION["WaitedBindPlayerPhone"]));
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
                    $retJson = GmServerCaller("ModifyCellPhoneNo", array($LoginStatus[3], ""));
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
                    $retJson = GmServerCaller("ModifyEmail", array($LoginStatus[3], $_SESSION["WaitedBindPlayerEmail"]));
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
                    $retJson = GmServerCaller("ModifyEmail", array($LoginStatus[3], ""));
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

    static function Retrieve($request){

        $action = getArrayValue("action", null, $request);
        if(count($request) == 0 || !isset($request["action"]) || empty($request["action"])){
            return self::showRetrieve();
        }

        switch ($action){
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
                    $retJson = array("code"=>200,"Message"=>"验证通过");
                }else{
                    $retJson = array("code"=>400,"Message"=>"验证失败，请重新输入您的验证码");
                }
                return output($retJson, "json");
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
                    $retJson = array("code"=>200,"Message"=>"验证通过");
                }else{
                    $retJson = array("code"=>400,"Message"=>"验证失败，请重新输入您的验证码");
                }
                return output($retJson, "json");
                break;
            case "UpdatePassword":
                $Pwd = getArrayValue("Password", "", $request);
                $rePwd = getArrayValue("rePassword", "", $request);
                $errorRet = $GLOBALS["errorRet"];
                
                if (empty($Pwd) || empty($rePwd)){
                    $errorRet["Message"] = "沙雕，新的密码没填";
                    return output($errorRet, "json");
                }
                if ($Pwd != $rePwd){
                    $errorRet["Message"] = "沙雕，新的密码2次输入要一样";
                    return output($errorRet, "json");
                }
                // $retJson = GmServerCaller("ModifyPwd", array("", $Pwd, $rePwd));
                $retJson = array("code"=>200);
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
        }
    }

    function GetBankCode(){
        $_SESSION["WaitedBindCardCode"] = (string)rand(1000, 9999);
        return output(array("code"=>200, "Message"=>"你的验证码是".$_SESSION["WaitedBindCardCode"]), "json");
    }


    static function receivebox($request){
        $page = self::initAccsMemberInfoArea("receivebox");//array data.
        $pageIndex = getArrayValue("pageIndex", "1", $request);
        $LoginStatus = checkLoginStatus();
        if(!$LoginStatus[0]){
            LoginReset();
            return false;
        }
        $retJson = GmServerCaller("GetMessages", array($LoginStatus[3]));// TODO:该请求后台未做好
        
        if($retJson["code"] == 200){
            array_push($page, self::makeReceiveBoxMailPage($retJson["data"], $pageIndex) );
        }else{
            array_push($page, self::makeReceiveBoxMailPage(array(), $pageIndex));
        }
        array_push($page, readHtml("common/commonfooter"));
        output(join("", $page));
    }
    

    function AddBankCard($request){
        /**
         * 添加绑定用户的银行卡
         */
        
        $LoginStatus = checkLoginStatus();
        if(!$LoginStatus[0]){
            LoginReset(false);
            return false;
        }
        $page = self::initAccsMemberInfoArea("receivebox");//array data.

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
        $retJson = GmServerCaller("AddBankCard", array($LoginStatus[3], $BankType, $RealName, $BankNo, $RegBank));
        return output($retJson, "json");
    }

    function DelBankCard($request){
        /** 
         * 删除用户绑定的银行卡
        */
        $page = self::initAccsMemberInfoArea("receivebox");//array data.
        $LoginStatus = checkLoginStatus();
        if(!$LoginStatus[0]){
            LoginReset();
            return false;
        }
        $cardIndex = getArrayValue("index", "", $request);
        if (empty($cardIndex)){
            return false;
        }
        $retJson = GmServerCaller("DeleteBankCard", array($LoginStatus[3], (int)$cardIndex));
        return output($retJson, "json");
    }

    
    function BettingRecords($request){
        /**
         * 查询用户的投注记录
         */
        //$recvJson = Base_GetBetStatisticsRecord($timeTag);// TODO:该请求后台未做好
        $page = self::initAccsMemberInfoArea("receivebox");//array data.
        $LoginStatus = checkLoginStatus();
        if(!$LoginStatus[0]){
            LoginReset();
            return false;
        }
        $s_et = time();
        $startTime = getArrayValue("starttime", "", $request);
        $requestGP = getArrayValue("productid", "", $request);
        if(!empty($requestGP)){
            $startTime = "month";
        }
        if($startTime == "today" || empty($startTime)){
            $s_st = time() - 24 * 60 * 60;
        }elseif ($startTime == "3day"){
            $s_st = time() - 24 * 60 * 60 * 3;
        }elseif ($startTime == "week"){
            $s_st = time() - 24 * 60 * 60 * 7;
        }elseif ($startTime == "month"){
            $s_st = time() - 24 * 60 * 60 * 30;
        }
        $page = self::initAccsMemberInfoArea("bettingrecords");//array data.
        array_push($page, self::initBetRecordJSHtml($startTime));

        
        if (empty($requestGP)){
            //查询汇总数据
            $AllowdGP = array("NB"=>"牛博");
            $bettingRecords = array();
            foreach($AllowdGP as $_gp=>$_name){
                $retJson = GmServerCaller("GetBetRecord", array($LoginStatus[3], $_gp,  $s_st, $s_et));
                
                if (getArrayValue("code", 0, $retJson) == 200){
                    $bettingRecords[$_gp] = array("data"=>getArrayValue(0, array(), $retJson["data"]),"name"=>$_name);
                }else{
                    // todo
                }
            }
            array_push($page, self::makebettingRecordsPage($bettingRecords));
        }else{
            //查询指定平台
            $retJson = GmServerCaller("GetBetRecordDetail", array($LoginStatus[3], $requestGP, $s_st, $s_et, 1, 999));
            // print_r($retJson);
            if(getArrayValue("code", "", $retJson) == 200){
                // print_r($retJson);
                array_push($page, self::makebetGPRecordsPage($requestGP, $retJson["data"]));
            }else{
                // todo 
            }
        }
        array_push($page, readHtml("common/commonfooter"));
        output(join("", $page));
    }
    

}
?>