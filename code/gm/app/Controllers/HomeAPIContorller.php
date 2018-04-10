<?php
namespace App\Controllers;

use App\Config\Config;
use App\Controllers\Def;
use App\Controllers\HomeAPIController as HomeAPI;
use App\Core\View;
use Gregwar\Captcha\CaptchaBuilder;

use App\Models\GmUsers;

class HomeAPIController extends BaseController
{

    private static function loginValidator($csName, $csPwd, $verifyCode)
    {
        if (empty($csName) || empty($csPwd) || empty($verifyCode))
            return [false, "empty args"];
        
        if ($verifyCode != \getSessionValue("validCaptcha", "") )
            return [false, "captcha error"];

        return [true];
    }
    public static function login($request)
    {   
        $csName = getArrayValue("csname", "", $request);
        $csPwd = getArrayValue("cspwd", "", $request);
        $verifyCode = getArrayValue("verifycode", "", $request);

        $checks = self::loginValidator($csName, $csPwd, $verifyCode);
        if (!$checks[0]) {
            return $checks;
        }

        $ret = GmUsers::where(["account"=>$csName, "password"=>$csPwd])
                ->first();
        if (count($ret) > 0) {
            // 登录成功，有数据即表示成功
            $_SESSION["Account"] = $csName;
            return [true, ""];
        } else {
            return [false, "login failed."];
        }
    }

    public static function mt($request)
    {
        // todo function.
        // CS的登录信息通知
        return [true];
    }

    public static function getTaskList($request)
    {
        // todo function
        // CS的任务通知
        return [true];
    }

    public static function getIpInfo($request)
    {
        
    }

    
}