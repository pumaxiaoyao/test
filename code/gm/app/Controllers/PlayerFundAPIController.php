<?php
namespace App\Controllers;

use App\Config\Config;
use App\Libs\HttpRequest as http;
use App\ViewHelper\PlayerFundViewHelper as viewHelper;

class PlayerFundAPIController extends BaseController
{
    public static function checkWater($request)
    {
        $RequestMemberName = getArrayValue("id", "", $request);
        $flCheckType = (string) getArrayValue("ftype", "1", $request);
        $RequestDno = (string) getArrayValue("dno", "", $request);

        $retJson = http::gmHttpCaller("GetPlayerWithdrawalLimitInfo", array($RequestMemberName));
        $retData = getArrayValue(0, array(), $retJson);

        if ($flCheckType == 2) {
            //针对指定限制单进行查询数据
            $ret = array("ok" => 1, "data" => array());
            $allGP = Config::platform;
            foreach ($retData as $_fl) {
                $_fl_dno = (string) getArrayValue("dno", "", $_fl["limit"]);
                if ($RequestDno === $_fl_dno) {
                    $flowData = array();
                    foreach ($allGP as $_gpId => $_gpName) {
                        $_ = array(
                            "gpid" => $_gpId,
                            "gpname" => $_gpName,
                            "rtype" => 1,
                            "water" => array(),
                        );
                        array_push($flowData, $_);
                    }
                }
            }
        }

        $ret = array("ok" => 1, "data" => array());
        foreach ($retData as $_limit) {
            $_limitData = getArrayValue("limit", array(), $_limit); //限制单信息
            $_flowData = getArrayValue("flow", array(), $_limit); //流水信息
            $leftAmount = getArrayValue("leftAmount", "0", $_limit, true); //限制单对应的剩余额度
            $agentAccount = getArrayValue("agentAccount", "", $_limit); //限制单对应的代理

            $account = getArrayValue("account", "", $_limitData);
            $agentName = getArrayValue("agentName", "", $_limitData);
            $amount = getArrayValue("amount", "0", $_limitData, true);
            $dno = getArrayValue("dno", "", $_limitData);
            $isWithdrawalLimitValid = getArrayValue("isWithdrawalLimitValid", false, $_limitData);
            $mainBalance = getArrayValue("balance", "0", $_limitData, true);
            $game = (string) getArrayValue("game", "0", $_limitData);
            $recordNum = getArrayValue("recordNum", "", $_limitData);

            $srcAmount = getArrayValue("srcAmount", 0, $_limitData, true);
            $srcType = (int) getArrayValue("srcType", 1, $_limitData);
            $time = getArrayValue("recordTime", "", $_limitData);

            if ($game === "0") {
                $gameStr = "不限平台";
            } else {
                $gameStr = $game; //getArrayValue($platform, "", $GLOBALS["GP_Names"]);
            }

            if (empty($time)) {
                $timeStr = "";
            } else {
                $timeStr = parseDate($time, 4);
            }

            $_retLimit = array(
                "wid" => getArrayValue("dno", "", $_limitData), //流水限制单号
                "ddno" => getArrayValue("recordNum", "", $_limitData), //订单单号
                "btype" => Config::opTypeMap[$srcType], //限制单类型
                "ptype" => getArrayValue("ptype", "无", $_limitData), //限制单类型说明
                "gpname" => $gameStr, //限制平台的名字
                "gpid" => $game, //限制平台ID
                "nowbalance" => $mainBalance, //当前的余额
                "amount" => $srcAmount, //流水要求的额度
                "leftAmount" => $leftAmount, //未完成的流水额度
                "agentname" => $agentAccount, //代理
                "actname" => getArrayValue("actname", null, $_limitData), //对应的活动名
                "createdtoString" => $timeStr, //显示的时间
                "created" => $time, //linux时间戳
                "flows" => $_flowData,
            );
            array_push($ret["data"], $_retLimit);
        }

        return $ret;
    }

    public static function dptVerifyAjax($request)
    {
        $s_args = parseCommonRequestArgus($request);
        $s_type = getArrayValue("s_type", "account", $request);
        $d_type = getArrayValue("displaytype", 1, $request);
        $orderNo = (int) getArrayValue("dno", "0", $request);
        $s_key = getArrayValue("s_keyword", "", $request); //查询关键字
        $s_payment = getArrayValue("payment", "", $request);
        $f_time = getArrayValue("ftime", "false", $request);

        if ($d_type == 1) {
            /**
             * 请求网银相关的数据
             */
            $retJson = http::gmHttpCaller("GetDepositCheckRecord", array($s_args[0], $s_args[1], $orderNo, $s_type, $s_key, $s_args[2], $s_args[3]));

        } elseif ($d_type == 2) {
            /**
             * TODO:请求第三方的数据，暂时未接入，使用普通网银数据
             */
            $retJson = http::gmHttpCaller("GetDepositCheckRecord", array($s_args[0], $s_args[1], $orderNo, $s_type, $s_key, $s_args[2], $s_args[3]));

        } else {
            /**
             * 什么鬼数据，重新查
             */
            return false;
        }

        $retJson = $retJson ? $retJson[0] : [];
        $retSize = (int) getArrayValue("size", 0, $retJson);
        $retData = getArrayValue("data", array(), $retJson);
        return [
            "sEcho" => $s_args[4],
            "iTotalRecords" => $retSize,
            "iTotalDisplayRecords" => $retSize, //floor($sSize / $sCount), //取整，用于页数
            "aaData" => viewHelper::showdptVerifyData($retData),
            "totalAll" => $retSize,
        ];
    }

    public static function dptHistoryAjax($request)
    {
        $s_args = parseCommonRequestArgus($request);
        $s_type = getArrayValue("s_type", "", $request);
        $s_dpttype = (int) getArrayValue("s_dpttype", 1, $request);
        if (!empty($s_st)) {
            $s_st = strtotime($s_st);
        }
        if (!empty($s_et)) {
            $s_et = strtotime($s_et);
        }

        $orderNo = (int) getArrayValue("dno", 0, $request);
        $s_key = getArrayValue("s_keyword", "", $request); //查询关键字
        $s_transtype = getArrayValue("s_transtype", "", $request);

        $retJson = http::gmHttpCaller("GetDepositRecord", array($s_args[0], $s_args[1], $orderNo, $s_dpttype, $s_type, $s_key, $s_args[2], $s_args[3]));
        $dps = getArrayValue(1, 0, $retJson, true);

        $retJson = $retJson ? $retJson[0] : [];
        $retSize = (int) getArrayValue("size", 0, $retJson);
        $retData = getArrayValue("data", array(), $retJson);
        $aaData = viewHelper::showdptHistoryData($retData);
        return [
            "sEcho" => $s_args[4],
            "iTotalRecords" => $retSize,
            "iTotalDisplayRecords" => $retSize, //floor($sSize / $sCount), //取整，用于页数
            "aaData" => $aaData[0],
            "dps" => $dps,
            "pdps" => $aaData[1],
        ];
    }

    public static function reset($request)
    {
        $requestdno = getArrayValue("dno", "", $request);
        $requestRemark = getArrayValue("remark", "", $request);

        if (empty($requestdno) || empty($requestRemark)) {
            return [false];
        }

        $retJson = http::gmHttpCaller("DepositApplyReset", array((int) $requestdno, $requestRemark));
        if (getArrayValue(0, "", $retJson) == 1) {
            return [true, "Message" => "重置成功"];
        } else {
            return [false, "Message" => "重置失败，请找客服咨询"];
        }
    }

    public static function dptCorrectionAjax($request)
    {

        $s_args = parseCommonRequestArgus($request);

        $s_type = getArrayValue("s_type", 1, $request);
        
        $ptype = getArrayValue("ptype", "All", $request);
        $optype = Config::transMap[$ptype];

        $s_key = getArrayValue("s_keyword", "", $request); //查询关键字

        $retJson = http::gmHttpCaller("GetBalanceAdjustmentRecord", array($optype, $s_args[0] , $s_args[1], $s_type, $s_key, $s_args[2], $s_args[3]));

        $staticJson = getArrayValue(1, array(), $retJson);

        $retJson = $retJson ? $retJson[0] : [];
        $retSize = (int) getArrayValue("size", 0, $retJson);
        $retData = getArrayValue("data", array(), $retJson);
        $aaData = viewHelper::showDptCorrectHtml($retData);
        $staticData = $aaData[1];
        return [
            "sEcho" => $s_args[4],
            "iTotalRecords" => $retSize,
            "iTotalDisplayRecords" => $retSize, //floor($sSize / $sCount), //取整，用于页数
            "aaData" => $aaData[0],
            "bonus" => $staticData[2],//数据为空，暂时显示页面值
            "pbonus" => $staticData[2],
            "dpt" => $staticData[0],
            "pdpt" => $staticData[0],
            "wtd" => $staticData[1],
            "pwtd" => $staticData[1],

        ];
    }

    public static function wtdVerifyAjax($request)
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

        $retJson = http::gmHttpCaller("GetWithdrawalCheckRecord", array($w_checkStatus, false, $w_group, $s_args[0], $s_args[1], $s_type, $s_key, $s_args[2], $s_args[3]));

        $retJson = $retJson ? $retJson[0] : [];
        $retSize = (int) getArrayValue("size", 0, $retJson);
        $retData = getArrayValue("data", array(), $retJson);
        return [
            "sEcho" => $s_args[4],
            "iTotalRecords" => $retSize,
            "iTotalDisplayRecords" => $retSize, //floor($sSize / $sCount), //取整，用于页数
            "aaData" => viewHelper::showWDRecordData($retData)
        ];
    }

    public static function ckflows($request)
    {
        $cks = (int)getArrayValue("cks", "1", $request);
        $wids = getArrayValue("wids", "", $request);
        $dno = getArrayValue("dno", "", $request);
        if(empty($cks) || empty($dno)){
            return ["c"=> 400, "m"=>"set water check status failed", "d"=> null];
        }

        $retJson = http::gmHttpCaller("SetWithdrawalLimitCheckResult", array($dno, $cks));
        if (getArrayValue(0, "", $retJson) == 1){
            return ["c"=> 0, "m"=>"set water check status success"];
            
        }else{
            return ["c"=> 400, "m"=>"set water check status failed"];
        }
    }

    public static function withdrawPass($request){
        $wdID = getArrayValue("dno", "", $request);
        $dealremark = getArrayValue("dealremark", "", $request);
        $amount = (int)getArrayValue("actual", 0, $request);
        $wfee = (int)getArrayValue("wfee", 0, $request);
        $feetype = getArrayValue("feetype", "", $request);

        if(empty($wdID) || empty($dealremark) || empty($amount)||empty($feetype)){
            return  ["c"=> 400, "m"=>"参数提交错误，请联系客服！"];
        }

        $retJson = http::gmHttpCaller("WithdrawalApplyAgree", array($wdID, $amount,$wfee,  $feetype, $dealremark));
        if (getArrayValue(0, "", $retJson) == 1){
            return  ["c"=> 0, "m"=>"成功"];
        }else{
            return  ["c"=> 400, "m"=>"通过取款审核失败，请联系客服！"];
        }
    }

    public static function withdrawRefuse($request){
        $wdID = getArrayValue("dno", "", $request);
        $dealremark = getArrayValue("dealremark", "", $request);
        $msgtitle = getArrayValue("msgtitle", "", $request);
        $msg = getArrayValue("msg", "", $request);
        $retJson = http::gmHttpCaller("WithdrawalApplyRefuse", array($wdID, $dealremark));
        if (getArrayValue(0, "", $retJson) == 1){
            return ["c"=> 0, "m"=>"set water check status success", "d"=> null];
        }else{
            return ["c"=> 400, "m"=>"set water check status failed", "d"=> null];
        }
    }

    public static function changeflows($request)
    {
        $RequestFlowlimitID = (int)getArrayValue("wid", "", $request);
        $RequestMemberName = getArrayValue("uid", "", $request);
        $RequestStatus = (int)getArrayValue("status", "", $request);
        if (empty($RequestFlowlimitID) || empty($RequestMemberName)) {
            return ["c"=>404, "d"=>[],"m"=>"argus error"];
        }

        if ($RequestStatus == 99) {
            $retJson = http::gmHttpCaller("RemoveWithdrawalLimits", array(array($RequestFlowlimitID)));
        } else {
            $retJson = http::gmHttpCaller("ResetWithdrawalLimits", array(array($RequestFlowlimitID)));
        }

        if (getArrayValue(0, "", $retJson) == 1) {
            return ["c"=>0, "d"=>null,"m"=>"change water gate success"];
        } else {
            return ["c"=>404, "d"=>$retJson,"m"=>"change water gate failed"]; 
        } 
    }

    public static function receive($request)
    {
        //预留接口
    }

    public static function wtdRemark($request)
    {
        $wtdID = getArrayValue("dno", "", $request);
        $remark = getArrayValue("remark", "", $request);

        if (empty($wtdID)){
            return ["code"=>400];
        }else{
            return ["code"=>200];
        }
    }

    public static function wtdGetMessageTemp($request)
    {
        $creatTime = parseDate(getArrayValue("created", time(), $request));
        $amount = getArrayValue("amt", "0", $request, true);
        $water = getArrayValue("water", "0", $request, true);
        $mid = getArrayValue("mid", "0", $request);

        $msgTitle = "取款拒绝";
        $msgContent = '<span style="color:red;font-size:12px;">'.$creatTime.'</span>申请的取款，其中：取款申请=<span style="color:red;font-size:12px;">'.$amount.'</span>,已被拒绝。谢谢您的参与，有任何问题请随时与我们联系。';
        return [
            "msg"=>"success",
            "response"=>array(
                "title"=>$msgTitle,
                "content"=>$msgContent
            ),
            "success"=>true
        ];
    }

    public static function wtdHistoryAjax($request)
    {
        $s_args = parseCommonRequestArgus($request);
        
        $s_type = getArrayValue("s_type", "account", $request);
        $s_dpttype = getArrayValue("s_dpttype", 1, $request);
        $s_key = getArrayValue("s_keyword", "", $request);//查询关键字
        $s_wd_from = (int)getArrayValue("s_wtdAmtFr", -1, $request);//查询关键字
        $s_wd_to = (int)getArrayValue("s_wtdAmtTo", -1, $request);//查询关键字
        $s_checkStatus = (int)getArrayValue("s_checkStatus", 15, $request);//查询关键字
        $s_remitStatus = (int)getArrayValue("s_remitStatus", 0, $request);//查询关键字
        
        $retJson = http::gmHttpCaller("GetWithdrawalRecord", array($s_args[0], $s_args[1], $s_wd_from, $s_wd_to, $s_checkStatus, $s_remitStatus, 1, $s_key, $s_args[2], $s_args[3]));
    
        $retJson = $retJson ? $retJson[0] : [];
        $retSize = (int) getArrayValue("size", 0, $retJson);
        $retData = getArrayValue("data", array(), $retJson);
        
        return [
            "sEcho" => $s_args[4],
            "iTotalRecords" => $retSize,
            "iTotalDisplayRecords" => $retSize, //floor($sSize / $sCount), //取整，用于页数
            "aaData" => viewHelper::showWDHistoryData($retData),
            "ac" => 0.0,
            "dc" => 0.0
        ];
    }

    public static function completewtd($request)
    {
         // bcid: bcid, wfee: wfee, dealremark: dealremark, dno: nowdno
         $bcid = getArrayValue("bcid", "", $request);
         $wfee = (float)getArrayValue("wfee", 0, $request);
         $dno = getArrayValue("dno", 0, $request);
         $note = getArrayValue("dealremark", "", $request);
 
         $ret = array("code"=>500, "Message"=>"");
         if (empty($bcid) || empty($dno) || empty($note)) {
             $ret["Message"] = "参数错误";
         } else {
             $retJson = http::gmHttpCaller("WithdrawalRemit", array($dno, $bcid, $note));
 
             if (getArrayValue(0, "", $retJson) == 1) {
                 $ret["code"] = 200;
             } else {
                 $ret["Message"] = getArrayValue(1, "no error msg", $retJson);
             }
         }
         return $ret;
    }

    public static function flowLimitAjax($request)
    {
        $s_args = parseCommonRequestArgus($request);

        $s_type = getArrayValue("s_type", "", $request);//account - 账号, name - 姓名 , agentName - 代理
        $s_key = getArrayValue("s_keyword", "", $request);//查询关键字
        
        $retJson = http::gmHttpCaller("GetWithdrawalLimitRecord", array($s_type, $s_key, $s_args[2], $s_args[3]));
        $retJson = $retJson ? $retJson[0] : [];
        $retSize = (int) getArrayValue("size", 0, $retJson);
        $retData = getArrayValue("data", array(), $retJson);
        
        return [
            "sEcho" => $s_args[4],
            "iTotalRecords" => $retSize,
            "iTotalDisplayRecords" => $retSize, //floor($sSize / $sCount), //取整，用于页数
            "aaData" => viewHelper::showflowLimitHtml($retData)
        ];
    }

    public static function transferListAjax($request)
    {
        $s_st = strtotime(urldecode(getArrayValue("s_StartTime", time() - 24*60*60*30, $request)));
        $s_et = strtotime(urldecode(getArrayValue("s_EndTime", time(), $request)));
        $s_name = getArrayValue("name", "", $request);

                
        $s_start_idx = getArrayValue(urlencode("data[3][value]"), "", $request);//查询起始index
        $s_start_idx = (int)($s_start_idx == 0)?1:$s_start_idx;//默认从1开始查询
        $s_count = (int)getArrayValue(urlencode("data[4][value]"), 999, $request);//查询的总条数


        // $retJson = gmServerCaller("", array());
        $ret = array("sEcho"=>"1","iTotalRecords"=>"0","iTotalDisplayRecords"=>"0","aaData"=>array());
        return $ret;
    }
}
