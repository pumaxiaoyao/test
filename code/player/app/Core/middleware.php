<?php

namespace App\Core;

use App\Config\Config;
use App\Core\Router as Route;
/**
 * 伪·中间件 机制
 * 仅仅用于路由调用前，处理下分派和过滤
 * 如要构建稳定的框架机制，需要给多时间重构
 */

function SessionValidator()
{
    global $reqClass, $reqAction, $uriConfig;
    $reqAuthCond = $uriConfig["ignore"];

    if (in_array($reqAction, $reqAuthCond)) {
        // 可忽略的请求直接略过
        return true;
    } else {
        // 检查sessionKey是否合法
        if (!getSessionValue($uriConfig["skey"], "")) {
            return false;
        } else {
            return true;
        }

    }
}

$uri = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

$reqClass = \getArrayValue(1, false, $uri);
$reqAction = \getArrayValue(2, false, $uri);
// 从系统配置中获取配置，无配置则默认用Player配置
$validKey = ($reqClass == "agent") ? $reqClass : "player";

$uriConfig = Config::validatorConfig[$validKey];

if ($reqClass && $reqAction) {
    if (!SessionValidator($uriConfig["skey"])) {
        LoginReset($validKey, false);
        echo json_encode(["data"=>[false, "session invalid"]]);
    } else {
        Route::dispatch();
    }
} else {
    Route::dispatch();
}
