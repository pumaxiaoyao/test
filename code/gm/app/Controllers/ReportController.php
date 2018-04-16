<?php
namespace App\Controllers;

use App\Config\Config;
use App\Controllers\Def;
use App\Controllers\ReportAPIController as ReportAPI;
use App\Core\View;
use App\ViewHelper\ReportViewHelper as ViewHelper;
use App\Libs\HttpRequest as http;

class ReportController extends BaseController
{

    public static function companydaily($request)
    {
        $factory = View::getView();

        if (isset($request["start"]) && !$request["start"]) {
            $st = strtotime($request["start"]);
        } else {
            $st = time() - 24 * 60*60*30;
        }

        if (isset($request["end"]) && !$request["end"]) {
            $et = strtotime($request["end"]);
        } else {
            $et = time();
        }

        $ret = http::gmHttpCaller("GetCompanyPlayerStatisticsDayData", [date("Ymd", $st), date("Ymd", $et)]);
        $pageArgs = [
            "sysMessageList" => [],
            "startDate" => date("Y-m-d", $st),
            "endDate" => date("Y-m-d", $et),
            "statics" => $ret
        ];
        return $factory->make('Report.companydaily.layout', $pageArgs)
            ->render();
    }
    
    public static function agentdaily($request)
    {
        $factory = View::getView();

        if (isset($request["start"]) && !$request["start"]) {
            $st = strtotime($request["start"]);
        } else {
            $st = time() - 24 * 60*60*30;
        }

        if (isset($request["end"]) && !$request["end"]) {
            $et = strtotime($request["end"]);
        } else {
            $et = time();
        }
        $agent = getArrayValue("agentName", "", $request);
        $ret = http::gmHttpCaller("GetAgentStatisticsDayData", [$agent, date("Ymd", $st), date("Ymd", $et)]);
        $pageArgs = [
            "sysMessageList" => [],
            "startDate" => date("Y-m-d", $st),
            "endDate" => date("Y-m-d", $et),
            "statics" => $ret
        ];
        return $factory->make('Report.agentdaily.layout', $pageArgs)
            ->render();
    }

    public static function platform($request)
    {
        $factory = View::getView();

        if (isset($request["start"]) && !$request["start"]) {
            $st = strtotime($request["start"]);
        } else {
            $st = time() - 24 * 60*60*30;
        }

        if (isset($request["end"]) && !$request["end"]) {
            $et = strtotime($request["end"]);
        } else {
            $et = time();
        }

        $ret = http::gmHttpCaller("GetGameStatisticsDayData", [date("Ymd", $st), date("Ymd", $et)]);
        $pageArgs = [
            "sysMessageList" => [],
            "startDate" => date("Y-m-d", $st),
            "endDate" => date("Y-m-d", $et),
            "statics" => $ret
        ];
        return $factory->make('Report.platform.layout', $pageArgs)
            ->render();
    }

    public static function playeractivity($request)
    {
        $factory = View::getView();

        if (isset($request["start"]) && !$request["start"]) {
            $st = strtotime($request["start"]);
        } else {
            $st = time() - 24 * 60*60*30;
        }

        if (isset($request["end"]) && !$request["end"]) {
            $et = strtotime($request["end"]);
        } else {
            $et = time();
        }

        $ret = http::gmHttpCaller("GetPlayerStatisticsDayData", [date("Ymd", $st), date("Ymd", $et)]);
        $pageArgs = [
            "sysMessageList" => [],
            "startDate" => date("Y-m-d", $st),
            "endDate" => date("Y-m-d", $et),
            "statics" => $ret
        ];
        return $factory->make('Report.playeractivity.layout', $pageArgs)
            ->render();
    }
    
}