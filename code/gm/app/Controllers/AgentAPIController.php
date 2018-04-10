<?php
namespace App\Controllers;

use App\Config\Config;
use App\Libs\HttpRequest as http;
use App\ViewHelper\AgentViewHelper as viewHelper;


class AgentAPIController extends BaseController
{
    public static function searchAgentX($request)
    {
        $skey = $request["q"];
        return http::gmHttpCaller("SearchAgentX", array($skey));
    }

    public static function verifyAjax($request)
    {
        $s_args = parseCommonRequestArgus($request);
        $s_type = getArrayValue("s_type", "account", $request);
        $s_key = getArrayValue("s_keyword", "", $request);
        $retJson = http::gmHttpCaller("GetAgentCheck", array($s_type, $s_key, $s_args[2], $s_args[3]));

        $retJson = getArrayValue(0, array(), $retJson);
        $retSize = (int) getArrayValue("size", 0, $retJson);
        $retData = getArrayValue("data", array(), $retJson);
        
        return [
            "sEcho" => $s_args[4],
            "iTotalRecords" => $retSize,
            "iTotalDisplayRecords" => $retSize, //floor($sSize / $sCount), //取整，用于页数
            "aaData" => viewHelper::showAgentVerifyHtml($retData), 
            "total" => 0
        ];
    }

    public static function getAgentInfo($request)
    {
        $retJson = http::gmHttpCaller("GetAgentInfo", [$request["id"]]);
        
        $retData = getArrayValue(0, [], $retJson);
        
        $domainData = getArrayValue(1, [], $retJson);

        $status = (string)getArrayValue("status", "1", $retData);
        $pParentId = (int)getArrayValue("pParentId", 1, $retData);
        $parentId = (int)getArrayValue("parentId", 0, $retData);
        $parentAccount = getArrayValue("parentAccount", "", $retData);
        $belongToTags = parseBelongTo($pParentId, $parentId, $parentAccount);
        
        $stag = Config::agentStatusMap[$status];
        $domainInfo = viewHelper::makeDomainHtml(["domains"=>$domainData]);

        return [
            "account" => $retData["account"],
            "name" => $retData["name"],
            "email" => $retData["email"],
            "agentCode" => $retData["roleId"],
            "agentLevel" => $retData["layerName"],
            "belongTo1st" => $belongToTags[0],
            "belongTo2rd" => $belongToTags[1],
            "regTime" => parseDate(getArrayValue("joinTime", 0, $retData)),
            "regIp" => $retData["joinIp"],
            "lastLoginTime" => parseDate(getArrayValue("lastLoginTime", 0, $retData)),
            "status" => $stag,
            "cellPhoneNo" => $retData["cellPhoneNo"],
            "qq" => $retData["qq"],
            "domainInfo" => $domainInfo
        ];
    }

    public static function agentVerify($request)
    {
        $agentid = getArrayValue("agentid", "", $request);
        $layerid = getArrayValue("layerid", "", $request);
        $note = getArrayValue("note", "", $request);
        $status = getArrayValue("status", "", $request);

        if (empty($agentid) || empty($layerid) || empty($note) || empty($status)) {
            return [false, "argus error."];
        }

        if ($status == "1") {
            $retJson = http::gmHttpCaller("AgentCheckAgree", array($agentid, $layerid, $note));
        } else {
            $retJson = http::gmHttpCaller("AgentCheckRefuse", array($agentid, $note));
        }

        if (getArrayValue(0, "", $retJson) == 1) {
            return [true];
        } else {
            return [false, getArrayValue(1, "no error msg", $retJson)];
        }
    }
    
    public static function listAjax($request)
    {
        $s_args = parseCommonRequestArgus($request);
        $status = (int)getArrayValue("status", 0, $request);
        $s_type = getArrayValue("s_type", "account", $request);
        $s_key = getArrayValue("s_keyword", "", $request);
        $retJson =  http::gmHttpCaller("SearchAgent", array($status, $s_type, $s_key, $s_args[2], $s_args[3]));

        $retJson = getArrayValue(0, array(), $retJson);
        $retSize = (int) getArrayValue("size", 0, $retJson);
        $retData = getArrayValue("data", array(), $retJson);
        
        return [
            "sEcho" => $s_args[4],
            "iTotalRecords" => $retSize,
            "iTotalDisplayRecords" => $retSize, //floor($sSize / $sCount), //取整，用于页数
            "aaData" => viewHelper::showAgentListHtml($retData)
        ];

    }

    public static function saveRemark($request)
    {
        $agentId = getArrayValue("aid", "", $request);
        $note = getArrayValue("remark", "", $request);

        if (empty($agentId)) {
            return ["code"=>500, "Message"=>"参数错误"];
        }

        $retJson = http::gmHttpCaller("ModifyAgentNote", array($agentId, $note));
        
        if (getArrayValue(0, "", $retJson) == 1) {
            $ret = ["code"=>200, "Message"=>getArrayValue(1, "ok", $retJson)];
        } else {
            $ret = ["code"=>500, "Message"=>getArrayValue(1, "no error msg", $retJson)];
        }
        return $ret;
    }

    public static function lockAgent($request)
    {
        $status = (int)getArrayValue("status", 0, $request);
        $agentId = getArrayValue("aid", "", $request);

        if (empty($agentId)) {
            return ["code"=>500, "Message"=>"参数错误"];
        }

        if ($status == 2) {
            $retJson = http::gmHttpCaller("LockAgent", array($agentId));
        } else {
            $retJson = http::gmHttpCaller("UnlockAgent", array($agentId));
        }
        
        if (getArrayValue(0, "", $retJson) == 1) {
            $ret = ["code"=>200, "Message"=>getArrayValue(1, "ok", $retJson)];
        } else {
            $ret = ["code"=>500, "Message"=>getArrayValue(1, "no error msg", $retJson)];
        }
        return $ret;
    }

    public static function saveAgentInfo($request)
    {
        $agentId = getArrayValue("aid", "", $request);
        $name = getArrayValue("name", "", $request);
        $phone = getArrayValue("phone", "", $request);
        $email = getArrayValue("email", "", $request);
        $qq = getArrayValue("qq", "", $request);

        if (empty($agentId)) {
            return ["code"=>500, "Message"=>"参数错误"];
        }

        $retJson = http::gmHttpCaller("ModifyAgentInfo", array($agentId, $name, $email, $phone, $qq));
        if (getArrayValue(0, "", $retJson) == 1) {
            $ret = ["code"=>200, "Message"=>getArrayValue(1, "ok", $retJson)];
        } else {
            $ret = ["code"=>500, "Message"=>getArrayValue(1, "no error msg", $retJson)];
        }
        return $ret;
    }

    public static function resetpwd($request)
    {
        $agentId = getArrayValue("aid", "", $request);
        $pwd = getArrayValue("pwd", "", $request);

        if (empty($agentId)) {
            return ["code"=>500, "Message"=>"参数错误"];
        }

        $retJson = http::gmHttpCaller("ModifyAgentPwd", array($agentId, $pwd));
        if (getArrayValue(0, "", $retJson) == 1) {
            $ret = ["code"=>200, "Message"=>getArrayValue(1, "ok", $retJson)];
        } else {
            $ret = ["code"=>500, "Message"=>getArrayValue(1, "no error msg", $retJson)];
        }
        return $ret;
        
    }


    public static function changeLayer($request)
    {
        $agentId = getArrayValue("aid", "", $request);
        $layerid = (int)getArrayValue("layerid", 0, $request);

        if (empty($agentId) || empty($layerid)) {
            return ["code"=>500, "Message"=>"参数错误"];
        }

        $retJson = http::gmHttpCaller("SetAgentLayer", array($agentId, $layerid));
        
        if (getArrayValue(0, "", $retJson) == 1) {
            $ret = ["code"=>200, "Message"=>getArrayValue(1, "ok", $retJson)];
        } else {
            $ret = ["code"=>500, "Message"=>getArrayValue(1, "no error msg", $retJson)];
        }
        return $ret;
    }

    public static function addAgent($request)
    {
        $aname = getArrayValue("aname", "", $request);
        $apwd = getArrayValue("apwd", "", $request);
        $reapwd = getArrayValue("password1", "", $request);
        $realname = getArrayValue("realname", "", $request);
        $parentId = getArrayValue("parentId", null, $request);
        
        if (empty($aname) || empty($apwd) || empty($reapwd) || $apwd != $reapwd) {
            return ["code"=>500, "Message"=>"参数错误"];
        }

        $retJson = http::gmHttpCaller("CreateAgent", array($aname, $apwd, $realname, $parentId));

        if (getArrayValue(0, "", $retJson) == 1) {
            $ret = ["code"=>200, "Message"=>getArrayValue(1, "ok", $retJson)];
        } else {
            $ret = ["code"=>500, "Message"=>getArrayValue(1, "no error msg", $retJson)];
        }
        return $ret;
    }

    public static function verifyHistoryAjax($request)
    {
        $s_args = parseCommonRequestArgus($request);
        $s_type = getArrayValue("s_type", "account", $request);
        $s_key  = getArrayValue("s_keyword", "", $request);
        $retJson = http::gmHttpCaller("GetAgentCheckRecord", array($s_type, $s_key, $s_args[2], $s_args[3]));

        $retJson = getArrayValue(0, array(), $retJson);
        $retSize = (int) getArrayValue("size", 0, $retJson);
        $retData = getArrayValue("data", array(), $retJson);
        
        return [
            "sEcho" => $s_args[4],
            "iTotalRecords" => $retSize,
            "iTotalDisplayRecords" => $retSize, //floor($sSize / $sCount), //取整，用于页数
            "aaData" => viewHelper::showVerifyHistory($retData)
        ];
    }

    public static function domainAjax($request)
    {
        $s_args = parseCommonRequestArgus($request);
        $s_type = getArrayValue("type", "", $request);
        $s_key = getArrayValue("keywords", "", $request);

        $retJson = http::gmHttpCaller("GetAgentDomain", array($s_type, $s_key));
        $retJson = getArrayValue(0, [], $retJson);
        $retSize = count($retJson);
        
        return [
            "sEcho" => $s_args[4],
            "iTotalRecords" => $retSize,
            "iTotalDisplayRecords" => $retSize, //floor($sSize / $sCount), //取整，用于页数
            "aaData" => viewHelper::showDomainHtml($retJson)
        ];
    }

    public static function deldomain($request)
    {
        $domainId = getArrayValue("id", "", $request);

        if (empty($domainId)) {
            return ["code"=>500, "Message"=>"参数错误"];
        }

        $retJson = http::gmHttpCaller("DeleteAgentDomain", array($domainId));

        if (getArrayValue(0, "", $retJson) == 1) {
            $ret = ["code"=>200, "Message"=>getArrayValue(1, "ok", $retJson)];
        } else {
            $ret = ["code"=>500, "Message"=>getArrayValue(1, "no error msg", $retJson)];
        }
        return $ret;
    }

    public static function addDomain($request)
    {
        $agentId = getArrayValue("agent", "", $request);
        $domain = getArrayValue("domain", "", $request);

        if (empty($agentId)) {
            return ["code"=>500, "Message"=>"参数错误"];
        }

        $retJson = http::gmHttpCaller("AddAgentDomain", array($agentId, $domain));

        if (getArrayValue(0, "", $retJson) == 1) {
            $ret = ["code"=>200, "Message"=>getArrayValue(1, "ok", $retJson)];
        } else {
            $ret = ["code"=>500, "Message"=>getArrayValue(1, "no error msg", $retJson)];
        }
        return $ret;
    }
}