<?php
/**
 * 工具库
 */

use App\Config\Config;


function xmlParse($xml)
{
    $data = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA | LIBXML_NOBLANKS);
    if (is_object($data) && get_class($data) === 'SimpleXMLElement') {
        $data = \arrarval($data);
    }
    return $data;
}

/**
 * 把对象转换成数组.
 *
 * @param string $data 数据
 *
 * @return array
 */
function arrarval($data)
{
    if (is_object($data) && get_class($data) === 'SimpleXMLElement') {
        $data = (array) $data;
    }
    if (is_array($data)) {
        foreach ($data as $index => $value) {
            $data[$index] = arrarval($value);
        }
    }
    return $data;
}

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
     * $rootUri 只能是player 和 agent
     */
    $rootUri = ($rootUri == "player") ? $rootUri : "agent";
    $skey = Config::validatorConfig[$rootUri]["skey"];
    
    unset($_SESSION[$skey]);

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

function parseRecodeTypes($codeID, $codeID1)
{
    /**
     * 解析日志状态码
     */
    $statusData = getArrayValue($codeID, array(), $GLOBALS["Record_Types"]);
    return getArrayValue($codeID1, "", $statusData);
}

function getAgentBankInfo($LoginStatus)
{
    $retJson = agentServerCaller("GetBankCardInfo", array($LoginStatus[3]));
    if ($retJson["code"] == 200) {
        $records = getArrayValue(0, array(), $retJson["data"]);
    } else {
        $records = array();
    }
    return $records;
}

function getTime($t_tag = "today")
{
    if ($t_tag == "today") {
        $s_st = time() - 24 * 60 * 60;
    } elseif ($t_tag == "3day") {
        $s_st = time() - 24 * 60 * 60 * 3;
    } elseif ($t_tag == "week") {
        $s_st = time() - 24 * 60 * 60 * 7;
    } elseif ($t_tag == "month") {
        $s_st = time() - 24 * 60 * 60 * 30;
    } else {
        $s_st = time() - 24 * 60 * 60 * 30;
    }

    return $s_st;
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
