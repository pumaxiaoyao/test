<?php

/**
 * 玩家资金扩展方法
 * 
 * @category Application/controllers/player
 * @package  Player
 * @author   alien <alien@alien.com>
 * @license  http://license.alien.com/license, alien
 * @link     null
 */
trait Playerfundtrait
{

    /**
     * 流水检查接口
     *
     * @param [type] $request URI参数
     * 
     * @return void
     */
    static function flowLimitOne($request)
    {
        $RequestMemberName = getArrayValue("id", "", $request);
        $flCheckType = (string)getArrayValue("ftype", "1", $request);
        $RequestDno = (string)getArrayValue("dno", "", $request);
        
        $errorRet = $GLOBALS["errorRet"];
        if (empty($RequestMemberName)) {
            return output(array("ok"=>0, "data"=>array()), "json");
        }
        $retJson = gmServerCaller("GetPlayerWithdrawalLimitInfo", array($RequestMemberName));
        $retData = getArrayValue(0, array(), $retJson);

        if ($flCheckType == 2) {
            //针对指定限制单进行查询数据
            $ret = array("ok"=>1, "data"=>array());
            $allGP = array("IBC", "NB");
            foreach ($retData as $_fl) {
                $_fl_dno = (string)getArrayValue("dno", "", $_fl["limit"]);
                if ($RequestDno === $_fl_dno) {
                    $flowData = array();
                    foreach ($allGP as $_gpId) {
                        $_gpName = getArrayValue($_gpId, "", $GLOBALS["GP_NAMES"]);
                        $_ = array(
                            "gpid"=>$_gpId,
                            "gpname"=>$_gpName,
                            "rtype"=>1,
                            "water"=>array()
                        );
                        array_push($flowData, $_);
                    }
                }
            }
        }
        
        $ret = array("ok"=>1, "data"=>array());
        foreach ($retData as $_limit) {
            $_limitData = getArrayValue("limit", array(), $_limit);//限制单信息
            $_flowData = getArrayValue("flow", array(), $_limit);//流水信息
            $leftAmount = getArrayValue("leftAmount", "0", $_limit, true);//限制单对应的剩余额度
            $agentAccount = getArrayValue("agentAccount", "", $_limit);//限制单对应的代理
            
            $account = getArrayValue("account", "", $_limitData);
            $agentName = getArrayValue("agentName", "", $_limitData);
            $amount = getArrayValue("amount", "0", $_limitData, true);
            $dno = getArrayValue("dno", "", $_limitData);
            $isWithdrawalLimitValid = getArrayValue("isWithdrawalLimitValid", false, $_limitData);
            $mainBalance = getArrayValue("balance", "0", $_limitData, true);
            $game = (string)getArrayValue("game", "0", $_limitData);
            $recordNum = getArrayValue("recordNum", "", $_limitData);
            
            $srcAmount = getArrayValue("srcAmount", 0, $_limitData, true);
            $srcType = (int)getArrayValue("srcType", 1, $_limitData);
            $time = getArrayValue("recordTime", "", $_limitData);

            if ($game === "0") {
                $gameStr = "不限平台";
            } else {
                $gameStr = $game;//getArrayValue($platform, "", $GLOBALS["GP_Names"]);
            }

            if (empty($time)) {
                $timeStr = "";
            } else {
                $timeStr = parseDate($time, 4);
            }
            
            $_retLimit = array(
                "wid"=>getArrayValue("dno", "", $_limitData),//流水限制单号
                "ddno"=>getArrayValue("recordNum", "", $_limitData),//订单单号
                "btype"=>parseRecodeTypes(2, $srcType),//限制单类型
                "ptype"=>getArrayValue("ptype", "无", $_limitData),//限制单类型说明
                "gpname"=>$gameStr,//限制平台的名字
                "gpid"=>$game,//限制平台ID
                "nowbalance"=>$mainBalance,//当前的余额
                "amount"=>$srcAmount,//流水要求的额度
                "leftAmount"=>$leftAmount,//未完成的流水额度
                "agentname"=>$agentAccount,//代理
                "actname"=>getArrayValue("actname", null, $_limitData),//对应的活动名
                "createdtoString"=>$timeStr,//显示的时间
                "created"=>$time,//linux时间戳
                "flows"=>$_flowData
            );
            array_push($ret["data"], $_retLimit);
        }
        // if(count($ret["data"]) > 0){
        //     $ret["ok"] = 1;
        // } 
        return output($ret, "json");
        
    }

    /**
     * 获取状态接口，备用
     *
     * @return void
     */
    static function receive()
    {
        //接口预留
    }

    /**
     * 检查流水情况
     *
     * @param [type] $request URI请求
     * 
     * @return void
     */
    static function checkFlows($request)
    {
        $RequestMemberName = getArrayValue("uid", "", $request);
        $RequestStartTime = getArrayValue("stime", "", $request);
        $RequestEndTime = getArrayValue("etime", time(), $request);
        $errorRet = $GLOBALS["errorRet"];
        if (empty($RequestMemberName)) {
            return $errorRet;
        }

        return output(array("ok"=>1, "data"=>array(array( "gpid"=>"IBC", "rtype"=>1, "gpname"=>"沙巴体育", "water"=>array()),)), "json");
    }

    /**
     * 修改流水状态
     *
     * @param [type] $request URI参数
     * 
     * @return void
     */
    static function changeflows($request)
    {
        $RequestFlowlimitID = (int)getArrayValue("wid", "", $request);
        $RequestMemberName = getArrayValue("uid", "", $request);
        $RequestStatus = (int)getArrayValue("status", "", $request);
        if (empty($RequestFlowlimitID) || empty($RequestMemberName)) {
            return false;
        }

        if ($RequestStatus == 99) {
            $retJson = gmServerCaller("RemoveWithdrawalLimits", array($RequestFlowlimitID));
        } else {
            $retJson = gmServerCaller("ResetWithdrawalLimits", array($RequestFlowlimitID));
        }

        if (getArrayValue(0, "", $retJson) == 1) {
            return output(array("c"=>0, "d"=>null,"m"=>"change water gate success"), "json");
        } else {
            return output(array("c"=>404, "d"=>$retJson,"m"=>"change water gate failed"), "json"); 
        }
    }

    /**
     * 存款审核的操作接口
     *
     * @param [type] $request URI参数
     * 
     * @return void
     */
    static function dptVerifyAjax($request)
    {
        $s_args = parseCommonRequestArgus($request);
        $s_type = getArrayValue("s_type", "account", $request);
        $d_type = getArrayValue("displaytype", 1, $request);
        $orderNo = (int)getArrayValue("dno", "0", $request);
        $s_key = getArrayValue("s_keyword", "", $request);//查询关键字
        $s_payment = getArrayValue("payment", "", $request);
        $f_time = getArrayValue("ftime", "false", $request);
        
        if ($d_type == 1) {
            /**
             * 请求网银相关的数据
             */
            $retJson = gmServerCaller("GetDepositCheckRecord", array($s_args[0] , $s_args[1], $orderNo, $s_type, $s_key, $s_args[2], $s_args[3]));
            
        } elseif ($d_type == 2) {
            /**
             * TODO:请求第三方的数据，暂时未接入，使用普通网银数据
             */
            $retJson = gmServerCaller("GetDepositCheckRecord", array($s_args[0] , $s_args[1], $orderNo, $s_type, $s_key, $s_args[2], $s_args[3]));
            
        } else {
            /**
             * 什么鬼数据，重新查
             */
            return false;
        }

        $retJson = getArrayValue(0, array(), $retJson);
        $retSize = (int)getArrayValue("size", 0, $retJson);
        $retData = getArrayValue("data", array(), $retJson);
        $ret = outputSearchData($retSize, $s_args[4], $s_args[3], showdptVerifyData($retData));
        $ret["totalAll"] = $retSize;
        return output($ret, "json");
    }


    function dptHistoryAjax($request){
        /**
         * 查询存款历史
         */
        $s_args = parseCommonRequestArgus($request);
         $s_type = getArrayValue("s_type", "", $request);
        $s_dpttype = (int)getArrayValue("s_dpttype", 1, $request);
        if(!empty($s_st)){
            $s_st = strtotime($s_st);
        }
        if(!empty($s_et)){
            $s_et = strtotime($s_et);
        }

        $orderNo = (int)getArrayValue("dno", 0, $request);
        $s_key = getArrayValue("s_keyword", "", $request);//查询关键字
        $s_transtype = getArrayValue("s_transtype", "", $request);
        
        $retJson = gmServerCaller("GetDepositRecord", array($s_args[0], $s_args[1], $orderNo, $s_dpttype, $s_type, $s_key, $s_args[2], $s_args[3]));
        $dps = getArrayValue(1, 0, $retJson, true);
        $retJson = getArrayValue(0, array(), $retJson);
        $retSize = (int)getArrayValue("size", 0, $retJson);
        $retData = getArrayValue("data", array(), $retJson);
        $aaData = showdptHistoryData($retData);
        $ret = outputSearchData($retSize, $s_args[4], $s_args[3], $aaData[0]);
        $ret["pdps"] = number_format($aaData[1], 2);
        $ret["dps"] = $dps;
        return output($ret, "json");
    }

    function reset($request){
        $requestdno = getArrayValue("dno", "", $request);
        $requestRemark = getArrayValue("remark", "", $request);

        if (empty($requestdno) || empty($requestRemark)){
            return false;
        }

        $retJson = gmServerCaller("DepositApplyReset", array((int)$requestdno, $requestRemark));
        if(getArrayValue(0, "", $retJson) == 1){
            return output(array("code"=>200, "Message"=>"重置成功"), "json");
        }else{
            return output(array("code"=>400, "Message"=>"重置失败，请找客服咨询", "DEBUG"=>$retJson), "json");
        }
    }

    function getTotalDeposit(){
        echo "670,230.80 - 总金额计算没有提供接口";
    }

    /**
     * 玩家资金调整界面
     *
     * @param [type] $request URI参数
     * 
     * @return void
     */
    function dptCorrectionAjax($request)
    {
        $s_args = parseCommonRequestArgus($request);

        $s_type = getArrayValue("s_type", 1, $request);
        $ptype = getArrayValue("ptype", "", $request);
        $fs_ptype = getArrayValue("fs_ptype", 1, $request);
        if (empty($ptype)) {
            $ptype = 131; // 1+2+128
        } else {
            $_ptypes = explode(",", urldecode($ptype));
            $ptype = array_sum($_ptypes);
        }
        
        $s_key = getArrayValue("s_keyword", "", $request);//查询关键字
        $retJson = gmServerCaller("GetBalanceAdjustmentRecord", array($ptype, $s_args[0] , $s_args[1], $s_type, $s_key, $s_args[2], $s_args[3]));
        $staticJson = getArrayValue(1, array(), $retJson);
        $retJson = getArrayValue(0, array(), $retJson);

        $retSize = (int)getArrayValue("size", 0, $retJson);
        $retData = getArrayValue("data", array(), $retJson);
        $aaData = showDptCorrectHtml($retData);
        $ret = outputSearchData($retSize, $s_args[4], $s_args[3], $aaData[0]);
        $staticData = $aaData[1];
        $ret["bonus"] = getArrayValue(128, 0, $staticData, true);
        $ret["pbonus"] = getArrayValue(2, 0, $staticData, true);  
        $ret["dpt"] =  getArrayValue(1, 0, $staticData, true);  
        $ret["pdpt"] = getArrayValue(0, 0, $staticData, true);  
        $ret["wtd"] =  getArrayValue(2, 0, $staticData, true);  
        $ret["pwtd"] =  getArrayValue(1, 0, $staticData, true);  
        
        output($ret, "json");
        
    }

    /**
     * 取款审核界面
     *
     * @param [type] $request URI
     * 
     * @return void
     */
    function wtdVerifyAjax($request)
    {
        $s_args = parseCommonRequestArgus($request);

        $w_type = (int)getArrayValue("w_type", 1, $request);//待审核 - 1， 待对账 - 2
        $s_type = getArrayValue("s_type", "", $request);
        $s_key = getArrayValue("s_keyword", "", $request);//查询关键字
        $w_checkStatus = (int)getArrayValue("waterckrs", 1, $request);
        $w_group = getArrayValue("groupid", "", $request);

        if ($w_type == 1) {
            $w_type = false;
        } else {
            $w_type = true;
        }

        $retJson = gmServerCaller("GetWithdrawalCheckRecord", array($w_checkStatus, false, $w_group, $s_args[0], $s_args[1], $s_type, $s_key, $s_args[2], $s_args[3]));
        $retJson = getArrayValue(0, array(), $retJson);
        $retSize = (int)getArrayValue("size", 0, $retJson);
        $retData = getArrayValue("data", array(), $retJson);
        $aaData = showWDRecordData($retData);
        $ret = outputSearchData($retSize, $s_args[4], $s_args[3], $aaData);
        output($ret, "json");
    }

    function wtdInfo($request){
        return output(array(
            array(
            "bankname"=>"天地银行",
            "realname"=>"孙悟空",
            "cardnum"=>"1234123412341234",
            "actual"=>50,
            "dealremark"=>"测试",
            "wfee"=>0
        )), "json");

    }

    function wtdComplete($request){
        $bcid = getArrayValue("bcid", 1, $request);
        $bmactual = (int)getArrayValue("wfee", 0, $request);
        $remark = getArrayValue("dealremark", "", $request);
        $dno = (int)getArrayValue("dno", 0, $request);


        $retJson = gmServerCaller("WithdrawalRemit", array($dno, $bmactual, 0, 0, $remark));
        if (getArrayValue(0, "", $retJson) == 1){
            return output(array(
                "c"=>0, "d"=>null,"m"=>"出款成功"
            ), "json");   
        }else{
            return output(array(
                "c"=>404, "d"=>$retJson,"m"=>"出款失败"
            ), "json"); 
        }
    }

    function wtdRemark($request){
        $wtdID = getArrayValue("dno", "", $request);
        $remark = getArrayValue("remark", "", $request);

        if (empty($wtdID)){
            return output(array("code"=>400), "json");
        }else{
            return output(array("code"=>200), "json");
        }
    }

    function ckflows($request){
        $cks = (int)getArrayValue("cks", "1", $request);
        $wids = getArrayValue("wids", "", $request);
        $dno = getArrayValue("dno", "", $request);
        if(empty($cks) || empty($wids) || empty($dno)){
            return output(array(
                "c"=> 400, "m"=>"set water check status failed", "d"=> null
            ), "json");
        }

        $retJson = gmServerCaller("SetWithdrawalLimitCheckResult", array($dno, $cks));
        if (getArrayValue(0, "", $retJson) == 1){
            return output(array(
                "c"=> 0, "m"=>"set water check status success"
            ), "json");
        }else{
            return output(array(
                "c"=> 400, "m"=>"set water check status failed"
            ), "json");
        }
    }

    function withdrawPass($request){
        $wdID = getArrayValue("dno", "", $request);
        $dealremark = getArrayValue("dealremark", "", $request);
        $amount = (int)getArrayValue("actual", 0, $request);
        $wfee = (int)getArrayValue("wfee", 0, $request);
        $feetype = getArrayValue("feetype", "", $request);

        if(empty($wdID) || empty($dealremark) || empty($amount)||empty($feetype)){
            return  output(array(
                "c"=> 400, "m"=>"参数提交错误，请联系客服！"
            ), "json");
        }

        $retJson = gmServerCaller("WithdrawalApplyAgree", array($wdID, $amount,$wfee,  $feetype, $dealremark));
        if (getArrayValue(0, "", $retJson) == 1){
            return  output(array(
                "c"=> 0, "m"=>"成功"
            ), "json");
        }else{
            return  output(array(
                "c"=> 400, "m"=>"通过取款审核失败，请联系客服！"
            ), "json");
        }

    }

    function withdrawRefuse($request){
        $wdID = getArrayValue("dno", "", $request);
        $dealremark = getArrayValue("dealremark", "", $request);
        $msgtitle = getArrayValue("msgtitle", "", $request);
        $msg = getArrayValue("msg", "", $request);
        $retJson = gmServerCaller("WithdrawalApplyRefuse", array($wdID, $dealremark));
        if (getArrayValue(0, "", $retJson) == 1){
            return output(array(
                "c"=> 0, "m"=>"set water check status success", "d"=> null
            ), "json");
        }else{
            return output(array(
                "c"=> 400, "m"=>"set water check status failed", "d"=> null
            ), "json");
        }
    }

    
    function wtdHistoryAjax($request){
        /**
         * 玩家取款审核历史纪录
         */
        $s_args = parseCommonRequestArgus($request);
        
        $s_type = getArrayValue("s_type", "account", $request);
        $s_dpttype = getArrayValue("s_dpttype", 1, $request);
        $s_key = getArrayValue("s_keyword", "", $request);//查询关键字
        $s_wd_from = (int)getArrayValue("s_wtdAmtFr", -1, $request);//查询关键字
        $s_wd_to = (int)getArrayValue("s_wtdAmtTo", -1, $request);//查询关键字
        $s_checkStatus = (int)getArrayValue("s_checkStatus", 15, $request);//查询关键字
        $s_remitStatus = (int)getArrayValue("s_remitStatus", 0, $request);//查询关键字
        
        $retJson = gmServerCaller("GetWithdrawalRecord", array($s_args[0], $s_args[1], $s_wd_from, $s_wd_to, $s_checkStatus, $s_remitStatus, 1, $s_key, $s_args[2], $s_args[3]));
        $staticData = getArrayValue(1, array(), $retJson);
        $retJson = getArrayValue(0, array(), $retJson);
        $retSize = (int)getArrayValue("size", 0, $retJson);
        $retData = getArrayValue("data", array(), $retJson);
        $aaData = showWDHistoryData($retData);
        $ret = outputSearchData($retSize, $s_args[4], $s_args[3], $aaData);
        $ret["ac"] = 0.0;
        $ret["dc"] = 0.0;
  
        output($ret, "json");
    }
  

    /**
     * 玩家流水限制记录汇总
     *
     * @param [type] $request 请求
     * 
     * @return void
     */
    function flowLimitAjax($request)
    {
        /**
         * 玩家流水限制记录查询
         */
        $s_args = parseCommonRequestArgus($request);

        $s_type = getArrayValue("s_type", "", $request);//account - 账号, name - 姓名 , agentName - 代理
        $s_key = getArrayValue("s_keyword", "", $request);//查询关键字
        
        $retJson = gmServerCaller("GetWithdrawalLimitRecord", array($s_type, $s_key, $s_args[2], $s_args[3]));
        $retJson = getArrayValue(0, array(), $retJson);
        $retSize = (int)getArrayValue("size", 0, $retJson);
        $retData = getArrayValue("data", array(), $retJson);
        $aaData = showflowLimitHtml($retData);
        $ret = outputSearchData($retSize, $s_args[4], $s_args[3], $aaData);
        output($ret, "json");
    }


    function transferListAjax($request){
        $s_st = strtotime(urldecode(getArrayValue("s_StartTime", time() - 24*60*60*30, $request)));
        $s_et = strtotime(urldecode(getArrayValue("s_EndTime", time(), $request)));
        $s_name = getArrayValue("name", "", $request);

                
        $s_start_idx = getArrayValue(urlencode("data[3][value]"), "", $request);//查询起始index
        $s_start_idx = (int)($s_start_idx == 0)?1:$s_start_idx;//默认从1开始查询
        $s_count = (int)getArrayValue(urlencode("data[4][value]"), 999, $request);//查询的总条数


        // $retJson = gmServerCaller("", array());
        $ret = array("sEcho"=>"1","iTotalRecords"=>"0","iTotalDisplayRecords"=>"0","aaData"=>array());
        echo json_encode($ret);
        
    }

    function wtdGetMessageTemp($request){
        $creatTime = parseDate(getArrayValue("created", time(), $request));
        $amount = getArrayValue("amt", "0", $request, true);
        $water = getArrayValue("water", "0", $request, true);
        $mid = getArrayValue("mid", "0", $request);

        $msgTitle = "取款拒绝";
        $msgContent = '<span style="color:red;font-size:12px;">'.$creatTime.'</span>申请的取款，其中：取款申请=<span style="color:red;font-size:12px;">'.$amount.'</span>,已被拒绝。谢谢您的参与，有任何问题请随时与我们联系。';
        return output(array(
            "msg"=>"success",
            "response"=>array(
                "title"=>$msgTitle,
                "content"=>$msgContent
            ),
            "success"=>true
        ), "json");
    }
}
?>