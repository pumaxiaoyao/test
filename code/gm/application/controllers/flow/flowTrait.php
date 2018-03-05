<?php
/**
 * 流水相关的API
 * php version 7.1
 * 
 * @category Flow
 * @package  GM
 * @author   alien <email@email.com>
 * @license  Public http://alien.com
 * @link     http://alien.com
 */


/**
 * 流水相关的API-Trait扩展
 * php version 7.1
 * 
 * @category Flowtrait
 * @package  GM
 * @author   alien <email@email.com>
 * @license  Public http://alien.com
 * @link     http://alien.com
 */
trait FlowTrait
{

    /**
     * 流水接口
     *
     * @param [type] $request URI参数
     * 
     * @return void
     */
    static function wageredAjax($request)
    {
        /**
         * 玩家流水记录查询
         */
        $s_args = parseCommonRequestArgus($request);
        $s_btype = getArrayValue("s_btype", "", $request);//查询类别，account-账号，name-姓名，ip-IP，agent-代理，默认为account
        $dno = getArrayValue("betNo", 0, $request);//查询订单ID
        $account = getArrayValue("name", "", $request);//查询关键字
        $game = getArrayValue("gpid", "", $request);//查询关键字
        
        $postArgus = array($dno, $account, $game, $s_args[0], 
            $s_args[1], $s_args[2], $s_args[3]);
        $retData = gmServerCaller("GetRoleFlowRecord", $postArgus);
        // print_r($retData);
        $retJson = getArrayValue(0, array(), $retData);
        $staticJson = getArrayValue(1, array(), $retData);
        $retSize = (int)getArrayValue("size", 0, $retJson);
        $retData = getArrayValue("data", array(), $retJson);

        $CorpWinlose = getArrayValue("companyWinLose", 0, $staticJson);
        $CorpStake = getArrayValue("stake", 0, $staticJson);
        $CorpWin = getArrayValue("win", 0, $staticJson);
        $CorpvalidAmount = getArrayValue("validStakeAmount", 0, $staticJson);

        $pageData = showWageredDatas($retData);
        
        $ret = outputSearchData($retSize, $s_args[4], $s_args[3], $pageData[0]);

        $ret["page_bet"] = number_format($pageData[1][0], 2);
        $ret["page_div"] = number_format($pageData[1][1], 2);
        $ret["page_win"] = number_format($pageData[1][2], 2);
        $ret["page_flows"] = number_format($pageData[1][3], 2);
        $ret["total_bet"] = number_format($CorpStake, 2);
        $ret["total_div"] = number_format($CorpWin, 2);
        $ret["total_win"] = number_format($CorpWinlose, 2);
        $ret["total_flows"] = number_format($CorpvalidAmount, 2);
        
        return output($ret, "json");
    }


    /**
     * 设置流水单状态
     *
     * @param [type] $request 数据
     * 
     * @return void
     */
    function changeFLow($request)
    {
        $betid = (int)getArrayValue("betid", "0", $request);//查询类别，account-账号，name-姓名，ip-IP，agent-代理，默认为account
        $gp_id = getArrayValue("gp_id", "0", $request);//查询关键字
        $status = (string)getArrayValue("status", "99", $request);//查询关键字
        
        if ($status == "66") {
            $status = true;
        } else {
            $status = false;
        }
        $retJson = gmServerCaller("SetFlowValid", array($betid, $status));
        if (getArrayValue(0, "", $retJson) == 1) {
            return output(array("code"=>200), "json");
        } else {
            return output(array("code"=>400), "json");
        }
        

    }

    /**
     * 返水记录查询
     *
     * @param [type] $request 参数
     * 
     * @return void
     */
    function getRakeBackList($request)
    {
        $s_args = parseCommonRequestArgus($request);
        $rebateID = getSessionValue("rebateID", "");
        $rebateAccount = getSessionValue("rebateAccount", array());

        $postArgus = array($rebateID, $s_args[2], $s_args[3]);
        $retJson = gmServerCaller("GetRebateGrantList", $postArgus);
        $retFlag = getArrayValue(0, 0, $retJson);
        if ($retFlag == 1) {
            $retData = getArrayValue(1, array(), $retJson);
        } else {
            $retData = array();
        }

        $pageData = showRebateListHtml($retData, $rebateID);
        $_size = count($retData);
        $_sEcho = $s_args[4]+1;
        $ret = outputSearchData($_size, $_sEcho, $s_args[3], $pageData);
        $ret["total_rake"] = 0.00;
        $ret["page_rake"] = 0.00;
        $ret["retFlag"] = $retFlag;
        return output($ret, "json");
        
    }

    /**
     * 测试的返水生成接口
     *
     * @param [type] $request 参数
     * 
     * @return void
     */
    function grantTask($request)
    {
        // $periodtype = getArrayValue("periodtype", "", $request);
        $retJson = gmServerCaller("Rebate", array());
        // $rebateID = getArrayValue(0, "", $retJson);
        if (!empty(getArrayValue(0, "", $retJson))) {
            // $_SESSION["rebateID"] = $rebateID;
            return output(array("code"=>200, "data"=>""), "json");
        } else {
            return output(array("code"=>400, "data"=>""), "json");
        }

    }

    // function getGrantList(){

    // }
    

    /**
     * 获得返水历史记录数据
     *
     * @param [type] $request 参数
     * 
     * @return void
     */
    function getRakeBackHistory($request)
    {
        /**
         * 查询返水历史
         */
        $s_args = parseCommonRequestArgus($request);
        $rebateID = (int)getSessionValue("rebateID", -1);
        $s_btype = getArrayValue("s_btype", "", $request);
        $s_type = getArrayValue("s_type", "", $request);
        $s_key = getArrayValue("s_keyword", "", $request);
                
        $postArgus = array($s_args[0], $s_args[1], 
            $s_type, $s_key, $s_args[2], $s_args[3]);
        $retJson = gmServerCaller("GetRebateGrantRecord", $postArgus);
        
        $retJson = getArrayValue(0, array(), $retJson);
        $retSize = (int)getArrayValue("size", 0, $retJson);
        $retData = getArrayValue("data", array(), $retJson);
        $pageData = showRebateHistoryHtml($retData, $rebateID);
        $ret = outputSearchData($retSize, $s_args[4], $s_args[3], $pageData);
        $ret["total"] = 0;
        return output($ret, "json");
    }

    // function getRakeBackListALL($request){
    //     $group = getArrayValue("getRakeBackListALL", "", $request);
    //     $rebateID = (int)getSessionValue("rebateID", -1);
        
    //     if (empty($rebateID)){
    //         return output(array("code"=>400, "data"=>$rebateID), "json");
    //     }else{
    //         $retJson = gmServerCaller("GrantRebateAll", array($rebateID, false));
    //         if (getArrayValue(0 , "", $retJson) == 1){
    //             $rebateAcc = "rebateAccount". $rebateID;
    //             $_SESSION[$rebateAcc] = $_SESSION["CanrebateAccount". $rebateID];
    //             return output(array("code"=>200, "data"=>$rebateID), "json");
    //         }else{
    //             return output(array("code"=>400, "data"=>$rebateID), "json");
    //         }
    //     }
    // }

    // function rake($request){
    //     $rebateID = (int)getArrayValue("sid", -1, $request);
    //     $account = getArrayValue("uid", "", $request);
    //     $ar = (int)getArrayValue("ar", 0, $request);
    //     $mul = (int)getArrayValue("mul", 0, $request);
    //     $platform = (int)getArrayValue("gpid", "0", $request);
    //     $rebateID = getSessionValue("rebateID", -1);
    //     if ($rebateID === -1){
    //         return output(array("code"=>400, "data"=>$rebateID), "json");
    //     }else{
    //         if($ar === 0){
    //             $isZero = true;
    //         }else{
    //             $isZero = false;
    //         }
    //         $postArgus = array($rebateID, array($platform), $isZero);
    //         $retJson = gmServerCaller("GrantRebateSome", $postArgus);
            
    //         if (getArrayValue(0, "", $retJson) == 1){
    //             if ( !array_key_exists("rebateAccount". $rebateID, $_SESSION) ){
    //                 $_SESSION["rebateAccount". $rebateID] = array();
    //             }
    //             array_push($_SESSION["rebateAccount". $rebateID], $account);
    //             return output(array("code"=>400, "data"=>$rebateID), "json");
    //         }else{
    //             return output(array("code"=>400, "data"=>$rebateID), "json");
    //         }
    //     }
    // }
}
?>