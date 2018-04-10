<?php
namespace App\ViewHelper;

use App\Config\Config;
use App\Controllers\Def;
use App\Core\View;


class SettingViewHelper extends BaseViewHelper
{
    /**
     * 构建代理结算抽佣
     *
     * @return void
     */
    public static function makeAgentBrokerageHtml()
    {
        $factory = View::getView();
        return $factory->make('Setting.agentBrokerage.content', [])
            ->render();
    }

    /**
     * 构建抽佣设置界面
     *
     * @param [type] $idx  序号
     * @param [type] $game 名字
     *
     * @return void
     */
    public function addBrokerageTdHtml($idx, $game)
    {
        $factory = View::getView();
        return $factory->make('Setting.addBrokerage.content', [
            "id" => $idx,
            "game" => $game
        ])->render();
    }

    /**
     * 生成代理数据
     *
     * @param [type] $retData 数据
     *
     * @return void
     */
    public function makeAgentLevelHtml($retData)
    {

        $html = "";
        $_SESSION["BrokerageSetting"] = array();
        for ($x = 0; $x < count($retData); $x++) {
            $agentData = $retData[$x];

            $layerId = getArrayValue("id", "", $agentData);
            $name = getArrayValue("name", "", $agentData);
            $note = getArrayValue("note", "", $agentData);
            $group = getArrayValue("group", 0, $agentData);
            $order = getArrayValue("orderVal", "", $agentData);
            $time = getArrayValue("lastModifyTime", "", $agentData);
            $caSetting = getArrayValue("costAllocationSetting", "", $agentData);
            // {"bonusFixedRate":0.1,"validPlayerCountMin":10,"depositBonusRateType":1,"depositBonusFixedRate":0.3,"rebateRateType":2,"rebateFixedRate":0.2,"lineChargeFixedRate":0.3,"bonusRateType":1,"lineChargeRateType":1,"validPlayerStakeMin":1000,"lineChargeFloatRate":[{"rate":0.5,"amount":100000},{"rate":0.2,"amount":10000},{"rate":0.1,"amount":1000}]}
            // {"game":{"sport":{"pumpingWatarFixedRate":0.3,"pumpingWatarRateType":1,"pumpingCommisionRate":1,"pumpingCommisionFixedRate":0.5},"pk":{"pumpingCommisionRate":2,"pumpingWatarFloatRate":[{"rate":0.5,"amount":100000},{"rate":0.2,"amount":10000},{"rate":0.1,"amount":1000}]}},"pumpingCommisionFloatRate":[{"rate":0.5,"amount":100000},{"rate":0.2,"amount":10000},{"rate":0.1,"amount":1000}]}

            $caData = json_decode($caSetting, true);

            $depositType = getArrayValue("depositBonusRateType", 0, $caData);
            $depositRate = getArrayValue("depositBonusFixedRate", 0, $caData);

            $rebateType = getArrayValue("rebateRateType", 0, $caData);
            $rebateRate = getArrayValue("rebateFixedRate", 0, $caData);

            $bonusType = getArrayValue("bonusRateType", 0, $caData);
            $bonusRate = getArrayValue("bonusFixedRate", 0, $caData);

            $lineType = getArrayValue("lineChargeRateType", 0, $caData);
            $lineRate = getArrayValue("lineChargeFixedRate", 0, $caData);
            $lineFloatRate = getArrayValue("lineChargeFloatRate", array(), $caData);
            $lineFloatStr = makeFloatStr($lineFloatRate);

            $validStake = getArrayValue("validPlayerStakeMin", 0, $caData);
            $validCount = getArrayValue("validPlayerCountMin", 0, $caData);

            $commisionSetting = getArrayValue("commisionSetting", "", $agentData);
            $cData = json_decode($commisionSetting, true);
            $floatRate = getArrayValue("pumpingCommisionFloatRate", array(), $cData);
            $commonFloatStr = makeFloatStr($floatRate);

            $_SESSION["BrokerageSetting"][$layerId] = $cData;

            $note = getArrayValue("note", "", $agentData);
            $html .= "<tr>";
            $html .= "<td>" . ($x + 1) . "</td>";
            $html .= "<td  id='agentLayerCommon" . $layerId . "'
                linefloatStr='" . $lineFloatStr . "'
                floatStr='" . $commonFloatStr . "'>" . $name . "</td>";
            $html .= "<td>" . $group . "</td>";
            $html .= "<td>" . $order . "</td>";
            $html .= "<td>" . parseDate($time) . "</td>";
            $EditData = array("'" . $layerId . "'", "'" . $group . "'",
                "'" . $name . "'", "'" . $note . "'", "'" . $order . "'");
            $html .= self::makeEditHtml($EditData);
            $asData = array($layerId, $depositType, $depositRate,
                $rebateType, $rebateRate, $bonusType, $bonusRate,
                $lineType, $lineRate, $validStake, $validCount);
            $html .= self::makeAllocationSetingHtml($asData);
            $CsHtml = self::makeCommisionSetingHtml(array("'" . $name . "'", $layerId));
            $html .= $CsHtml . '</td></tr>';
        }
        return $html;
    }

    /**
     * 构建编辑按钮Html
     *
     * @param [type] $args 参数
     *
     * @return void
     */
    public function makeEditHtml($args)
    {
        $factory = View::getView();
        return $factory->make('Setting.editOper.content', [
            "args" => $args
        ])->render();
    }

    /**
     * 构建抽佣抽水设置按钮Html
     *
     * @param [type] $args 参数
     *
     * @return void
     */
    public function makeCommisionSetingHtml($args)
    {
        $factory = View::getView();
        return $factory->make('Setting.commisionSetting.content', [
            "args" => $args
        ])->render();
    }

    /**
     * 构建结算分摊设置按钮Html
     *
     * @param [type] $args 参数
     *
     * @return void
     */
    public function makeAllocationSetingHtml($args)
    {
        $factory = View::getView();
        return $factory->make('Setting.allocationSetting.content', [
            "args" => $args
        ])->render();
    }
}
