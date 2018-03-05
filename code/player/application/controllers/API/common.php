<?php
registerDataHelper(array("protoHelper"));

/**
 * 一些通用的接口，用于直接给JS提供数据返回
 */
class Common{
    
    
    
    /**
     * 检测在线状态的接口和接受服务器推送状态的接口
     *
     * @return void
     */
    static function CheckStatus(){

        $LoginStatus = checkLoginStatus();
        if(!$LoginStatus[0]){
            LoginReset(false);
            return output(array(), "json");
        }else{
            $retJson = GmServerCaller("GetSessionState", array($LoginStatus[3]));
            if (getArrayValue("code", "", $retJson) == 200){
                $retData = getArrayValue(0, "", $retJson["data"]);
                // $retJson["code11"] = $retData;
                if (getArrayValue("isOk", "", $retData) == false){
                    $inValidMsg = getArrayValue("code", "", $retData);
                    if ($inValidMsg == "kickByGM"){
                        $time1 = parseDate(getArrayValue('time', '', $retData));
                        $inValidMsg = "您因违规，于[".$time1."]被客服强制下线";
                    }
                    $retJson["Message"] = $inValidMsg;
                    $retJson["code"] = 999;
                }
                
            }
            output($retJson, "json");
        }
     }

    static function CheckAgentStatus() {
        $LoginStatus = checkAgentLoginStatus();
        if(!$LoginStatus[0]){
            AgentLoginReset(false);
            return output(array(), "json");
        }else{
            $retJson = agentServerCaller("GetSessionState", array($LoginStatus[3]));
            if (getArrayValue("code", "", $retJson) == 200){
                $retData = getArrayValue(0, "", $retJson["data"]);
                // $retJson["code11"] = $retData;
                if (getArrayValue("isOk", "", $retData) == false){
                    $inValidMsg = getArrayValue("code", "", $retData);
                    if ($inValidMsg == "kickByGM"){
                        $time1 = parseDate(getArrayValue('time', '', $retData));
                        $inValidMsg = "您因违规，于[".$time1."]被客服强制下线";
                    }
                    $retJson["Message"] = $inValidMsg;
                    $retJson["code"] = 999;
                }
            }
            output($retJson, "json");
        }
     }
     
    function ModifyIp($request){
        if (empty($request)){
            $config = json_decode(file_get_contents("../config.json"), true);
            $html = readHtml("config");

            $html = str_replace("%GM_ServerHost%", $config["GM"]["ServerHost"], $html);
            $html = str_replace("%GM_ServerPort%", $config["GM"]["ServerPort"], $html);
            $html = str_replace("%GM_ShowDebug%", $config["GM"]["ShowDebug"], $html);
            $html = str_replace("%WEB_ServerHost%", $config["WEB"]["ServerHost"], $html);
            $html = str_replace("%WEB_ServerPort%", $config["WEB"]["ServerPort"], $html);
            $html = str_replace("%WEB_ShowDebug%", $config["WEB"]["ShowDebug"], $html);

            output($html);
        }else{
            echo writeServerConfig($request);
            // output(array("code"=>200, "Message"=>"配置修改成功"), "json");
            // header("location:/API/common/ModifyIp");
        }
        
    }

    static function GetPlatforms(){
        $LoginStatus = checkLoginStatus();
        if(!$LoginStatus[0]){
            LoginReset();
            return false;
        }
        
        $memberinfo = getSessionValue("memberinfo", array());
        $MainBalance = getArrayValue("MainBalance", 0, $memberinfo, true);

        //array("id"=>"10000","name"=>"主账户","status"=>1,"i"=>"0","s"=>"","e"=>"","flag"=>1,"nb"=>0),
        $validGP = array("MAIN", "IBC");
        $GPData = array();
        foreach($validGP as $_gp){
            $_gp_name = getArrayValue($_gp, "未定义", $GLOBALS["GP_Names"]);
            // $retJson = GmServerCaller("GetBalanceAmount", array($MemberName, $_gp));
            // print_r($retJson);
            // if ($retJson["code"] == 200){
            array_push($GPData,array("id"=>$_gp,"name"=>$_gp_name,"status"=>1,
                    "i"=>"0","s"=>"","e"=>"","flag"=>1,"nb"=>$MainBalance));
            // }else{
            //     array_push($GPData,array("id"=>$_gp,"name"=>$_gp_name,"status"=>0,
            //     "i"=>"0","s"=>"","e"=>"","flag"=>0,"nb"=>0)
            //     );
            // }
        }
        $ret = array(
            "code"=>0,
            "data"=>array($GPData, $MainBalance),
            );
        output($ret, "json");
    }

    static function RefreshBalance($request){
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

        $LoginStatus = checkLoginStatus();
        if(!$LoginStatus[0]){
            LoginReset();
            return output(array(), "json");
        }

        $retJson = GmServerCaller("GetBalanceAmount", array($LoginStatus[3], $partner));
        $retJson["GP"] = $partner;
        $retJson["amount"] = getArrayValue(2, 0, $retJson["data"]);
        unset($retJson["data"]);
        if ($retJson["code"] == 200){
            if (!isset($_SESSION["Balance"])){
                $_SESSION["Balance"] = array();
            }
            $_SESSION["Balance"][$partner] = $retJson["amount"];
            
            return output($retJson, "json");
        }else{
            return output($retJson, "json");
        }       
    }

    static function GetPlatformLogin(){
        /**
         * 默认登录体育平台
         */
        $Platform = "IBC";
        $LoginStatus = checkLoginStatus();
        if(!$LoginStatus[0]){
            LoginReset();
            return output(ProcessSportsLoginWithoutAccount());
        }else{
            $retJson = GmServerCaller("LoginPlatform", array($LoginStatus[3], $Platform));
            if ($retJson["code"] == 200){
                return output(ProcessSportsLogin($retJson["data"][1]));
            }else{
                return output(ProcessSportsLoginWithoutAccount());
            }
        }
    }

    static function DepositCash($request){
        /**
         * 玩家存款申请
         */
        $LoginStatus = checkLoginStatus();
        if(!$LoginStatus[0]){
            LoginReset();
            return false;
        }
        $banktype = getArrayValue("banktype", "", $request);
        $depostimode = getArrayValue("mode", "", $request);
        $amount = (int)getArrayValue("amount", 0, $request);
        //$depostimode = getArrayValue("mode", "", $request);
        if (empty($banktype) || empty($depostimode) || empty($amount)){
            return false;
        }
        $retJson = GmServerCaller("ApplyDeposit", array($LoginStatus[3], $amount));
        return output($retJson, "json");
    }

    static function WithdrawalCash($request){
        /**
         * 玩家提款申请
         */
        $LoginStatus = checkLoginStatus();
        if(!$LoginStatus[0]){
            LoginReset(false);
            return false;
        }
        $CardIdx = (int)getArrayValue("bank", 1, $request);
        $Amount = (float)getArrayValue("amount", 0, $request, true);
        $Action = getArrayValue("action", "create", $request);
        
        $retJson = GmServerCaller("ApplyWithdrawal", array($LoginStatus[3], $Amount, $CardIdx));
        
        if($retJson["code"] == 200){
            $retJson["Message"] = "取款申请提交成功，请等待客服处理";
        }else{
            $retJson["Message"] = "取款申请提交失败，请找客服检查";
        }
        return output($retJson, "json");
    }

    static function agentWithdrawalCash($request){
        /**
         * 玩家提款申请
         */
        $LoginStatus = checkAgentLoginStatus();
        if(!$LoginStatus[0]){
            AgentLoginReset(false);
            return false;
        }
        $CardIdx = (int)getArrayValue("bank", 1, $request);
        $Amount = (float)getArrayValue("amount", 0, $request, true);
        $Action = getArrayValue("action", "create", $request);
        
        $retJson = agentServerCaller("ApplyWithdrawal", array($LoginStatus[3], $Amount, $CardIdx));
        
        if($retJson["code"] == 200){
            $retJson["Message"] = "取款申请提交成功，请等待客服处理";
        }else{
            $retJson["Message"] = "取款申请提交失败，请找客服检查";
        }
        return output($retJson, "json");
    }
    
    static function TransferCash($request){
        $LoginStatus = checkLoginStatus();
        if(!$LoginStatus[0]){
            LoginReset();
            return false;
        }
        $transferFrom = getArrayValue("source", "", $request);
        $transferTo = getArrayValue("dest", "", $request);
        $amount = (float)getArrayValue("amount", 0, $request);
        
        if (empty($transferFrom) || empty($transferTo) || $amount === 0){
            return false;
        }

        if ($transferFrom == "MAIN"){
            //主账户转出
           $retJson = GmServerCaller("TransactOut", array($LoginStatus[3], $amount, $transferTo));
        }else{
            //主账户转入
            $retJson = GmServerCaller("TransactIn", array($LoginStatus[3], $amount, $transferFrom));
        }
        output($retJson, "json");
    }

    static function DoTransfer($request){
        $LoginStatus = checkLoginStatus();
        if(!$LoginStatus[0]){
            LoginReset();
            return false;
        }

        $transferFrom = getArrayValue("tout", "", $request);
        $transferTo = getArrayValue("tin", "", $request);
        $amount = (int)getArrayValue("amount", 0, $request);

        if ($transferFrom == $transferTo){
            return output(array(), "json");
        }

        if ($transferFrom == "MAIN"){
            //主账户转出
            
           $retJson = GmServerCaller("TransactOut", array($LoginStatus[3], $amount, $transferTo));
        }else{
            //主账户转入
            $retJson = GmServerCaller("TransactIn", array($LoginStatus[3], $amount, $transferTo));
        }
        output($retJson, "json");
        
    }

    static function GetLBCPLogin(){
        $key="s19FDSAdf345saf5,1FDSAds518df4243____fds-a434fD32dEE54325_fda265__kj534fgsa5.5fdfd32z3Qw4543HK/I43te0";
        $key1='dsafd34423aecx1dfas23fdsaf';
        $key2= '2017.10.27 21:15:39--';
        
        $gs_url='https://cbw1.cb001.net/cp/';

        $LoginStatus = checkLoginStatus();
        if(!$LoginStatus[0]){
            LoginReset();
            return output(ProcessSportsLoginWithoutAccount());
        }else{
            $MemberName = "nb_".$LoginStatus[2];
            $MemberPasswd = "nb_".$LoginStatus[2];
            $urlRefer = 'http://www.baidu.com';
            $PlatformUrl = $gs_url."login.php";
            $signstr = md5($key1 . $MemberName . $key . $MemberPasswd . $urlRefer . $key2);
            $requestArgus = array(
                "uno"=>$MemberName,
                "pw" =>$MemberName,
                "refurl"=>$urlRefer,
                "signstr"=>$signstr
            );

            $o = "";
            foreach ( $requestArgus as $k => $v ) 
            { 
                $o.= "$k=" . urlencode( $v ). "&" ;
            }
            $requestArgus = substr($o,0,-1);
        // return output("https://cbw1.cb001.net/cp/login.php?uno=alien1&pw=alien123&refurl=http%3A%2F%2Fwww.baidu.com&signstr=dae222ad32df9c0f89d5e380ca2d3fa6");

        return output($PlatformUrl . "?" . $requestArgus );
        }
    }
}
?>