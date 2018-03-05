<?php

/**
 * 构建代理审核界面
 *
 * @return void
 */
function showVerifyHtml()
{
    $retJson = gmServerCaller("GetAllAgentLayer", array());
    $page = array(
        makeHeaderPage(""),
        readHtml("agent/verify"),
        makeFooterPage(""),
    );
    output(join("", $page));
}

/**
 * Undocumented function
 *
 * @return void
 */
function showaglistHtml()
{
    $page = array(
        makeHeaderPage(""),
        readHtml("agent/list"),
        makeFooterPage(""),
    );
    output(join("", $page)); 
}

/**
 * 构建代理审核历史界面
 *
 * @return void
 */
function showagVerifyHistory()
{
    $page = array(
        makeHeaderPage(""),
        readHtml("agent/verifyHistory"),
        makeFooterPage(""),
    );
    output(join("", $page)); 
}

/**
 * Undocumented function
 *
 * @return void
 */
function showagDomain(){
    $page = array(
        makeHeaderPage(""),
        readHtml("agent/domain"),
        makeFooterPage("domain_footer"),
    );
    output(join("", $page)); 
}

/**
 * 构建审核代理数据的界面ajax
 *
 * @param [type] $ret 数据
 * 
 * @return void
 */
function showAgentVerifyHtml($ret)
{
    $retdatas = array();
    for ($x=0;$x<count($ret);$x++) {
        $roleId = getArrayValue("roleId", "", $ret[$x]);
        $account = getArrayValue("account", "", $ret[$x]);
        $name = getArrayValue("name", "", $ret[$x]);
        
        $joinIp = getArrayValue("joinIp", "", $ret[$x]);
        $joinTime = getArrayValue("joinTime", 0, $ret[$x]);
        $status = (string)getArrayValue("status", "1", $ret[$x]);
        
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
        $pParentId = (int)getArrayValue("pParentId", 1, $ret[$x]);
        $parentId = (int)getArrayValue("parentId", 0, $ret[$x]);
        $parentAccount = getArrayValue("parentAccount", "", $ret[$x]);

        $belongToTags = parseBelongTo($pParentId, $parentId, $parentAccount);
        $tmp = array(
            makeAgentAccountHtml($roleId, $account),
            $name,
            $belongToTags[0],
            $belongToTags[1],
            parseDate($joinTime, 4),
            $joinIp,
            $stag,
            makeAgentVerifyOperHtml($account, $roleId)
        );
        array_push($retdatas, $tmp);
    }
    return $retdatas;
}

/**
 * 构建代理账号页面
 *
 * @param [type] $_aid 代理ID
 * @param [type] $_acc 代理账号
 * 
 * @return void
 */
function makeAgentAccountHtml($_aid, $_acc)
{
    return "<span class=\"label label-info\" style=\"cursor:pointer;\" onclick=\"custom_getAgentModel('". $_aid . "','" . $_acc . "');\">".$_aid."</span>";
}


/**
 * 构建代理账号页面
 *
 * @param [type] $_aid 代理ID
 * @param [type] $_acc 代理账号
 * 
 * @return void
 */
function makeAgentAccountHtml1($_aid, $_acc)
{
    return "<span class=\"label label-info\" style=\"cursor:pointer;\" onclick=\"custom_getAgentModel('". $_aid . "','" . $_acc . "');\">".$_acc."</span>";
}
/**
 * 代理审核界面的操作按钮Html
 * 
 * @param [type] $_acc 代理账号
 * @param [type] $_aid 代理ID
 * 
 * @return void
 */
function makeAgentVerifyOperHtml($_acc, $_aid)
{
    return "<a onclick=\"setInfo('". $_acc ."','".$_aid."');\" data-toggle=\"modal\" href=\"#checkAgentModal\" class=\"btn mini green\"><i class=\"icon-trash\"></i>审核</a>";
}

/**
 * 添加代理列表的备注按钮
 *
 * @param [type] $_aid 代理ID
 * @param [type] $note 备注内容
 * 
 * @return void
 */
function makeAgentNoteHtml($_aid, $note)
{
    return "<label remark=\"remark\" id=\"remark_".$_aid."\" title=\"".$note."\">".$note."</label><a href=\"javascript:void(0);\" remark=\"remark\" aid=\"".$_aid."\"><i class=\"fa fa-edit\"></i></a>";

}
/**
 * 构建代理审核历史界面
 *
 * @param [type] $retData 代理审核数据
 * 
 * @return void
 */
function showVerifyHistory($retData)
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

        $tmp = array(
            $agentCode,
            makeAgentAccountHtml1($agentCode, $account),
            $name,
            $layerName,
            parseDate($joinTime, 4),
            $joinIp,
            parseAgentVerifyStatus($status),
            $note,
            parseDate($checkTime, 4),
        );
        array_push($aaData, $tmp);
    }
    return $aaData;
}

/**
 * 构建代理信息界面
 *
 * @param [type] $retData 代理数据
 * 
 * @return void
 */
function showAgentListHtml($retData)
{
    $aaData = array();
    for ($x=0; $x < count($retData); $x++) {
        $_data = $retData[$x];
        $layerid = getArrayValue("layerId", 0, $_data);
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
            
        
        $tmp = array(
            $x + 1,
            makeAgentAccountHtml1($agentCode, $account),
            "<span id='realname'>".$name."</span>",
            $layerName,
            $belongToTags[0],
            $belongToTags[1],
            $agentCode,
            parseDate($joinTime),
            $joinIp,
            makeAgentNoteHtml($agentCode, $note),
            parseAgentVerifyStatus($status),
            makeAgentlistOperHtml($status, $name, $agentCode, $layerid)
        );
        array_push($aaData, $tmp);
    }
    return $aaData;
}

/**
 * 生成代理列表界面的操作按钮
 *
 * @param [type] $st    状态
 * @param [type] $aname 名字
 * @param [type] $aid   ID
 * 
 * @return void
 */
function makeAgentlistOperHtml($st, $aname, $aid, $layerid )
{
    $html = "<a href=\"#accountModal\" data-toggle=\"modal\" astatus=\"".$st."\" aname=\"".$aname."\" aid=\"".$aid."\" onclick=\"lockunlock(this);\" ";
    if ($st == 2) {
        $html .= "class=\"btn btn-xs red status\">锁定</a>";
    } else if ($st == 3) {
        $html .= "class=\"btn btn-xs green status\">解锁</a>";
    } else {
        $html = "";
    }
    $html .= "<a href=\"#editModal\" class=\"btn btn-xs blue\" data-toggle=\"modal\" onclick=\"initModal('".$aid."')\">编辑</a><br/><br>";
    $html .= "<a href=\"#resetPwd\" class=\"btn btn-xs blue\" data-toggle=\"modal\" aid=\"".$aid."\" onclick=\"resetPwdModal(this)\" > 修改密码</a>";
    $html .= "<a href=\"#levelModal\" data-toggle=\"modal\" class=\"btn btn-xs blue level\" aid=\"".$aid."\" layerid='".$layerid."' onclick=\"getLayerList(this);\"> 调整层级</a>";
    return $html;

}

/**
 * 生成域名界面
 *
 * @param [type] $retData 数据
 * 
 * @return void
 */
function showDomainHtml($retData)
{
    $aaData = array();

    for ($x=0; $x < count($retData); $x++) {
        $_data = $retData[$x];
        $domainid = getArrayValue("id", 0, $_data);
        $roleId = (int)getArrayValue("roleId", 0, $_data);
        $account = getArrayValue("account", "", $_data);
        $domain = getArrayValue("domain", "", $_data);
        $createTime = getArrayValue("createTime", "", $_data);
        
        $tmp = array(
            $x,
            makeAgentAccountHtml1($roleId, $account),
            $roleId,
            $domain,
            parseDate($createTime),
            "<a href=\"javascript:void(0);\" domainId=\"". $domainid . "\" domain=\"" . $domain . "\"\r\nclass=\"btn mini red deleteDomain\"><i class=\"icon-trash\"></i>删除</a>",
        );
        array_push($aaData, $tmp);
    }
    return $aaData;
}


?>