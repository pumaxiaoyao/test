<?php
namespace App\Controllers;

use App\Core\View;

class AgentFundController extends BaseController
{
    public static function curperiod($request)
    {
        $factory = View::getView();
        $pageArgs = [
            "sysMessageList" => [],
            "lastMonth" => date("Ym", time() - 24 * 3600 * 30),
        ];
        return $factory->make('AgentFund.curperiod.layout', $pageArgs)
            ->render();
    }

    public static function settleDetail($request)
    {
        $data = getSessionValue("GameCommision", array());
        $dno = getArrayValue("dno", "", $request);
        $commisionHtml = getArrayValue($dno, array(), $data);
        $gcHtml = getArrayValue("gc", "", $commisionHtml);
        $ccHtml = getArrayValue("cc", "", $commisionHtml);

        $factory = View::getView();
        $pageArgs = [
            "GameCommisionData" => $gcHtml,
            "ChildCommisionData" => $ccHtml,
        ];
        return $factory->make('AgentFund.curperiod.settleDetail', $pageArgs)
            ->render();
    }

    public static function settleDetail2($request)
    {
        $data = getSessionValue("GameCommision", array());
        $dno = getArrayValue("dno", "", $request);
        $commisionHtml = getArrayValue($dno, array(), $data);
        $caHtmlData = getArrayValue("ca", array(), $commisionHtml);

        $caHtaml1 = getArrayValue(0, "", $caHtmlData);
        $caHtaml2 = getArrayValue(1, "", $caHtmlData);

        $factory = View::getView();
        $pageArgs = [
            "AgentAllocationData" => $caHtaml1,
            "ChildAllocationData" => $caHtaml2,
        ];
        return $factory->make('AgentFund.curperiod.settleDetail2', $pageArgs)
            ->render();
    }

    /**
     * 代理结算历史
     */
    public static function settlehistory($request)
    {
        $factory = View::getView();
        $pageArgs = [
            "sysMessageList" => [],
        ];
        return $factory->make('AgentFund.settleHistory.layout', $pageArgs)
            ->render();
    }
    public static function agentWtdVerify($request)
    {
        $factory = View::getView();
        $pageArgs = [
            "sysMessageList" => [],
            "startTime" => parseDate(time() - 24 * 60 * 60 * 30),
            "endTime" => parseDate(time()),
        ];
        return $factory->make('AgentFund.wtdVerify.layout', $pageArgs)
            ->render();
    }

    public static function agentWtdHistory($request)
    {
        $factory = View::getView();
        $pageArgs = [
            "sysMessageList" => [],
            "startTime" => parseDate(time() - 24 * 60 * 60 * 30),
            "endTime" => parseDate(time()),
        ];
        return $factory->make('AgentFund.wtdHistory.layout', $pageArgs)
            ->render();
    }

    /**
     * 确认订单数据
     *
     * @param [type] $request 数据
     *
     * @return void
     */
    public static function wtdInfo($request)
    {
        $dno = getArrayValue("dno", "", $request);
        return json_encode([[
            'bankname' => "中国天地人民银行",
            'realname' => "韦小宝",
            'cardnum' => "6926565684855156",
            'actual' => 659.9,
            'wfee' => 0
        ]]);
    }
}
