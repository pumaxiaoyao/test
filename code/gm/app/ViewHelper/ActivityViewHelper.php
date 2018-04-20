<?php
namespace App\ViewHelper;
use App\Config\Config;
use App\Core\View;
class ActivityViewHelper extends BaseViewHelper
{

    /**
     * 代理资金结算的数据界面
     *
     * @param [type] $retData 数据
     *
     * @return void
     */
    public static function makeActivityHtml($datas)
    {
        $retdatas = [];
        for ($x = 0; $x < count($datas); $x++) {
            $act = $datas[$x];
            $actId = $act['id'];
            $actT = [
                "actId" => $actId
            ];
            $actCell = self::makeActListOperHtml($actT);

            
            $tmpdata = array(
                $x + 1,
                $act["name"],
                '',
                '<div  id="status_'. $actId .'">' . Config::actStatusTransMap[$act['status']] . '</div>',
                "<div style=\"width:150px;word-break:break-all;word-wrap:break-word;\">" . $act['agentStr'] . "</div>",
                $act['groupStr'],
                $act['timesLimit'],
                $act['orderVal'],
                date('Y-m-d H:i:s',$act['createTime']),
                $actCell,
            );

            array_push($retdatas, $tmpdata);
        }

        return $retdatas;
    }

    public static function makeActivityVerifyHtml($data)
    {
        $retdatas = [];
        for ($x = 0; $x < count($data); $x++) {
            $ret = $data[$x];

            // 构建checker-col
            $checkT = [
                "dno" => $ret["dno"]
            ];
            $checkCell = self::makeDnoCheckHtml($checkT);
            // 构建玩家账号
            $accountT = [
                "account" => $ret["account"]
            ];
            $accountCell = self::makeAccHtml($accountT);
            // 构建操作按钮
            $actT = [
                "dno" => $ret["dno"],
                "account" => $ret["account"]
            ];
            $factory = View::getView();
            $actCell = $factory->make('Common.activity.activityVerifyOperCell', $actT)
                    ->render();
            
            $retdatas[] = [ 
                $checkCell, // dno checker
                $x + 1, // index number
                $accountCell, // account detail button
                $ret["name"],
                $ret["agentAccount"],
                $ret["activityName"],
                "", //$ret["actType"],
                parseDate($ret["recordTime"]),
                Config::statusMap[$ret["status"]],
                $actCell
            ];
        }
        return $retdatas;
    }

    public static function makeActivityVerifyHistoryHtml($data)
    {
        $retdatas = [];
        for ($x = 0; $x < count($data); $x++) {
            $ret = $data[$x];

            // 构建checker-col
            $checkT = [
                "dno" => $ret["dno"]
            ];
            $checkCell = self::makeDnoCheckHtml($checkT);
            // 构建玩家账号
            $accountT = [
                "account" => $ret["account"]
            ];
            $accountCell = self::makeAccHtml($accountT);
            // 构建操作按钮
            $resultT = [
                "存款金额: 0.00" , // 未提交相关数据
                "红利金额: " . $ret["bonusAmount"], //红利金额
                "取款流水: 红利：+" . $ret["bonusAmount"] . ", 取款流水: +". $ret["withdrawalLimitAmount"],
            ];
            
            $retdatas[] = [
                $x + 1, // index number
                $accountCell, // account detail button
                $ret["name"],
                $ret["agentAccount"],
                $ret["activityName"],
                parseDate($ret["recordTime"]),
                Config::statusMap[$ret["status"]] . "<br/>" .$ret["note"],
                join("<br/>", $resultT)
            ];
        }
        return $retdatas;
    }

    public static function makeActivityFundHtml($data)
    {
        error_reporting(~E_ALL);

        $retdatas = [];
        for ($x = 0; $x < count($data); $x++) {
            $ret = $data[$x];

            $retdatas[] = [
                '<a href="/activity/activityHistory?actid='.$ret["activityId"].'">'. $ret["activityName"].'</a>', // index number
                $ret["playerCount"] or 0, //未提供支持
                $ret["count"], // account detail button
                0, //存款总额
                $ret["bonusAmount"],
                Config::actStatusTransMap[$ret["actStatus"]],
                date('Y-m-d H:i:s',$ret['createTime']),
            ];
        }
        return $retdatas;
    }
}
