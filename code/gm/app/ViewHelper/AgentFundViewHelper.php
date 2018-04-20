<?php
namespace App\ViewHelper;

use App\Config\Config;
use App\Controllers\CheckStatus;

class AgentFundViewHelper extends BaseViewHelper
{

    /**
     * 代理资金结算的数据界面
     *
     * @param [type] $retData 数据
     *
     * @return void
     */
    public static function shouCurPeriodData($retData)
    {
        $aaData = [];
        $new_retData = [];
        foreach ($retData as $_data) {
            $pParentId = (int) getArrayValue("pParentId", 0, $_data);
            $parentId = (int) getArrayValue("parentId", 0, $_data);
            $roleId = (int) getArrayValue("roleId", 0, $_data);
            if ($pParentId !== 0) {
                // $lv3 = $accTag;
                $new_retData[$pParentId]["lv2"][$parentId]["lv3"][$roleId] = array("data" => $_data);
            } else if ($parentId == 0) {
                if (!isset($new_retData[$roleId])) {
                    $new_retData[$roleId] = array("data" => array(), "lv2" => array());
                }
                $new_retData[$roleId]["data"] = $_data;
            } else {
                if (!isset($new_retData[$parentId]["lv2"][$roleId])) {
                    $new_retData[$parentId]["lv2"][$roleId] = array("data" => array(), "lv3" => array());
                }
                $new_retData[$parentId]["lv2"][$roleId]["data"] = $_data;
            }
        }
        foreach ($new_retData as $lv1 => $_ret) {
            if (isset($_ret["data"])) {
                array_push($aaData, self::makeOneAgentCurPeriodData($_ret["data"]));
            }
            if (isset($_ret["lv2"]) && count($_ret["lv2"]) > 0) {
                foreach ($_ret["lv2"] as $lv2 => $_ret2) {
                    if (isset($_ret2["data"])) {
                        array_push($aaData, self::makeOneAgentCurPeriodData($_ret2["data"]));
                    }
                    if (isset($_ret2["lv3"]) && count($_ret2["lv3"]) > 0) {
                        foreach ($_ret2["lv3"] as $lv3 => $_ret3) {
                            if (isset($_ret3["data"])) {
                                array_push($aaData, self::makeOneAgentCurPeriodData($_ret3["data"]));
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
    private static function makeOneAgentCurPeriodData($_data, $_type = "settle")
    {
        if (count($_data) == 0) {
            return array();
        }
        $month = getArrayValue("month", "", $_data);
        $roleId = (int) getArrayValue("roleId", 0, $_data);
        $account = getArrayValue("account", "无", $_data);
        $pParentId = (int) getArrayValue("pParentId", 0, $_data);
        $parentId = (int) getArrayValue("parentId", 0, $_data);
        $parentAccount = getArrayValue("parentAccount", "", $_data);
        $dno = (int) getArrayValue("dno", 0, $_data);

        $lv1 = "/";
        $lv2 = "/";
        $lv3 = "/";

        // 构建代理账号按钮
        $accountT = [
            "agentId" => $_data["roleId"],
            "agentAccount" => $account,
            "type" => 1,
        ];
        $accountCell = self::makeAgentAccountHtml($accountT);

        if ($pParentId !== 0) {
            $lv3 = $accountCell;
        } else if ($parentId == 0) {
            $lv1 = $accountCell;
        } else {
            $lv2 = $accountCell;
        }

        $layerName = getArrayValue("layerName", "", $_data);
        $validPlayerCount = (int) getArrayValue("validPlayerCount", 0, $_data);
        $layerNeedPlayer = (int) getArrayValue("layerNeedPlayer", 0, $_data);

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
        $checkStatus = (int) getArrayValue("status", 1, $_data);



        $statusTag = Config::agStatusTransMap[$checkStatus];

        // 构建OperBtn
        $operT = [
            "checkStatus" => $checkStatus,
            "dno" => $dno,
        ];
        $operCell = self::makeCurPeriodOperHtml($operT);

        // 构建调整按钮
        $adjustT = [
            "dno" => $dno,
            "checkStatus" => $checkStatus,
            "adjustmentAmount" => $adjustmentAmount,
        ];
        $adjustCell = self::makeAdjustBtnCellHtml($adjustT);

        // 构建结果按钮
        $resultT = [
            "commisionResultAmount" => $commisionResultAmount,
            "dno" => $dno,
            "platformCommision" => $platformCommision,
            "checkStatus" => $checkStatus,
        ];
        $resultCell = self::makeResultBtnCellHtml($resultT);

        if ($_type == "settle") {
            $tmp = array(
                "<input type='checkbox' name='groups' status='" . $checkStatus . "'  month='" . $month . "' dno='" . $dno . "' agentcode='" . $roleId . "'  agentname='" . $account . "'>",
                $month,
                $lv1,
                $lv2,
                $lv3,
                $layerName,
                $playerTag,
                "<a href=\"#DetailModal\" onclick=\"showDetail('" . $dno . "');\" data-toggle=\"modal\" class=\"btn mini green\"><i class=\"fa fa-building-o\"></i>" . $platformCommision . "</a></td>",
                "<a href=\"#CbDetailModal\" onclick=\"showCbDetail('" . $dno . "')\" data-toggle=\"modal\" class=\"btn mini green\"><i class=\"fa fa-building-o\"></i>" . $costAllocation . "</a>",
                $lastMonthLeftAMount,
                $adjustCell,
                $adjustmentNote,
                $commisionAmount,
                $resultCell,
                $nextMonthLeftAMount,
                $resultNote,
                $statusTag,
                $operCell,
            );
        } else {
            $tmp = array(
                $month,
                $lv1,
                $lv2,
                $lv3,
                $layerName,
                $playerTag,
                "<a href=\"#DetailModal\" onclick=\"showDetail('" . $dno . "');\" data-toggle=\"modal\" class=\"btn mini green\"><i class=\"fa fa-building-o\"></i>" . $platformCommision . "</a></td>",
                "<a href=\"#CbDetailModal\" onclick=\"showCbDetail('" . $dno . "')\" data-toggle=\"modal\" class=\"btn mini green\"><i class=\"fa fa-building-o\"></i>" . $costAllocation . "</a>",
                $lastMonthLeftAMount,
                $adjustCell,
                $adjustmentNote,
                $commisionAmount,
                $resultCell,
                $nextMonthLeftAMount,
                $resultNote,
                $statusTag,
            );
        };

        $gcData = self::makeGameCommissionHtml($_data);
        $gcHtml = $gcData[0];

        $ccHtml = self::makeChildCommissionHtml($_data, $gcData[1]);
        $caHtml = self::makeChildCostAlloation($_data);
        if (!isset($_SESSION["GameCommision"])) {
            $_SESSION["GameCommision"] = array();
        }

        $_SESSION["GameCommision"][$dno] = array("gc" => $gcHtml, "cc" => $ccHtml, "ca" => $caHtml);

        return $tmp;
    }

    /**
     * 构建佣金报表页面
     *
     * @param [type] $data 数据
     *
     * @return void
     */
    public static function makeGameCommissionHtml($data)
    {
        $crHtml = "";
        $gameStr = getArrayValue("gameStr", "", $data);
        $TotalWinLose = 0;
        $TotalCommision = 0;
        $TotalWater = 0;
        $TotalStake = 0;
        $lineChargeRate = sprintf("%.2f", getArrayValue("lineChargeRate", 0, $data) * 100);

        if (!empty($gameStr)) {
            $gameData = json_decode($gameStr, true);

            foreach ($gameData as $gpName => $gpData) {
                $winlose = 0 - getArrayValue("winLoseAmount", 0, $gpData);
                $commision = getArrayValue("pumpingCommisionAmount", 0, $gpData);
                $water = getArrayValue("pumpingWaterAmount", 0, $gpData);
                $stake = getArrayValue("validStakeAmount", 0, $gpData);
                $TotalWinLose += $winlose;
                $TotalCommision += $commision;
                $TotalWater += $water;
                $TotalStake += $stake;

                $PCR = sprintf("%.2f", getArrayValue("pumpingCommisionRate", 0, $gpData) * 100);
                $PWR = sprintf("%.2f", getArrayValue("pumpingWaterRate", 0, $gpData) * 100);
                $crHtml .= "<tr><td>" . $gpName . "</td>";
                $crHtml .= "<td>" . $winlose . "</td>";
                $crHtml .= "<td>" . $PCR . "%</td>";
                $crHtml .= "<td>" . $commision . "</td>";
                $crHtml .= "<td>" . $stake . "</td>";
                $crHtml .= "<td>" . $PWR . "%</td>";
                $crHtml .= "<td>" . $water . "</td></tr>";
            }
        }
        $crHtml .= "<tr><td>小计</td>";
        $crHtml .= "<td>" . $TotalWinLose . "</td><td></td>";
        $crHtml .= "<td>" . $TotalCommision . "</td>";
        $crHtml .= "<td>" . $TotalStake . "</td><td></td>";
        $crHtml .= "<td>" . $TotalWater . "</td></tr>";

        $lineCommision = (1 - $lineChargeRate / 100) * $TotalCommision;
        $crHtml .= "<tr><td>平台合计</td>";
        $crHtml .= "<td>" . ($TotalCommision +  $TotalWater) . "</td>";
        $crHtml .= "<td>线路费</td>";
        $crHtml .= "<td>" . $lineChargeRate . "%</td>";
        $crHtml .= "<td>代理线佣金</td>";
        $crHtml .= "<td colspan='2'>" . $lineCommision . "</td></tr>";
        return array($crHtml, $lineCommision);
    }

    /**
     * 构建数据
     *
     * @param [type] $data           数据
     * @param [type] $TotalCommision 汇总
     *
     * @return void
     */
    public function makeChildCommissionHtml($data, $TotalCommision)
    {
        $ccHtml = "";
        $childStr = getArrayValue("childStr", "", $data);
        $lineChargeRate = sprintf("%.2f", getArrayValue("lineChargeRate", 0, $data) * 100);
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
     * 生成成本分摊界面的Html
     *
     * @param [type] $data 数据
     *
     * @return void
     */
    public function makeChildCostAlloation($data)
    {
        $caHtml = "";
        $childStr = getArrayValue("childStr", "", $data);

        $depositBonusAllocationAmount = (float) getArrayValue("depositBonusAllocationAmount", 0, $data);
        $depositBonusAmount = (float) getArrayValue("depositBonusAmount", 0, $data);
        $depositBonusRate = sprintf("%.2f", getArrayValue("depositBonusRate", 0, $data) * 100);

        $bonusAllocationAmount = (float) getArrayValue("bonusAllocationAmount", 0, $data);
        $bonusAmount = (float) getArrayValue("bonusAmount", 0, $data);
        $bonusRate = sprintf("%.2f", getArrayValue("bonusRate", 0, $data) * 100);

        $rebateAllocationAmount = (float) getArrayValue("rebateAllocationAmount", 0, $data);
        $rebateAmount = (float) getArrayValue("rebateAmount", 0, $data);
        $rebateRate = sprintf("%.2f", getArrayValue("rebateRate", 0, $data) * 100);
        // AgentAllocationData

        $caHtml = "<tr><th>" . $depositBonusAllocationAmount . "</th>";
        $caHtml .= "<th>" . $depositBonusRate . "%</th>";
        $caHtml .= "<th>" . $depositBonusAmount . "</th>";

        $caHtml .= "<th>" . $bonusAllocationAmount . "</th>";
        $caHtml .= "<th>" . $bonusRate . "%</th>";
        $caHtml .= "<th>" . $bonusAmount . "</th>";

        $caHtml .= "<th>" . $rebateAllocationAmount . "</th>";
        $caHtml .= "<th>" . $rebateRate . "%</th>";
        $caHtml .= "<th>" . $rebateAmount . "</th></tr>";

        $lineChargeRate = sprintf("%.2f", getArrayValue("lineChargeRate", 0, $data) * 100);

        $ccHtml = "";
        $totalDeposit = 0;
        $totalBonus = 0;
        $totalRebate = 0;
        if (!empty($childStr)) {
            $childData = json_decode($childStr, true);
            foreach ($childData as $cData) {
                $roleId = getArrayValue("roleId", "", $cData);

                $_depositBonusAllocationAmount = (float) getArrayValue("depositBonusAllocationAmount", 0, $cData);
                $_depositBonusAmount = (float) getArrayValue("depositBonusAmount", 0, $cData);
                $_depositBonusRate = sprintf("%.2f", getArrayValue("depositBonusRate", 0, $cData) * 100);

                $_bonusAllocationAmount = (float) getArrayValue("bonusAllocationAmount", 0, $cData);
                $_bonusAmount = (float) getArrayValue("bonusAmount", 0, $cData);
                $_bonusRate = sprintf("%.2f", getArrayValue("bonusRate", 0, $cData) * 100);

                $_rebateAllocationAmount = (float) getArrayValue("rebateAllocationAmount", 0, $cData);
                $_rebateAmount = (float) getArrayValue("rebateAmount", 0, $cData);
                $_rabateRate = sprintf("%.2f", getArrayValue("rabateRate", 0, $cData) * 100);

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
        $ccHtml .= "<td>" . ($depositBonusAllocationAmount - $totalDeposit) . "</td>";
        $ccHtml .= "<td colspan=2>红利</td>";
        $ccHtml .= "<td>" . ($bonusAllocationAmount - $totalBonus) . "</td>";
        $ccHtml .= "<td colspan=2>返水</td>";
        $ccHtml .= "<td>" . ($rebateAllocationAmount - $totalRebate) . "</td>";

        return array($caHtml, $ccHtml);
    }

    /**
     * 构建代理结算历史Html
     *
     * @param [type] $retData 数据
     *
     * @return void
     */
    public static function showSettleHistoryData($retData)
    {

        $rData = getArrayValue("data", array(), $retData);
        $aaData = array();
        $new_retData = array();
        foreach ($rData as $_data) {
            $pParentId = (int) getArrayValue("pParentId", 0, $_data);
            $parentId = (int) getArrayValue("parentId", 0, $_data);
            $roleId = (int) getArrayValue("roleId", 0, $_data);
            if ($pParentId !== 0) {
                // $lv3 = $accTag;
                $new_retData[$pParentId]["lv2"][$parentId]["lv3"][$roleId] = array("data" => $_data);
            } else if ($parentId == 0) {
                if (!isset($new_retData[$roleId])) {
                    $new_retData[$roleId] = array("data" => array(), "lv2" => array());
                }
                $new_retData[$roleId]["data"] = $_data;
            } else {
                if (!isset($new_retData[$parentId]["lv2"][$roleId])) {
                    $new_retData[$parentId]["lv2"][$roleId] = array("data" => array(), "lv3" => array());
                }
                $new_retData[$parentId]["lv2"][$roleId]["data"] = $_data;
            }
        }
        foreach ($new_retData as $lv1 => $_ret) {
            if (isset($_ret["data"])) {
                array_push($aaData, self::makeOneAgentCurPeriodData($_ret["data"], "history"));
            }
            if (isset($_ret["lv2"]) && count($_ret["lv2"]) > 0) {
                foreach ($_ret["lv2"] as $lv2 => $_ret2) {
                    if (isset($_ret2["data"])) {
                        array_push($aaData, self::makeOneAgentCurPeriodData($_ret2["data"], "history"));
                    }
                    if (isset($_ret2["lv3"]) && count($_ret2["lv3"]) > 0) {
                        foreach ($_ret2["lv3"] as $lv3 => $_ret3) {
                            if (isset($_ret3["data"])) {
                                array_push($aaData, self::makeOneAgentCurPeriodData($_ret3["data"], "history"));
                            }
                        }
                    }
                }
            }
        }
        return $aaData;
    }

    public static function showwtdVeryfyDataHtml($retData)
    {
        $rData = getArrayValue("data", array(), $retData);
        $aaData = array();
        foreach ($rData as $_data) {
            $amount = (float) getArrayValue("amount", 0, $_data);
            $amountResult = (float) getArrayValue("amountResult", 0, $_data);
            $balance = (float) getArrayValue("balance", 0, $_data);

            $checkStatus = (int) getArrayValue("checkStatus", 0, $_data);
            $commisionAmount = (float) getArrayValue("commisionAmount", 0, $_data);
            $recordTime = getArrayValue("recordTime", "", $_data);

            $opType = getArrayValue("opType", 0, $_data);
            $recordNum = getArrayValue("recordNum", 0, $_data);
            $dno = getArrayValue("dno", 0, $_data);
            $roleId = getArrayValue("roleId", 0, $_data);
            $account = getArrayValue("account", "无数据", $_data);
            $name = getArrayValue("name", "无数据", $_data);

            $withdrawalAmount = (float) getArrayValue("withdrawalAmount", 0, $_data);
            $withdrawal_fee = (float) getArrayValue("withdrawal_fee", 0, $_data);
            $withdrawal_feeType = (int) getArrayValue("withdrawal_feeType", 0, $_data);
            $withdrawal_isRemit = (int) getArrayValue("withdrawal_isRemit", 0, $_data);
            $withdrawal_remitBankCardId = (int) getArrayValue("withdrawal_remitBankCardId", 0, $_data);

            $layerName = getArrayValue("layerName", "无", $_data);

            $pParentId = (int) getArrayValue("pParentId", 1, $_data);
            $parentId = (int) getArrayValue("parentId", 0, $_data);
            $parentAccount = getArrayValue("parentAccount", "", $_data);
            $belongToTags = parseBelongTo($pParentId, $parentId, $parentAccount);

            $cardBankType = getArrayValue("cardBankType", 0, $_data);
            $cardName = getArrayValue("cardName", "", $_data);
            $cardNo = getArrayValue("cardNo", "", $_data);
            $cardRegisterBank = getArrayValue("cardRegisterBank", "", $_data);

            $bankinfo = Config::bankTypes[$cardBankType];
            $showBankInfo = $bankinfo["name"] . " " . $cardName . "<br/>" . $cardNo;

            // 构建代理账号按钮
            $accountT = [
                "agentId" => $roleId,
                "agentAccount" => $account,
                "type" => 2,
            ];
            $accountCell = self::makeAgentAccountHtml($accountT);

            // 构建备注按钮
            $remarkT = [
                "dno" => $dno,
                "note" => $_data["note"],

            ];

            $remarkCell = self::makeWtdRemarkHtml($remarkT);

            $operT = [
                "dno" => $dno,
                "amount" => $amount,
                "feeType" => $withdrawal_feeType,
                "fee" => $withdrawal_fee,
            ];

            $operCell = self::makeAgentWtdOperHtml($operT);
            $tmp = array(
                $dno,
                $accountCell,
                $layerName,
                $belongToTags[0],
                $belongToTags[1],
                $name,
                $amount,
                $withdrawal_fee,
                $amountResult,
                parseDate($recordTime, 4),
                $showBankInfo,
                $remarkCell,
                $operCell,
            );
            array_push($aaData, $tmp);
        }
        return $aaData;
    }

    /**
     * 构建代理审核历史界面数据请求
     *
     * @param [type] $retData 数据
     *
     * @return void
     */
    public static function showagentWDHistoryData($retData)
    {
        $aaData = array();
        foreach ($retData as $_data) {
            $amount = (float) getArrayValue("amount", 0, $_data);
            $amountResult = (float) getArrayValue("amountResult", 0, $_data);
            $balance = (float) getArrayValue("balance", 0, $_data);

            $checkStatus = (int) getArrayValue("checkStatus", 0, $_data);
            $commisionAmount = (float) getArrayValue("commisionAmount", 0, $_data);
            $recordTime = getArrayValue("recordTime", "", $_data);
            $dealTime = getArrayValue("dealTime", "", $_data);

            $opType = getArrayValue("opType", 0, $_data);
            $recordNum = getArrayValue("recordNum", 0, $_data);
            $dno = getArrayValue("dno", 0, $_data);
            $roleId = getArrayValue("roleId", 0, $_data);
            $account = getArrayValue("account", "无数据", $_data);
            $name = getArrayValue("name", "无数据", $_data);

            $withdrawalAmount = (float) getArrayValue("withdrawalAmount", 0, $_data);
            $withdrawal_fee = (float) getArrayValue("withdrawal_fee", 0, $_data);
            $withdrawal_feeType = (int) getArrayValue("withdrawal_feeType", 0, $_data);
            $withdrawal_isRemit = (int) getArrayValue("withdrawal_isRemit", 0, $_data);
            $withdrawal_remitBankCardId = (int) getArrayValue("withdrawal_remitBankCardId", 0, $_data);

            $layerName = getArrayValue("layerName", "无", $_data);

            $pParentId = (int) getArrayValue("pParentId", 1, $_data);
            $parentId = (int) getArrayValue("parentId", 0, $_data);
            $parentAccount = getArrayValue("parentAccount", "", $_data);
            $note = getArrayValue("note", "", $_data);

            $belongToTags = parseBelongTo($pParentId, $parentId, $parentAccount);
            
            $statusTag = Config::agStatusTransMap[$checkStatus];
            // 构建银行卡信息
            $cardBankType = getArrayValue("cardBankType", 0, $_data);
            $cardName = getArrayValue("cardName", "", $_data);
            $cardNo = getArrayValue("cardNo", "", $_data);
            $cardRegisterBank = getArrayValue("cardRegisterBank", "", $_data);
            $bankinfo = Config::bankTypes[$cardBankType];
            $showBankInfo = $bankinfo["name"] . " " . $cardName . "<br/>" . $cardNo;


            // 构建代理账号按钮
            $accountT = [
                "agentId" => $roleId,
                "agentAccount" => $account,
                "type" => 2,
            ];
            $accountCell = self::makeAgentAccountHtml($accountT);

            // 构建银行卡按钮
            $bankT = [
                "checkStatus" => $checkStatus,
                "cardId" => $cardNo,
                "dno" => $dno,
            ];
            $bankCell = self::makeAgWtdBankOperHtml($bankT);

            
            
            $tmp = array(
                // $dno,
                $accountCell,
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
                $bankCell,
            );
            array_push($aaData, $tmp);
        }
        return $aaData;
    }
}
