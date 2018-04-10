<?php
namespace App\Controllers;

use App\Config\Config;
use App\Libs\HttpRequest as http;
use App\ViewHelper\AgentFundViewHelper as viewHelper;


class AgentFundAPIController extends BaseController
{
    public static function curPeriodList($request)
    {
        $s_args = parseCommonRequestArgus($request);
        $retJson = http::gmHttpCaller("GetAgentSettleStatement", array());
        

        $retJson = getArrayValue(0, array(), $retJson);
        $retSize = count($retJson);

        return [
            "sEcho" => $s_args[4],
            "iTotalRecords" => $retSize,
            "iTotalDisplayRecords" => $retSize, //floor($sSize / $sCount), //取整，用于页数
            "aaData" => viewHelper::shouCurPeriodData($retJson)
        ];
    }

    public static function getAgentGrantList($request)
    {
        
        // $retJson = gmServerCaller("GetCreateSettleStatementProcess", array());
        // $percent = (float)getArrayValue(0, 0, $retJson) * 100;
        $ret = array("count"=>"1","asmonth"=>date("Ym", time() - 24*3600 *30),"proc"=>"4","pect"=>"100");//(string)$percent);
        return $ret;
    }

    public static function agentAdjust($request)
    {
        $dno = getArrayValue("dno", "", $request);
        $amount = (float)getArrayValue("amount", 0, $request);
        $note = getArrayValue("note", "", $request);

        $ret = array("code"=>500, "Message"=>"");
        if (empty($dno) || empty($amount)) {
            $ret["Message"] = "参数错误";
        } else {
            $retJson = http::gmHttpCaller("SetAgentSettleStatementAdjustment", array($dno, $amount, $note));

            if (getArrayValue(0, "", $retJson) == 1) {
                $ret["code"] = 200;
            } else {
                $ret["Message"] = getArrayValue(1, "no error msg", $retJson);
            }
        }
        return $ret;
    }

    /**
     * 代理的实际发放调整
     *
     * @param [type] $request 参数
     * 
     * @return void
     */
    public static function agentActural($request)
    {
        $dno = getArrayValue("dno", "", $request);
        $amount = (float)getArrayValue("amount", 0, $request);
        $note = getArrayValue("note", "", $request);

        $ret = array("code"=>500, "Message"=>"");
        if (empty($dno) || empty($amount)) {
            $ret["Message"] = "参数错误";
        } else {
            $retJson = http::gmHttpCaller("SetAgentSettleStatementResultAmount", array($dno, $amount, $note));

            if (getArrayValue(0, "", $retJson) == 1) {
                $ret["code"] = 200;
            } else {
                $ret["Message"] = getArrayValue(1, "no error msg", $retJson);
            }
        }
        return $ret;
    }

        /**
     * 代理结算的审核操作
     *
     * @param [type] $request 参数
     * 
     * @return void
     */
    public static function settleCheck($request)
    {
        $dno = (int)getArrayValue("dno", "", $request);
        $lvl = (int)getArrayValue("lvl", 0, $request);
        

        $ret = array("code"=>500, "Message"=>"");
        if (empty($dno) || empty($lvl)) {
            $ret["Message"] = "参数错误";
        } else {

            if ($lvl == 1) {
                $retJson = http::gmHttpCaller("AgentSettleStatementFirstCheck", array($dno));
            } else if ($lvl == 2) {
                $retJson = http::gmHttpCaller("AgentSettleStatementSecondCheck", array($dno));
            } else {
                $retJson = array();
            }
            
            if (getArrayValue(0, "", $retJson) == 1) {
                $ret["code"] = 200;
            } else {
                $ret["Message"] = getArrayValue(1, "no error msg", $retJson);
            }
        }
        return $ret;
    }  
    

    /**
     * 代理结算的审核操作
     *
     * @param [type] $request 参数
     * 
     * @return void
     */
    public static function resettle($request)
    {
        $ret = array("code"=>500, "Message"=>"");
        $retJson = http::gmHttpCaller("ReCreateAgentLastMonthSettleStatement", array());
            
        if (getArrayValue(0, "", $retJson) == 1) {
            $ret["code"] = 200;
        } else {
            $ret["Message"] = getArrayValue(1, "no error msg", $retJson);
        }
        return $ret;
    }

    /**
     * 代理结算的审核操作
     *
     * @param [type] $request 参数
     * 
     * @return void
     */
    public static function createSettle($request)
    {
        $ret = array("code"=>500, "Message"=>"");
        $retJson = http::gmHttpCaller("CreateAgentLastMonthSettleStatement", array());
            
        if (getArrayValue(0, "", $retJson) == 1) {
            $ret["code"] = 200;
        } else {
            $ret["Message"] = getArrayValue(1, "no error msg", $retJson);
        }
        return $ret;
    }

    public static function settleHistoryList($request)
    {
        $s_args = parseCommonRequestArgus($request);
        $account = getArrayValue("account", "", $request);
        $retJson = http::gmHttpCaller("GetAgentSettleStatementRecord", array($account, $s_args[2], $s_args[3]));

        $retJson = getArrayValue(0, array(), $retJson);
        $retSize = count($retJson);

        return [
            "sEcho" => $s_args[4],
            "iTotalRecords" => $retSize,
            "iTotalDisplayRecords" => $retSize, //floor($sSize / $sCount), //取整，用于页数
            "aaData" => viewHelper::showSettleHistoryData($retJson)
        ];
    }

    /**
     * 取款代理审核接口
     *
     * @param [type] $request URI参数
     * 
     * @return void
     */
    
    public static function wtdVerifyAjax($request)
    {
        $s_args = parseCommonRequestArgus($request);
        $s_type = getArrayValue("s_type", "account", $request);
        $s_key = getArrayValue("s_keyword", "", $request);

        $retJson = http::gmHttpCaller("GetAgentWithdrawalCheck", array($s_type, $s_key, $s_args[2], $s_args[3]));
        
        $retJson = getArrayValue(1, array(), $retJson);
        $retSize = count($retJson);

        return [
            "sEcho" => $s_args[4],
            "iTotalRecords" => $retSize,
            "iTotalDisplayRecords" => $retSize, //floor($sSize / $sCount), //取整，用于页数
            "aaData" => viewHelper::showwtdVeryfyDataHtml($retJson)
        ];
    }

    /**
     * 取款审核备注
     *
     * @param [type] $request URI
     * 
     * @return void
     */
    public static function wtdRemark($request)
    {
        $dno = getArrayValue("dno", "", $request);
        $note = getArrayValue("remark", "", $request);

        if (empty($dno)) {
            return ["code"=>500, "Message"=>"参数错误"];
        }

        $retJson = http::gmHttpCaller("SetAgentWithdrawalNote", array($dno, $note));
        
        if (getArrayValue(0, "", $retJson) == 1) {
            $ret = ["code"=>200, "Message"=>getArrayValue(1, "ok", $retJson)];
        } else {
            $ret = ["code"=>500, "Message"=>getArrayValue(1, "没有提供取款审核备注接口", $retJson)];
        }
        return $ret;
    }

    /**
     * Undocumented function
     *
     * @param [type] $request URI参数
     * 
     * @return void
     */
    public static function wtdpass($request)
    {
        $dno = (int)getArrayValue("dno", 0, $request);
        $amount = (float)getArrayValue("actual", 0, $request);
        $wfee = (float)getArrayValue("wfee", 0, $request);
        $feetype = (int)getArrayValue("feetype", 0, $request);
        $note = getArrayValue("dealremark", "", $request);

        $ret = array("code"=>500, "Message"=>"");
        if (empty($dno) || empty($amount)) {
            $ret["Message"] = "参数错误";
        } else {
            $retJson = http::gmHttpCaller("AgentWithdrawalAgree", array($dno, $amount, $wfee, $feetype, $note));
            
            if (getArrayValue(0, "", $retJson) == 1) {
                $ret["code"] = 200;
            } else {
                $ret["Message"] = getArrayValue(1, "no error msg", $retJson);
            }
        }
        return $ret;
    }

    /**
     * 拒绝申请
     *
     * @param [type] $request URI参数
     * 
     * @return void
     */
    public static function wtdrefuse($request)
    {
        $dno = (int)getArrayValue("dno", 0, $request);
        $note = getArrayValue("dealremark", "", $request);

        $ret = array("code"=>500, "Message"=>"");
        if (empty($dno)) {
            $ret["Message"] = "参数错误";
        } else {
            $retJson = http::gmHttpCaller("AgentWithdrawalRefuse", array($dno, $note));
            
            if (getArrayValue(0, "", $retJson) == 1) {
                $ret["code"] = 200;
            } else {
                $ret["Message"] = getArrayValue(1, "no error msg", $retJson);
            }
        }
        return $ret;
    }



    /**
     * 获取代理取款审核历史数据
     */
    public static function wtdHistoryAjax($request)
    {
        $s_args = parseCommonRequestArgus($request);

        $s_type = getArrayValue("s_type", "account", $request);
        $s_btype = getArrayValue("s_btype", 1, $request);
        $s_key = getArrayValue("s_keyword", "", $request);//查询关键字
        $s_status = (int)getArrayValue("s_Status", 0, $request);//查询关键字

        $retJson = http::gmHttpCaller("GetAgentWithdrawalRecord", array($s_args[0], $s_args[1], $s_status, 0, $s_type, $s_key, $s_args[2], $s_args[3]));
        
        $retJson = getArrayValue(1, array(), $retJson);
        $retSize = (int)getArrayValue("size", 0, $retJson);
        $retData = getArrayValue("data", array(), $retJson);
        
        return [
            "sEcho" => $s_args[4],
            "iTotalRecords" => $retSize,
            "iTotalDisplayRecords" => $retSize, //floor($sSize / $sCount), //取整，用于页数
            "aaData" => viewHelper::showagentWDHistoryData($retData)
        ];
    }

    public static function completewtd($request)
    {
        // bcid: bcid, wfee: wfee, dealremark: dealremark, dno: nowdno
        $bcid = getArrayValue("bcid", "", $request);
        $wfee = (float)getArrayValue("wfee", 0, $request);
        $dno = getArrayValue("dno", 0, $request);
        $note = getArrayValue("dealremark", "", $request);

        $ret = array("code"=>500, "Message"=>"");
        if (empty($bcid) || empty($dno) || empty($note)) {
            $ret["Message"] = "参数错误";
        } else {
            $retJson = http::gmHttpCaller("AgentWithdrawalRemit", array($dno, $bcid, $note));

            if (getArrayValue(0, "", $retJson) == 1) {
                $ret["code"] = 200;
            } else {
                $ret["Message"] = getArrayValue(1, "no error msg", $retJson);
            }
        }
        return $ret;
    }

}