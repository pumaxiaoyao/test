<?php
namespace App\ViewHelper;

use App\Config\Config;
use App\Controllers\Def;
use App\Core\View;

class PlayerFundViewHelper extends BaseViewHelper
{

    /**
     * 显示在线玩家的数据
     *
     * @param [type] $OnlineRoles 在线玩家的数据
     * 
     * @return void
     */
    public static function showdptVerifyData($OnlineRoles)
    {
        $retdatas = array();
        for ($x=0;$x<count($OnlineRoles);$x++) {
            $role = $OnlineRoles[$x];
            $dno = $role["dno"];
            $account = $role["account"];
            $name = $role["name"];
            $agentAccount = $role["agentAccount"];
            $roleId = $role["roleId"];
            
            // 构建DNO单号选择格子Html
            $dnoCell = self::makeDnoCheckHtml(["dno" => $dno]);

            // 构建存款时间/单号
            $timeCell = parseDate($role["recordTime"]) . " / " . $dno;

            // 构建账号格子Html
            $accountCell = self::makeAccHtml(["account"=>$account]);
            
            
            // 构建操作格子Html
            $operT = [
                "account" => $account,
                "dno" => $dno,
                "amount" => $role["amount"]
            ];
            $operCell = self::makedptVerifyOperHtml($operT);

            $tmpdata = [
                $dnoCell, // dno check cell
                $timeCell, // record time & dno cell
                $accountCell, //account cell inner html
                $name, // user name
                $role["groupName"], // group name
                $agentAccount, // agent name
                "", // 支付
                $role["amount"], // 申请金额
                "", // 存入银行
                "", // 反馈状态
                $role["note"], // 备注内容
                $operCell // 操作格子
            ];
            
            array_push($retdatas, $tmpdata);
        }
        return $retdatas;
    }

    public static function showdptHistoryData($data)
    {
        $retdatas = array();
        $totalCount = 0;
        for ($x=0;$x<count($data);$x++) {
            $role = $data[$x];
            $dno = $role["dno"];
            $account = $role["account"];
            $name = $role["name"];
            $agentAccount = $role["agentAccount"];
            $roleId = $role["roleId"];
            
            // 构建DNO单号选择格子Html
            $dnoCell = self::makeDnoCheckHtml(["dno" => $dno]);

            // 构建存款时间/单号
            $timeCell = parseDate($role["recordTime"]) . " / ". $dno;

            // 构建账号格子Html
            $accountCell = self::makeAccHtml(["account"=>$account]);
            
            // 构建状态格子Html
            $status = $role["checkStatus"];
            if ($status == 2) {
                $totalCount += (float)$amount;
            }

            $statusCell = Config::statusMap[$status];
            
            // 构建操作格子Html
            $operT = [
                "code" => $status,
                "dno" => $dno
            ];
            $operCell = self::makedptHistoryOperHtml($operT);

            $tmpdata = [
                $timeCell, // record time & dno cell
                $accountCell, //account cell inner html
                $name, // user name
                $agentAccount, // agent name
                $role["amount"], // 申请金额
                $role["applyAmount"], // 实际金额
                $role["depositBonusAmount"], // 优惠
                $role["bonusAmount"], // 红利
                $role["deposit_withdrawalLimitAmount"], // 取款限制
                "", // 交易方式
                "", // 存入银行
                $statusCell, // 状态
                parseDate($role["dealTime"]),
                $role["note"], // 备注内容
                $operCell // 操作格子
            ];
            
            array_push($retdatas, $tmpdata);
        }
        return [$retdatas, $totalCount];
    }

    public static function showDptCorrectHtml($data)
    {
        $retdatas = array();
        $pbonus = 0.0;
        $pdpt = 0.0;
        $pwtd= 0.0;
        for ($x=0;$x<count($data);$x++) {
            $role = $data[$x];
            $dno = $role["dno"];
            $account = $role["account"];
            $name = $role["name"];
            $agentAccount = $role["agentAccount"];
            $roleId = $role["roleId"];
            $amount = $role["amount"];
            // 构建DNO单号选择格子Html
            $dnoCell = self::makeDnoCheckHtml(["dno" => $dno]);

            // 构建存款时间/单号
            $timeCell = parseDate($role["recordTime"]) . " / ". $dno;

            // 构建账号格子Html
            $accountCell = self::makeAccHtml(["account"=>$account]);
            

            // 构建opcode格子
            $opType = $role["opType"];
            $opTypeCell = Config::opTypeMap[$opType];


            // 构建状态格子Html
            $status = $role["checkStatus"];
            if ($opType == 1) {
                $pdpt += (float)$amount;
            } elseif ($opType == 2) {
                $pwtd += (float)$amount;
            } elseif ($opType == 128) {
                $pbonus += (float)$amount;
            }
            $statusCell = Config::statusMap[$status];
            
            $tmpdata = [
                $x + 1, // 序号
                $accountCell, //account cell inner html
                $name, // user name
                $groupName = $role["groupName"], // group name
                $agentAccount, // 代理
                $amount, // 申请金额
                $opTypeCell, // optype
                "", // 操作人
                $role["note"], // 备注内容
                "", // 活动
                parseDate($role["dealTime"])
            ];
            
            array_push($retdatas, $tmpdata);
        }
        return [$retdatas, [$pdpt, $pwtd, $pbonus]];
    }

    public static function showWDRecordData($datas)
    {
        $retdatas = array();
        $total = 0.0;
        for ($x=0;$x<count($datas);$x++) {
            $dno = getArrayValue("dno", "", $datas[$x]);
            $recordNum = getArrayValue("recordNum", "", $datas[$x]);
            $recordType1 = getArrayValue("recordType1", "", $datas[$x]);
            $groupName = getArrayValue("groupName", "", $datas[$x]);
            $time = getArrayValue("recordTime", "", $datas[$x]);
            $name = urldecode(getArrayValue("name", "", $datas[$x]));
            $agentName = getArrayValue("agentAccount", "", $datas[$x]);
            $remark = getArrayValue("note", "TODO:备注信息", $datas[$x]);
            $amount = getArrayValue("amount", 0, $datas[$x], true);
            $wdFee = getArrayValue("wdFee", 0, $datas[$x], true);
            $wdconfirm = getArrayValue("wdconfirm", 0, $datas[$x], true);
            $lastDptAmount = getArrayValue("lastDepositAmount", 0, $datas[$x], true);
            $flows = getArrayValue("flows", 0, $datas[$x], true);
            
            $withdrawalLimitAmount = getArrayValue("withdrawalLimitAmount", 0, $datas[$x], true);
            $withdrawalLimitCheckStatus = getArrayValue("withdrawalLimitCheckStatus", 1, $datas[$x]);
            
            $bankType = (int)getArrayValue("withdrawal_remitBankCardId", 0, $datas[$x]);
            $bankCardName = getArrayValue("bankCardName", "", $datas[$x]);
            $bankCardNo = getArrayValue("bankCardNo", 0, $datas[$x]);
            $registerBank = getArrayValue("registerBank", "", $datas[$x]);
            
            $bankConfigs = Config::bankTypes[$bankType];

            $bankInfo = $bankConfigs["name"]. "&nbsp; ".$bankCardName . "<br/>".$bankCardNo."<br/>".$registerBank;
            $checkStatus = getArrayValue("checkStatus", "", $datas[$x]);
            $opType = getArrayValue("opType", "", $datas[$x]);
            $account = getArrayValue("account", "", $datas[$x]);


            // 构建账号格子Html
            $accountCell = self::makeAccHtml(["account"=>$account]);
            // 构建备注格子    
            $remarkCell = self::makeCSRemarkHtml(["dno" => $dno]);

            $statusCell = self::makeWtdStatusHtml([
                "dno" => $dno,
                "account" => $account,
                "status" => $withdrawalLimitCheckStatus
            ]);

            $operCell = self::makeWtdOperHtml([
                "ckStatus" => $checkStatus,
                "status" => $withdrawalLimitCheckStatus,
                "dno" => $dno,
                "account" => $account,
                "amount" => $amount,
                "rname" => $registerBank,
                "bank" => $bankConfigs["name"],
                "card" => $bankCardNo


            ]);
            $tmpdata = array(
                $dno, // 单号
                $accountCell, //账号
                // $name,
                $groupName,
                $agentName,
                '<label style="color: red">'. (string)$amount. '</label>',
                $wdFee,
                $wdconfirm,
                $lastDptAmount,
                $withdrawalLimitAmount,
                parseDate($time, 4),
                $bankInfo,
                $remarkCell,
                $statusCell, 
                $operCell
            );
            
            array_push($retdatas, $tmpdata);
        }
        return $retdatas;
    }

    public static function showWDHistoryData($datas)
    {
        $retdatas = array();
        for ($x=0;$x<count($datas);$x++) {
            $account = getArrayValue("account", "", $datas[$x]);
            $agentName = getArrayValue("agentName", "", $datas[$x]);
            $amount = getArrayValue("amount", "0", $datas[$x], true);
            $amountResult = getArrayValue("amountResult", "0", $datas[$x], true);
            $amountResult1 = getArrayValue("amountResult1", "0", $datas[$x], true);
            $bankCardId = getArrayValue("bankCardId", 0, $datas[$x]);
            $checkStatus = getArrayValue("checkStatus", 0, $datas[$x]);
            $dno = getArrayValue("dno", "0", $datas[$x]);
            $fee = getArrayValue("fee", "0", $datas[$x], true);
            $feeType = (int)getArrayValue("feeType", 0, $datas[$x]);
            $groupName = getArrayValue("groupName", "", $datas[$x]);
            $isRemit = getArrayValue("isRemit", false, $datas[$x]);
            $lastDepositAmount = getArrayValue("lastDepositAmount", "0", $datas[$x],true);
            $name = getArrayValue("name", "", $datas[$x]);
            $note = getArrayValue("note", "", $datas[$x]);
            $recordNum = (int)getArrayValue("recordNum", 0, $datas[$x]);
            $recordType = (int)getArrayValue("recordType", 0, $datas[$x]);
            $recordType1 = (int)getArrayValue("recordType1", 0, $datas[$x]);
            $time = getArrayValue("recordTime", "", $datas[$x]);
            $time1 = getArrayValue("dealTime", "", $datas[$x]);
            $withdrawalLimitAmount = getArrayValue("withdrawalLimitAmount", "0", $datas[$x], true);
            $withdrawalLimitCheckStatus = (int)getArrayValue("withdrawalLimitCheckStatus", "0", $datas[$x]);

            $staff  = getArrayValue("staff", "TODO:处理人", $datas[$x]);
            $remark1  = getArrayValue("remark1", "TODO:审核备注", $datas[$x]);
            $remark2  = getArrayValue("remark2", "TODO:出款备注", $datas[$x]);

            $bankType = (int)getArrayValue("bankType", 0, $datas[$x]);
            $bankCardName = getArrayValue("bankCardName", "", $datas[$x]);
            $bankCardNo = getArrayValue("bankCardNo", 0, $datas[$x]);
            $registerBank = getArrayValue("registerBank", "", $datas[$x]);
            
            $bankConfigs = getArrayValue($bankType, "", Config::bankTypes);
            $bankName = getArrayValue("name", "", $bankConfigs);
            $bankInfo = $bankName."&nbsp; ".$name . "<br/>".$bankCardNo."<br/>".$registerBank;

            if ($withdrawalLimitCheckStatus == 2) {
                $status = "出款中";
            } else {
                $status = "todo:未知状态";
            }

            // 构建账号格子Html
            $accountCell = self::makeAccHtml(["account"=>$account]);

            // 构建银行卡按钮Html
            $bankCell = self::makeWDBankHtml(["dno" => $dno]);
            
            $tmpdata = array(
                $dno, // 单号
                $accountCell,
                $name,
                $groupName,
                $agentName,
                "RMB",
                $amount,
                $amountResult,
                date("Y-m-d", $time). "<br/>".date("H:i:s", $time),
                $status,
                $bankCell,
                $bankInfo,
                date("Y-m-d", $time1). "<br/>".date("H:i:s", $time1),
                date("Y-m-d", $time1). "<br/>".date("H:i:s", $time1),
                $staff,
                $note,
                $remark2,
            );
            
            $retdatas[] = $tmpdata;
        }
        return $retdatas;
    }

    public static function showflowLimitHtml($datas)
    {
        $retdatas = array();
    
        for ($x=0;$x<count($datas);$x++) {
            $account = getArrayValue("account", "", $datas[$x]);
            $agentName = getArrayValue("agentAccount", "", $datas[$x]);
            $amount = getArrayValue("amount", 0, $datas[$x], true);
            $dno = getArrayValue("dno", "", $datas[$x]);
            $isWithdrawalLimitValid = getArrayValue("isWithdrawalLimitValid", false, $datas[$x]);
            $mainBalance = getArrayValue("mainBalance", 0, $datas[$x], true);
            $name = getArrayValue("name", "", $datas[$x]);
            $platformID = (string)getArrayValue("platform", "0", $datas[$x]);
            if ($platformID === "0") {
                $platform = "不限制";
            } else {
                $platform = getArrayValue($platformID, "TODO:未知平台配置", $GLOBALS["GP_Names"]);
            }
            $recordNum = getArrayValue("recordNum", "", $datas[$x]);
            $recordType1 = getArrayValue("recordType1", "", $datas[$x]);
            $recordType = getArrayValue("recordType", "", $datas[$x]);
            $time = getArrayValue("recordTime", "", $datas[$x]);
            if (!empty($time)) {
                $timestr = parseDate($time, 4);
            } else {
                $timestr = "";
            }

            if ($isWithdrawalLimitValid === false) {
                $status = "已结算";
            } else {
                $status = "未结算";
            }
            
            $groupName = getArrayValue("groupName", "TODO:玩家组解析为0或空", $datas[$x]);
            $note = getArrayValue("note", "TODO:备注信息", $datas[$x]);
            

            // 构建流水检查CheckerHtml
            $flCheckT = [
                'wid' => $recordNum,
                'account' => $account
            ];
            $flCheckCell = self::makeFLCheckHtml($flCheckT);

            // 构建账号格子Html
            $accountCell = self::makeAccHtml(["account"=>$account]);

            // 构建流水检查Html
            $limitCheckT = [
                "amount" => $amount, 
                "gpid" => $platformID,
                "dno" => $dno,
                "account" => $account,
                "gpname" => $platform,
                "type" => 2
            ];
            $limitCheckCell = self::makeLimitCheckHtml($limitCheckT);
            
            // 构建流水检查操作按钮Html
            $limitOperT = [
                "account" => $account,
                "dno" => $dno,
                "flag" => $isWithdrawalLimitValid
            ];
            $limitOperCell = self::makeLimitOperHtml($limitOperT);

            $tmpdata = [
                $flCheckCell,
                $accountCell,
                $name,
                $amount,
                "",
                $platform,
                $timestr,
                $agentName,
                $status,
                $limitCheckCell,
                $limitOperCell
            ];
            $retdatas[] = $tmpdata;
        }
        return $retdatas;
    }
}