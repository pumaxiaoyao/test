<?php
namespace App\ViewHelper;

use App\Config\Config;
use App\Controllers\Def;
use App\Core\View;

class PlayerViewHelper extends BaseViewHelper
{

    /**
     * 显示在线玩家的数据
     *
     * @param [type] $OnlineRoles 在线玩家的数据
     * 
     * @return void
     */
    public static function showOnlineRoles($OnlineRoles)
    {
        $retdatas = array();
        for ($x=0;$x<count($OnlineRoles);$x++) {
            $role = $OnlineRoles[$x];
            $account = $role["account"];
            $name = $role["name"];
            $agentId = $role["agentId"];
            $agentName = $role["agentAccount"];
            $roleId = $role["roleId"];
            $companyWinLose = $role["companyWinLose"];
            $loginWay = $role["lastLoginWay"];
            // 构建账号格子Html
            $accountCell = self::makeAccHtml(["account"=>$account]);

            // 构建代理格子Html
            $agentT = [
                "account"=>$account, 
                "roleId"=>$roleId, 
                "agentId"=>$agentId, 
                "agentName"=>$agentName
            ];
            $agentCell = self::makeAgentHtml($agentT);
            
            // 构建玩家组格子Html
            $groupT = [
                "roleId" => $roleId,
                "groupId" => $role["groupId"],
                "groupName" => $role["groupName"],
                "name" => $name,
                "account" => $account
            ];
            $groupCell = self::makeGroupHtml($groupT);
            
            // 构建余额格子Html
            $balanceT = [
                "balance" => $role["balance"],
                "account" => $account
            ];
            $balanceCell = self::makeBalanceHtml($balanceT);
            
            // 构建红利格子Html
            $bonusT = [
                "bonus" => $role["cost"],
                "account" => $account
            ];
            $bonusCell = self::makeBonusHtml($bonusT);

            // 构建取款流水检查格子Html
            $waterCheckCell = self::makeCheckWithDrawHtml(["account"=>$account]);

            // 构建备注格子Html
            $remarkT = [
                "account" => $account,
                "remark" => $role["note"]
            ];
            $remarkCell = self::makeRemarkHtml($remarkT);

            // 构建最近登录IP格子Html
            $lastLoginT = [
                "time" => parseDate($role["lastLoginTime"]),
                "ip" => $role["lastLoginIp"]
            ];
            $lastLoginCell = self::makeIpHtml($lastLoginT);

            // 构建注册IP格子Html
            $registerT = [
                "time" => parseDate($role["joinTime"]),
                "ip" => $role["joinIp"]
            ];
            $registerCell = self::makeIpHtml($registerT);

            // 构建状态格子Html
            $status = $role["status"];
            $statusCell = self::makeStatusHtml(["status"=>$status]);

            // 构建踢号操作格子Html
            $operT = [
                "status" => $status,
                "account" => $account
            ];
            $operCell = self::makeOnlineOperHtml($operT);

            $tmpdata = [
                (string)($x+1), // index
                $accountCell, //account cell inner html
                $name, // user name
                $agentCell, // agent name
                $groupCell, // group name
                $balanceCell, // main balance
                $companyWinLose, // win loss
                $bonusCell, // 成本占用
                $waterCheckCell, //取款限制
                $remarkCell, // 备注
                $lastLoginCell, // 最近登录IP信息
                $registerCell, // 注册IP信息
                $loginWay, // 登录渠道
                $statusCell, // 账号状态处理
                $operCell // 操作格子，踢号+锁定/解锁

            ];
            
            array_push($retdatas, $tmpdata);
        }
        return $retdatas;
    }

    public static function showAllRoles($data)
    {
        $retdatas = array();
        for ($x=0;$x<count($data);$x++) {
            $role = $data[$x];
            $account = $role["account"];
            $name = $role["name"];
            $agentId = $role["agentId"];
            $agentName = $role["agentAccount"];
            $roleId = $role["roleId"];
            $companyWinLose = $role["companyWinLose"];
            $loginWay = $role["lastLoginWay"];

            $checkT = [
                "account"=>$account, 
            ];
            $checkCell = self::makeRoleChecker($checkT);

            // 构建账号格子Html
            $accountCell = self::makeAccHtml(["account"=>$account]);

            // 构建代理格子Html
            $agentT = [
                "account"=>$account, 
                "roleId"=>$roleId, 
                "agentId"=>$agentId, 
                "agentName"=>$agentName
            ];
            $agentCell = self::makeAgentHtml($agentT);
            
            // 构建玩家组格子Html
            $groupT = [
                "roleId" => $roleId,
                "groupId" => $role["groupId"],
                "groupName" => $role["groupName"],
                "name" => $name,
                "account" => $account
            ];
            $groupCell = self::makeGroupHtml($groupT);
            
            // 构建余额格子Html
            $balanceT = [
                "balance" => $role["balance"],
                "account" => $account
            ];
            $balanceCell = self::makeBalanceHtml($balanceT);
            
            // 构建红利格子Html
            $bonusT = [
                "bonus" => $role["cost"],
                "account" => $account
            ];
            $bonusCell = self::makeBonusHtml($bonusT);

            // 构建取款流水检查格子Html
            $waterCheckCell = self::makeCheckWithDrawHtml(["account"=>$account]);

            // 构建备注格子Html
            $remarkT = [
                "account" => $account,
                "remark" => $role["note"]
            ];
            $remarkCell = self::makeRemarkHtml($remarkT);

            // 构建最近登录IP格子Html
            $lastLoginT = [
                "time" => parseDate($role["lastLoginTime"]),
                "ip" => $role["lastLoginIp"]
            ];
            $lastLoginCell = self::makeIpHtml($lastLoginT);

            // 构建注册IP格子Html
            $registerT = [
                "time" => parseDate($role["joinTime"]),
                "ip" => $role["joinIp"]
            ];
            $registerCell = self::makeIpHtml($registerT);

            // 构建状态格子Html
            $status = $role["status"];
            $statusCell = self::makeStatusHtml(["status"=>$status]);

            // 构建踢号操作格子Html
            $operT = [
                "status" => $status,
                "account" => $account
            ];
            $operCell = self::makeAllOperHtml($operT);

            $tmpdata = [
                $checkCell, /// role check 
                $accountCell, //account cell inner html
                $name, // user name
                $agentCell, // agent name
                $groupCell, // group name
                $balanceCell, // main balance
                $companyWinLose, // win loss
                $bonusCell, // 成本占用
                $waterCheckCell, //取款限制
                $remarkCell, // 备注
                $lastLoginCell, // 最近登录IP信息
                $registerCell, // 注册IP信息
                $loginWay, // 登录渠道
                $statusCell, // 账号状态处理
                $operCell // 操作格子，踢号+锁定/解锁

            ];
            
            array_push($retdatas, $tmpdata);
        }
        return $retdatas;
    }

    
    public static function showRegRoles($data)
    {
        $retdatas = array();
        for ($x=0;$x<count($data);$x++) {
            $role = $data[$x];
            $account = $role["account"];
            $name = $role["name"];
            $agentId = $role["agentId"];
            $agentName = $role["agentAccount"];
            $roleId = $role["roleId"];
            $companyWinLose = $role["companyWinLose"];
            $loginWay = $role["lastLoginWay"];

            $checkT = [
                "account"=>$account, 
            ];
            $checkCell = self::makeRoleChecker($checkT);

            // 构建账号格子Html
            $accountCell = self::makeAccHtml(["account"=>$account]);

            // 构建代理格子Html
            $agentT = [
                "account"=>$account, 
                "roleId"=>$roleId, 
                "agentId"=>$agentId, 
                "agentName"=>$agentName
            ];
            $agentCell = self::makeAgentHtml($agentT);
            
            // 构建玩家组格子Html
            $groupT = [
                "roleId" => $roleId,
                "groupId" => $role["groupId"],
                "groupName" => $role["groupName"],
                "name" => $name,
                "account" => $account
            ];
            $groupCell = self::makeGroupHtml($groupT);
            
            // 构建余额格子Html
            $balanceT = [
                "balance" => $role["balance"],
                "account" => $account
            ];
            $balanceCell = self::makeBalanceHtml($balanceT);
            
            // 构建红利格子Html
            $bonusT = [
                "bonus" => $role["cost"],
                "account" => $account
            ];
            $bonusCell = self::makeBonusHtml($bonusT);

            // 构建取款流水检查格子Html
            $waterCheckCell = self::makeCheckWithDrawHtml(["account"=>$account]);

            // 构建备注格子Html
            $remarkT = [
                "account" => $account,
                "remark" => $role["note"]
            ];
            $remarkCell = self::makeRemarkHtml($remarkT);

            // 构建最近登录IP格子Html
            $lastLoginT = [
                "time" => parseDate($role["lastLoginTime"]),
                "ip" => $role["lastLoginIp"]
            ];
            $lastLoginCell = self::makeIpHtml($lastLoginT);

            // 构建注册IP格子Html
            $registerT = [
                "time" => parseDate($role["joinTime"]),
                "ip" => $role["joinIp"]
            ];
            $registerCell = self::makeIpHtml($registerT);

            // 构建状态格子Html
            $status = $role["status"];
            $statusCell = self::makeStatusHtml(["status"=>$status]);

            // 构建踢号操作格子Html
            $operT = [
                "status" => $status,
                "account" => $account
            ];
            $operCell = self::makeRegOperHtml($operT);

            $tmpdata = [
                $x + 1,
                $accountCell, //account cell inner html
                $name, // user name
                $agentCell, // agent name
                $groupCell, // group name
                $balanceCell, // main balance
                $companyWinLose, // win loss
                $bonusCell, // 成本占用
                $waterCheckCell, //取款限制
                $remarkCell, // 备注
                $lastLoginCell, // 最近登录IP信息
                $registerCell, // 注册IP信息
                $loginWay, // 登录渠道
                $statusCell, // 账号状态处理
                $operCell // 操作格子，踢号+锁定/解锁

            ];
            
            array_push($retdatas, $tmpdata);
        }
        return $retdatas;
    }

    public static function showFundFlowHtml($data)
    {
        $retdatas = array();
        
        $statics = [];

        foreach (Config::opTypeMap as $key => $val)
        {
            $statics[$key] = 0;
        }

        for ($x=0;$x<count($data);$x++) {
            $role = $data[$x];
            $account = $role["account"];

            // 构建账号格子Html
            $accountCell = self::makeAccHtml(["account"=>$account]);
            $timeTag = getArrayValue("recordTime", "", $role);
            $amount = (float)getArrayValue("amount", 0, $role);
            $opType = getArrayValue("opType", "", $role);
            $statics[$opType] += $amount;

            $tmpdata = [
                $x + 1,
                $accountCell, //account cell inner html
                $amount,
                Config::opTypeMap[$opType],
                "TODO:来源".getArrayValue("Source", "", $role),
                parseDate($timeTag),
                "TODO:操作人".getArrayValue("Operator2", "", $role),
                $role["note"], // 备注

            ];
            
            array_push($retdatas, $tmpdata);
        }
        return [$retdatas, $statics];
    }

}