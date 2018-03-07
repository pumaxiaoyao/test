<?php
/**
 * 工具库
 * php version 7.1
 * 
 * @category Utilities
 * @package  GM
 * @author   alien <email@email.com>
 * @license  Public http://alien.com
 * @link     http://alien.com
 */



 /**
 * 解析日志的状态
 * 
 * @param string $codeID  状态码
 * @param string $codeID1 状态码
 * 
 * @return string
 */
function parseOPType($optypes)
{
    $opArugs = [];
    foreach (explode(",", $optypes) as $_optype) {
        $opval = $GLOBALS["ParsePlayerRecordBalanceType"][$_optype];
        array_push($opArugs, $opval);
    }
    return array_sum($opArugs);
}


/**
 * 构建界面中所需的玩家组下拉选项菜单
 *
 * @return void
 */
function parseGroupHtml()
{
    $groupdata = getGroupConfig();
    $validGroups = getArrayValue("t1", array(), $groupdata);
    $html = "";
    for ($x=0;$x<count($validGroups);$x++) {
        $_group = $validGroups[$x];
        $html = $html . "<option value='".getArrayValue("id", "", $_group) ."'>". getArrayValue("name", "", $_group). "</option>";
    }
    return $html;
}

/**
 * 获取系统的玩家组配置数据
 *
 * @return void
 */
function getGroupConfig($needFresh = false)
{
    if ($needFresh) {
        unset($_SESSION["PLayerGroupConfig"]);
        return refreshGroupsData();
    }
    if (!isset($_SESSION["PLayerGroupConfig"])) {
        return refreshGroupsData();
    } else {
        return $_SESSION["PLayerGroupConfig"];
    }
}

/**
 * 请求后台获得玩家组配置
 *
 * @return void
 */
function refreshGroupsData()
{
    $retJson = gmServerCaller("GetAllPlayerGroup", array());
    $groupData = getArrayValue(0, array(), $retJson);
    $defaultGroupID = getArrayValue(1, "", $retJson);
    $ret = array("t1"=>array(), "t2"=>array());
    $_SESSION["layerSetting"] = array();
    foreach ($groupData as $key=>$_val) {
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
                return (int)$a["orderVal"] -(int)$b["orderVal"]; 
        }
    );
    $ret["t1"] = $t1;
    
    $t2 = $ret["t2"];
    usort(
        $t2, function ($a, $b) { 
                return (int)$a["orderVal"] -(int)$b["orderVal"]; 
        }
    );
    $ret["t2"] = $t2;
    $_SESSION["PLayerGroupConfig"] = $ret;
    return $ret;
}
/**
 * 处理需要显示的合营信息
 * 
 * @param [type] $domains 数据
 * 
 * @return void
 */
function parseDomainInfo($domains)
{
    $html = "";
    if (count($domains) > 0) {
        foreach ($domains as $index => $_domain) {
            $domain_str = getArrayValue("domain", "", $_domain);
            $html .= '<tr><td style="cursor:hand;text-align: left;">
                <font style=color:red;>'.$domain_str."</font></td></tr>";
        }
    } else {
        $html = "<tr><td style=\"cursor:hand;text-align: left;\">无数据</td></tr>";
    }
    
    return $html;
}
/**
 * 处理需要在表格中显示的银行卡信息
 *
 * @param [type] $bankType   银行卡类别
 * @param [type] $personName 持卡人名字
 * @param [type] $cardNo     卡号
 * 
 * @return void
 */
function parseBankInfo($bankType, $personName, $cardNo)
{
    $bankinfo = getArrayValue($bankType, array(), $GLOBALS["BankTypes"]);
    $bankName = getArrayValue("name", "", $bankinfo);
    return $bankName . " " . $personName . "<br/>" . $cardNo;

}

/**
 * 处理需要显示上级代理所属的字符串
 *
 * @param [type] $pParentId     上上级ID
 * @param [type] $parentId      父级代理ID
 * @param [type] $parentAccount 父级代理账号
 * 
 * @return void
 */
function parseBelongTo($pParentId, $parentId, $parentAccount)
{
    $stag1 = "无";
    $stag2 = "无";

    if ($pParentId != 0) {
        $stag2 = $parentAccount;
    } else if ($parentId != 0) {
        $stag1 = $parentAccount;
    }
    return array($stag1, $stag2);
}

/**
 * 统一的文本字符串长度处理
 *
 * @param [type] $remark 备注
 * 
 * @return void
 */
function parseNote($remark)
{
    //超过一定数量字符就处理掉，避免数据服务器超长不处理
    $maxChars = 80;
    if (mb_strlen($remark, "UTF8")> $maxChars) {
        $remark = mb_substr($remark, 0, $maxChars, 'utf8'); 
    }
    return $remark;
    
}

/**
 * 自定义的对多维数组的指定键名进行排序的方法
 *
 * @param [array] $datas 需要排序的数组
 * 
 * @return void
 */
function sortarray($datas)
{
    usort(
        $datas, function ($a, $b) { 
                return (int)$a["time"] -(int)$b["time"]; 
        }
    );
    return $datas;
}

/**
 * 解析日志的状态
 * 
 * @param string $codeID  状态码
 * @param string $codeID1 状态码
 * 
 * @return string
 */
function parseRecodeTypes($codeID, $codeID1)
{
    $statusData = getArrayValue($codeID, array(), $GLOBALS["Record_Types"]);
    return getArrayValue($codeID1, "", $statusData);
}

/**
 * 解析玩家的状态
 * 
 * @param string $codeID 状态码
 * 
 * @return string
 */
function parseStatus($codeID)
{
    return getArrayValue($codeID, "", $GLOBALS["roleStatusCode"]);
}

/**
 * 转换linux时间戳为日期格式
 * 
 * @param string $timeTag linux时间
 * @param string $Ttype   转换模式
 * 
 * @return string
 */
function parseDate($timeTag = 0, $Ttype = 1)
{
    if ($timeTag == "") {
        return "";
    }
    $timeTag = ($timeTag === 0)?time():$timeTag;
    if ($Ttype == 1) {
        return date("Y-m-d H:i:s", (int)$timeTag);
    } elseif ($Ttype == 2) {
        return date("Y-m-d", (int)$timeTag);
    } elseif ($Ttype == 3) {
        return date("H:i:s", (int)$timeTag);
    } elseif ($Ttype == 4) {
        return date("Y-m-d", (int)$timeTag)."<br/>".date("H:i:s", (int)$timeTag);
    }
}

/**
 * 读取日期数据，并将格式为linux时间
 * 
 * @param string $_tag $_req数组中的键名
 * @param string $_def 当读取不到$_tag的值时，设置为默认的$_def
 * @param string $_req 请求索引的数组
 * 
 * @return string
 */
function parseTimeArgus($_tag, $_def, $_req)
{
    $_time = getArrayValue($_tag, $_def, $_req);
    if (!empty(trim($_time)) && strpos($_time, '-') !== false) {
        $_time = strtotime($_time);
    }
    return $_time;
}


/**
 * 从Session数组中请求指定键名的值，若不存在，则返回预设值
 * 
 * @param string $_key    请求查询的键名
 * @param string $_val    键名不存在时的默认值
 * @param bool   $ifTrans 是否需要强制保留为字符串格式，且留2位小数
 * 
 * @return data
 */
function getSessionValue($_key = "", $_val = "", $ifTrans = false)
{
    return getArrayValue($_key, $_val, $_SESSION, $ifTrans);
}

/**
 * 从指定数组中请求指定键名的值，若不存在，则返回预设值
 * 
 * @param string $_key    请求查询的键名
 * @param string $_val    键名不存在时的默认值
 * @param array  $_arr    请求检查的指定数组
 * @param bool   $ifTrans 是否需要强制保留为字符串格式，且留2位小数
 * 
 * @return data
 */
function getArrayValue($_key = "", $_val = "", $_arr = array(), $ifTrans = false)
{
    $ret = (!empty($_arr) && 
        array_key_exists((string)$_key, $_arr) &&
        $_arr[$_key] !== "")?$_arr[$_key]:$_val;
    if (is_string($ret)) {
        return urldecode($ret);
    } elseif (is_numeric($ret)) {
        if ($ifTrans) {
            return sprintf("%.2f", $ret);
            //return number_format($ret, 2);
        } else {
            return round($ret, 2);
        }
    } else {
        return $ret;
    }
}

/**
 * 加载指定的Html文件
 * 
 * @param string $_html 请求加载的Html文件名，该值应该是相对于根目录下的html的路径，文件路径中不需要填写.html
 * 
 * @return data
 */
function readHtml($_html)
{
    $filepath = "./html/".$_html.".html";
    if (is_file($filepath)) {
        return file_get_contents($filepath);
    } else {
        return "";
    }
}


/**
 * 对于有搜索相关处理的页面请求，封装的参数预处理函数
 * 
 * @param string $request URI请求时的参数组
 * 
 * @return array
 */
function parseCommonRequestArgus($request)
{
    $s_st = (int)parseTimeArgus("s_StartTime", time() - 30 * 24 * 60 * 60, $request);
    $s_et = (int)parseTimeArgus("s_EndTime", time(), $request);
    $s_start_idx = (int)getArrayValue(urlencode("data[3][value]"), 0, $request);//查询起始index
    $s_start_idx += 1;//($s_start_idx == 0)?1:$s_start_idx;//默认从1开始查询
    $s_count = (int)getArrayValue(urlencode("data[4][value]"), 999, $request);//查询的总条数
    $sEcho = (int)getArrayValue(urlencode("data[0][value]"), 1, $request);//疑似查询次数，界面的实际表现都是通过上、下或指定页面时会出现次数增加，其他时候都是1
    return array($s_st, $s_et, $s_start_idx, $s_count, $sEcho);
}

/**
 * 对于有搜索相关处理的页面请求，封装的JSON结果返回处理方法
 * 
 * @param intger $sSize  返回JSON数据中的data大小
 * @param intger $sEcho  页面JS翻页插件所需用到的当前页面ID
 * @param intger $sCount 页面搜索结果每页显示数量
 * @param array  $sDatas 预处理过的页面数据数组
 * 
 * @return array
 */
function outputSearchData($sSize, $sEcho, $sCount, $sDatas)
{
    return array(
        "sEcho" => $sEcho,
        "iTotalRecords"=> $sSize,
        "iTotalDisplayRecords"=>$sSize,//floor($sSize / $sCount), //取整，用于页数
        "aaData"=> $sDatas,
    );
}

/**
 * URI请求的统一对浏览器的输出方法，其他地方不得echo或print输出
 * 
 * @param string $_data 待输出的页面数据，可能为String，也可能为Array
 * @param string $_type 页面数据的待输出模式，目前为字符串或Json，默认为字符串，即直接打印
 * 
 * @return null
 */
function output($_data, $_type = "html")
{
    if ($_type == "html") {
        echo $_data;
    } elseif ($_type == "json") {
        if (getArrayValue("ShowDebug", "true", $GLOBALS) == "true") {
            $_data["DEBUG"] = getSessionValue("retJson", "[]");
        }
        echo json_encode($_data);
    } else {
        
        print_r($_data);
    }
}

/**
 * 生成统一页面头部Html的方法
 * 
 * @param string $Content 已经预处理过的头部Html
 * 
 * @return string
 */
function makeHeader($Content)
{
    $waitReplace = array(
        "Title" => "%TITLE%",
        "Nickname" => "%NICKNAME%",
        "TotalBalance" => "%TOTALBALANCE%",
    );

    foreach ($waitReplace as $_key => $_value) {
        if (isset($_SESSION[$_key])) {
            $_session_val = $_SESSION[$_key];
        } else {
            $_session_val = "TinyPennis";
        }
        $Content = str_replace($_value, $_session_val, $Content);
    }
    return $Content;
}



/**
 * 解析代理审核状态
 *
 * @param [type] $status 状态
 * 
 * @return void
 */
function parseAgentVerifyStatus($status)
{
    switch ($status) {
    case 1:
        $stag = "待审核";
        break;
    case 2:
        $stag = "正常";
        break;
    case 3:
        $stag = "锁定";
        break;
    case 4:
        $stag = "已拒绝";
        break;
    }
    return $stag;
}

/**
 * 处理floatStr
 *
 * @param [type] $floatStr 数据
 * 
 * @return void
 */
function parseFloatStr($floatStr)
{
    $fsa = array();
    if (!empty($floatStr) && $floatStr != "-") {
        foreach (explode("|", $floatStr) as $_fs) {
            $_ds = explode("_", $_fs);
            if (count($_ds) > 0) {
                $_d = array(
                    "amount"=>(float)getArrayValue(0, 0, $_ds),
                    "rate"=>(float)getArrayValue(1, 0, $_ds)
                );
                array_push($fsa, $_d);
            }
        }
    }
    return $fsa;
}

/**
 * 生成浮动比例的文字描述
 *
 * @param [type] $data 浮动比例数据
 * 
 * @return void
 */
function makeFloatStr($data)
{
    $_floatStr = array();
    if (count($data) > 0) {
        usort(
            $data, function ($a, $b) { 
                    return (float)$a["rate"] - (float)$b["rate"]; 
            }
        );
        reset($data);
        foreach ($data as $_data) {
            $_s = (float)$_data["amount"] . "_" . (float)$_data["rate"];
            array_push($_floatStr, $_s);
        }
    }
    return join("|", $_floatStr);
}

?>