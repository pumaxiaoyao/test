<?php
namespace App\Controllers;

use App\Config\Config;
use App\Controllers\Def;
use App\Controllers\PlayerAPIController as PlayerAPI;
use App\Core\View;
use Gregwar\Captcha\CaptchaBuilder;

class PlayerController extends BaseController
{
    public static function online($request)
    {
        $factory = View::getView();
        $pageArgs = [
            "sysMessageList" => [],
        ];
        return $factory->make('Player.online.layout', $pageArgs)
            ->render();
    }

    public static function allRoles($request)
    {
        $factory = View::getView();
        $pageArgs = [
            "sysMessageList" => [],
        ];
        return $factory->make('Player.allRoles.layout', $pageArgs)
            ->render();
    }

    public static function regDaily($request)
    {
        $factory = View::getView();
        $pageArgs = [
            "sysMessageList" => [],
            "today" => date("Y-m-d", time())
        ];
        return $factory->make('Player.regDaily.layout', $pageArgs)
            ->render();
    }

    public static function fundFlow($request)
    {
        $factory = View::getView();
        $pageArgs = [
            "sysMessageList" => [],
            "startTime" => parseDate(time() - 24 * 60*60*30),
            "endTime" => parseDate(time()),
            "platforms" => Config::platform
        ];
        return $factory->make('Player.fundFlow.layout', $pageArgs)
            ->render();
    }

    public static function playerDetailBox($request)
    {
        $factory = View::getView();
        $pageArgs = [
            "sysMessageList" => [],
            "startTime" => date("Y-m-s H:m:s", time() - 24 * 60 * 60 * 30),
            "endTime" => date("Y-m-s H:m:s", time()),
            "account" => $request["id"],
        ];
        $t = PlayerAPI::getPlayerBaseInfo($request);
        return $factory->make('Player.playerDetailBox.layout', array_merge($pageArgs, $t))
            ->render();
    }

    public static function playerActiveTable($request)
    {
        $factory = View::getView();
        $pageArgs = [
            "sysMessageList" => [],
            "startTime" => date("Y-m-s H:m:s", time() - 24 * 60 * 60 * 30),
            "endTime" => date("Y-m-s H:m:s", time()),
        ];
        $t = PlayerAPI::getPlayerStaticInfo($request);
        $t["lastDepositTime"] = parseDate(getArrayValue("lastDepositTime", "", $t));
        $t["lastWithDrawalTime"] = parseDate(getArrayValue("lastWithDrawalTime", "", $t));
        return $factory->make('Player.playerDetailBox.playerStaticInfo', array_merge($pageArgs, $t))
            ->render();
    }


    public static function fundList($request)
    {
        $account = $request["account"];
        $btypes = $request["btypes"];
        if ($btypes != 0) {
            $_btypes = explode(",", urldecode($btypes));
            $_btype = 0;
            foreach ($_btypes as $_btKey){
                $_btype += Config::transMap[$_btKey];
            }
        } else {
            $_btype = Config::transMap["All"];//传参搜索时，为空就真的空，不能替换为全部搜索
        }
        
        $rstatus = (int)getArrayValue("status", 1, $request);
        if ($rstatus === 1) {
            $RequestStatus = true;
        } else {
            $RequestStatus = false;
        }
        $RequestDno = $request["dno"];

        $RequestStart = parseTimeArgus("start", time() - 30 * 24 * 60 * 60, $request);
        $RequestEnd = parseTimeArgus("end", time(), $request);
        return json_encode(PlayerAPI::getFundList($account, $RequestStatus, $RequestStart, $RequestEnd, $RequestDno,  $_btype));
    }

    /**
     * 玩家详情界面 TAB4 - 获取玩家的历史消息数据的Api接口
     *
     * @param [array] $request URI请求的参数数组
     * 
     * @return void
     */
    public static function playerMessage($request)
    {
        return json_encode(PlayerAPI::getPlayerMessages($request));
    }

    public static function playerLoginRecord($request)
    {
        return json_encode(PlayerAPI::playerLoginRecord($request));
    }

    public static function playerBankInfo($request)
    {
        return json_encode(PlayerAPI::playerBankInfo($request));
    }
    
    public static function getCsLog($request)
    {
        return "";
    }

    public static function kickdown($request)
    {
        return json_encode(PlayerAPI::kickdown($request));
    }

    public static function playerDetail($request)
    {
        $factory = View::getView();
        $pageArgs = [
            "sysMessageList" => [],
        ];

        $t = PlayerAPI::getDetailInfo($request);
        return $factory->make('Player.detailPage.layout', array_merge($pageArgs, $t))
            ->render();
    }

    public static function playerListModel($request)
    {
        $requestKey = getArrayValue("k", "", $request);
        // $retJson = gmServerCaller("", array($requestKey));
        $s_args = parseCommonRequestArgus($request);
        $s_type = getArrayValue("s_type", "", $request);//查询类别，account-账号，name-姓名，ip-IP，agent-代理，默认为account
        $s_key = getArrayValue("s_keyword", "", $request);//查询关键字
        $s_group = getArrayValue("groupid", "", $request);//查询关键字
        $s_group = (empty($s_group))?0:$s_group;//默认从1开始查询
        // 后台查询数据
        $retJson = PlayerAPI::SearchAllPlayer($s_args[0], $s_args[1], $s_group, $s_type, $s_key, $s_args[2], $s_args[3]);;
        // 准备数据
        $retJson = $retJson ? $retJson[0] : [];
        $retSize = (int) getArrayValue("size", 0, $retJson);
        $retData = getArrayValue("data", array(), $retJson);

        $factory = View::getView();
        $pageArgs = [
            "requestKey" => $requestKey,
            "roleDatas" => $retData
        ];

        return $factory->make('Player.listModal.layout', $pageArgs)
            ->render();
    }
}