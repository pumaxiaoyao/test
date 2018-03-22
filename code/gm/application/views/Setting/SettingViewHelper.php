<?php
/**
 * 流水相关的API
 * php version 7.1
 * 
 * @category Flow
 * @package  GM
 * @author   alien <email@email.com>
 * @license  Public http://alien.com
 * @link     http://alien.com
 */

/**
 * 玩家用户组界面显示
 *
 * @return void
 */
function showplayerLevel()
{
    $page = array(
        makeHeaderPage(""),
        readHtml("settings/playerLevel"),
        makeFooterPage(""),
    );
    output(join("", $page));
}

/**
 * 玩家用户组属性界面显示
 *
 * @param [type] $reqGroupId 玩家组ID
 * @param [type] $attr       玩家组属性
 * 
 * @return void
 */
function makePLAttrHtml($reqGroupId, $attr)
{
    $allHtml = "";
    $gpIDS = array();
    foreach ($attr as $key=>$_attr) {
        $groupId = (int)getArrayValue("groupId", 0, $_attr);
        $minDeposit = (float)getArrayValue("minDeposit", 0, $_attr);
        $id = (int)getArrayValue("id", 0, $_attr);
        $name = getArrayValue("name", "", $_attr);
        $html = '<tr groupid="' . $groupId . '" id="'. $id .'"><td>如果存款总额 >= </td>';
        $html .= '<td><input type="text" name="dptamount" 
            value="' . $minDeposit . '" class="form-control input-sm" 
            placeholder="" onchange="changeAttr($(this).parent().parent())"
            ></td>';
        $html .= '<td><input type="text" name="groupname" 
            value="' . $name . '" class="form-control input-sm" 
            placeholder="" onchange="changeAttr($(this).parent().parent())"
            ></td>';
        $html .= '<td>不满足则下一步</td>';
        $html .= '<td><a href="javascript:void(0);" onclick="setwateredit(this);" 
            groupid="' . $id.'" groupname="' . $name.'" class="btn btn-xs blue">
            返水设置</a>';
        $html .= '<a href="javascript:void(0);" onclick="getCardList(this);" 
            groupid="' . $id.'" groupname="' . $name.'" 
            class="btn btn-xs blue">选银行卡</a>';
        $html .= "<a href=\"#\" onclick=\"delattrrow(" . $id . "," . $groupId .")\" 
            class=\"btn btn-xs red\">删除</a></td></tr>";
        $allHtml .= $html;
        array_push($gpIDS, $id);
    }
    
    return $allHtml;
}

/**
 * 构建GPlist界面
 *
 * @return void
 */
function showGPList()
{
    $page = array(
        makeHeaderPage(""),
        readHtml("settings/gplist"),
        makeFooterPage("settings_gplist_footer"),
    );
    output(join("", $page));
}


/**
 * 代理层级界面
 *
 * @return void
 */
function showagentLevel()
{
    $retJson = gmServerCaller("GetAllAgentLayer", array());
    $retData = getArrayValue(0, array(), $retJson);
    usort(
        $retData, function ($a, $b) { 
                return (int)getArrayValue("orderVal", "", $a)
                     - (int)getArrayValue("orderVal", "", $b); 
        }
    );

    $html = readHtml("settings/agentLevel");
    $html = str_replace("%AGENTLEVEL%", makeAgentLevelHtml($retData), $html);
    $html = str_replace("%AgentBrokerageModal%", makeAgentBrokerageHtml(), $html);
    $agBsPage = readHtml("settings/agentBrokerageSetting");
    $html = str_replace("%AGENTBROKERAGESETTING%", $agBsPage, $html);
    $page = array(
        makeHeaderPage(""),
        $html,
        makeFooterPage(""),
    );

    $fullPage = join("", $page);
    // getGroupConfig
    $html = parseGroupHtml();
    $fullPage = str_replace("%GROUPDATA%", $html, $fullPage);
    output($fullPage);
}

/**
 * 构建代理结算抽佣
 *
 * @return void
 */
function makeAgentBrokerageHtml()
{
    $html = readHtml("settings/agentBrokerage");
    return $html;
}


/**
 * 构建抽佣设置界面
 *
 * @param [type] $idx  序号
 * @param [type] $game 名字
 * 
 * @return void
 */
function addBrokerageTdHtml($idx, $game)
{
    $html = "<tr><td>".$idx."</td>";
    $html .= "<td id='brokerageFloat".$game."'>".$game."</td>";
    $html .= '<td><select class="form-control" id="CommisionChoose'.$game.'" >
        <option value="0">不抽佣</option>
        <option value="1">固定比例抽佣</option>
        <option value="2">浮动比例抽佣</option>
        </select></td>';
    $html .= '<td><input type="text" id="Commisionratedata'.$game.'" 
        name="Commisionratedata'.$game.'" size="8" placeholder=""></td>';
    $html .= '<td><select class="form-control" id="WaterChoose'.$game.'">
        <option value="0">不抽水</option>
        <option value="1">固定比例抽水</option>
        <option value="2">浮动比例抽水</option>
        </select></td>';
    $html .= '<td><input type="text" id="Waterratedata'.$game.'" 
        name="Waterratedata'.$game.'" size="8" placeholder="">
        <a href="#floatSettingModal" id="Waterconfig'.$game.'" 
        modalTag="water" data-toggle="modal" 
        class="btn btn-xs blue">浮动比例设置</a></td></tr>';
    return $html;
}


/**
 * 生成代理数据
 *
 * @param [type] $retData 数据
 * 
 * @return void
 */
function makeAgentLevelHtml($retData)
{
    
    $html = "";
    $_SESSION["BrokerageSetting"] = array();
    for ($x=0;$x<count($retData);$x++) {
        $agentData = $retData[$x];

        $layerId = getArrayValue("id", "", $agentData);
        $name = getArrayValue("name", "", $agentData);
        $note = getArrayValue("note", "", $agentData);
        $group = getArrayValue("group", 0, $agentData);
        $order = getArrayValue("orderVal", "", $agentData);
        $time = getArrayValue("lastModifyTime", "", $agentData);
        $caSetting = getArrayValue("costAllocationSetting", "", $agentData);
        // {"bonusFixedRate":0.1,"validPlayerCountMin":10,"depositBonusRateType":1,"depositBonusFixedRate":0.3,"rebateRateType":2,"rebateFixedRate":0.2,"lineChargeFixedRate":0.3,"bonusRateType":1,"lineChargeRateType":1,"validPlayerStakeMin":1000,"lineChargeFloatRate":[{"rate":0.5,"amount":100000},{"rate":0.2,"amount":10000},{"rate":0.1,"amount":1000}]}
        // {"game":{"sport":{"pumpingWatarFixedRate":0.3,"pumpingWatarRateType":1,"pumpingCommisionRate":1,"pumpingCommisionFixedRate":0.5},"pk":{"pumpingCommisionRate":2,"pumpingWatarFloatRate":[{"rate":0.5,"amount":100000},{"rate":0.2,"amount":10000},{"rate":0.1,"amount":1000}]}},"pumpingCommisionFloatRate":[{"rate":0.5,"amount":100000},{"rate":0.2,"amount":10000},{"rate":0.1,"amount":1000}]}
        
        $caData = json_decode($caSetting, true);

        $depositType = getArrayValue("depositBonusRateType", 0, $caData);
        $depositRate = getArrayValue("depositBonusFixedRate", 0, $caData); 

        $rebateType = getArrayValue("rebateRateType", 0, $caData);
        $rebateRate = getArrayValue("rebateFixedRate", 0, $caData);

        $bonusType = getArrayValue("bonusRateType", 0, $caData);
        $bonusRate = getArrayValue("bonusFixedRate", 0, $caData);

        $lineType = getArrayValue("lineChargeRateType", 0, $caData);
        $lineRate = getArrayValue("lineChargeFixedRate", 0, $caData);
        $lineFloatRate = getArrayValue("lineChargeFloatRate", array(), $caData);
        $lineFloatStr = makeFloatStr($lineFloatRate);

        $validStake = getArrayValue("validPlayerStakeMin", 0, $caData);
        $validCount = getArrayValue("validPlayerCountMin", 0, $caData);
        

        $commisionSetting = getArrayValue("commisionSetting", "", $agentData);
        $cData = json_decode($commisionSetting, true);
        $floatRate = getArrayValue("pumpingCommisionFloatRate", array(), $cData);
        $commonFloatStr = makeFloatStr($floatRate);
        
        $_SESSION["BrokerageSetting"][$layerId] = $cData;

        $note = getArrayValue("note", "", $agentData);
        $html .= "<tr>";
        $html .= "<td>" . ( $x + 1 ). "</td>";
        $html .= "<td  id='agentLayerCommon". $layerId ."' 
            linefloatStr='".$lineFloatStr."' 
            floatStr='".$commonFloatStr."'>" . $name . "</td>";
        $html .= "<td>" . $group . "</td>";
        $html .= "<td>" . $order . "</td>";
        $html .= "<td>" . parseDate($time). "</td>";
        $EditData = array("'".$layerId."'", "'".$group."'",
            "'". $name."'", "'".$note."'", "'".$order."'");
        $html .= makeEditHtml($EditData);
        $asData = array($layerId, $depositType, $depositRate, 
            $rebateType, $rebateRate, $bonusType, $bonusRate,
            $lineType, $lineRate, $validStake, $validCount);
        $html .= makeAllocationSetingHtml($asData);
        $CsHtml = makeCommisionSetingHtml(array( "'".$name."'", $layerId));
        $html .= $CsHtml.'</td></tr>';
    }
    return $html;
}

/**
 * 构建编辑按钮Html
 *
 * @param [type] $args 参数
 * 
 * @return void
 */
function makeEditHtml($args)
{
    $html = "<td><a href=\"#editModal\" onclick=\"setedit(";
    $html .= join(",", $args);
    $html .= ");\" data-toggle=\"modal\" class=\"btn btn-xs green\">编辑</a>";
    return $html;
}

/**
 * 构建抽佣抽水设置按钮Html
 *
 * @param [type] $args 参数
 * 
 * @return void
 */
function makeCommisionSetingHtml($args)
{
    $html = '<a href="#brokerageModal" 
        id="brokerageModallayer'. getArrayValue(1, "", $args).'" 
        data-toggle="modal" onclick="setBrokerage(';
    $html .= join(",", $args);
    $html .= ')" class="btn btn-xs blue">设置抽佣/抽水</a>';
    return $html;
}


/**
 * 构建结算分摊设置按钮Html
 *
 * @param [type] $args 参数
 * 
 * @return void
 */
function makeAllocationSetingHtml($args)
{

    $html = '<a href="#apportionModal" 
        id="apportionModallayer'. getArrayValue(0, "", $args) .'" 
        data-toggle="modal" onclick="setApportion(';
    $html .= join(",", $args);
    $html .= ')" class="btn btn-xs blue">结算分摊</a>';
    return $html;
}

/**
 * 构建客服部门界面
 *
 * @return void
 */
function showcsDept()
{
    $page = array(
        makeHeaderPage(""),
        readHtml("settings/csDept"),
        makeFooterPage("settings_csdept_footer"),
    );
    output(join("", $page)); 
}

/**
 * 构建客服账号管理界面
 *
 * @return void
 */
function showcsAcct()
{
    $page = array(
        makeHeaderPage(""),
        readHtml("settings/csAcct"),
        makeFooterPage("settings_csacct_footer"),
    );
    output(join("", $page)); 
} 

/**
 * 构建ws界面
 *
 * @return void
 */
function showWS()
{
    $page = array(
        makeHeaderPage(""),
        readHtml("settings/ws"),
        makeFooterPage(""),
    );
    output(join("", $page));
}
?>