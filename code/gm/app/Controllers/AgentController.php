<?php
namespace App\Controllers;

use App\Config\Config;
use App\Controllers\Def;
use App\Controllers\AgentAPIController as AgentAPI;
use App\Controllers\SettingAPIController as SettingAPI;
use App\Core\View;
use Gregwar\Captcha\CaptchaBuilder;

class AgentController extends BaseController
{
    public static function verify($request)
    {
        // $layers = AgentAPI::getAgentLayer($request);
        $factory = View::getView();
        $pageArgs = [
            "sysMessageList" => [],
            "startTime" => parseDate(time() - 24 * 60*60*30),
            "endTime" => parseDate(time()),
            // "layers" => $layers
        ];
        return $factory->make('Agent.verify.layout', $pageArgs)
            ->render();
    }

    public static function detailBox($request)
    {
        $factory = View::getView();
        $t = AgentAPI::getAgentInfo($request);
        $pageArgs = [
            "sysMessageList" => [],
            "startTime" => parseDate(time() - 24 * 60*60*30),
            "endTime" => parseDate(time()),
        ];
        return $factory->make('Agent.agentDetail.layout', array_merge($pageArgs, $t))
            ->render();
    }

    public static function aglist($request)
    {
        $factory = View::getView();
        $pageArgs = [
            "sysMessageList" => []
        ];
        return $factory->make('Agent.agentList.layout', $pageArgs)
            ->render();
    }

    public static function getLayerList($request)
    {
        $retData = SettingAPI::getAgentLayer($request);
        $ret = array();
        foreach ($retData as $layer) {
            $cData = getArrayValue("commisionSetting", "", $layer);
            $csJson = json_decode($cData, true);
            $caData = getArrayValue("costAllocationSetting", "", $layer);
            $casJson = json_decode($caData, true);
            
            $dt = (int)getArrayValue("depositBonusRateType", 0, $casJson);
            $rt = (int)getArrayValue("rebateRateType", 0, $casJson);
            $bt = (int)getArrayValue("bonusRateType", 0, $casJson);

            if ($dt  != 0 && $rt != 0 && $bt != 0) {
                $caTag = "<font color='green'>是</font>";
            } else {
                $caTag = "<font color='red'>否</font>";
            }

            $cTag = "<font color='red'>否</font>";
            $wTag = "<font color='red'>否</font>";

            foreach (getArrayValue("game", array(), $csJson) as $game=>$gData) {
                $commisionType = (int)getArrayValue("pumpingCommisionRateType", 0, $gData);
                $waterType = (int)getArrayValue("pumpingWaterRateType", 0, $gData);

                if ($commisionType == 2) {
                    $cTag = "<font color='green'>是</font>";
                }
                if ($waterType == 2) {
                    $wTag = "<font color='green'>是</font>";
                }

                if ($commisionType == 1 && (float)getArrayValue("pumpingCommisionFixedRate", 0, $gData) > 0) {
                    $cTag = "<font color='green'>是</font>";
                }

                if ($waterType == 1 && (float)getArrayValue("pumpingWaterFixedRate", 0, $gData) > 0) {
                    $wTag = "<font color='green'>是</font>";
                }

            }
            $tmp = array(
                "layerid"=>getArrayValue("id", 0, $layer),
                "name"=>getArrayValue("name", "", $layer),
                "note"=>getArrayValue("note", "", $layer),
                "isAllocation"=>$caTag,
                "isCommision"=>$cTag,
                "isWater"=>$wTag
            );
            $ret[] = $tmp;
        }

        
        return json_encode(["data"=>$ret]);
    }

    public static function register($request)
    {
        $factory = View::getView();
        $pageArgs = [
            "sysMessageList" => []
        ];
        return $factory->make('Agent.register.layout', $pageArgs)
            ->render();
    }

    public static function verifyHistory($request)
    {
        $factory = View::getView();
        $pageArgs = [
            "sysMessageList" => []
        ];
        return $factory->make('Agent.verifyHistory.layout', $pageArgs)
            ->render();
    }

    public static function domain($request)
    {
        $factory = View::getView();
        $pageArgs = [
            "sysMessageList" => []
        ];
        return $factory->make('Agent.domain.layout', $pageArgs)
            ->render();
    }

    public static function listAjaxS($request)
    {
        $ret = AgentAPI::searchAgentX($request);
        $rets = [];
        foreach (getArrayValue("data", [], $ret) as $_ret) {
            $rets[] = [
                "id" => $_ret["roleId"],
                "name" => $_ret["name"],
                "code" => $_ret["account"],
            ];
        }
        return json_encode($rets);
    }
}
    
