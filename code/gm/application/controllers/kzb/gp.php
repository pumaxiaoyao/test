<?php

registerDataHelper(array("protoHelper", "dataHelper"));

/**
 * 后台平台相关操作接口
 * 
 */
class Gp
{
    
    /**
     * 获取可以用的平台配置
     *
     * @param [type] $request URI参数
     * 
     * @return void
     */
    static function gps($request)
    {
        $MemberName = getArrayValue("account", "", $request);
        $errorRet = $GLOBALS["errorRet"];
        if (empty($MemberName)) {
            return output($errorRet);
        }
        // $retJson = gmServerCaller("GetAvailablePlatforms", array());
        // if (count($retJson) != 1 && empty($retJson[0])) {
        //     return output($errorRet);
        // } else {
        $balanceJson = gmServerCaller("GetPlayerBalanceAmount", array($MemberName, "MAIN"));
        if (isset($balanceJson[0]) && $balanceJson[0] == 1) {
            $MainBalance = $balanceJson[2];
            if (!array_key_exists($MemberName, $_SESSION)) {
                $_SESSION[$MemberName] = array();
            }
            $_SESSION[$MemberName]["MAIN"] = $MainBalance;
            
            $GPList = array("MAIN", "NB");
            $GPData = array();
            foreach ($GPList as $_gp) {
                $_gp_name = getArrayValue($_gp, "未定义", $GLOBALS["GP_Names"]);
                $_ = array("id"=>$_gp,"name"=>$_gp_name,"status"=>1,"i"=>"0","s"=>"","e"=>"","flag"=>1,"nb"=>0);
                array_push($GPData, $_);
            }
            $ret = array(
                "code"=>0,
                "data"=>array($GPData, (string)$MainBalance),
                );
            output($ret, "json");
        };
    }

    /**
     * 查询玩家余额
     *
     * @param [type] $request URI参数
     * 
     * @return void
     */
    static function balance($request)
    {
        $MemberName = getArrayValue("account", "", $request);
        $GamePlatformID = getArrayValue("gpid", "", $request);
        $errorRet = $GLOBALS["errorRet"];
        
        if (empty($MemberName) || empty($GamePlatformID)) {
             return output($errorRet, "json");
        }

        $retJson = gmServerCaller("GetPlayerBalanceAmount", array($MemberName, $GamePlatformID));

        if (!empty(getArrayValue(0, "", $retJson))) {
            if (!array_key_exists($MemberName, $_SESSION)) {
                $_SESSION[$MemberName] = array();
            }
            $_SESSION[$MemberName][$GamePlatformID] = $retJson[2];

            $ret = array("code"=>0,"data"=>array("gpid"=>$GamePlatformID,"val"=>$retJson[2]));
        } else {
            $ret = $errorRet;
        }

        return output($ret, "json");
    }


    /**
     * 转账交易
     *
     * @param [type] $request URI参数
     * 
     * @return void
     */
    static function transaction($request)
    {

        $MemberName = getArrayValue("account", "", $request);
        $TransAmount = (float)getArrayValue("amount", "0", $request);
        $TransFrom = getArrayValue("tout", "", $request);
        $TransTo = getArrayValue("tin", "", $request);
        
        if (empty($MemberName) || empty($TransAmount) || empty($TransFrom) || empty($TransTo)) {
            return output(array("c"=>1236,"m"=>"","d"=>null), "json"); 
        }

        if ($TransFrom == $TransTo) {
            return output(array("c"=>1080,"m"=>"不能同平台互转","d"=>null), "json"); 
        }
        
        if ($TransFrom == "MAIN") {
            //主账户转出

            $retJson = gmServerCaller("TransactOut", array($MemberName, $TransAmount, $TransTo));
        } else {
            //主账户转入
            $retJson = gmServerCaller("TransactIn", array($MemberName, $TransAmount, $TransFrom));
        }

        if (getArrayValue(0, "", $retJson) == 1) {
            return output(array("c"=>0,"m"=>"","d"=>null), "json"); 
        } else {
            return output(array("c"=>1080,"m"=>"转账失败，请联系运维","d"=>null), "json"); 
        }
    }

    // function unsettled(){
    // }

    // function transaction_in(){
    //     $ret = array("c"=>0,"m"=>"","d"=>null);
    //     echo json_encode($ret);
    // }

    /**
     * 回收玩家资金
     *
     * @param [type] $request URI参数
     * 
     * @return void
     */
    function fundreclaim($request)
    {
        $GamePlatformID = getArrayValue("gpid", "", $request);
        $MemberName = getArrayValue("account", "", $request);
        if (empty($MemberName) || empty($GamePlatformID)) {
            return output(array("c"=>1236,"m"=>"","d"=>null), "json"); 
        }
        $MemberBalances = getSessionValue($MemberName, array());
        if (empty($MemberBalances)) {
            return output(array("c"=>1080,"m"=>"玩家Session缓存的账户数据为空","d"=>null), "json");
        } else {
            $GP_Balance = getArrayValue($GamePlatformID, 0, $MemberBalances);
            $reClaimJson = gmServerCaller("TransactIn", array($MemberName, $GP_Balance, $GamePlatformID));
            if (getArrayValue(0, "", $reClaimJson) == 1) {
                return output(array("c"=>0,"m"=>"","d"=>null), "json"); 
            } else {
                $errorMsg = getArrayValue(1, "no msg return by data server.", $reClaimJson);
                return output(array("c"=>1080,"m"=>$errorMsg,"d"=>null), "json");
            }
        }
    }
}  
  
  
?>  