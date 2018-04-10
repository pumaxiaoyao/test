<?php
namespace App\ViewHelper;

use App\Config\Config;
use App\Controllers\Def;
use App\Core\View;

class AgentViewHelper extends BaseViewHelper
{
    public static function showAgentVerifyHtml($data)
    {
        $retdatas = array();
        for ($x=0;$x<count($data);$x++) {
            $_data = $data[$x];

            $account = getArrayValue("account", "", $_data);
            
            $joinIp = getArrayValue("joinIp", "", $_data);
            $joinTime = getArrayValue("joinTime", 0, $_data);
            $status = (string)getArrayValue("status", "1", $_data);
            
            $stag = Config::agentStatusMap[$status];

            // 构建上级代理数据
            $pParentId = (int)getArrayValue("pParentId", 1, $_data);
            $parentId = (int)getArrayValue("parentId", 0, $_data);
            $parentAccount = getArrayValue("parentAccount", "", $_data);

            $belongToTags = parseBelongTo($pParentId, $parentId, $parentAccount);


            // 构建代理账号按钮
            $accountT = [
                "agentId" => $_data["roleId"],
                "agentAccount" => $account,
                "type" => 1
            ];
            $accountCell = self::makeAgentAccountHtml($accountT);
            // --------------------------
            $agentOperT = [
                "agentId" => $_data["roleId"],
                "agentAccount" => $account
            ];

            $agentOperCell = self::makeAgentVerifyOperHtml($agentOperT);
            $tmp = array(
                $accountCell,
                $_data["name"],
                $belongToTags[0],
                $belongToTags[1],
                parseDate($joinTime, 4),
                $joinIp,
                $stag,
                $agentOperCell
            );

            $retdatas[] = $tmp;
        }
        return $retdatas;
    }

    public static function showAgentListHtml($retData)
    {
        $aaData = array();
        for ($x=0; $x < count($retData); $x++) {
            $_data = $retData[$x];
            $layerId = getArrayValue("layerId", 0, $_data);
            $agentCode = getArrayValue("roleId", 0, $_data);
            $account = getArrayValue("account", "", $_data);
            $name = getArrayValue("name", "", $_data);
            $joinTime = getArrayValue("joinTime", "", $_data);
            $joinIp = getArrayValue("joinIp", "", $_data);
            $status = (int)getArrayValue("status", 1, $_data);
            $note = getArrayValue("note", "", $_data);
            $checkTime = getArrayValue("checkTime", "", $_data);
            $parentId = (int)getArrayValue("parentId", 0, $_data);
            $lvl = (int)getArrayValue("lvl", 1, $_data);

            if ($lvl == 1) {
                $lv1Parent = "/";
                $lv2Parent = "/";
            } else if ($lvl == 2) {
                $lv1Parent = $parentId;
                $lv2Parent = "/";
            } else if ($lvl == 3) {
                $lv1Parent = "/";
                $lv2Parent = $parentId;
            } else {
                $lv1Parent = "lvl参数错误";
                $lv2Parent = "lvl参数错误";
            }
            
                
            $layerName = getArrayValue("layerName", "无", $_data);

            $pParentId = (int)getArrayValue("pParentId", 1, $_data);
            $parentId = (int)getArrayValue("parentId", 0, $_data);
            $parentAccount = getArrayValue("parentAccount", "", $_data);

            $belongToTags = parseBelongTo($pParentId, $parentId, $parentAccount);
                
             // 构建代理账号按钮
             $accountT = [
                "agentId" => $agentCode,
                "agentAccount" => $account,
                "type" => 2
            ];
            $accountCell = self::makeAgentAccountHtml($accountT);

            // 构建代理备注
            $noteT = [
                "agentId" => $agentCode,
                "note" => $note
            ];
            $noteCell = self::makeAgentNoteHtml($noteT);

            // 构建代理操作按钮
            $operT = [
                "agentId" => $agentCode,
                "status" => $status,
                "agentName" => $name,
                "layerId" => $layerId
            ];
            $operCell = self::makeAgentlistOperHtml($operT);
            
            $tmp = array(
                $x + 1,
                $accountCell,
                "<span id='realname'>".$name."</span>",
                $layerName,
                $belongToTags[0],
                $belongToTags[1],
                $agentCode,
                parseDate($joinTime),
                $joinIp,
                $noteCell,
                Config::agentStatusMap[$status],
                $operCell
            );
            $aaData[] = $tmp;
        }
        return $aaData;
    }

    public static function showVerifyHistory($retData)
    {
        $aaData = array();
        usort(
            $retData, function ($a, $b) { 
                    return (int)$a["roleId"] -(int)$b["roleId"]; 
            }
        );
        foreach ($retData as $_data) {
            $layerName = getArrayValue("layerName", "无", $_data);
            $agentCode = getArrayValue("roleId", 0, $_data);
            $account = getArrayValue("account", "", $_data);
            $name = getArrayValue("name", "", $_data);
            $joinTime = getArrayValue("joinTime", "", $_data);
            $joinIp = getArrayValue("joinIp", "", $_data);
            $status = (int)getArrayValue("status", 1, $_data);
            $note = getArrayValue("note", "", $_data);
            $checkTime = getArrayValue("checkTime", "", $_data);
             // 构建代理账号按钮
             $accountT = [
                "agentId" => $agentCode,
                "agentAccount" => $account,
                "type" => 2
            ];
            $accountCell = self::makeAgentAccountHtml($accountT);

            $tmp = array(
                $agentCode,
                $accountCell,
                $name,
                $layerName,
                parseDate($joinTime, 4),
                $joinIp,
                Config::agentStatusMap[$status],
                $note,
                parseDate($checkTime, 4),
            );
            $aaData[] = $tmp;
        }
        return $aaData;
    }

    public static function showDomainHtml($retData)
    {
        $aaData = [];

        for ($x=0; $x < count($retData); $x++) {
            $_data = $retData[$x];
            $domainId = getArrayValue("id", 0, $_data);
            $agentCode = (int)getArrayValue("roleId", 0, $_data);
            $account = getArrayValue("account", "", $_data);
            $domain = getArrayValue("domain", "", $_data);
            $createTime = getArrayValue("createTime", "", $_data);

            // 构建代理账号按钮
            $accountT = [
                "agentId" => $agentCode,
                "agentAccount" => $account,
                "type" => 2
            ];
            $accountCell = self::makeAgentAccountHtml($accountT);

            // 构建Domain操作按钮
            $operT = [
                "domainId" => $domainId,
                "domain" => $domain
            ];
            $operCell = self::makeDomainOperHtml($operT);
            $tmp = array(
                $x,
                $accountCell,
                $agentCode,
                $domain,
                parseDate($createTime),
                $operCell
            );
            $aaData[] = $tmp;
        }
        return $aaData;
    }
}