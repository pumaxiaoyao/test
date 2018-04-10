<?php
namespace App\ViewHelper;
use App\Config\Config;

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
                $act['type'],
                '<div  id="status_'. $actId .'">' . Config::actStatusTransMap[$act['status']] . '</div>',
                "<div style=\"width:150px;word-break:break-all;word-wrap:break-word;\">" . $act["agentCodes"] . "</div>",
                $act["groupNames"],
                $act['timesLimit'],
                $act['orderVal'],
                $act['created_at'],
                $actCell,
            );

            array_push($retdatas, $tmpdata);
        }

        return $retdatas;
    }

}
