<?php
namespace App\Controllers;

use App\Config\Config;
use App\Libs\HttpRequest as http;

use App\ViewHelper\SettingViewHelper as viewHelper;

class SettingAPIController extends BaseController
{

    public static function getPlayerLevels($request)
    {
        $ret = self::getGroupConfig(true);
        $ret["gps"] = Config::platform;
        $ret["banks"] = array("data" => array(
            array("CODE" => "newdinpay", "ID" => 3000, "BANKNAME" => "制服诱惑", "NAME" => "村花", "CARD" => "6226 4656 9584 5456", "REGBANK" => "天上人间", "DESC" => "存款", "TYPE" => "三方"),
            array("CODE" => "oldPay", "ID" => 4000, "BANKNAME" => "黑丝长腿", "NAME" => "小红", "CARD" => "6256 5648 6597 1452", "REGBANK" => "海天盛筵", "DESC" => "存款", "TYPE" => "三方"),
        ));
        return $ret;
    }

    /**
     * 获取系统的玩家组配置数据
     *
     * @return void
     */
    public function getGroupConfig($needFresh = false)
    {
        if ($needFresh) {
            unset($_SESSION["PLayerGroupConfig"]);
            return self::refreshGroupsData();
        }
        if (!isset($_SESSION["PLayerGroupConfig"])) {
            return self::refreshGroupsData();
        } else {
            return $_SESSION["PLayerGroupConfig"];
        }
    }

    /**
     * 请求后台获得玩家组配置
     *
     * @return void
     */
    public static function refreshGroupsData()
    {
        $retJson = http::gmHttpCaller("GetAllPlayerGroup", array());
        $groupData = getArrayValue(0, array(), $retJson);
        $defaultGroupID = getArrayValue(1, "", $retJson);
        $ret = array("t1" => array(), "t2" => array());
        $_SESSION["layerSetting"] = array();
        foreach ($groupData as $key => $_val) {
            $tt = getArrayValue("lastModifyTime", "", $_val);
            $groupId = getArrayValue("id", 0, $_val);
            $_val["lastModifyTime"] = parseDate($tt);
            // $_val["id"] = (int)$key + 1;
            if (!empty($defaultGroupID) && $defaultGroupID == $groupId) {
                $_val["isDefault"] = 1;
            } else {
                $_val["isDefault"] = 0;
            }

            $_val["note"] = parseNote($_val["note"]);
            if (getArrayValue("isValid", "", $_val) == 1) {
                array_push($ret["t1"], $_val);
            } else {
                array_push($ret["t2"], $_val);
            }
            $_SESSION["layerSetting"][$groupId] = json_decode(getArrayValue("layerSetting", "[]", $_val), true);
        }
        $t1 = $ret["t1"];
        usort(
            $t1, function ($a, $b) {
                return (int) $a["orderVal"] - (int) $b["orderVal"];
            }
        );
        $ret["t1"] = $t1;

        $t2 = $ret["t2"];
        usort(
            $t2, function ($a, $b) {
                return (int) $a["orderVal"] - (int) $b["orderVal"];
            }
        );
        $ret["t2"] = $t2;
        $_SESSION["PLayerGroupConfig"] = $ret;
        return $ret;
    }

    public static function editPlayerLevels($request)
    {
        $groupId = getArrayValue("groupid", "0", $request);
        $name = getArrayValue("name", "", $request);
        $note = parseNote(getArrayValue("remark", "", $request));
        $showIdx = (int) getArrayValue("displayorder", 0, $request);
        $isDefault = (int) getArrayValue("isdefault", 0, $request);
        $isValid = (int) getArrayValue("status", 0, $request);
        $action = getArrayValue("action", "", $request);
        $isDefault = $isDefault === 1 ? true : false;
        $isValid = $isValid === 1 ? true : false;

        if ($groupId === "" || $name === "") {
            return ["c" => 400, "m" => "参数错误"];
        }

        if ($action === "add") {
            $retJson = http::gmHttpCaller("CreatePlayerGroup", array($name, $note, $isDefault, $isValid, $showIdx));
        } else {
            $retJson = http::gmHttpCaller("ModifyPlayerGroup", array($groupId, $name, $note, $isDefault, $isValid, $showIdx));
        }

        if (getArrayValue(0, "", $retJson) == 1) {
            unset($_SESSION["PLayerGroupConfig"]); //当有新增或修改的时候，都需要刷新全局的玩家组配置
            return ["c" => 0, "m" => ""];
        } else {
            return ["c" => 500, "m" => "error"];
        }
    }

    /**
     * 修改系统配置的玩家组数据
     *
     * @param [type] $request URI参数
     *
     * @return void
     */
    public static function setPlayerLevelAttrs($request)
    {
        $requestGroupID = getArrayValue("groupId", 0, $request);
        $reqAttrStr = getArrayValue("attr", "", $request);
        $retJson = http::gmHttpCaller("SetPlayerGroupLayerSetting", array($requestGroupID, $reqAttrStr));

        if (getArrayValue(0, "", $retJson) == 1) {
            return ["c" => 0, "m" => "successful", "d" => null];
        } else {
            return ["c" => 404, "m" => "error", "d" => null];
        }
    }

    public static function getAgentLayer($request)
    {
        $retJson = http::gmHttpCaller("GetAllAgentLayer", array());
        $retData = getArrayValue(0, array(), $retJson);
        usort(
            $retData, function ($a, $b) {
                return (int) getArrayValue("orderVal", "", $a)
                 - (int) getArrayValue("orderVal", "", $b);
            }
        );
        return $retData;
    }

    /**
     * 保存抽佣结算分摊
     *
     * @param [type] $request URI参数
     *
     * @return void
     */
    public static function saveApportion($request)
    {
        $layerid = getArrayValue("layerid", "", $request);
        $depositType = getArrayValue("dt", "", $request);
        $depositAmount = getArrayValue("dts", "", $request);
        $rebateType = getArrayValue("rt", "", $request);
        $rebateAmount = getArrayValue("rts", "", $request);
        $bonusType = getArrayValue("bt", "", $request);
        $bonusAmount = getArrayValue("bts", "", $request);
        $linefeeType = getArrayValue("lt", "", $request);
        $linefeeAmount = getArrayValue("lts", "", $request);
        $validBetAmount = getArrayValue("vb", "", $request);
        $validMemberCount = getArrayValue("vc", "", $request);
        $floatStr = getArrayValue("fs", "", $request);
        $lineFloatStr = getArrayValue("lfs", "", $request);

        $costAllocatingConfig = array(
            "depositBonusRateType" => (int) $depositType,
            "depositBonusFixedRate" => (float) $depositAmount,
            "rebateRateType" => (int) $rebateType,
            "rebateFixedRate" => (float) $rebateAmount,
            "bonusRateType" => (int) $bonusType,
            "bonusFixedRate" => (float) $bonusAmount,
            "lineChargeRateType" => (int) $linefeeType,
            "lineChargeFixedRate" => (float) $linefeeAmount,
            "lineChargeFloatRate" => parseFloatStr($lineFloatStr),
            "validPlayerStakeMin" => (float) $validBetAmount,
            "validPlayerCountMin" => (float) $validMemberCount,
        );
        $retJson = http::gmHttpCaller("SetAgentLayerCostAllocatingSetting", array($layerid, json_encode($costAllocatingConfig)));
        if (getArrayValue(0, "", $retJson) == 1) {
            $ret = array("code" => 200, "Message" => "对了的");
        } else {
            $ret = array("code" => 500, "Message" => "出错了，请联系客服");
        }
        return $ret;
    }

    /**
     * 保存抽佣/抽水设置
     *
     * @param [type] $request URI参数
     *
     * @return void
     */
    public static function saveBrokerage($request)
    {
        $layerid = getArrayValue("layerid", "", $request);
        $floatStr = getArrayValue("cfs", "", $request);
        $games = json_decode(getArrayValue("game", array(), $request), true);

        if (empty($layerid)) {
            return output(array("code" => 500, "Message" => "出错了，请联系客服"), "json");
        }
        $commisionConfig = array(
            "pumpingCommisionFloatRate" => parseFloatStr($floatStr),
            "game" => array(),
        );

        if (count($games) > 0) {
            foreach ($games as $_game => $_data) {
                $ct = (int) getArrayValue("ct", 0, $_data);
                $commisionConfig["game"][$_game] = array();
                $commisionConfig["game"][$_game]["pumpingCommisionRateType"] = $ct;
                if ($ct == 1) {
                    $cts = (float) getArrayValue("cts", 0, $_data);
                    $cts = (1 >= $cts && $cts >= 0) ? $cts : 0;
                    $commisionConfig["game"][$_game]["pumpingCommisionFixedRate"] = $cts;
                }

                $wt = (int) getArrayValue("wt", 0, $_data);
                $commisionConfig["game"][$_game]["pumpingWaterRateType"] = $wt;
                if ($wt == 1) {
                    $wts = (float) getArrayValue("wts", 0, $_data);
                    $wts = (1 >= $wts && $wts >= 0) ? $wts : 0;
                    $commisionConfig["game"][$_game]["pumpingWaterFixedRate"] = $wts;
                } else if ($wt == 2) {
                    $commisionConfig["game"][$_game]["pumpingWaterFloatRate"] = parseFloatStr(getArrayValue("wfs", "", $_data));
                }
            }
        }

        $retJson = http::gmHttpCaller("SetAgentLayerCommisionSetting", array($layerid, json_encode($commisionConfig)));

        if (getArrayValue(0, "", $retJson) == 1) {
            $_SESSION["BrokerageSetting"][$layerid] = $commisionConfig;
            $ret = array("code" => 200, "Message" => "对了的");
        } else {
            $ret = array("code" => 500, "Message" => "出错了，请联系客服");
        }
        return $ret;
    }


}
