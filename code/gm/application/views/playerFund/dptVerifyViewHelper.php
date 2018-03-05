<?php

/**
 * 存款审核界面的构建方法
 *
 * @param [type] $datas 待审核的数据
 * 
 * @return void
 */
function showdptVerifyData($datas)
{
    $retdatas = array();
    for ($x=0;$x<count($datas);$x++) {
        // print_r($datas[$x]);
        $dno = getArrayValue("dno", "", $datas[$x]);
        $recordNum = getArrayValue("recordNum", "", $datas[$x]);
        $opType = getArrayValue("opType", "", $datas[$x]);
        $groupName = getArrayValue("groupName", "", $datas[$x]);
        $time = (int)getArrayValue("recordTime", "", $datas[$x]);
        $name = urldecode(getArrayValue("name", "", $datas[$x]));
        $agentAccount = getArrayValue("agentAccount", "", $datas[$x]);
        $ConfirmStatus = getArrayValue("ConfirmStatus", "TODO:反馈状态", $datas[$x]);
        $note = getArrayValue("note", "", $datas[$x]);
        $amount = getArrayValue("amount", 0, $datas[$x], true);
        $checkStatus = getArrayValue("checkStatus", "", $datas[$x]);
        
        $account = getArrayValue("account", "", $datas[$x]);
        $tmpdata = array(
            makeCheckHtml($dno),//单号
            parseDate($time)."<br/>".$dno,
            makeVerifyAccHtml(),
            $name,
            $groupName,
            $agentAccount,
            "<font color=green>TODO</font>",
            $amount,
            "<font color=green>TODO</font>",
            $ConfirmStatus,
            $note,
            makeVerifyOperHtml($dno, $amount)
        );
    
        for ($y=0;$y<count($tmpdata);$y++) {
            $tmpdata[$y] = str_replace("%ACCOUNT%", $account, $tmpdata[$y]);
        }
        array_push($retdatas, $tmpdata);
    }
    return $retdatas;
}

/**
 * 展示构建历史存款记录页面
 *
 * @param [type] $datas 数据
 * 
 * @return void
 */
function showdptHistoryData($datas)
{
    $retdatas = array();
    $totalCount = 0.0;
    for ($x=0;$x<count($datas);$x++) {
        $dno = getArrayValue("dno", "", $datas[$x]);
        $recordNum = getArrayValue("recordNum", "", $datas[$x]);
        $recordType1 = getArrayValue("recordType1", "", $datas[$x]);
        $groupName = getArrayValue("groupName", "", $datas[$x]);
        $dealTime = getArrayValue("dealTime", "", $datas[$x]);
        $recordTime = getArrayValue("recordTime", "", $datas[$x]);
        $name = getArrayValue("name", "", $datas[$x]);
        $agentAccount = getArrayValue("agentAccount", "", $datas[$x]);
        $remark = getArrayValue("note", "", $datas[$x]);
        $amount = getArrayValue("amount", 0, $datas[$x], true);
        
        $amountResult = getArrayValue("amountResult", 0, $datas[$x], true);
        $depositBonusAmount = getArrayValue("depositBonusAmount", 0, $datas[$x], true);
        $bonusAmount = getArrayValue("bonusAmount", 0, $datas[$x], true);
        $withdrawalLimitAmount = getArrayValue("withdrawalLimitAmount", 0, $datas[$x], true);
        $checkStatusCode = (int)getArrayValue("checkStatus", 1, $datas[$x]);
        if ($checkStatusCode == 2) {
            $totalCount += (float)$amount;
            $checkStatus = "<font color=green>成功</font>";
        } elseif ($checkStatusCode == 4) {
            $checkStatus = "<font color=red>失败</font>";
        } else {
            $checkStatus = "待审核";
        }

        $opType = getArrayValue("opType", "", $datas[$x]);
        $account = getArrayValue("account", "", $datas[$x]);
        $tmpdata = array(
            // makeCheckHtml($dno),//单号
            parseDate($recordTime)."<br/>".$dno,
            makeVerifyAccHtml(),
            $name,
            $agentAccount,
            $amount,
            $amountResult,
            $depositBonusAmount,
            $bonusAmount,
            $withdrawalLimitAmount,
            "TODO:交易方式",
            "TODO:存入银行",
            $checkStatus,
            parseDate($dealTime, 4),
            $remark,
            makeHistoryOperHtml($checkStatusCode, $dno)
            
        );
        
        for ($y=0;$y<count($tmpdata);$y++) {
            $tmpdata[$y] = str_replace("%ACCOUNT%", $account, $tmpdata[$y]);
        }
        array_push($retdatas, $tmpdata);
    }
    return array($retdatas, $totalCount);
}


/**
 * 资金调整界面的构造
 *
 * @param [type] $datas 数据
 * 
 * @return void
 */
function showDptCorrectHtml($datas)
{
    $retdatas = array();
    // $bonus = 0;
    // $dpt = 0;
    $pbonus = 0.0;
    $pdpt = 0.0;
    $pwtd= 0.0;
    // $wtd=0;
    
    for ($x=0;$x<count($datas);$x++) {
        
        $transId = getArrayValue("dno", "", $datas[$x]);
        $recordNum = getArrayValue("recordNum", "", $datas[$x]);
        $opType = getArrayValue("opType", "", $datas[$x]);
        $groupName = getArrayValue("groupName", "", $datas[$x]);
        $recordTime = getArrayValue("recordTime", "", $datas[$x]);
        
        $name = urldecode(getArrayValue("name", "", $datas[$x]));
        $agentName = getArrayValue("agentAccount", "", $datas[$x]);
        
        $amount = getArrayValue("amount", 0, $datas[$x], true);
        if ($opType == 1) {
            $pdpt += (float)$amount;
        } elseif ($opType == 2) {
            $pwtd += (float)$amount;
        } elseif ($opType == 128) {
            $pbonus += (float)$amount;
        }

        $bonus = getArrayValue("bonus", 0, $datas[$x], true);
        $flows = getArrayValue("flows", 0, $datas[$x], true);
        
        $remark = getArrayValue("note", "", $datas[$x]);
        $Operate = getArrayValue("Operate", "TODO:操作解析", $datas[$x]);
        $Acts = getArrayValue("ACTS", "TODO:活动解析", $datas[$x]);
       
        $account = getArrayValue("account", "", $datas[$x]);
        $tmpdata = array(
            $x+1,
            makeVerifyAccHtml(),
            $name,
            $groupName,
            $agentName,
            $amount,
            parseRecodeTypes(2, $opType),
            $Operate,
            $remark,
            $Acts,
            parseDate($recordTime, 4)
        );
        
        for ($y=0;$y<count($tmpdata);$y++) {
            $tmpdata[$y] = str_replace("%ACCOUNT%", $account, $tmpdata[$y]);
        }
        array_push($retdatas, $tmpdata);
    }
    return array($retdatas, array($pdpt, $pwtd, $pbonus));
}

/**
 * 展示取款审核数据
 *
 * @param [type] $datas 数据
 * 
 * @return void
 */
function showWDRecordData($datas)
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
        
        $bankType = (int)getArrayValue("bankType", 0, $datas[$x]);
        $bankCardName = getArrayValue("bankCardName", "", $datas[$x]);
        $bankCardNo = getArrayValue("bankCardNo", 0, $datas[$x]);
        $registerBank = getArrayValue("registerBank", "", $datas[$x]);
        
        $bankConfigs = getArrayValue($bankType  , "", $GLOBALS["BankTypes"]);
        $bankName = getArrayValue("name", "", $bankConfigs);
        $bankInfo = $bankName."&nbsp; ".$bankCardName . "<br/>".$bankCardNo."<br/>".$registerBank;
        $checkStatus = getArrayValue("checkStatus", "", $datas[$x]);
        $recordType = getArrayValue("recordType", "", $datas[$x]);
        $account = getArrayValue("account", "", $datas[$x]);
        $tmpdata = array(
            $dno, // 单号
            makeVerifyAccHtml(),
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
            makeWdRemarkHtml($dno),
            makeCheckStatusHtml($withdrawalLimitCheckStatus, $dno),
            makeWdOperHtml($withdrawalLimitCheckStatus, $checkStatus, $dno, $amount, $name, $bankCardNo, $bankCardNo)
        );
        
        for($y=0;$y<count($tmpdata);$y++){
            $tmpdata[$y] = str_replace("%ACCOUNT%", $account, $tmpdata[$y]);
        }
        array_push($retdatas, $tmpdata);
    }
    return $retdatas;
}

/**
 * 构建代理取款历史的数据界面
 *
 * @param [type] $datas 数据
 * 
 * @return void
 */
function showWDHistoryData($datas)
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
        
        $bankConfigs = getArrayValue($bankType, "", $GLOBALS["BankTypes"]);
        $bankName = getArrayValue("name", "", $bankConfigs);
        $bankInfo = $bankName."&nbsp; ".$name . "<br/>".$bankCardNo."<br/>".$registerBank;


        if ($withdrawalLimitCheckStatus == 2) {
            $status = "出款中";
        } else {
            $status = "todo:未知状态";
        }
        $tmpdata = array(
            $dno, // 单号
            makeVerifyAccHtml(),
            $name,
            $groupName,
            $agentName,
            "RMB",
            $amount,
            $amountResult,
            date("Y-m-d", $time). "<br/>".date("H:i:s", $time),
            $status,
            makeWDBankHtml($dno),
            $bankInfo,
            date("Y-m-d", $time1). "<br/>".date("H:i:s", $time1),
            date("Y-m-d", $time1). "<br/>".date("H:i:s", $time1),
            $staff,
            $note,
            $remark2,
        );
        
        for ($y=0;$y<count($tmpdata);$y++) {
            $tmpdata[$y] = str_replace("%ACCOUNT%", $account, $tmpdata[$y]);
        }
        array_push($retdatas, $tmpdata);
    }
    return $retdatas;
}

/**
 * 构建数据界面
 *
 * @param [type] $datas 数据
 * 
 * @return void
 */
function showflowLimitHtml($datas)
{
    /**
     * 构建取款流水限制汇总界面
     */
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
        
        $tmpdata = array(
            makeFLchkbox($recordNum),
            makeVerifyAccHtml(),
            $name,
            $amount,
            "",
            $platform,
            $timestr,
            $agentName,
            $status,
            makeLismitCheckBtn($amount, $platformID, $dno, $account, $platform, 2),
            makeLimitOkBtn($recordNum, $dno, $isWithdrawalLimitValid)
        );
        
        for ($y=0;$y<count($tmpdata);$y++) {
            $tmpdata[$y] = str_replace("%ACCOUNT%", $account, $tmpdata[$y]);
        }
        array_push($retdatas, $tmpdata);
    }
    return $retdatas;
}

function makeLimitOkBtn($recNum, $_dno, $flag){
    if ($flag === false){
        return '<a href="javascript:void(0);" onclick="endWater(\''.$recNum.'\',\'%ACCOUNT%\', 66);" class="btn btn-xs red"><i class="icon-trash"></i>重启</a></td>';
    }else{
        return '<a href="javascript:void(0);" onclick="endWater(\''.$recNum.'\',\'%ACCOUNT%\', 99);" class="btn btn-xs green"><i class="icon-trash"></i>OK</a></td>';
    }
    
}

function makeLismitCheckBtn($_amount, $_gpid, $_dno, $_account, $_gpname, $_type){
    return "<a href=\"#WCheckDetial\" data-toggle=\"modal\" 
    onclick=\"checkWater('".$_amount."','". $_gpid."','".$_dno."','".$_account."','".$_gpname."', '". $_type."');\" class=\"btn btn-xs red\">流水检查</a></td>";
}
function makeFLchkbox($wid){
    return "<input name=\"list\" class=\"form-control\" status=\"0\" wid=\"".$wid."\" uid=\"%ACCOUNT%\" type=\"checkbox\">";
}

function makeWDBankHtml($dno){
    return '<a href="#bankModal" data-toggle="modal" onclick="setbankModal(\''.$dno.'\');" class="btn btn-xs blue"><i class="icon-trash"></i>银行卡出款</a>';
}

function makeDPBankHtml(){
    return ;
}
function makeCheckStatusHtml($status, $_dno){
    if($status == 1){
        return '<a href="#WCheck" data-toggle="modal" onclick="getWList(\''.$_dno.'\',\'%ACCOUNT%\',1);" class="btn mini green"><i class="icon-trash"></i>请检查</a>';
    }elseif($status == 2){
        return "<label value='".$status."'>已通过</label>";
    }elseif($status == 4){
        return "<label value='".$status."'>未通过</label>";
    }else{
        return "<label value='".$status."'>未定义状态</label>";
    }
    
}
function makeWdOperHtml($flowStatus, $CkStatus , $_dno, $amount, $rname, $bank,$card){
    $passHtml = '<a href="#passModal" data-toggle="modal" onclick="passSet(\''.$_dno.'\',
    \''.$amount.'\',\''.$rname.'\',\''.$bank.'\',\''.$card.'\',\'%ACCOUNT%\');"class="btn btn-xs green"><i class="icon-trash"></i>通过</a>';
    $refuseHtml = '<a href="#refuseModal" data-toggle="modal" onclick="refuseSet(\''.$_dno.'\',
    \''.$amount.'\',\'0.00\',\'1510375133\');" class="btn btn-xs red"><i class="icon-trash"></i>拒绝</a>';
    $bankHtml = "<a href=\"#bankModal\" data-toggle=\"modal\" onclick=\"setbankModal('".$_dno."');\" class=\"btn btn-xs blue\"><i class=\"icon-trash\"></i>银行卡出款</a>";
    if($CkStatus == 1){
        if ($flowStatus == 1){
            return $refuseHtml;
        }elseif($flowStatus == 2){
            return $passHtml. "&nbsp; " .$refuseHtml;
        }elseif($flowStatus == 4){
            return $refuseHtml;
        }
    }elseif($CkStatus == 2){
        return $bankHtml;
    }elseif($CkStatus == 4){
        return "不知道";
    }

}

function makeWdRemarkHtml($_dno){
    return '<label remark="cs" data-original-title="" id="cs_'.$_dno.'">
    </label><a href="javascript:void(0);"  csremark="csremark" dno="'.$_dno.'">
    <i class="fa fa-edit"></i></a>';
}

function makeHistoryOperHtml($code, $_dno){
    if ($code == 4){
        return '<a href="javascript:void(0);" reset="reset" dno="'.$_dno.'" class="btn mini green">重置</a>';
    }else{
        return '<a href="javascript:void(0);" onclick="resetAlert()" class="btn mini grey-steel">重置</a>';
    }
    

}

/**
 * 存款审核界面的操作按钮Html构建
 *
 * @param [type] $_dno    订单号
 * @param [type] $_amount 存款数量
 * 
 * @return void
 */
function makeVerifyOperHtml($_dno, $_amount)
{
    return '<a href="javascript:void(0);" limit="1000000.00" cb="161908.0000" dealsrate="0" 
    onclick="startverifytask(this,\''.$_dno.'\',\''.(float)$_amount.'\',\'%ACCOUNT%\',\'TODO:平台银行卡\',\'TODO:平台银行卡备注\',\'\',
    \'H\');"  class="btn mini green"><i class="icon-trash"></i>审核</a></td>';
}

/**
 * 构建账号按钮的Html
 *
 * @return void
 */
function makeVerifyAccHtml()
{
    return "<span class='label label-info' style='cursor:pointer;' onclick='custom_getBalance(\"%ACCOUNT%\", \"%ACCOUNT%\")'>%ACCOUNT%</span>";
}

/**
 * 界面的check框的html
 *
 * @param [type] $_dno 订单号
 * 
 * @return void
 */
function makeCheckHtml($_dno)
{
    return '<input name="list" class="form-control" dno="'.$_dno.'" type="checkbox">';
}

?>