<?php

/**
 * 流水相关的API
 */
trait AgentTrait
{

    /**
     * Agent审核数据
     *
     * @param [type] $request URI参数
     * 
     * @return void
     */
    static function verifyAjax($request)
    {
        $s_args = parseCommonRequestArgus($request);
        $s_type = getArrayValue("s_type", "account", $request);
        $s_key = getArrayValue("s_keyword", "", $request);
        $retJson = gmServerCaller("GetAgentCheck", array($s_type, $s_key, $s_args[2], $s_args[3]));

        // 准备数据
        $retJson = getArrayValue(0, array(), $retJson);
        $retSize = (int)getArrayValue("size", 1, $retJson);
        $retData = getArrayValue("data", array(), $retJson);
        $aaData = showAgentVerifyHtml($retData);
        $ret = outputSearchData($retSize, $s_args[4], $s_args[3], $aaData);
        return output($ret, "json");
    }

    /**
     * Agent信息界面
     *
     * @param [type] $request URI参数
     * 
     * @return void
     */
    static function detailBox($request)
    {
        $Html = readHtml("agent/agentDetail");
        $agentId = (int)getArrayValue("id", 0, $request);
        if ($agentId == 0) {
            $retJson = array();
        } else {
            $retJson = gmServerCaller("GetAgentInfo", array($agentId));
        }
        $retData = getArrayValue(0, array(), $retJson);
        $domainData = getArrayValue(1, array(), $retJson);
        $status = (string)getArrayValue("status", "1", $retData);
        $pParentId = (int)getArrayValue("pParentId", 1, $retData);
        $parentId = (int)getArrayValue("parentId", 0, $retData);
        $parentAccount = getArrayValue("parentAccount", "", $retData);

        $belongToTags = parseBelongTo($pParentId, $parentId, $parentAccount);
        
        switch ($status) {
        case "1":
            $stag = "待审核";
            break;
        case "2":
            $stag = "正常";
            break;
        case "3":
            $stag = "锁定";
            break;
        case "4":
            $stag = "被拒绝";
            break;
        default:
            $stag = "未定义 - ".$status;
            break;
        }

        $domainInfo = parseDomainInfo($domainData);

        $replaceData = array(
            "ACCOUNT"=>getArrayValue("account", "", $retData),
            "NAME"=>getArrayValue("name", "", $retData),
            "EMAIL"=>getArrayValue("email", "", $retData),
            "AGENTCODE"=>getArrayValue("roleId", "", $retData),
            "AGENTLEVEL"=>getArrayValue("layerName", "无", $retData),
            "AGENT1ST"=>$belongToTags[0],
            "AGENT2RD"=>$belongToTags[1],
            "REGTIME"=>parseDate(getArrayValue("joinTime", 0, $retData), 4),
            "REGIP"=>getArrayValue("joinIp", "", $retData),
            "LASTLOGINDATE"=>parseDate(getArrayValue("lastLoginTime", 0, $retData), 4),
            "STATUS"=>$stag,
            "PHONE"=>getArrayValue("cellPhoneNo", "", $retData),
            "QQ"=>getArrayValue("qq", "", $retData),
            "DOMAIN"=>$domainInfo,
        );
        foreach ($replaceData as $_key=>$_val) {
            $Html = str_replace("%" . $_key . "%", $_val, $Html);
        }
        
        return output($Html);
    }

    /**
     * 处理代理审核操作
     *
     * @param [type] $request URI参数
     * 
     * @return void
     */
    static function agentVerify($request)
    {
        $agentid = getArrayValue("agentid", "", $request);
        $layerid = getArrayValue("layerid", "", $request);
        $note = getArrayValue("note", "", $request);
        $status = getArrayValue("status", "", $request);

        if (empty($agentid) || empty($layerid) || empty($note) || empty($status)) {
            return output(array("code"=>500, "Message"=>"参数错误"), "json");
        }

        if ($status == "1") {
            $retJson = gmServerCaller("AgentCheckAgree", array($agentid, $layerid, $note));
        } else {
            $retJson = gmServerCaller("AgentCheckRefuse", array($agentid, $note));
        }

        if (getArrayValue(0, "", $retJson) == 1) {
            return output(array("code"=>200, "Message"=>"ok"), "json");
        } else {
            return output(array("code"=>500, "Message"=>getArrayValue(1, "no error msg", $retJson)), "json");
        }
    }

    /**
     * AgentList列表数据
     *
     * @param [type] $request URI
     * 
     * @return void
     */
    static function listAjax($request)
    {
        $s_args = parseCommonRequestArgus($request);
        $status = (int)getArrayValue("status", 0, $request);
        $s_type = getArrayValue("s_type", "account", $request);
        $s_key = getArrayValue("s_keyword", "", $request);
        $retJson = gmServerCaller("SearchAgent", array($status, $s_type, $s_key, $s_args[2], $s_args[3]));

        $retJson = getArrayValue(0, array(), $retJson);
        $retSize = (int)getArrayValue("size", 1, $retJson);
        $retData = getArrayValue("data", array(), $retJson);
        $aaData = showAgentListHtml($retData);
        $ret = outputSearchData($retSize, $s_args[4], $s_args[3], $aaData);
        return output($ret, "json");
    }


    /**
     * 修改代理的备注信息
     *
     * @param [type] $request URI参数
     * 
     * @return void
     */
    static function saveRemark($request)
    {
        $agentId = getArrayValue("aid", "", $request);
        $note = getArrayValue("remark", "", $request);

        if (empty($agentId)) {
            return output(array("code"=>500, "Message"=>"参数错误"), "json");
        }

        $retJson = gmServerCaller("ModifyAgentNote", array($agentId, $note));
        
        if (getArrayValue(0, "", $retJson) == 1) {
            $ret = array("code"=>200, "Message"=>getArrayValue(1, "ok", $retJson));
        } else {
            $ret = array("code"=>500, "Message"=>getArrayValue(1, "no error msg", $retJson));
        }
        return output($ret, "json");
    }

    /**
     * 解锁或锁定代理
     *
     * @param [type] $request URI参数
     * 
     * @return void
     */
    static function lockAgent($request)
    {
        $status = (int)getArrayValue("status", 0, $request);
        $agentId = getArrayValue("aid", "", $request);

        if (empty($agentId)) {
            return output(array("code"=>500, "Message"=>"参数错误"), "json");
        }

        if ($status == 2) {
            $retJson = gmServerCaller("LockAgent", array($agentId));
        } else {
            $retJson = gmServerCaller("UnlockAgent", array($agentId));
        }
        
        if (getArrayValue(0, "", $retJson) == 1) {
            $ret = array("code"=>200, "Message"=>getArrayValue(1, "ok", $retJson));
        } else {
            $ret = array("code"=>500, "Message"=>getArrayValue(1, "no error msg", $retJson));
        }
        return output($ret, "json");
    }

    /**
     * 获取代理信息
     *
     * @param [type] $request 参数
     * 
     * @return void
     */
    static function getAgentInfo($request)
    {
        $agentId = getArrayValue("aid", "", $request);

        if (empty($agentId)) {
            return output(array("code"=>500, "Message"=>"参数错误"), "json");
        }

        $retJson = gmServerCaller("GetAgentInfo", array($agentId));
        $retData = getArrayValue(0, array(), $retJson);
        return output(array("data"=>$retData), "json");
    }

    /**
     * 修改后台代理信息
     *
     * @param [type] $request URI
     * 
     * @return void
     */
    static function saveAgentInfo($request)
    {
        $agentId = getArrayValue("aid", "", $request);
        $name = getArrayValue("name", "", $request);
        $phone = getArrayValue("phone", "", $request);
        $email = getArrayValue("email", "", $request);
        $qq = getArrayValue("qq", "", $request);

        if (empty($agentId)) {
            return output(array("code"=>500, "Message"=>"参数错误"), "json");
        }

        $retJson = gmServerCaller("ModifyAgentInfo", array($agentId, $name, $email, $phone, $qq));
        if (getArrayValue(0, "", $retJson) == 1) {
            $ret = array("code"=>200, "Message"=>getArrayValue(1, "ok", $retJson));
        } else {
            $ret = array("code"=>500, "Message"=>getArrayValue(1, "no error msg", $retJson));
        }
        return output($ret, "json");
    }

    /**
     * 修改代理密码
     *
     * @param [type] $request URI参数
     * 
     * @return void
     */
    static function resetpwd($request)
    {
        $agentId = getArrayValue("aid", "", $request);
        $pwd = getArrayValue("pwd", "", $request);

        if (empty($agentId)) {
            return output(array("code"=>500, "Message"=>"参数错误"), "json");
        }

        $retJson = gmServerCaller("ModifyAgentPwd", array($agentId, $pwd));
        if (getArrayValue(0, "", $retJson) == 1) {
            $ret = array("code"=>200, "Message"=>getArrayValue(1, "ok", $retJson));
        } else {
            $ret = array("code"=>500, "Message"=>getArrayValue(1, "no error msg", $retJson));
        }
        return output($ret, "json");
        
    }

    /**
     * 修改代理层级
     *
     * @param [type] $request URI
     * 
     * @return void
     */
    static function changeLayer($request)
    {
        $agentId = getArrayValue("aid", "", $request);
        $layerid = (int)getArrayValue("layerid", 0, $request);

        if (empty($agentId) || empty($layerid)) {
            return output(array("code"=>500, "Message"=>"参数错误"), "json");
        }

        $retJson = gmServerCaller("SetAgentLayer", array($agentId, $layerid));
        
        if (getArrayValue(0, "", $retJson) == 1) {
            $ret = array("code"=>200, "Message"=>getArrayValue(1, "ok", $retJson));
        } else {
            $ret = array("code"=>500, "Message"=>getArrayValue(1, "no error msg", $retJson));
        }
        return output($ret, "json");

    }

    /**
     * 删除域名
     *
     * @param [type] $request URI
     * 
     * @return void
     */
    static function deldomain($request)
    {
        $domainId = getArrayValue("id", "", $request);

        if (empty($domainId)) {
            return output(array("code"=>500, "Message"=>"参数错误"), "json");
        }

        $retJson = gmServerCaller("DeleteAgentDomain", array($domainId));

        if (getArrayValue(0, "", $retJson) == 1) {
            $ret = array("code"=>200, "Message"=>getArrayValue(1, "ok", $retJson));
        } else {
            $ret = array("code"=>500, "Message"=>getArrayValue(1, "no error msg", $retJson));
        }
        return output($ret, "json");
    }

    /**
     * 添加域名
     *
     * @param [type] $request URI
     * 
     * @return void
     */
    static function addDomain($request)
    {
        $agentId = getArrayValue("agent", "", $request);
        $domain = getArrayValue("domain", "", $request);

        if (empty($agentId)) {
            return output(array("code"=>500, "Message"=>"参数错误"), "json");
        }

        $retJson = gmServerCaller("AddAgentDomain", array($agentId, $domain));

        if (getArrayValue(0, "", $retJson) == 1) {
            $ret = array("code"=>200, "Message"=>getArrayValue(1, "ok", $retJson));
        } else {
            $ret = array("code"=>500, "Message"=>getArrayValue(1, "no error msg", $retJson));
        }
        return output($ret, "json");
    }

    
    /**
     * 后台直接创建代理
     *
     * @param [type] $request URI参数
     * 
     * @return void
     */
    static function addAgent($request)
    {
        $aname = getArrayValue("aname", "", $request);
        $apwd = getArrayValue("apwd", "", $request);
        $reapwd = getArrayValue("password1", "", $request);
        $realname = getArrayValue("realname", "", $request);
        $parentId = getArrayValue("parentId", null, $request);
        
        if (empty($aname) || empty($apwd) || empty($reapwd) || $apwd != $reapwd) {
            return output(array("code"=>500, "Message"=>"参数错误"), "json");
        }

        $retJson = gmServerCaller("CreateAgent", array($aname, $apwd, $realname, $parentId));

        if (getArrayValue(0, "", $retJson) == 1) {
            $ret = array("code"=>200, "Message"=>getArrayValue(1, "ok", $retJson));
        } else {
            $ret = array("code"=>500, "Message"=>getArrayValue(1, "no error msg", $retJson));
        }
        return output($ret, "json");
    }


    
}