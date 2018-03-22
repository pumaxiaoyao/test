<?php

/**
 * MVC路由功能简单实现
 * @desc 简单实现MVC路由功能
 */
registerDataHelper(array("protoHelper", "dataHelper"));
registerViewHelper(array("GmViewHelper", "agentfund/agentfundViewHelper"));
registerCtrlHelper(array("agentfund/agentfundTrait"));
/**
 * 代理资金功能的接口
 *
 */
class Agentfund
{
    use AgentfundTrait;
    /**
     * 代理结算界面
     *
     * @return void
     */
    static function curPeriod()
    {
        showcurPeriod();
    }


    /**
     * 获取游戏平台佣金
     *
     * @param [type] $request URI参数
     *
     * @return void
     */
    static function curPeriodList($request)
    {
        $s_args = parseCommonRequestArgus($request);
        $retJson = gmServerCaller("GetAgentSettleStatement", array());
        
        $retJson = getArrayValue(0, array(), $retJson);
        $aaData = shouCurPeriodData($retJson);
        $ret = outputSearchData(count($retJson), $s_args[4], $s_args[3], $aaData);

        return output($ret, "json");

    }

    /**
     * 处理详情界面1
     *
     * @param [type] $request URI
     *
     * @return void
     */
    static function settleDetail($request)
    {
        
        $data = getSessionValue("GameCommision", array());
        $dno = getArrayValue("dno", "", $request);
        $commisionHtml = getArrayValue($dno, array(), $data);
        $gcHtml = getArrayValue("gc", "", $commisionHtml);
        $ccHtml = getArrayValue("cc", "", $commisionHtml);
        $srHtml = readHtml("agent/settleDetail");
        $srHtml = str_replace("{{GameCommisionData}}", $gcHtml, $srHtml);
        $srHtml = str_replace("{{ChildCommisionData}}", $ccHtml, $srHtml);

        return output($srHtml);


    }
    
    /**
     * 处理详情界面1
     *
     * @param [type] $request URI
     *
     * @return void
     */
    static function settleDetail2($request)
    {
        $data = getSessionValue("GameCommision", array());
        $dno = getArrayValue("dno", "", $request);
        $commisionHtml = getArrayValue($dno, array(), $data);
        $caHtmlData = getArrayValue("ca", array(), $commisionHtml);
        
        $caHtaml1 = getArrayValue(0, "", $caHtmlData);
        $caHtaml2 = getArrayValue(1, "", $caHtmlData);

        $Html = readHtml("agent/settleDetail2");
        $Html = str_replace("{{AgentAllocationData}}", $caHtaml1, $Html);
        $Html = str_replace("{{ChildAllocationData}}", $caHtaml2, $Html);

        return output($Html);
    }


    /**
     * 获得当前生成月结单的进度
     *
     * @param [type] $request URI参数
     * 
     * @return void
     */
    static function getAgentGrantList($request)
    {
        // $retJson = gmServerCaller("GetCreateSettleStatementProcess", array());
        // $percent = (float)getArrayValue(0, 0, $retJson) * 100;
        $ret = array("count"=>"1","asmonth"=>date("Ym", time() - 24*3600 *30),"proc"=>"4","pect"=>"100");//(string)$percent);
        return output($ret, "json");
    }

    /**
     * 获得代理结算历史页面
     *
     * @return void
     */
    function settleHistory()
    {
        showsettleHistory();
    }

    /**
     * 获得代理结算历史的数据
     *
     * @param [type] $request URI数据
     * 
     * @return void
     */
    function settleHistoryList($request)
    {
        $s_args = parseCommonRequestArgus($request);
        $account = getArrayValue("account", "", $request);
        $retJson = gmServerCaller("GetAgentSettleStatementRecord", array($account, $s_args[2], $s_args[3]));
        
        $retJson = getArrayValue(0, array(), $retJson);
        $aaData = showSettleHistoryData($retJson);
        $ret = outputSearchData(count($retJson), $s_args[4], $s_args[3], $aaData);

        return output($ret, "json");

    }

    /**
     * 创建代理取款审核界面
     *
     * @return void
     */
    static function agentWtdVerify()
    {
        showwtdVerify();
    }



    /**
     * 构建代理取款历史界面
     *
     * @return void
     */
    static function agentWtdHistory()
    {
        showwtdHistory();
    }


    /**
     * 代理取款历史请求
     *
     * @param [type] $request 数据
     *
     * @return void
     */
    static function wtdHistoryAjax($request)
    {
        $s_args = parseCommonRequestArgus($request);

        $s_type = getArrayValue("s_type", "account", $request);
        $s_btype = getArrayValue("s_btype", 1, $request);
        $s_key = getArrayValue("s_keyword", "", $request);//查询关键字
        $s_status = (int)getArrayValue("s_Status", 0, $request);//查询关键字

        $retJson = gmServerCaller("GetAgentWithdrawalRecord", array($s_args[0], $s_args[1], $s_status, 0, $s_type, $s_key, $s_args[2], $s_args[3]));
        // $staticData = getArrayValue(1, array(), $retJson);
        $retJson = getArrayValue(1, array(), $retJson);
        $retSize = (int)getArrayValue("size", 0, $retJson);
        $retData = getArrayValue("data", array(), $retJson);
        $aaData = showagentWDHistoryData($retData);
        $ret = outputSearchData($retSize, $s_args[4], $s_args[3], $aaData);

        return output($ret, "json");

    }
}


?>