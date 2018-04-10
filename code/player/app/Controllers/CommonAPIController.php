<?php
namespace App\Controllers;

use App\Config\Config;
use App\Libs\HttpRequest as http;

class CommonAPIController extends BaseController
{
    public static function CheckAgentStatus($request)
    {
        $LoginStatus = getSessionValue("AgentLoginStatus", "False");
        $loginSession = getSessionValue("AgentSessionID", "");

        if (!$loginSession) {
            LoginReset("agent", false);
            return [false, "Session无效，请重新登录"];
        } else {
            $retJson = http::agentHttpCaller("GetSessionState", array($loginSession));
            $retData = $retJson[0];
            $isOk = getArrayValue("isOk", "", $retData);
            if (!$isOk) {
                $code = getArrayValue("code", "", $retData);
                if ($code == "kickByGM") {
                    $time = parseDate(getArrayValue('time', '', $retData));
                    $msg = "您因违规，于[" . $time . "]被客服强制下线";
                } else {
                    $msg = $code;
                }
                LoginReset("player", false);
                return [false, $msg];
            } else {
                return [true];
            }
        }
    }

    public static function CheckStatus($request)
    {
        $LoginStatus = getSessionValue("PlayerLoginStatus", "False");
        $loginSession = getSessionValue("PlayerSessionID", "");

        if (!$loginSession) {
            LoginReset("player", false);
            return [false, "Session无效，请重新登录"];
        } else {
            $retJson = http::playerHttpCaller("GetSessionState", array($loginSession));
            $retData = $retJson[0];
            $isOk = getArrayValue("isOk", "", $retData);
            if (!$isOk) {
                $code = getArrayValue("code", "", $retData);
                if ($code == "kickByGM") {
                    $time = parseDate(getArrayValue('time', '', $retData));
                    $msg = "您因违规，于[" . $time . "]被客服强制下线";
                } else {
                    $msg = $code;
                }
                LoginReset("player", false);
                return [false, $msg];
            } else {
                return [true];
            }
        }
    }

    public static function RefreshBalance($request)
    {
        /**
         * 刷新账号余额信息
         */
        $partner = getArrayValue("partnerCode", "", $request);
        if (count($request) == 0) {
            return [false, "未提交参数"];
        }
        if (empty($partner)) {
            return [false, "提交的参数错误"];
        }
        $LoginStatus = getSessionValue("PlayerLoginStatus", "False");
        $loginSession = getSessionValue("PlayerSessionID", "");
        if (!$LoginStatus) {
            LoginReset("player");;
            return [false];
        }

        $retJson = http::playerHttpCaller("GetBalanceAmount", array($loginSession, $partner));

        if ($retJson && $retJson[0]) {
            if (!isset($_SESSION["Balance"])) {
                $_SESSION["Balance"] = array();
            }
            $_SESSION["Balance"][$partner] = $retJson[2];
        } else {
            $retJson = [false, "no resp", ""];
        }
        array_push($retJson, $partner);
        return $retJson;
    }

    public static function DepositCash($request)
    {
        /**
         * 玩家存款申请
         */
        $loginSession = getSessionValue("PlayerSessionID", "");
        $channelId = getArrayValue("channelId", "", $request);
        $channelType = getArrayValue("channelType", "", $request);
        $amount = (float) getArrayValue("amount", 0, $request);

        if (empty($channelId) || empty($channelType) || empty($amount)) {
            return [false];
        }
        $ip = getIp();

        $retJson = http::playerHttpCaller("ApplyDeposit", array($loginSession, (float) ($amount), (int) $channelId, (int) $channelType, empty($ip) ? "192.168.0.1" : $ip));
        $lastDno = $retJson[1];
        $_SESSION[$loginSession] = $retJson[1]; // last dno save in session
        return $retJson;
    }

    public static function getlastdeposit($request)
    {
        $loginSession = getSessionValue("PlayerSessionID", "");
        $lastDno = \getSessionValue($loginSession);
        // return  200 - finished, 400 - error, 500 - no response
        if (!$lastDno) {
            $ret = ["code" => 900];
        } else {
            $retData = http::playerHttpCaller("GetDepositStatus", array($loginSession, $lastDno));

            // $retJson = ["code"=>200, "data"=>[2, 10, 12]];

            if (count($retData) > 1 && $retData[0]) {
                if ($retData[1] == 2) {
                    $ret = ["code" => $retData[1], "amount" => $retData[2], "amountResult" => $retData[3]];
                } else {
                    $ret = ["code" => $retData[1]];
                }

            } else {
                $ret = ["code" => 500];
            }

        }
        return $ret;
    }

    

    public static function GetPlatforms($request)
    {

        //array("id"=>"10000","name"=>"主账户","status"=>1,"i"=>"0","s"=>"","e"=>"","flag"=>1,"nb"=>0),
        $gps = Config::platform;
        $GPData = array();
        foreach ($gps as $ID => $NAME) {
            array_push($GPData, array("id" => $ID, "name" => $NAME, "status" => 1,
                "i" => "0", "s" => "", "e" => "", "flag" => 1, "nb" => 0));
        }
        return [true, $GPData];
    }

    public static function TransferCash($request)
    {
        $loginSession = getSessionValue("PlayerSessionID", "");
        $transferFrom = getArrayValue("source", "", $request);
        $transferTo = getArrayValue("dest", "", $request);
        $amount = (float) getArrayValue("amount", 0, $request);

        if (empty($transferFrom) || empty($transferTo) || $amount === 0) {
            return [false];
        }

        if ($transferFrom == "MAIN") {
            //主账户转出
            $retJson = http::playerHttpCaller("TransactOut", array($loginSession, $amount, $transferTo));
        } else {
            //主账户转入
            $retJson = http::playerHttpCaller("TransactIn", array($loginSession, $amount, $transferFrom));
        }
        return $retJson;
    }

}
