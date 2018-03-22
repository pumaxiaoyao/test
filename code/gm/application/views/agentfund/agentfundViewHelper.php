<?php

/**
 * 构建代理结算界面
 *
 * @return void
 */
function showcurPeriod()
{
    $html = readHtml("agentfund/curPeriod");
    $html = str_replace("%LASTMON%", date("Ym", time() - 24*3600 *30), $html);
    $page = array(
        makeHeaderPage(""),
        $html,
        makeFooterPage("agentfund_curperiod_footer"),
    );
    output(join("", $page));
}

/**
 * 构建代理结算历史界面
 *
 * @return void
 */
function showsettleHistory()
{
    $page = array(
        makeHeaderPage(""),
        readHtml("agentfund/settleHistory"),
        makeFooterPage(""),
    );
    output(join("", $page));
}

function showwtdVerify(){
    $page = array(
        makeHeaderPage(""),
        readHtml("agentfund/wtdVerify"),
        makeFooterPage(""),
    );
    output(join("", $page));     
}

/**
 * 构建代理取款历史界面
 *
 * @return void
 */
function showwtdHistory()
{
    $html = readHtml("agentfund/wtdHistory");
    $s_st = parseDate(time() - 24*60*60*30);
    $s_et = parseDate(time());
    $html = str_replace("%STARTTIME%", $s_st, $html);
    $html = str_replace("%ENDTIME%", $s_et, $html);

    $page = array(
        makeHeaderPage(""),
        $html,
        makeFooterPage(""),
    );
    output(join("", $page));    
}   

/**
 * 构建代理取款审核界面
 *
 * @param [type] $retData URI数据
 * 
 * @return void
 */
function showwtdVeryfyDataHtml($retData)
{

    $rData = getArrayValue("data", array(), $retData);
    $aaData = array();
    foreach ($rData as $_data) {
        $amount = (float)getArrayValue("amount", 0, $_data);
        $amountResult = (float)getArrayValue("amountResult", 0, $_data);
        $balance = (float)getArrayValue("balance", 0, $_data);

        $checkStatus = (int)getArrayValue("checkStatus", 0, $_data);
        $commisionAmount = (float)getArrayValue("commisionAmount", 0, $_data);
        $recordTime = getArrayValue("recordTime", "", $_data);

        $opType = getArrayValue("opType", 0, $_data);
        $recordNum = getArrayValue("recordNum", 0, $_data);
        $dno = getArrayValue("dno", 0, $_data);
        $roleId = getArrayValue("roleId", 0, $_data);
        $account = getArrayValue("account", "无数据", $_data);
        $name = getArrayValue("name", "无数据", $_data);

        $withdrawalAmount = (float)getArrayValue("withdrawalAmount", 0, $_data);
        $withdrawal_fee = (float)getArrayValue("withdrawal_fee", 0, $_data);
        $withdrawal_feeType = (int)getArrayValue("withdrawal_feeType", 0, $_data);
        $withdrawal_isRemit = (int)getArrayValue("withdrawal_isRemit", 0, $_data);
        $withdrawal_remitBankCardId = (int)getArrayValue("withdrawal_remitBankCardId", 0, $_data);

        $layerName = getArrayValue("layerName", "无", $_data);

        $pParentId = (int)getArrayValue("pParentId", 1, $_data);
        $parentId = (int)getArrayValue("parentId", 0, $_data);
        $parentAccount = getArrayValue("parentAccount", "", $_data);
        $belongToTags = parseBelongTo($pParentId, $parentId, $parentAccount);

        $cardBankType = getArrayValue("cardBankType", 0, $_data);
        $cardName = getArrayValue("cardName", "", $_data);
        $cardNo = getArrayValue("cardNo", "", $_data);
        $cardRegisterBank = getArrayValue("cardRegisterBank", "", $_data);

        $showBankInfo = parseBankInfo($cardBankType, $cardName, $cardNo);

        $tmp = array(
            $dno,
            makeAgentAccountHtml($roleId, $account),
            $layerName,
            $belongToTags[0],
            $belongToTags[1],
            $name,
            $amount,
            $withdrawal_fee,
            $amountResult,
            parseDate($recordTime, 4),
            $showBankInfo,
            makeAgentWtdNoteHtml($dno, getArrayValue("note", "", $_data)),
            makeAgenWtdOperHtml($dno, $amount, $withdrawal_feeType, $withdrawal_fee)
        );
        array_push($aaData, $tmp);
    }
    return $aaData;
}

/**
 * 构建代理账号页面
 *
 * @param [type] $_acc 代理账号
 * @param [type] $_aid 代理ID
 * 
 * @return void
 */
function makeAgentAccountHtml($_aid, $_acc)
{
    return "<span class=\"label label-info\" style=\"cursor:pointer;\" onclick=\"custom_getAgentModel('". $_aid . "','" . $_acc . "');\">".$_acc."</span>";
}


/**
 * 添加代理列表的备注按钮
 *
 * @param [type] $dno  订单ID
 * @param [type] $note 备注内容
 * 
 * @return void
 */
function makeAgentWtdNoteHtml($dno, $note)
{
    return "<label remark=\"remark\" id=\"remark_".$dno."\" title=\"".$note."\">".$note."</label><a href=\"javascript:void(0);\" csremark=\"csremark\" dno=\"".$dno."\"><i class=\"fa fa-edit\"></i></a>";

}


/**
 * 代理审核界面的操作按钮Html
 * 
 * @param [type] $dno     订单
 * @param [type] $amount  金额
 * @param [type] $fee     手续费
 * @param [type] $feetype 手续类型
 * 
 * @return void
 */
function makeAgenWtdOperHtml($dno, $amount, $fee, $feetype)
{
    $html = "<a onclick=\"refuseSet('". $dno ."');\" data-toggle=\"modal\" href=\"#refuseModal\" class=\"btn mini red\"><i class=\"icon-trash\"></i>拒绝</a>";
    $html .= "<a onclick=\"passSet('". $dno ."','". $amount ."','".$feetype."','".$fee."');\" data-toggle=\"modal\" href=\"#passModal\" class=\"btn mini green\"><i class=\"icon-trash\"></i>通过</a>"; 
    return $html;
}

/**
 * 构建代理审核历史界面数据请求
 *
 * @param [type] $retData 数据
 * 
 * @return void
 */
function showagentWDHistoryData($retData)
{
    $aaData = array();
    foreach ($retData as $_data) {
        $amount = (float)getArrayValue("amount", 0, $_data);
        $amountResult = (float)getArrayValue("amountResult", 0, $_data);
        $balance = (float)getArrayValue("balance", 0, $_data);

        $checkStatus = (int)getArrayValue("checkStatus", 0, $_data);
        $commisionAmount = (float)getArrayValue("commisionAmount", 0, $_data);
        $recordTime = getArrayValue("recordTime", "", $_data);
        $dealTime = getArrayValue("dealTime", "", $_data);

        $opType = getArrayValue("opType", 0, $_data);
        $recordNum = getArrayValue("recordNum", 0, $_data);
        $dno = getArrayValue("dno", 0, $_data);
        $roleId = getArrayValue("roleId", 0, $_data);
        $account = getArrayValue("account", "无数据", $_data);
        $name = getArrayValue("name", "无数据", $_data);

        $withdrawalAmount = (float)getArrayValue("withdrawalAmount", 0, $_data);
        $withdrawal_fee = (float)getArrayValue("withdrawal_fee", 0, $_data);
        $withdrawal_feeType = (int)getArrayValue("withdrawal_feeType", 0, $_data);
        $withdrawal_isRemit = (int)getArrayValue("withdrawal_isRemit", 0, $_data);
        $withdrawal_remitBankCardId = (int)getArrayValue("withdrawal_remitBankCardId", 0, $_data);

        $layerName = getArrayValue("layerName", "无", $_data);

        $pParentId = (int)getArrayValue("pParentId", 1, $_data);
        $parentId = (int)getArrayValue("parentId", 0, $_data);
        $parentAccount = getArrayValue("parentAccount", "", $_data);
        $note = getArrayValue("note", "", $_data);

        $belongToTags = parseBelongTo($pParentId, $parentId, $parentAccount);

        if ($checkStatus == 2) {
            $operBtn = makeAgentWtdHistoryOperHtml($dno, $withdrawal_remitBankCardId);
            $statusTag = "已通过";
        } else if ($checkStatus == 4) {
            $operBtn = "";
            $statusTag = "已拒绝";
        } else if ($checkStatus == 1) {
            $operBtn = "";
            $statusTag = "待审核";
        }

        
        $cardBankType = getArrayValue("cardBankType", 0, $_data);
        $cardName = getArrayValue("cardName", "", $_data);
        $cardNo = getArrayValue("cardNo", "", $_data);
        $cardRegisterBank = getArrayValue("cardRegisterBank", "", $_data);

        $showBankInfo = parseBankInfo($cardBankType, $cardName, $cardNo);


        $tmp = array(
            // $dno,
            makeAgentAccountHtml($roleId, $account),
            $layerName,
            $belongToTags[0],
            $belongToTags[1],
            $name,
            $amount,
            $withdrawal_fee,
            $amountResult,
            parseDate($recordTime, 4),
            parseDate($dealTime, 4),
            $showBankInfo,
            $statusTag,
            $note,
            $operBtn
        );
        array_push($aaData, $tmp);
    }
    return $aaData;
}

/**
 * 构建代理取款审核历史界面的银行卡按钮
 *
 * @param [type] $CardId 卡ID
 * 
 * @return void
 */
function makeAgentWtdHistoryOperHtml($dno, $CardId)
{
    return '<a href="#bankModal" data-toggle="modal" onclick="setbankModal(\''. $dno .'\', \''.$CardId.'\');" class="btn btn-xs blue"><i class="icon-trash"></i>银行卡出款</a>';
}

/**
 * 代理资金结算的数据界面
 *
 * @param [type] $retData 数据
 * 
 * @return void
 */
function shouCurPeriodData($retData)
{
    $aaData = array();
   
    $new_retData = array();
    foreach ($retData as $_data) {
        $pParentId = (int)getArrayValue("pParentId", 0, $_data);
        $parentId = (int)getArrayValue("parentId", 0, $_data);
        $roleId = (int)getArrayValue("roleId", 0, $_data);
        if ($pParentId !== 0) {
            $lv3 = $accTag;
            $new_retData[$pParentId]["lv2"][$parentId]["lv3"][$roleId] = array("data"=>$_data);
        } else if ($parentId == 0) {
            if (!isset($new_retData[$roleId])) {
                $new_retData[$roleId] = array("data"=>array(), "lv2"=>array());
            }
            $new_retData[$roleId]["data"] = $_data;
        } else {
            if (!isset($new_retData[$parentId]["lv2"][$roleId])) {
                $new_retData[$parentId]["lv2"][$roleId] = array("data"=>array(), "lv3"=>array());
            }
            $new_retData[$parentId]["lv2"][$roleId]["data"] = $_data;
        }
    }
    foreach ($new_retData as $lv1=>$_ret) {
        if (isset($_ret["data"])) {
            array_push($aaData, makeOneAgentCurPeriodData($_ret["data"]));
        }
        if (isset($_ret["lv2"]) && count($_ret["lv2"]) > 0) {
            foreach ($_ret["lv2"] as $lv2=>$_ret2) {
                if (isset($_ret2["data"])) {
                    array_push($aaData, makeOneAgentCurPeriodData($_ret2["data"]));
                }
                if (isset($_ret2["lv3"]) && count($_ret2["lv3"]) > 0) {
                    foreach ($_ret2["lv3"] as $lv3=>$_ret3) {
                        if (isset($_ret3["data"])) {
                            array_push($aaData, makeOneAgentCurPeriodData($_ret3["data"]));
                        }
                    }
                }
            }
        }
    }

    return $aaData;
}

/**
 * 处理结算单的数据构建
 *
 * @param [type] $_data 结算单的数据
 * 
 * @return void
 */
function makeOneAgentCurPeriodData($_data, $_type="settle")
{
    if (count($_data) == 0 ) {
        return array();
    }
    $month = getArrayValue("month", "", $_data);
    $roleId = (int)getArrayValue("roleId", 0, $_data);
    $account = getArrayValue("account", "无", $_data);
    $pParentId = (int)getArrayValue("pParentId", 0, $_data);
    $parentId = (int)getArrayValue("parentId", 0, $_data);
    $parentAccount = getArrayValue("parentAccount", "", $_data);
    $dno = (int)getArrayValue("dno", 0, $_data);
    
    $lv1 = "/";
    $lv2 = "/";
    $lv3 = "/";

    $accTag = makeAgentAccountHtml($roleId, $account);
    if ($pParentId !== 0) {
        $lv3 = $accTag;
    } else if ($parentId == 0) {
        $lv1 = $accTag;
    } else {
        $lv2 = $accTag;
    }

    $layerName = getArrayValue("layerName", "", $_data);
    $validPlayerCount = (int)getArrayValue("validPlayerCount", 0, $_data);
    $layerNeedPlayer = (int)getArrayValue("layerNeedPlayer", 0, $_data);

    if ($validPlayerCount > $layerNeedPlayer) {
        $playerTag = "<font color='green'>" . $validPlayerCount . " / " . $layerNeedPlayer . "</font>";
    } else {
        $playerTag = "<font color='red'>" . $validPlayerCount . " / " . $layerNeedPlayer . "</font>";
    }
   
    $platformCommision = getArrayValue("platformCommision", 0, $_data);
    $costAllocation = getArrayValue("costAllocation", 0, $_data);
    $lastMonthLeftAMount = getArrayValue("lastMonthLeftAmount", 0, $_data);
    $nextMonthLeftAMount = getArrayValue("lastMonthLeftAmount", 0, $_data);
    $adjustmentAmount = getArrayValue("adjustmentAmount", 0, $_data);
    $adjustmentNote = getArrayValue("adjustmentNote", "", $_data);
    
    $commisionAmount = getArrayValue("commisionAmount", 0, $_data);
    $commisionResultAmount = getArrayValue("commisionResultAmount", 0, $_data);

    $resultNote = getArrayValue("resultNote", "", $_data);
    $checkStatus = (int)getArrayValue("status", 1, $_data);

    if ($checkStatus == 2) {
        $adjustBtn = $adjustmentAmount;
        $resultBtn = $commisionResultAmount;
        $operBtn = "<a href=\"#verifyModal\" data-toggle=\"modal\" onclick=\"verifystart(2,'".$dno. "');\" class=\"btn btn-xs red\"><i class=\"icon-question\"></i>终审</a>";
        $statusTag = "待终审";
    } else if ($checkStatus == 4) {
        $operBtn = "";
        $adjustBtn = $adjustmentAmount;
        $resultBtn = $commisionResultAmount;
        $statusTag = "已通过";
    } else if ($checkStatus == 1) {
        $operBtn = "<a href=\"#verifyModal\" data-toggle=\"modal\" onclick=\"verifystart(1,'".$dno. "');\" class=\"btn btn-xs blue\"><i class=\"icon-question\"></i>初审</a>";
        $adjustBtn = "<a href=\"#adjustModal\" data-toggle=\"modal\" onclick=\"adjuststart('" . $dno. "', '".$adjustmentAmount."');\" class=\"btn btn-xs green\"><i class=\"fa fa-edit\"></i>".$adjustmentAmount."</a>";
        $resultBtn = "<a href=\"#acturalModal\" data-toggle=\"modal\" onclick=\"acturalstart('" . $dno. "','".$commisionResultAmount."', '".$platformCommision."');\" class=\"btn btn-xs green\"><i class=\"fa fa-edit\"></i>".$commisionResultAmount."</a>";

        $statusTag = "待初审";
    }
    
    if ($_type == "settle") {
        $tmp = array(
            "<input type='checkbox' name='groups' status='".$checkStatus."'  month='".$month. "' dno='".$dno."' agentcode='".$roleId."'  agentname='".$account."'>",
            $month,
            $lv1,
            $lv2,
            $lv3,
            $layerName,
            $playerTag,
            "<a href=\"#DetailModal\" onclick=\"showDetail('" . $dno. "');\" data-toggle=\"modal\" class=\"btn mini green\"><i class=\"fa fa-building-o\"></i>".$platformCommision."</a></td>",
            "<a href=\"#CbDetailModal\" onclick=\"showCbDetail('" . $dno. "')\" data-toggle=\"modal\" class=\"btn mini green\"><i class=\"fa fa-building-o\"></i>". $costAllocation . "</a>",
            $lastMonthLeftAMount,
            $adjustBtn,
            $adjustmentNote,
            $commisionAmount,
            $resultBtn,
            $nextMonthLeftAMount,
            $resultNote,
            $statusTag,
            $operBtn
        );
    } else {
        $tmp = array(
            $month,
            $lv1,
            $lv2,
            $lv3,
            $layerName,
            $playerTag,
            "<a href=\"#DetailModal\" onclick=\"showDetail('" . $dno. "');\" data-toggle=\"modal\" class=\"btn mini green\"><i class=\"fa fa-building-o\"></i>".$platformCommision."</a></td>",
            "<a href=\"#CbDetailModal\" onclick=\"showCbDetail('" . $dno. "')\" data-toggle=\"modal\" class=\"btn mini green\"><i class=\"fa fa-building-o\"></i>". $costAllocation . "</a>",
            $lastMonthLeftAMount,
            $adjustBtn,
            $adjustmentNote,
            $commisionAmount,
            $resultBtn,
            $nextMonthLeftAMount,
            $resultNote,
            $statusTag
        );
    };
    
    $gcData = makeGameCommissionHtml($_data);
    $gcHtml = $gcData[0];
    
    $ccHtml = makeChildCommissionHtml($_data, $gcData[1]);
    $caHtml = makeChildCostAlloation($_data);
    if (!isset($_SESSION["GameCommision"])) {
        $_SESSION["GameCommision"] = array();
    }

    $_SESSION["GameCommision"][$dno] = array("gc"=>$gcHtml, "cc"=>$ccHtml, "ca"=>$caHtml);

    return $tmp;
}

/**
 * 生成成本分摊界面的Html
 *
 * @param [type] $data 数据
 * 
 * @return void
 */
function makeChildCostAlloation($data)
{
    $caHtml = "";
    $childStr = getArrayValue("childStr", "", $data);

    $depositBonusAllocationAmount = (float)getArrayValue("depositBonusAllocationAmount", 0, $data);
    $depositBonusAmount = (float)getArrayValue("depositBonusAmount", 0, $data);
    $depositBonusRate = sprintf("%.2f", getArrayValue("depositBonusRate", 0, $data) *100);

    $bonusAllocationAmount = (float)getArrayValue("bonusAllocationAmount", 0, $data);
    $bonusAmount = (float)getArrayValue("bonusAmount", 0, $data);
    $bonusRate = sprintf("%.2f", getArrayValue("bonusRate", 0, $data) *100);

    $rebateAllocationAmount = (float)getArrayValue("rebateAllocationAmount", 0, $data);
    $rebateAmount = (float)getArrayValue("rebateAmount", 0, $data);
    $rebateRate = sprintf("%.2f", getArrayValue("rebateRate", 0, $data) *100);
    // AgentAllocationData

    $caHtml = "<tr><th>".$depositBonusAllocationAmount."</th>";
    $caHtml .= "<th>".$depositBonusRate."%</th>";
    $caHtml .= "<th>".$depositBonusAmount."</th>";

    $caHtml .= "<th>".$bonusAllocationAmount."</th>";
    $caHtml .= "<th>".$bonusRate."%</th>";
    $caHtml .= "<th>".$bonusAmount."</th>";

    $caHtml .= "<th>".$rebateAllocationAmount."</th>";
    $caHtml .= "<th>".$rebateRate."%</th>";
    $caHtml .= "<th>".$rebateAmount."</th></tr>";

    $lineChargeRate = sprintf("%.2f", getArrayValue("lineChargeRate", 0, $data) *100);
    
    
    $ccHtml = "";
    $totalDeposit = 0;
    $totalBonus = 0;
    $totalRebate = 0;
    if (!empty($childStr)) {
        $childData = json_decode($childStr, true);
        foreach ($childData as $cData) {
            $roleId = getArrayValue("roleId", "", $cData);

            $_depositBonusAllocationAmount = (float)getArrayValue("depositBonusAllocationAmount", 0, $cData);
            $_depositBonusAmount = (float)getArrayValue("depositBonusAmount", 0, $cData);
            $_depositBonusRate = sprintf("%.2f", getArrayValue("depositBonusRate", 0, $cData) *100);
            
            $_bonusAllocationAmount = (float)getArrayValue("bonusAllocationAmount", 0, $cData);
            $_bonusAmount = (float)getArrayValue("bonusAmount", 0, $cData);
            $_bonusRate = sprintf("%.2f", getArrayValue("bonusRate", 0, $cData) *100);

            $_rebateAllocationAmount = (float)getArrayValue("rebateAllocationAmount", 0, $cData);
            $_rebateAmount = (float)getArrayValue("rebateAmount", 0, $cData);
            $_rabateRate = sprintf("%.2f", getArrayValue("rabateRate", 0, $cData) *100);
            
            $totalDeposit += $_depositBonusAllocationAmount;
            $totalBonus += $_bonusAllocationAmount;
            $totalRebate += $_rebateAllocationAmount;

            $ccHtml .= "<tr><td>" . $roleId . "</td>";
            $ccHtml .= "<td>" . $_depositBonusAllocationAmount . "</td>";
            $ccHtml .= "<td>" . $_depositBonusRate . "%</td>";
            $ccHtml .= "<td>" . $_depositBonusAmount . "</td>";
            $ccHtml .= "<td>" . $_bonusAllocationAmount . "</td>";
            $ccHtml .= "<td>" . $_bonusRate . "%</td>";
            $ccHtml .= "<td>" . $_bonusAmount . "</td>";
            $ccHtml .= "<td>" . $_rebateAllocationAmount . "</td>";
            $ccHtml .= "<td>" . $_rabateRate . "%</td>";
            $ccHtml .= "<td>" . $_rebateAmount . "</td></tr>";
        }

    }

    $ccHtml .= "<tr><td>实际承担费用</td>";
    $ccHtml .= "<td colspan=2>存款优惠</td>";
    $ccHtml .= "<td>". ($depositBonusAllocationAmount - $totalDeposit) ."</td>";
    $ccHtml .= "<td colspan=2>红利</td>";
    $ccHtml .= "<td>". ($bonusAllocationAmount - $totalBonus) ."</td>";
    $ccHtml .= "<td colspan=2>返水</td>";
    $ccHtml .= "<td>". ($rebateAllocationAmount - $totalRebate) ."</td>";

    return array($caHtml, $ccHtml);
}

/**
 * 构建数据
 *
 * @param [type] $data           数据
 * @param [type] $TotalCommision 汇总
 *  
 * @return void
 */
function makeChildCommissionHtml($data, $TotalCommision)
{   
    $ccHtml = "";
    $childStr = getArrayValue("childStr", "", $data);
    $lineChargeRate = sprintf("%.2f", getArrayValue("lineChargeRate", 0, $data) *100);
    $totalLineCommision = 0;
    if (!empty($childStr)) {
        $childData = json_decode($childStr, true);

        foreach ($childData as $cData) {
            $roleId = getArrayValue("roleId", "", $cData);
            $commisionAmount = getArrayValue("pumpingCommisionAmount", 0, $cData);
            $waterAmount = getArrayValue("pumpingWaterAmount", 0, $cData);
            $totalAmount = $commisionAmount + $waterAmount;
            $lineAmount = getArrayValue("lineChargeAmount", 0, $cData);
            $totalLineCommision += $lineAmount;
            $ccHtml .= "<tr><td>" . $roleId . "</td>";
            $ccHtml .= "<td>" . $commisionAmount . "</td>";
            $ccHtml .= "<td>" . $waterAmount . "</td>";
            $ccHtml .= "<td>" . $totalAmount . "</td>";
            $ccHtml .= "<td>" . $lineChargeRate . "%</td>";
            $ccHtml .= "<td>" . $lineAmount . "</td></tr>";
        }
    }
    $ccHtml .= "<tr><td>代理线佣金</td>";
    $ccHtml .= "<td>" . $TotalCommision . "</td>";
    $ccHtml .= "<td>下线佣金合计</td>";
    $ccHtml .= "<td>" . $totalLineCommision . "</td>";
    $ccHtml .= "<td>实际结算佣金</td>";
    $ccHtml .= "<td>" . ($TotalCommision - $totalLineCommision) . "</td>";
    return $ccHtml;
}



/**
 * 构建佣金报表页面
 *
 * @param [type] $data 数据
 * 
 * @return void
 */
function makeGameCommissionHtml($data)
{
    $crHtml = "";
    $gameStr = getArrayValue("gameStr", "", $data);
    $TotalWinLose = 0;
    $TotalCommision = 0;
    $TotalWater = 0;
    $TotalStake = 0;
    $lineChargeRate = sprintf("%.2f", getArrayValue("lineChargeRate", 0, $data) *100);
    
    if (!empty($gameStr)) {
        $gameData = json_decode($gameStr, true);

        foreach ($gameData as $gpName=>$gpData) {
            $winlose = getArrayValue("winLoseAmount", 0, $gpData);
            $commision = getArrayValue("pumpingCommisionAmount", 0, $gpData);
            $water = getArrayValue("pumpingWaterAmount", 0, $gpData);
            $stake = getArrayValue("validStakeAmount", 0, $gpData);
            $TotalWinLose += $winlose;
            $TotalCommision += $commision;
            $TotalWater += $water;
            $TotalStake += $stake;

            $PCR = sprintf("%.2f", getArrayValue("pumpingCommisionRate", 0, $gpData) * 100);
            $PWR = sprintf("%.2f", getArrayValue("pumpingWaterRate", 0, $gpData) * 100);
            $crHtml .= "<tr><td>". $gpName . "</td>";
            $crHtml .= "<td>". $winlose . "</td>";
            $crHtml .= "<td>". $PCR . "%</td>";
            $crHtml .= "<td>". $commision . "</td>";
            $crHtml .= "<td>". $stake . "</td>";
            $crHtml .= "<td>". $PWR . "%</td>";
            $crHtml .= "<td>". $water . "</td></tr>";
        }
    }
    $crHtml .= "<tr><td>小计</td>";
    $crHtml .= "<td>". $TotalWinLose ."</td><td></td>";
    $crHtml .= "<td>". $TotalCommision ."</td>";
    $crHtml .= "<td>". $TotalStake ."</td><td></td>";
    $crHtml .= "<td>". $TotalWater ."</td></tr>";

    $lineCommision = (1 - $lineChargeRate / 100) * $TotalCommision;
    $crHtml .= "<tr><td>平台合计</td>";
    $crHtml .= "<td>". $TotalCommision ."</td>";
    $crHtml .= "<td>线路费</td>";
    $crHtml .= "<td>". $lineChargeRate ."%</td>";
    $crHtml .= "<td>代理线佣金</td>";
    $crHtml .= "<td colspan='2'>". $lineCommision ."</td></tr>";
    return array($crHtml, $lineCommision);
}


/**
 * 构建代理结算历史Html
 *
 * @param [type] $retData 数据
 * 
 * @return void
 */
function showSettleHistoryData($retData)
{
    
    $rData = getArrayValue("data", array(), $retData);
    $aaData = array();
    $new_retData = array();
    foreach ($rData as $_data) {
        $pParentId = (int)getArrayValue("pParentId", 0, $_data);
        $parentId = (int)getArrayValue("parentId", 0, $_data);
        $roleId = (int)getArrayValue("roleId", 0, $_data);
        if ($pParentId !== 0) {
            $lv3 = $accTag;
            $new_retData[$pParentId]["lv2"][$parentId]["lv3"][$roleId] = array("data"=>$_data);
        } else if ($parentId == 0) {
            if (!isset($new_retData[$roleId])) {
                $new_retData[$roleId] = array("data"=>array(), "lv2"=>array());
            }
            $new_retData[$roleId]["data"] = $_data;
        } else {
            if (!isset($new_retData[$parentId]["lv2"][$roleId])) {
                $new_retData[$parentId]["lv2"][$roleId] = array("data"=>array(), "lv3"=>array());
            }
            $new_retData[$parentId]["lv2"][$roleId]["data"] = $_data;
        }
    }
    foreach ($new_retData as $lv1=>$_ret) {
        if (isset($_ret["data"])) {
            array_push($aaData, makeOneAgentCurPeriodData($_ret["data"], "history"));
        }
        if (isset($_ret["lv2"]) && count($_ret["lv2"]) > 0) {
            foreach ($_ret["lv2"] as $lv2=>$_ret2) {
                if (isset($_ret2["data"])) {
                    array_push($aaData, makeOneAgentCurPeriodData($_ret2["data"], "history"));
                }
                if (isset($_ret2["lv3"]) && count($_ret2["lv3"]) > 0) {
                    foreach ($_ret2["lv3"] as $lv3=>$_ret3) {
                        if (isset($_ret3["data"])) {
                            array_push($aaData, makeOneAgentCurPeriodData($_ret3["data"], "history"));
                        }
                    }
                }
            }
        }
    }
    return $aaData;
}

?>