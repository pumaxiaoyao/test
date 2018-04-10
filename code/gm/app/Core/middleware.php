<?php

namespace App\Core;

use App\Config\Config;
use App\Core\Router as Route;
/**
 * 伪·中间件 机制
 * 仅仅用于路由调用前，处理下分派和过滤
 * 如要构建稳定的框架机制，需要给多时间重构
 */

function LoginSessionValidator()
{
    global $reqUriRoot, $method, $reqUriAction;
    $sysConfig = Config::validatorConfig;
    $reqConfig = array_key_exists($reqUriRoot, $sysConfig)?$sysConfig[$reqUriRoot]:$sysConfig["default"];
    $reqAuthCond = $reqConfig[$method];

    if (in_array($reqUriAction, $reqAuthCond)) {
        return true;
    } else {
        $skeys = $reqConfig["skey"];
        if (!getSessionValue($skeys[0], "")) {
            return false;
        } else {
            return true;
        }
    }
}

$uri = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$method = $_SERVER['REQUEST_METHOD'];

$reqUriRoot = getArrayValue(1, false, $uri);
$reqUriAction = getArrayValue(2, false, $uri);

if ($reqUriRoot && $reqUriAction) {
    if (!LoginSessionValidator()) {
        // Todo：middleware session control
        // LoginReset($reqUriRoot);
    }
}

Route::dispatch();
