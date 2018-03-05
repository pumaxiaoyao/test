<?php
/**
 * 显示在线玩家数据
 *
 * @param [type] $AllRoles 所有角色的数据
 * 
 * @return void
 */
function showAllRoles($AllRoles)
{
    $retdatas = array();
    for ($x=0;$x<count($AllRoles);$x++) {
        $account = getArrayValue("account", "", $AllRoles[$x]);
        
        $lastLoginTime = parseDate(getArrayValue("lastLoginTime", "", $AllRoles[$x]));
        $registerTime = parseDate(getArrayValue("joinTime", "", $AllRoles[$x]));
        
        $statusCode = (int)getArrayValue("status", 1, $AllRoles[$x]);
        $agentId = getArrayValue("agentId", "", $AllRoles[$x]);
        $agentName = getArrayValue("agentAccount", "无", $AllRoles[$x]);
        $roleId = (int)getArrayValue("roleId", 0, $AllRoles[$x]);

        $tmpdata = array(
            makeRoleChecker(),
            makeAccHtml(), //account cell inner html
            urldecode(getArrayValue("name", "", $AllRoles[$x])), // user name
            makeAgentHtml($roleId, $agentId, $agentName), // agent name
            makeGroupHtml($AllRoles[$x]), // group name
            makeBalanceHtml(getArrayValue("balance", 0, $AllRoles[$x])), // main balance
            getArrayValue("companyWinLose", 0, $AllRoles[$x]), // win loss
            makeBonusHtml(getArrayValue("cost", 0, $AllRoles[$x])), // 成本占用
            makeCheckWithDrawHtml(getArrayValue("withdrawalLimitAmount", 0, $AllRoles[$x])), // 取款限制
            makeRemarkHtml(getArrayValue("note", "", $AllRoles[$x])), //备注
            makeIpHtml($lastLoginTime, getArrayValue("lastLoginIp", "", $AllRoles[$x])), // current login info
            makeIpHtml($registerTime, getArrayValue("joinIp", "", $AllRoles[$x])), // last login info
            getArrayValue("lastLoginWay", "HTML", $AllRoles[$x]), // 登录渠道
            makeStatusHtml($statusCode), // 账号状态
            makeOpersHtml($statusCode) // opration html
        );
        for ($y=0;$y<count($tmpdata);$y++) {
            $tmpdata[$y] = str_replace("%ACCOUNT%", $account, $tmpdata[$y]);
        }
        array_push($retdatas, $tmpdata);
    }
    return $retdatas;
}

/**
 * 显示在线玩家的数据
 *
 * @param [type] $OnlineRoles 在线玩家的数据
 * 
 * @return void
 */
function showOnlineRoles($OnlineRoles)
{
    $retdatas = array();

    for ($x=0;$x<count($OnlineRoles);$x++) {
        $account = getArrayValue("account", "", $OnlineRoles[$x]);
        
        $lastLoginTime = parseDate(getArrayValue("lastLoginTime", "", $OnlineRoles[$x]));
        $registerTime = parseDate(getArrayValue("joinTime", "", $OnlineRoles[$x]));
        
        $statusCode = (int)getArrayValue("status", 1, $OnlineRoles[$x]);
        $agentId = (int)getArrayValue("agentId", 0, $OnlineRoles[$x]);
        $agentName = getArrayValue("agentAccount", "无", $OnlineRoles[$x]);
        $roleId = (int)getArrayValue("roleId", 0, $OnlineRoles[$x]);

        $tmpdata = array(
            (string)($x+1), // index
            makeAccHtml(), //account cell inner html
            urldecode(getArrayValue("name", "", $OnlineRoles[$x])), // user name
            makeAgentHtml($roleId, $agentId, $agentName), // agent name
            makeGroupHtml($OnlineRoles[$x]), // group name
            makeBalanceHtml(getArrayValue("balance", 0, $OnlineRoles[$x])), // main balance
            getArrayValue("companyWinLose", 0, $OnlineRoles[$x]), // win loss
            makeBonusHtml(getArrayValue("cost", 0, $OnlineRoles[$x])), // 成本占用
            makeCheckWithDrawHtml(getArrayValue("withdrawalLimitAmount", 0, $OnlineRoles[$x])), // 取款限制
            makeRemarkHtml(getArrayValue("note", "", $OnlineRoles[$x])), //备注
            makeIpHtml($lastLoginTime, getArrayValue("lastLoginIp", "", $OnlineRoles[$x])), // current login info
            makeIpHtml($registerTime, getArrayValue("joinIp", "", $OnlineRoles[$x])), // last login info
            getArrayValue("lastLoginWay", "HTML", $OnlineRoles[$x]), // 登录渠道
            makeStatusHtml($statusCode), // 账号状态
            makeKickHtml($statusCode) // opration html
        );
        for ($y=0;$y<count($tmpdata);$y++) {
            $tmpdata[$y] = str_replace("%ACCOUNT%", $account, $tmpdata[$y]);
        }
        array_push($retdatas, $tmpdata);
    }
    return $retdatas;
}

/**
 * 当日注册玩家
 *
 * @param [type] $regRoles 指定日期的注册玩家
 * 
 * @return void
 */
function showRegRoles($regRoles)
{
    $retdatas = array();
    for ($x=0;$x<count($regRoles);$x++) {
        $account = getArrayValue("account", "", $regRoles[$x]);
        $lastLoginTime = parseDate(getArrayValue("lastLoginTime", "", $regRoles[$x]));
        $registerTime = parseDate(getArrayValue("joinTime", "", $regRoles[$x]));
        
        $statusCode = (int)getArrayValue("status", 1, $regRoles[$x]);
        $agentId = getArrayValue("agentId", "", $regRoles[$x]);
        $agentName = getArrayValue("agentAccount", "无", $regRoles[$x]);
        $roleId = (int)getArrayValue("roleId", 0, $regRoles[$x]);
        $tmpdata = array(
            (string)($x+1), // index
            makeAccHtml(), //account cell inner html
            urldecode(getArrayValue("name", "", $regRoles[$x])), // user name
            makeAgentHtml($roleId, $agentId, $agentName), // agent name
            makeGroupHtml($regRoles[$x]), // group name
            makeBalanceHtml(getArrayValue("balance", 0, $regRoles[$x])), // main balance
            getArrayValue("companyWinLose", 0, $regRoles[$x]), // win loss
            makeBonusHtml(getArrayValue("cost", 0, $regRoles[$x])), // 成本占用
            makeCheckWithDrawHtml(getArrayValue("withdrawalLimitAmount", 0, $regRoles[$x])), // 取款限制
            makeRemarkHtml(getArrayValue("note", "", $regRoles[$x])), //备注
            makeIpHtml($lastLoginTime, getArrayValue("lastLoginIp", "", $regRoles[$x])), // current login info
            makeIpHtml($registerTime, getArrayValue("joinIp", "", $regRoles[$x])), // last login info
            getArrayValue("lastLoginWay", "HTML", $regRoles[$x]), // 登录渠道
            makeStatusHtml($statusCode), // 账号状态
            makeRegCheckHtml($statusCode) // opration html
        );
        for ($y=0;$y<count($tmpdata);$y++) {
            $tmpdata[$y] = str_replace("%ACCOUNT%", $account, $tmpdata[$y]);
        }
        array_push($retdatas, $tmpdata);
    }
    return $retdatas;
}

/**
 * 玩家资金流水的数据
 *
 * @param [type] $datas 资金流水数据
 * 
 * @return void
 */
function makeFundFlowHtml($datas)
{
    $retdatas = array();
    $static = array(1=>0, 2=>0, 4=>0, 8=>0, 16=>0, 32=>0);
    for ($x=0;$x<count($datas);$x++) {
        $account = getArrayValue("account", "TODO: 未返回账号", $datas[$x]);
        $timeTag = getArrayValue("recordTime", "", $datas[$x]);
        $amount = (float)getArrayValue("amount", 0, $datas[$x]);
        $opType = getArrayValue("opType", "", $datas[$x]);
        if (in_array($opType, array_keys($static))) {
            $static[$opType] = $static[$opType] + $amount;
        }
        $opTags = parseRecodeTypes(2, $opType);
        $tmpdata = array(
            $x+1,
            makeAccHtml(),
            $amount,
            empty($opTags)? $opType:$opTags,
            "TODO:来源".getArrayValue("Source", "", $datas[$x]),
            parseDate($timeTag),
            // "TODO:审核人".parseDate(getArrayValue("dealTime", "", $datas[$x])),
            "TODO:操作人".getArrayValue("Operator2", "", $datas[$x]),
            getArrayValue("note", "", $datas[$x]),
        );
        for ($y=0;$y<count($tmpdata);$y++) {
            $tmpdata[$y] = str_replace("%ACCOUNT%", $account, $tmpdata[$y]);
        }
        array_push($retdatas, $tmpdata);
    }
    return array($retdatas, $static);
}

/**
 * 角色检查框HTML
 *
 * @return void
 */
function makeRoleChecker()
{
    return '<input type="checkbox" layer="layer" value="%ACCOUNT%" />';
}

/**
 * 代理HTML
 *
 * @param [type] $roleId     玩家ID
 * @param [type] $_agentId   代理ID
 * @param [type] $_agentName 代理名
 * 
 * @return void
 */
function makeAgentHtml($roleId, $_agentId, $_agentName)
{
    // $html = "<label id=\"an_".$_AGENT."\">". $_AGENT ."</label><br/>";
    $html ="<a href=\"javascript:void(0);\" agent=agent uid=\"".$roleId."\" acc=\"%ACCOUNT%\" class=\"btn btn-xs\">";
    $html .= "<label id=\"agent_%ACCOUNT%\" agentId=\"".$_agentId."\" agentName=\"".$_agentName."\">".$_agentId. "-" .$_agentName."</label> <i class=\"fa fa-edit\"></i></a>";
    return $html;
}

/**
 * IP数据Html
 *
 * @param [type] $_TIME 时间
 * @param [type] $_IP   IP
 * 
 * @return void
 */
function makeIpHtml($_TIME, $_IP)
{
    return $_TIME . "<br/><label attr=\"ip\">" . $_IP . "</label><br /><label attr=\"addr\">&nbsp;</label>";
}

/**
 * 玩家账号Html
 *
 * @return void
 */
function makeAccHtml()
{
    return "<span class='label label-info' style='cursor:pointer;' onclick='custom_getBalance(\"%ACCOUNT%\", \"%ACCOUNT%\")'>%ACCOUNT%</span>";
}

/**
 * 踢号Html
 *
 * @param [type] $statusCode 状态ID
 * 
 * @return void
 */
function makeKickHtml($statusCode)
{
    if ($statusCode == 2) {
        $_lockhtml = "<a id='lock' href='javascript:void(0)' onclick='lockPlayer(this, \"%ACCOUNT%\")'  class='btn mini red'><i class='fa fa-lock'>锁定</i></a>";
    } elseif ($statusCode == 3) {
        $_lockhtml = "<a id='lock' href='javascript:void(0)' onclick='lockPlayer(this, \"%ACCOUNT%\")'  class='btn mini green'><i class='fa fa-unlock'>解锁</i></a>";
    } else {
        $_lockhtml = "";
    }

    $_kickhtml = "<a href='javascript:void(0)' onclick='playerkickdown(\"%ACCOUNT%\")'  class='btn mini blue'><i class='icon-trash'></i>踢线</a>";
    return $_lockhtml."&nbsp; &nbsp;".$_kickhtml;
}

/**
 * 操作按钮HTML
 *
 * @param [type] $statusCode 状态码
 * 
 * @return void
 */
function makeOpersHtml($statusCode)
{
    if ($statusCode == 2) {
        $_lockhtml = "<a id='lock' href='javascript:void(0)' onclick='lockPlayer(this, \"%ACCOUNT%\")'  class='btn mini red'><i class='fa fa-lock'>锁定</i></a>";
    } elseif ($statusCode == 3) {
        $_lockhtml = "<a id='lock' href='javascript:void(0)' onclick='lockPlayer(this, \"%ACCOUNT%\")'  class='btn mini green'><i class='fa fa-unlock'>解锁</i></a>";
    } else {
        $_lockhtml = "";
    }
    
    $_edithtml = "<a id='edit' href='javascript:void(0)' onclick='editPlayerDetail(\"%ACCOUNT%\")'  class='btn mini blue'><i class='fa fa-edit'></i>编辑</a>";
    $_pwdhtml = "<a id='pwd' href='javascript:void(0)' reset='reset' uid='%ACCOUNT%'  class='btn mini blue'><i class='fa fa-edit'></i>修改密码</a>";
    $_msghtml = "<a id='msg' href=\"javascript:void(0);\" message=message uid=\"%ACCOUNT%\" class='btn mini blue'><i class=\"fa fa-bell\"></i>发消息</a>";

    return $_lockhtml."&nbsp; &nbsp;".$_edithtml."<br/><br/>".$_msghtml."&nbsp; &nbsp;".$_pwdhtml;
}

/**
 * 注册检查Html
 *
 * @param [type] $statusCode 状态码
 * 
 * @return void
 */
function makeRegCheckHtml($statusCode)
{
    if ($statusCode == 2) {
        $_lockhtml = "<a id='lock' href='javascript:void(0)' onclick='lockPlayer(this, \"%ACCOUNT%\")'  class='btn mini red'><i class='fa fa-lock'>锁定</i></a>";
    } elseif ($statusCode == 3) {
        $_lockhtml = "<a id='lock' href='javascript:void(0)' onclick='lockPlayer(this, \"%ACCOUNT%\")'  class='btn mini green'><i class='fa fa-unlock'>解锁</i></a>";
    } else {
        $_lockhtml = "";
    }
    $_checkhtml = "<a id='edit' href='javascript:void(0)' onclick='editPlayerDetail(\"%ACCOUNT%\")'  class='btn mini green'><i class='fa fa-edit'></i>校验</a>";
    return $_checkhtml . "&nbsp; &nbsp;" . $_lockhtml;

}
/**
 * 玩家组Html
 *
 * @param [type] $data 玩家组数据
 * 
 * @return void
 */
function makeGroupHtml($data)
{
    $roleId = (int)getArrayValue("roleId", 0, $data);
    $groupId = (int)getArrayValue("groupId", 0, $data);
    $groupName = getArrayValue("groupName", "无", $data);
    $playerName = getArrayValue("name", "无", $data);
    
    return '<label group="uGroup" ></label><a href="javascript:void(0);" id="'.$roleId.'_group" layer=layer roleid="'.$roleId.'" uname="'.$playerName.'" uid="%ACCOUNT%" groupid="'.$groupId.'"class="btn btn-xs">'.$groupId." - ".$groupName.' <i class="fa fa-edit"></i></a>';
}

/**
 * 玩家余额数据Html
 *
 * @param [type] $_balance 余额
 * 
 * @return void
 */
function makeBalanceHtml($_balance)
{
    return (string)$_balance.'&nbsp;<a href="#" balance="balance" uid="%ACCOUNT%"><i class="fa fa-edit"></i></a>';
}

/**
 * 玩家备注Html
 *
 * @param [type] $_remark 备注内容
 * 
 * @return void
 */
function makeRemarkHtml($_remark)
{
    return '<label remark="remark" id="remark_%ACCOUNT%" title data-original-title="'.$_remark.'">'.$_remark.'</label><a href="javascript:void(0);" remark="remark" uid="%ACCOUNT%"><i class="fa fa-edit"></i></a>';
}

/**
 * 玩家红利Html
 *
 * @param [type] $_BONUS 红利数据
 * 
 * @return void
 */
function makeBonusHtml($_BONUS)
{
    return (string)$_BONUS.'&nbsp;<a href="javascript:void(0);" bonus="bonus" uid="%ACCOUNT%"><i class="fa fa-edit"></i></a>';
}

/**
 * 玩家状态Html
 *
 * @param [type] $_code 玩家状态
 * 
 * @return void
 */
function makeStatusHtml($_code)
{
    $_STATUS = parseStatus($_code);
    if ($_code == 2) {
        return "<span class='label label-success'>".$_STATUS."</span>";//<a href='javascript:void(0);' uid='%ACCOUNT%' lock='lock' class='btn btn-xs'></a>";//<i class='fa fa-lock'></i></a>";
    } elseif ($_code == 3) {
        return "<span class='label label-danger'>".$_STATUS."</span>";//<a href='javascript:void(0);' uid='%ACCOUNT%' lock='lock' class='btn btn-xs'></a>";//<i class='fa fa-unlock'></i></a>";
    } else {
        return "<span class='label label-success'>".$_STATUS."</span>";//<a href='javascript:void(0);' uid='%ACCOUNT%' lock='lock' class='btn btn-xs'></a>";//<i class='fa fa-lock'></i></a>";
    }
    
}

/**
 * 流水检查按钮
 *
 * @param [type] $_val 检查值
 * 
 * @return void
 */
function makeCheckWithDrawHtml($_val){
    $_html = '&nbsp;<a href="#" water="water" title="流水检查" uid="%ACCOUNT%" name="%ACCOUNT%"><i class="fa fa-search"></i></a>';
    if ($_val == 0) {
        return (float)$_val.$_html;
    } else {
        return (float)$_val.$_html;
    }
}

/**
 * 个人详情界面 TAB1 -- 玩家活跃度统计数据页面
 *
 * @param [type] $activeData 活跃数据
 * @param [type] $_st        开始时间
 * @param [type] $_et        结束时间
 * 
 * @return void
 */
function makeActiveHtml($activeData, $_st, $_et)
{
    $page = readHtml("playerDetail/playerActiveTable");
    $htmlData = array(
        "<tr><td>".getArrayValue("rebate", 0, $activeData)."</td>",
        "<td>". getArrayValue("bonus", 0, $activeData) ."</td>",
        "<td>". getArrayValue("depositBonus", 0, $activeData) ."</td>",
        "<td>". getArrayValue("stake", 0, $activeData) ."</td>",
        "<td>". getArrayValue("win", "0", $activeData) ."</td>",
        "<td style='color=red'>". getArrayValue("companyWinLose", "0", $activeData) ."</td>",
        "<td>". getArrayValue("validBet", "0", $activeData) ."</td>",
        "<td style='color=red'>". getArrayValue("companyIncome", "0", $activeData) ."</td></tr>",
    );
    $info1_html = join("", $htmlData);
    $lastDepositTime = getArrayValue("lastDepositTime", 0, $activeData);
    if ($lastDepositTime !== 0) {
        $lastDepositTime = parseDate($lastDepositTime);
    }
    $lastWithDrawalTime = getArrayValue("lastWithDrawalTime", 0, $activeData);
    if ($lastWithDrawalTime !== 0) {
        $lastWithDrawalTime = parseDate($lastWithDrawalTime);
    }
    $htmlData1 = array(
        "<tr><td>".getArrayValue("depositTimes", 0, $activeData)."</td>",
        "<td>". getArrayValue("depositAmount", 0, $activeData) ."</td>",
        "<td>". $lastDepositTime ."</td>",
        "<td>". getArrayValue("withdrawalTimes", 0, $activeData) ."</td>",
        "<td>". getArrayValue("withdrawalAmount", 0, $activeData) ."</td>",
        "<td>". $lastWithDrawalTime ."</td></tr>",    
    );
    $info2_html = join("", $htmlData1);
    
    $page = str_replace("%STARTTIME%", parseDate($_st), $page);
    $page = str_replace("%ENDTIME%", parseDate($_et), $page);
    $page = str_replace("%INFO1%", $info1_html, $page);
    $page = str_replace("%INFO2%", $info2_html, $page);
    output($page);
}


/**
 * 个人详情界面 TAB1 -- 玩家基础信息
 *
 * @param [type] $page       页面HTML
 * @param [type] $playerdata 玩家数据
 * 
 * @return void
 */
function MakeDT_baseInfo($page, $playerdata)
{
    $groupName = getArrayValue("groupName", "", $playerdata);
    $statusCode = getArrayValue("status", 0, $playerdata);
    $timeTag = getArrayValue("joinTime", "", $playerdata);
    $timeTag1 = getArrayValue("lastLoginTime", "", $playerdata);
    $replaceArray = array(
        "account"=>getArrayValue("account", "", $playerdata),
        "name"=>getArrayValue("name", "", $playerdata),
        "layer"=>$groupName,
        "status"=>parseStatus($statusCode),
        "agent"=>getArrayValue("agentAccount", "", $playerdata),
        "qq"=>getArrayValue("qq", "", $playerdata),
        "cellPhoneNo"=>getArrayValue("cellPhoneNo", "", $playerdata),
        "birthDate"=>getArrayValue("birthDate", "", $playerdata),
        "email"=>urldecode(getArrayValue("email", "", $playerdata)),
        "joinTime"=>parseDate($timeTag),
        "joinIp"=>getArrayValue("joinIp", "", $playerdata),
        "lastLoginTime"=>parseDate($timeTag1),
        "mainBalance"=>getArrayValue("balance", 0, $playerdata, true),
    );
    foreach ($replaceArray as $_key => $_vals) {
        $page = str_replace("%".$_key. "%", $_vals, $page);
    }
    return $page;
}


/**
 * 个人详情界面 TAB6 - 临时的防套利数据查询接口
 *
 * @param [type] $page       页面HTML
 * @param [type] $playerData 玩家数据
 * 
 * @return void
 */
function MakeDT_sameDataInfo($page, $playerData)
{
    $_html = "";
    $replaceWords = array(
        "account", "name", "birthDate", "password", "cellPhoneNo", "joinIp",
        "joinTime", "lastLoginIp", "lastLoginTime"
    );
    foreach ($replaceWords as $_key) {
        if ($_key == "password") {
            $defaultVal = "******";
        } else {
            $defaultVal = "";
        }
        $_val = getArrayValue($_key, $defaultVal, $playerData);
        if (strpos($_key, "Time") !== false) {
            $_val = parseDate($_val);
        }
        $page = str_replace("%".$_key."%", $_val, $page);
    }
    return $page;
}

?>