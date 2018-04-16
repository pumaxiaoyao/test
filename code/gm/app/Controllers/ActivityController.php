<?php
namespace App\Controllers;

use App\Config\Config;
use App\Libs\HttpRequest as http;
use App\Controllers\Def;
use App\Controllers\ActivityAPIController as ActivityAPI;
use App\Controllers\SettingAPIController as SettingAPI;
use App\Core\View;

class ActivityController extends BaseController
{
    public static function activities($request)
    {
        $factory = View::getView();
        $pageArgs = [
            "sysMessageList" => [],
        ];
        return $factory->make('Activity.activities.layout', $pageArgs)
            ->render();
    }

    public static function activityVerify($request)
    {
        $factory = View::getView();
        $pageArgs = [
            "sysMessageList" => [],
            "actTypes" => http::gmHttpCaller("GetActivityType", []),
            "platforms" => Config::platform
        ];
        return $factory->make('Activity.activityVerify.layout', $pageArgs)
            ->render();
    }

    public static function activityHistory($request)
    {
        $factory = View::getView();
        $pageArgs = [
            "sysMessageList" => [],
        ];
        return $factory->make('Activity.activityHistory.layout', $pageArgs)
            ->render();
    }

    public static function activityFund($request)
    {
        $factory = View::getView();
        $pageArgs = [
            "sysMessageList" => [],
        ];
        return $factory->make('Activity.activityFund.layout', $pageArgs)
            ->render();
    }

    /**
     * 添加或新增活动
     */
    public static function editActivity($request)
    {
        $actId = getArrayValue("actid", false, $request);

        if ($actId) {
            $act = getArrayValue(0, [], http::gmHttpCaller('GetActivities', [$actId]));
        } else {
            $act = [];
        }

        $factory = View::getView();
        $groups = SettingAPI::getGroupConfig(false);
        $pageArgs = [
            "sysMessageList" => [],
            "todayDate" => date("Y-m-d", time() + 8 * 3600),
            "groups" => $groups["t1"], // 只用生效玩家组
            "actTypes" => http::gmHttpCaller("GetActivityType", []),
            "act" => $act
        ];
        return $factory->make('Activity.editActivity.layout', $pageArgs)
            ->render();
    }

    public static function actCateList($request)
    {
        $factory = View::getView();
        $pageArgs = [
            "sysMessageList" => [],
            "todayDate" => date("Y-m-d", time() + 8 * 3600),
            "actTypes" => http::gmHttpCaller("GetActivityType", [])
        ];
        return $factory->make('Activity.actCateList.layout', $pageArgs)
            ->render();
    }


    public static function gPDlist($request)
    {
        return json_encode(["c"=>0,"m"=>[]]);
    }
}