<?php
/**
 * 代理相关
 */
registerDataHelper(array("protoHelper", "dataHelper"));
registerViewHelper(array("GmViewHelper", "agent/agentViewHelper"));
registerCtrlHelper(array("agent/agentTrait"));
/**
 * Agent功能
 */
class Agent
{
    use AgentTrait;
    /**
     * Agent审核界面
     *
     * @return void
     */
    static function verify()
    {  
        showVerifyHtml();       
    } 
    
   
    /**
     * AgentList界面
     *
     * @return void
     */
    function aglist()
    {
        showaglistHtml();
    }

    

    /**
     * 获取群组信息
     *
     * @param [type] $request URI
     * 
     * @return void
     */
    function getLayerList($request)
    {

        $retJson = gmServerCaller("GetAllAgentLayer", array());
        $retData = getArrayValue(0, array(), $retJson);
        usort(
            $retData, function ($a, $b) { 
                    return (int)getArrayValue("orderVal", "", $a) -(int)getArrayValue("orderVal", "", $b); 
            }
        );
        $ret = array();
        foreach ($retData as $layer) {
            $cData = getArrayValue("commisionSetting", "", $layer);
            $csJson = json_decode($cData, true);
            $caData = getArrayValue("costAllocationSetting", "", $layer);
            $casJson = json_decode($caData, true);
            
            $dt = (int)getArrayValue("depositBonusRateType", 0, $casJson);
            $rt = (int)getArrayValue("rebateRateType", 0, $casJson);
            $bt = (int)getArrayValue("bonusRateType", 0, $casJson);

            if ($dt  != 0 && $rt != 0 && $bt != 0) {
                $caTag = "<font color='green'>是</font>";
            } else {
                $caTag = "<font color='red'>否</font>";
            }

            $cTag = "<font color='red'>否</font>";
            $wTag = "<font color='red'>否</font>";

            foreach (getArrayValue("game", array(), $csJson) as $game=>$gData) {
                $commisionType = (int)getArrayValue("pumpingCommisionRateType", 0, $gData);
                $waterType = (int)getArrayValue("pumpingWaterRateType", 0, $gData);

                if ($commisionType == 2) {
                    $cTag = "<font color='green'>是</font>";
                }
                if ($waterType == 2) {
                    $wTag = "<font color='green'>是</font>";
                }

                if ($commisionType == 1 && (float)getArrayValue("pumpingCommisionFixedRate", 0, $gData) > 0) {
                    $cTag = "<font color='green'>是</font>";
                }

                if ($waterType == 1 && (float)getArrayValue("pumpingWaterFixedRate", 0, $gData) > 0) {
                    $wTag = "<font color='green'>是</font>";
                }

            }
            $tmp = array(
                "layerid"=>getArrayValue("id", 0, $layer),
                "name"=>getArrayValue("name", "", $layer),
                "note"=>getArrayValue("note", "", $layer),
                "isAllocation"=>$caTag,
                "isCommision"=>$cTag,
                "isWater"=>$wTag
            );
            array_push($ret, $tmp);
        }

        
        return output(array("data"=>$ret), "json");
    }

    /**
     * 新增agent页面
     *
     * @param [type] $request URI
     * 
     * @return void
     */
    static function add($request)
    {
        $page = array(
            makeHeaderPage(""),
            readHtml("agent/agentAdd"),
            makeFooterPage(""),
        );
        return output(join("", $page)); 
    
    }

    /**
     * 显示代理审核历史界面
     *
     * @return void
     */
    static function verifyHistory()
    {
        showagVerifyHistory();
    }

    
    /**
     * 获取代理审核历史数据
     *
     * @param [type] $request URI参数
     * 
     * @return void
     */
    static function verifyHistoryAjax($request)
    {
        $s_args = parseCommonRequestArgus($request);
        $s_type = getArrayValue("s_type", "account", $request);
        $s_key  = getArrayValue("s_keyword", "", $request);
        $retJson = gmServerCaller("GetAgentCheckRecord", array($s_type, $s_key, $s_args[2], $s_args[3]));
        $retJson = getArrayValue(0, array(), $retJson);
        $retSize = (int)getArrayValue("size", 1, $retJson);
        $retData = getArrayValue("data", array(), $retJson);
        $aaData = showVerifyHistory($retData);
        $ret = outputSearchData($retSize, $s_args[4], $s_args[3], $aaData);
        return output($ret, "json");
    }

    /**
     * 生成代理域名界面
     *
     * @return void
     */
    static function domain(){
        showagDomain();

    }
    /**
     * 域名数据请求
     *
     * @param [type] $request URI参数
     * 
     * @return void
     */
    static function domainAjax($request)
    {
        
        $s_args = parseCommonRequestArgus($request);
        $s_type = getArrayValue("type", "", $request);
        $s_key = getArrayValue("keywords", "", $request);

        $retJson = gmServerCaller("GetAgentDomain", array($s_type, $s_key));
        $retData = getArrayValue(0, array(), $retJson);
        $aaData = showDomainHtml($retData);
        $ret = outputSearchData(count($retData), $s_args[4], $s_args[3], $aaData);
        return output($ret, "json");
    }

   
}  
  
  
?>  