<?php
namespace App\Controllers;

use App\Config\Config;
use App\Config\IBCConfig;
use App\Config\NBConfig;
use App\Core\View;
use App\Libs\HttpRequest as http;

class ActivitiesAPIController extends BaseController
{
    public static function joinActivity($request)
    {
        $loginSession = getSessionValue("PlayerSessionID", "");
        if (empty($loginSession)) {
            return [false, "请先登录"];
        }

        $actId = $request["actId"];
        if (!$actId) {
            return [false, "参数错误"];
        }
        return http::playerHttpCaller("ApplyActivity", [$loginSession, $actId]);
    }

    public static function activityVerifyAjax($request)
    {

    }
}