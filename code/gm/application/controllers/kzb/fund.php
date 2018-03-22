<?php

/** 
 * MVC路由功能简单实现 
 * @desc 简单实现MVC路由功能  
 */  

registerDataHelper(array("protoHelper", "dataHelper"));
registerViewHelper(array("GmViewHelper"));

class Fund  
{
    function adjust($request){
        /**
         * 调整资金余额
         */
        $account = getArrayValue("uid", "", $request);
        $atype = (int)getArrayValue("atype", 1, $request); // 调整类型， 1为增加，2为减少
        $amount = (float)getArrayValue("amount", 0, $request, true); // 调整金额
        if ($atype == 2){
            $amount = 0 - $amount;
        }
        if (empty($account)){
            $ret = array("c"=>404, "m"=>"请输入玩家账号", "d"=>null); 
        }else{
            $argus = array(
                    getArrayValue("uid", "", $request), // 调整玩家的账号
                    $amount,
                    urldecode(getArrayValue("remark", "", $request)), // 备注
                    "", //调试期间,暂时为空, getArrayValue("bcid", "", $request), // 平台银行卡的编号，包网商的配置
                    (float)getArrayValue("flows", 0, $request, true), // 调整取款流水的金额
                    "IBC",//调试期间,默认为IBC getArrayValue("gpid", "0", $request), // 对应平台ID，0为全平台
                    
                );
            
            $retJson = gmServerCaller("PlayerAdjustBalanceAmount", $argus);
            if (getArrayValue(0, "", $retJson) == 1){
                $ret = array("c"=>0, "m"=>"adjust balance success", "d"=>$retJson); 
            }else{
                $ret = array("c"=>404, "m"=>$retJson[1], "d"=>$retJson); 
            }
        }
        output($ret, "json");
    }  

    function bouns($request){
        /**
         * 调整红利
         */

        $atype = (int)getArrayValue("atype", 1, $request); // 调整类型， 1为增加，2为减少
        $amount = (float)getArrayValue("amount", 0, $request, true); // 调整金额
        $account = getArrayValue("uid", "", $request);
        $note = urldecode(getArrayValue("remark", "", $request));
        $flow = (float)getArrayValue("flows", 0, $request, true);
        $gpId = getArrayValue("gpid", "", $request);
        if ($atype == 2){
            $amount = 0 - $amount;
        }
        if (empty($account)){
            $ret = array("c"=>404, "m"=>"请输入玩家账号", "d"=>null); 
        }else{
            $argus = array(
                $account, // 调整玩家的账号
                $amount,
                $note, // 备注
                0, //getArrayValue("actid", "", $request), // 对应平台ID，0为全平台
                $flow, // 流水限制金额
                $gpId, // 对应平台ID，0为全平台
            );
        
            $retJson = gmServerCaller("PlayerGrantBonus", $argus);
            if (getArrayValue(0, "", $retJson) == 1){
                $ret = array("c"=>0, "m"=>"adjust balance success", "d"=>$retJson); 
            }else{
                $ret = array("c"=>404, "m"=>$retJson[1], "d"=>$retJson); 
            }
        }
        
        output($ret, "json");
    }

    /**
     * 通过存款审核
     *
     * @param [type] $request URI
     * 
     * @return void
     */
    function pass($request)
    {
        $argus = array(
            getArrayValue("dno", "", $request), // 申请的订单号
            (float)getArrayValue("actual", 0, $request, true), // 真实的资金数量
            (float)getArrayValue("ddeals", 0,  $request, true), // 存款补助金额
            (float)getArrayValue("bonus", 0, $request, true), // 本次红利金额

            (float)getArrayValue("flows", 0, $request, true), // 取款流水限制
            getArrayValue("dgpid", 0, $request), // 存款流水限平台
            getArrayValue("bgpid", 0, $request), // 红利流水限平台
            getArrayValue("actid", 0, $request), // 对应的活动ID
            urldecode(getArrayValue("dealremark", "TODO", $request)), // 备注信息

        );

        $retJson = gmServerCaller("DepositApplyAgree", $argus);
        if (getArrayValue(0, "", $retJson) == 1) {
            $ret = array("c"=>0, "m"=>"adjust balance success", "d"=>$retJson); 
        } else {
            $ret = array("c"=>404, "m"=>getArrayValue(1, "科多没有写错误原因", $retJson), "d"=>$retJson); 
        }
        return output($ret, "json");
    }

    function refuse($request){

        $requestdno = getArrayValue("dno", "", $request);
        $remark  = getArrayValue("dealremark", "TODO", $request);

        if (empty($requestdno) || empty($remark)){
            return false;
        }

        $retJson = gmServerCaller("DepositApplyRefuse", array($requestdno, $remark));
        if (getArrayValue(0, "", $retJson) == 1){
            $ret = array("c"=>0, "m"=>"adjust balance success", "d"=>$retJson); 
        }else{
            $ret = array("c"=>404, "m"=>getArrayValue(1, "科多没有写错误原因", $retJson), "d"=>$retJson); 
        }
        return output($ret, "json");
    }

    function freetas9k($request){

    }
}
?>
