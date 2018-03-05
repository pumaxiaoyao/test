<?php
/**
 * Settings的API接口trait，用于提供给Js_Ajax请求的方法定义
 *
 * @category Application/controllers/settings
 * @package  Settings
 * @author   alien <alien@alien.com>
 * @license  http://license.alien.com/license, alien
 * @link     null
 */

/**
 * Settings的API接口trait，用于提供给Js_Ajax请求的方法定义
 *
 * @category Application/controllers/settings
 * @package  Settings
 * @author   alien <alien@alien.com>
 * @license  http://license.alien.com/license, alien
 * @link     null
 */
trait SettingsTrait
{

    /**
     * 获取系统配置的玩家组数据
     *
     * @param [type] $request URI参数
     *
     * @return void
     */
    public static function getPlayerLevels($request)
    {
        $ret = getGroupConfig(true);
        $ret["gps"] = array("data" => array(array("name" => "沙巴体育", "code" => "sport"), array("name" => "牛博游戏", "code" => "nbGame")));
        $ret["banks"] = array("data" => array(
            array("CODE" => "newdinpay", "ID" => 3000, "BANKNAME" => "制服诱惑", "NAME" => "村花", "CARD" => "6226 4656 9584 5456", "REGBANK" => "天上人间", "DESC" => "存款", "TYPE" => "三方"),
            array("CODE" => "oldPay", "ID" => 4000, "BANKNAME" => "黑丝长腿", "NAME" => "小红", "CARD" => "6256 5648 6597 1452", "REGBANK" => "海天盛筵", "DESC" => "存款", "TYPE" => "三方"),
        ));
        return output($ret, "json");
    }

    /**
     * 修改系统配置的玩家组数据
     *
     * @param [type] $request URI参数
     *
     * @return void
     */
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
            return output(array("c" => 400, "m" => "参数错误"), "json");
        }

        if ($action === "add") {
            $retJson = gmServerCaller("CreatePlayerGroup", array($name, $note, $isDefault, $isValid, $showIdx));
        } else {
            $retJson = gmServerCaller("ModifyPlayerGroup", array($groupId, $name, $note, $isDefault, $isValid, $showIdx));
        }

        if (getArrayValue(0, "", $retJson) == 1) {
            unset($_SESSION["PLayerGroupConfig"]); //当有新增或修改的时候，都需要刷新全局的玩家组配置
            return output(array("c" => 0, "m" => ""), "json");
        } else {
            return output(array("c" => 500, "m" => "error"), "json");
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
        $retJson = gmServerCaller("SetPlayerGroupLayerSetting", array($requestGroupID, $reqAttrStr));

        if (getArrayValue(0, "", $retJson) == 1) {
            return output(array("c" => 0, "m" => "successful", "d" => null), "json");
        } else {
            return output(array("c" => 404, "m" => "error", "d" => null), "json");
        }
    }

    /**
     * 保存处理玩家层级的返水设置
     *
     * @param [type] $request URI
     *
     * @return void
     */
    public static function saveWaterConfig($request)
    {
        $requestLayerID = getArrayValue("layerid", 0, $request);
        $requestGPID = getArrayValue("gpid", "", $request);
        $requestRebateRate = getArrayValue("rrate", 0, $request);
        $requestStepCond = getArrayValue("stepcond", "", $request);
        $jsonCond = parseFloatStr($requestStepCond);

        $retJson = gmServerCaller("SetPlayerLayerRebate", array($requestLayerID, $requestGPID, $requestRebateRate, json_encode($jsonCond)));

        if (getArrayValue(0, "", $retJson) == 1) {
            return output(array("c" => 0, "m" => "", "d" => null), "json");
        } else {
            return output(array("c" => 404, "m" => "error", "d" => null), "json");
        }
    }

    /**
     * 查询玩家层级银行卡
     *
     * @param [type] $request URI
     *
     * @return void
     */
    public static function getLayerBankCard($request)
    {
        $requestLayerID = getArrayValue("groupid", "0", $request);
        $requestGPName = getArrayValue("groupname", "", $request);

        $retJson = gmServerCaller("GetPlayerLayerBankCard", array($requestLayerID));
        $retData = getArrayValue(0, array(), $retJson);
        $banks = array(
            array("CODE" => "newdinpay", "ID" => 3000, "BANKNAME" => "制服诱惑", "NAME" => "村花", "CARD" => "6226 4656 9584 5456", "REGBANK" => "天上人间", "DESC" => "存款", "TYPE" => "三方"),
            array("CODE" => "oldPay", "ID" => 4000, "BANKNAME" => "黑丝长腿", "NAME" => "小红", "CARD" => "6256 5648 6597 1452", "REGBANK" => "海天盛筵", "DESC" => "存款", "TYPE" => "三方"),
        );

        $allHtml = "";
        foreach ($banks as $key => $val) {

            $html = "<tr><td><input name=bankcard code='" . $val["CODE"] . "' bcid='" . $val["ID"] . "' layerid='" . $requestLayerID . "' type='checkbox'";
            if (in_array($val["CODE"], $retData)) {
                $html .= "checked ></td>";
            } else {
                $html .= "></td>";
            }
            $html .= "<td>" . $val["BANKNAME"] . "</td>";
            $html .= "<td>" . $val["NAME"] . "</td>";
            $html .= "<td>" . $val["CARD"] . "</td>";
            $html .= "<td>" . $val["REGBANK"] . "</td>";
            $html .= "<td>" . $val["DESC"] . "</td>";
            $html .= "<td>" . $val["TYPE"] . "</td></tr>";

            $allHtml .= $html;
        }
        $ret = array("html" => $allHtml, "name" => $requestGPName);
        return output($ret, "json");
    }

    /**
     * 设置层级银行卡
     *
     * @param [type] $request URI
     *
     * @return void
     */
    public static function setLayerBankCard($request)
    {
        $requestLayerID = getArrayValue("layerid", "", $request);
        $reqBankCard = getArrayValue("bankcode", "", $request);

        $retJson = gmServerCaller("SetPlayerLayerBankCard", array($requestLayerID, explode(",", $reqBankCard)));
        if (getArrayValue(0, "", $retJson) == 1) {
            return output(array("c" => 0, "m" => "", "d" => null), "json");
        } else {
            return output(array("c" => 404, "m" => "error", "d" => null), "json");
        }

    }

    /**
     * 修改系统配置的代理层级数据
     *
     * @param [type] $request URI参数
     *
     * @return void
     */
    public static function editAgentLevel($request)
    {
        $action = getArrayValue("action", "add", $request);
        $layerid = getArrayValue("layerid", "0", $request);
        $groupid = getArrayValue("groupid", "0", $request);
        $name = getArrayValue("name", "", $request);
        $note = parseNote(getArrayValue("remark", "", $request));
        $showIdx = (int) getArrayValue("displayorder", 0, $request);

        if (empty($name)) {
            return output(array("c" => 400, "m" => "参数错误"), "json");
        }

        if ($action === "add") {
            $retJson = gmServerCaller("AddAgentLayer", array($name, $note, $showIdx));
        } else {
            $retJson = gmServerCaller("ModifyAgentLayerInfo", array($layerid, $name, $note, $showIdx));
        }

        return output(array("c" => 0, "m" => ""), "json");
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
        $retJson = gmServerCaller("SetAgentLayerCostAllocatingSetting", array($layerid, json_encode($costAllocatingConfig)));
        if (getArrayValue(0, "", $retJson) == 1) {
            $ret = array("code" => 200, "Message" => "对了的");
        } else {
            $ret = array("code" => 500, "Message" => "出错了，请联系客服");
        }
        return output($ret, "json");
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

        $retJson = gmServerCaller("SetAgentLayerCommisionSetting", array($layerid, json_encode($commisionConfig)));

        if (getArrayValue(0, "", $retJson) == 1) {
            $_SESSION["BrokerageSetting"][$layerid] = $commisionConfig;
            $ret = array("code" => 200, "Message" => "对了的");
        } else {
            $ret = array("code" => 500, "Message" => "出错了，请联系客服");
        }
        return output($ret, "json");
    }

    /**
     * 获得代理层级数据
     *
     * @param [type] $request URI参数
     *
     * @return void
     */
    public static function getAgentLayer($request)
    {
        $retJson = gmServerCaller("GetAllAgentLayer", array());
        $retData = getArrayValue(0, array(), $retJson);
        usort(
            $retData, function ($a, $b) {
                return (int) getArrayValue("orderVal", "", $a) - (int) getArrayValue("orderVal", "", $b);
            }
        );

        return output(array("data" => $retData), "json");
    }
}
