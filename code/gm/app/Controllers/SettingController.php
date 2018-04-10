<?php
namespace App\Controllers;

use App\Config\Config;
use App\Controllers\Def;
use App\Controllers\SettingAPIController as SettingAPI;
use App\Core\View;
use App\ViewHelper\SettingViewHelper as ViewHelper;

class SettingController extends BaseController
{
    public static function getPlayerLevels($request)
    {
        return json_encode(SettingAPI::getPlayerLevels($request));
    }

    public static function playerLevel($request)
    {
        
        $factory = View::getView();
        $pageArgs = [
            "sysMessageList" => []
        ];
        return $factory->make('Setting.playerLevel.layout', $pageArgs)
            ->render();
    }

    /**
     * 构建界面中所需的玩家组下拉选项菜单
     *
     * @return void
     */
    function parseGroupHtml()
    {
        $groupdata = SettingAPI::getGroupConfig();
        $validGroups = getArrayValue("t1", array(), $groupdata);
        $factory = View::getView();
        $pageArgs = [
            "validGroups" => $validGroups
        ];
        return $factory->make('Setting.playerLevel.parseGroup', $pageArgs)
            ->render();

    }

    public static function agentLevel($request)
    {
        $factory = View::getView();

        $agentLayers = SettingAPI::getAgentLayer($request);

        $pageArgs = [
            "sysMessageList" => [],
            "AGENTLEVEL" => ViewHelper::makeAgentLevelHtml($agentLayers),
            "GROUPDATA" => self::parseGroupHtml(),
            "AGENTBROKERAGESETTING" => "",
            "AgentBrokerageModal" => ""
        ];
        return $factory->make('Setting.agentLevel.layout', $pageArgs)
            ->render();
    }


    /**
     * 获取抽佣抽水界面
     *
     * @param [type] $request URI参数
     *
     * @return void
     */
    public static function getbrokerage($request)
    {
        $layerId = getArrayValue("layerid", "", $request);
        $html = "";
        $BrokerageSetting = getSessionValue("BrokerageSetting", array());
        $bsData = getArrayValue($layerId, array(), $BrokerageSetting);
        $gameData = getArrayValue("game", array(), $bsData);
        if (count($gameData) == 0) {
            $gameData = array("sport" => array(), "pk" => array(), "xjssc" => array());
        }
        $comFloatData = getArrayValue("pumpingCommisionFloatRate", array(), $bsData);
        $ret = array(
            "data" => array(),
            "commisionFloat" => $comFloatData,
        );
        if (count($gameData) > 0) {
            // {"game":{"sport":{"pumpingWatarFixedRate":0.3,"pumpingWatarRateType":1,"pumpingCommisionRate":1,"pumpingCommisionFixedRate":0.5},"pk":{"pumpingCommisionRate":2,"pumpingWatarFloatRate":[{"rate":0.5,"amount":100000},{"rate":0.2,"amount":10000},{"rate":0.1,"amount":1000}]}},"pumpingCommisionFloatRate":[{"rate":0.5,"amount":100000},{"rate":0.2,"amount":10000},{"rate":0.1,"amount":1000}]}
            $idx = 0;
            foreach ($gameData as $game => $_data) {
                $idx++;
                $ret["data"][$game] = array("html" => viewHelper::addBrokerageTdHtml($idx, $game), "data" => $_data);
            }
        }
        return json_encode($ret);
    }

    
}