<?php
/**
 * 流水相关的API
 */
trait AgentfundTrait
{

    /**
     * 取款代理审核接口
     *
     * @param [type] $request URI参数
     * 
     * @return void
     */
    
    static function wtdVerifyAjax($request)
    {
        $s_args = parseCommonRequestArgus($request);
        $s_type = getArrayValue("s_type", "account", $request);
        $s_key = getArrayValue("s_keyword", "", $request);

        $retJson = gmServerCaller("GetAgentWithdrawalCheck", array($s_type, $s_key, $s_args[2], $s_args[3]));
        
        $retJson = getArrayValue(1, array(), $retJson);
        $aaData = showwtdVeryfyDataHtml($retJson);
        $ret = outputSearchData(getArrayValue("size", 0, $retJson), $s_args[4], $s_args[3], $aaData);
        return output($ret, "json");
    }

    /**
     * 取款审核备注
     *
     * @param [type] $request URI
     * 
     * @return void
     */
    static function wtdRemark($request)
    {
        $dno = getArrayValue("dno", "", $request);
        $note = getArrayValue("remark", "", $request);

        if (empty($dno)) {
            return output(array("code"=>500, "Message"=>"参数错误"), "json");
        }

        $retJson = gmServerCaller("SetAgentWithdrawalNote", array($dno, $note));
        
        if (getArrayValue(0, "", $retJson) == 1) {
            $ret = array("code"=>200, "Message"=>getArrayValue(1, "ok", $retJson));
        } else {
            $ret = array("code"=>500, "Message"=>getArrayValue(1, "没有提供取款审核备注接口", $retJson));
        }
        return output($ret, "json");
    }

    /**
     * Undocumented function
     *
     * @param [type] $request URI参数
     * 
     * @return void
     */
    static function wtdpass($request)
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
            $retJson = gmServerCaller("AgentWithdrawalAgree", array($dno, $amount, $wfee, $feetype, $note));
            
            if (getArrayValue(0, "", $retJson) == 1) {
                $ret["code"] = 200;
            } else {
                $ret["Message"] = getArrayValue(1, "no error msg", $retJson);
            }
        }
        return output($ret, "json");
    }

    /**
     * 拒绝申请
     *
     * @param [type] $request URI参数
     * 
     * @return void
     */
    static function wtdrefuse($request)
    {
        $dno = (int)getArrayValue("dno", 0, $request);
        $note = getArrayValue("dealremark", "", $request);

        $ret = array("code"=>500, "Message"=>"");
        if (empty($dno)) {
            $ret["Message"] = "参数错误";
        } else {
            $retJson = gmServerCaller("AgentWithdrawalRefuse", array($dno, $note));
            
            if (getArrayValue(0, "", $retJson) == 1) {
                $ret["code"] = 200;
            } else {
                $ret["Message"] = getArrayValue(1, "no error msg", $retJson);
            }
        }
        return output($ret, "json");
    }

    /**
     * 确认订单数据
     *
     * @param [type] $request 数据
     * 
     * @return void
     */
    static function wtdInfo($request)
    {
        $dno = getArrayValue("dno", "", $request);
        return output(array(
            array(
                'bankname'=>"中国天地人民银行",
                'realname'=>"韦小宝",
                'cardnum'=>"6926565684855156",
                'actual'=>659.9,
                'wfee'=>0,
            )
        ), "json");
    }

    /**
     * 代理的出款操作
     *
     * @param [type] $request 参数
     * 
     * @return void
     */
    static function completewtd($request)
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
            $retJson = gmServerCaller("AgentWithdrawalRemit", array($dno, $bcid, $note));

            if (getArrayValue(0, "", $retJson) == 1) {
                $ret["code"] = 200;
            } else {
                $ret["Message"] = getArrayValue(1, "no error msg", $retJson);
            }
        }
        return output($ret, "json");
        
    }

    /**
     * 代理的手动调整
     *
     * @param [type] $request 参数
     * 
     * @return void
     */
    static function agentAdjust($request)
    {
        $dno = getArrayValue("dno", "", $request);
        $amount = (float)getArrayValue("amount", 0, $request);
        $note = getArrayValue("note", "", $request);

        $ret = array("code"=>500, "Message"=>"");
        if (empty($dno) || empty($amount)) {
            $ret["Message"] = "参数错误";
        } else {
            $retJson = gmServerCaller("SetAgentSettleStatementAdjustment", array($dno, $amount, $note));

            if (getArrayValue(0, "", $retJson) == 1) {
                $ret["code"] = 200;
            } else {
                $ret["Message"] = getArrayValue(1, "no error msg", $retJson);
            }
        }
        return output($ret, "json");
        
    }
    /**
     * 代理的实际发放调整
     *
     * @param [type] $request 参数
     * 
     * @return void
     */
    static function agentActural($request)
    {
        $dno = getArrayValue("dno", "", $request);
        $amount = (float)getArrayValue("amount", 0, $request);
        $note = getArrayValue("note", "", $request);

        $ret = array("code"=>500, "Message"=>"");
        if (empty($dno) || empty($amount)) {
            $ret["Message"] = "参数错误";
        } else {
            $retJson = gmServerCaller("SetAgentSettleStatementResultAmount", array($dno, $amount, $note));

            if (getArrayValue(0, "", $retJson) == 1) {
                $ret["code"] = 200;
            } else {
                $ret["Message"] = getArrayValue(1, "no error msg", $retJson);
            }
        }
        return output($ret, "json");
        
    }


    /**
     * 代理结算的审核操作
     *
     * @param [type] $request 参数
     * 
     * @return void
     */
    static function settleCheck($request)
    {
        $dno = (int)getArrayValue("dno", "", $request);
        $lvl = (int)getArrayValue("lvl", 0, $request);
        

        $ret = array("code"=>500, "Message"=>"");
        if (empty($dno) || empty($lvl)) {
            $ret["Message"] = "参数错误";
        } else {

            if ($lvl == 1) {
                $retJson = gmServerCaller("AgentSettleStatementFirstCheck", array($dno));
            } else if ($lvl == 2) {
                $retJson = gmServerCaller("AgentSettleStatementSecondCheck", array($dno));
            } else {
                $retJson = array();
            }
            
            if (getArrayValue(0, "", $retJson) == 1) {
                $ret["code"] = 200;
            } else {
                $ret["Message"] = getArrayValue(1, "no error msg", $retJson);
            }
        }
        return output($ret, "json");
    }  
    

    /**
     * 代理结算的审核操作
     *
     * @param [type] $request 参数
     * 
     * @return void
     */
    static function resettle($request)
    {
        $ret = array("code"=>500, "Message"=>"");
        $retJson = gmServerCaller("ReCreateAgentLastMonthSettleStatement", array());
            
        if (getArrayValue(0, "", $retJson) == 1) {
            $ret["code"] = 200;
        } else {
            $ret["Message"] = getArrayValue(1, "no error msg", $retJson);
        }
        return output($ret, "json");
    }

    /**
     * 代理结算的审核操作
     *
     * @param [type] $request 参数
     * 
     * @return void
     */
    static function createSettle($request)
    {
        $ret = array("code"=>500, "Message"=>"");
        $retJson = gmServerCaller("CreateAgentLastMonthSettleStatement", array());
            
        if (getArrayValue(0, "", $retJson) == 1) {
            $ret["code"] = 200;
        } else {
            $ret["Message"] = getArrayValue(1, "no error msg", $retJson);
        }
        return output($ret, "json");
    }
}
?>