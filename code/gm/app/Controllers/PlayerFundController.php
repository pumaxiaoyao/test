<?php
namespace App\Controllers;

use App\Config\Config;
use App\Controllers\Def;
use App\Controllers\PlayerFundAPIController as PlayerFundAPI;
use App\Core\View;

class PlayerFundController extends BaseController
{
    public static function flowLimitOne($request)
    {
        return json_encode(PlayerFundAPI::checkWater($request));   
    }


    public static function dptVerify($request)
    {
        $factory = View::getView();
        $pageArgs = [
            "sysMessageList" => [],
            "startTime" => parseDate(time() - 24 * 60*60*30),
            "endTime" => parseDate(time()),
            "platforms" => Config::platform
        ];
        return $factory->make('PlayerFund.dptVerify.layout', $pageArgs)
            ->render();
    }

    public static function dptHistory($request)
    {
        $factory = View::getView();
        $pageArgs = [
            "sysMessageList" => [],
            "startTime" => parseDate(time() - 24 * 60*60*30),
            "endTime" => parseDate(time()),
            "platforms" => Config::platform
        ];
        return $factory->make('PlayerFund.dptHistory.layout', $pageArgs)
            ->render();
    }

    public static function dptCorrection($request)
    {
        $factory = View::getView();
        $pageArgs = [
            "sysMessageList" => [],
            "startTime" => parseDate(time() - 24 * 60*60*30),
            "endTime" => parseDate(time()),
            "platforms" => Config::platform
        ];
        return $factory->make('PlayerFund.dptCorrection.layout', $pageArgs)
            ->render();
    }

    public static function wtdVerify($request)
    {
        $factory = View::getView();
        $pageArgs = [
            "sysMessageList" => [],
            "startTime" => parseDate(time() - 24 * 60*60*30),
            "endTime" => parseDate(time()),
            "platforms" => Config::platform
        ];
        return $factory->make('PlayerFund.wtdVerify.layout', $pageArgs)
            ->render();
    }


    public static function receive($request)
    {
        // 预留接口
    }

    public static function wtdHistory($request)
    {
        $factory = View::getView();
        $pageArgs = [
            "sysMessageList" => [],
            "startTime" => parseDate(time() - 24 * 60*60*30),
            "endTime" => parseDate(time()),
            "platforms" => Config::platform
        ];
        return $factory->make('PlayerFund.wtdHistory.layout', $pageArgs)
            ->render();
    }

    public static function wtdInfo($request)
    {
        return json_encode([
            "bankname"=>"天地银行",
            "realname"=>"孙悟空",
            "cardnum"=>"1234123412341234",
            "actual"=>50,
            "dealremark"=>"测试",
            "wfee"=>0
        ]);
    }

    public static function flowLimit($requst)
    {
        $factory = View::getView();
        $pageArgs = [
            "sysMessageList" => []
        ];
        return $factory->make('PlayerFund.flowLimit.layout', $pageArgs)
            ->render();
    }

    public static function transferList($request)
    {
        $factory = View::getView();
        $pageArgs = [
            "sysMessageList" => [],
            "startTime" => parseDate(time() - 24 * 60*60*30),
            "endTime" => parseDate(time()),
        ];
        return $factory->make('PlayerFund.transferList.layout', $pageArgs)
            ->render();
    }
}