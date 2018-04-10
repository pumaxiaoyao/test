<?php
namespace App\Controllers;

use App\Config\Config;
use App\Controllers\Def;
use App\Controllers\FlowAPIController as FlowAPI;
use App\Core\View;

class FlowController extends BaseController
{
    public static function wagered($request)
    {
        $factory = View::getView();
        $pageArgs = [
            "sysMessageList" => [],
            "startTime" => parseDate(time() - 24 * 60*60*30),
            "endTime" => parseDate(time()),
            "platforms" => Config::platform
        ];
        return $factory->make('Flow.wagered.layout', $pageArgs)
            ->render();
    }

    public static function history($request)
    {
        $factory = View::getView();
        $pageArgs = [
            "sysMessageList" => [],
            "startTime" => parseDate(time() - 24 * 60*60*30),
            "endTime" => parseDate(time()),
            "platforms" => Config::platform
        ];
        return $factory->make('Flow.history.layout', $pageArgs)
            ->render();
    }
}