<?php
namespace App\Controllers;

use App\Libs\DES;
use App\Libs\HttpRequest as http;

class GameAPIController extends BaseController
{

    /**
     * 登录沙巴
     */
    public static function GetPlatformLogin($request)
    {
        $loginSession = \getSessionValue("PlayerSessionID", false);
        if ($loginSession) {
            $retJson = http::playerHttpCaller("LoginPlatform", [$_SESSION["PlayerSessionID"], "IBC"]);
            if ($retJson[0]) {
                return [true, "url"=>$retJson[2]];
            } else {
                return [false, "url"=>$retJson[2]];
            }
        } else {
            return [false, "url"=>$retJson[2]];
        }

    }

    /**
     * 登录乐博
     */
    public static function GetLBCPLogin($request)
    {
        $retJson = http::playerHttpCaller("LoginPlatform", [$_SESSION["PlayerSessionID"], "NB"]);
        if ($retJson[0]) {
            return [true, $retJson[2]];
        } else {
            return [false, "login failed"];
        }
    }

    /**
     * 登录IG-时时彩
     */
    public static function LoginIGLottery($request)
    {
        $retJson = http::playerHttpCaller("LoginPlatform", [$_SESSION["PlayerSessionID"], "IG", "LOTTERY"]);
        if ($retJson[0]) {
            return [true, $retJson[2]];
        } else {
            return [false, "login failed"];
        }
    }

    /**
     * 登录IG-香港彩
     */
    public static function LoginIGLotto($request)
    {
        $retJson = http::playerHttpCaller("LoginPlatform", [$_SESSION["PlayerSessionID"], "IG", "LOTTO"]);
        if ($retJson[0]) {
            return [true, $retJson[2]];
        } else {
            return [false, "login failed"];
        }

    }

    public static function LoginAgGame($request)
    {
        $gameId = $request["gameId"];
        $retJson = http::playerHttpCaller("LoginPlatform", [$_SESSION["PlayerSessionID"], "AG", $gameId]);
        return $retJson;

    }

    public static function LoginBBinGame($request)
    {
        $loginSession = \getSessionValue("PlayerSessionID", false);
        if ($loginSession) {
            return http::playerHttpCaller("LoginPlatform", [$loginSession, "BBIN"]);
             
        } else {
            return [false, "not logined."];
        }
        
    }
}
