<?php
namespace App\Controllers;

use App\Config\Config;
use App\Config\IBCConfig;
use App\Config\NBConfig;

use App\Libs\HttpRequest as http;
use App\ViewHelper\FlowViewHelper as viewHelper;

class FLowAPIController extends BaseController
{
    /**
     * 查询在线玩家接口的二次封装
     *
     * @param [type] $s_st      开始时间
     * @param [type] $s_et      结束时间
     * @param [type] $_stype    查询类型
     * @param [type] $_key      查询关键字
     * @param [type] $_startIdx 查询起始标志位
     * @param [type] $_count    查询数量
     *
     * @return void
     */
    public static function wageredAjax($request)
    {
        $s_args = parseCommonRequestArgus($request);
        $s_btype = getArrayValue("s_btype", "", $request);//查询类别，account-账号，name-姓名，ip-IP，agent-代理，默认为account
        $dno = getArrayValue("betNo", 0, $request);//查询订单ID
        $account = getArrayValue("name", "", $request);//查询关键字
        $game = getArrayValue("gpid", "", $request);//查询关键字
        
        $postArgus = array($dno, $account, $game, $s_args[0], 
            $s_args[1], $s_args[2], $s_args[3]);
        $retData = http::gmHttpCaller("GetRoleFlowRecord", $postArgus);
        // print_r($retData);

        // 准备数据
        $retJson = getArrayValue(0, array(), $retData);
        $staticJson = getArrayValue(1, array(), $retData);
        $retSize = (int) getArrayValue("size", 0, $retJson);
        $retData = getArrayValue("data", array(), $retJson);
        $CorpWinlose = getArrayValue("companyWinLose", 0, $staticJson);
        $CorpStake = getArrayValue("stake", 0, $staticJson);
        $CorpWin = getArrayValue("win", 0, $staticJson);
        $CorpvalidAmount = getArrayValue("validStakeAmount", 0, $staticJson);

        $pageData = viewHelper::showWageredDatas($retData);
        $summaryData = $pageData[1];
        return [
            "sEcho" => $s_args[4],
            "iTotalRecords" => $retSize,
            "iTotalDisplayRecords" => $retSize, //floor($sSize / $sCount), //取整，用于页数
            "aaData" => $pageData[0], 
            "page_bet" => number_format($summaryData[0], 2),
            "page_div" => number_format($summaryData[1], 2),
            "page_win" => number_format($summaryData[2], 2),
            "page_flows" => number_format($summaryData[3], 2),
            "total_bet" => number_format($CorpStake, 2),
            "total_div" => number_format($CorpWin, 2),
            "total_win" => number_format($CorpWinlose, 2),
            "total_flows" => number_format($CorpvalidAmount, 2),
        ];
    }

    public static function getRakeBackHistory($request)
    {
        $s_args = parseCommonRequestArgus($request);
        $rebateID = (int)getSessionValue("rebateID", -1);
        $s_btype = getArrayValue("s_btype", "", $request);
        $s_type = getArrayValue("s_type", "", $request);
        $s_key = getArrayValue("s_keyword", "", $request);
                
        $postArgus = array($s_args[0], $s_args[1], 
            $s_type, $s_key, $s_args[2], $s_args[3]);
        $retJson = http::gmHttpCaller("GetRebateGrantRecord", $postArgus);
        $retJson = getArrayValue(0, array(), $retJson);
        $retSize = (int) getArrayValue("size", 0, $retJson);
        $retData = getArrayValue("data", array(), $retJson);
        
        return [
            "sEcho" => $s_args[4],
            "iTotalRecords" => $retSize,
            "iTotalDisplayRecords" => $retSize, //floor($sSize / $sCount), //取整，用于页数
            "aaData" => viewHelper::showRebateHistoryHtml($retData, $rebateID), 
            "total" => 0
        ];
    }

    public static function grantTask($request)
    {
        $retJson = http::gmHttpCaller("Rebate", array());
        // $rebateID = getArrayValue(0, "", $retJson);
        if (!empty(getArrayValue(0, "", $retJson))) {
            // $_SESSION["rebateID"] = $rebateID;
            return [true];
        } else {
            return [false];
        }
    }
}