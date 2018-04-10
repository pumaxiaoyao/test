<?php
/**
 * 工具库
 */

use App\Config\Config;

/**
 * 解析Get或Post请求的参数
 */
function parseRequest()
{
    $func_query = parseArgus();
    $func_posts = parsePost();
    return !$func_posts ? $func_query : $func_posts;
}

// 解析post数据
function parsePost()
{
    $_PostData = file_get_contents('php://input');
    if (strpos($_PostData, "=") !== false) {
        $ret = parseArgus(explode("&", $_PostData));
    } else {
        $ret = json_decode($_PostData, true);
    }

    return $ret;
}

// 解析uri参数
function parseArgus($querys = "")
{
    if (empty($querys)) {
        $querys = explode("&", $_SERVER['QUERY_STRING']);
    }

    $ret = array();
    foreach ($querys as $_query) {
        if (!empty($_query)) {
            $_q = explode("=", $_query);
            $ret[$_q[0]] = $_q[1];
        }
    }
    return $ret;
}

function parseDate($timeTag = 0, $Ttype = 1)
{
    /**
     * 转时间格式
     */
    if (!$timeTag)
        return "";

    if ($timeTag === 0) {
        $timeTag = time();
    }
    if ($Ttype == 1) {
        return date("Y-m-d H:i:s", $timeTag);
    } else if ($Ttype == 2) {
        return date("Y-m-d", $timeTag);
    } else {
        return date("Y-m-d", $timeTag) . "<br/>" . date("H:i:s", $timeTag);
    }
}

/**
 * 自定义的分页数据管理方法
 */
function paginate($data, $pageCount, $curPage)
{
    $dataCount = count($data);
    $dataStart = $pageCount * ($curPage - 1);
    $dataPages = (int) ceil($dataCount / $pageCount);

    if ($dataCount < $dataStart) {
        $curPage = 1;
        $dataStart = 0;
    }

    if ($dataStart + $pageCount < $dataCount) {
        $dataEnd = $dataStart + $pageCount;
    } else {
        $dataEnd = $dataCount;
    }

    $showData = array_slice($data, $dataStart, $dataEnd);

    return [$showData, $dataPages, $curPage];
}

function getSessionValue($_key = "", $_value = "")
{
    return (isset($_SESSION[$_key]) && !empty($_SESSION[$_key]))?$_SESSION[$_key] : $_value;
}

function getArrayValue($_key = "", $_value = "", $_arr = array(), $ifTrans = false)
{

    $ret = (!empty($_arr) && array_key_exists((string)$_key, $_arr) && $_arr[$_key] !== "")?$_arr[$_key]:$_value;

    if (is_string($ret)) {
        return urldecode($ret);
    } elseif (is_numeric($ret)) {
        if ($ifTrans) {
            return sprintf('%.2f', $ret);
        } else {
            return round($ret, 2);
        }
    } else {
        return $ret;
    }
}

function LoginReset($rootUri = "player", $needRefer = true)
{
    /**
     * 重置session数据
     */

    $skeys = Config::validatorConfig[$rootUri]["skey"];

    foreach ($skeys as $rsKey) {
        $_SESSION[$rsKey] = "";
    }

    try {
        session_regenerate_id(true);
    } catch (Exception $e) {
        // print_r($e);
    }

    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    if ($needRefer) {
        header("location:/");
    }

}
// ------------------------------------------------------------------
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
    return [$s_st, $s_et, $s_start_idx, $s_count, $sEcho];
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

function getIp()
{
    //strcasecmp 比较两个字符，不区分大小写。返回0，>0，<0。
    if (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
        $ip = getenv('HTTP_CLIENT_IP');
    } elseif (getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
        $ip = getenv('HTTP_X_FORWARDED_FOR');
    } elseif (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
        $ip = getenv('REMOTE_ADDR');
    } elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    $res = preg_match('/[\d\.]{7,15}/', $ip, $matches) ? $matches[0] : '';
    return $res;
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