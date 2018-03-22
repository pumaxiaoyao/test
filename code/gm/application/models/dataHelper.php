<?php

/**
 * 获取交易记录
 *
 * @param [type] $_acc   账号
 * @param [type] $status 状态
 * @param [type] $_st    起始时间
 * @param [type] $_et    结束时间
 * @param [type] $dno    订单号
 * @param [type] $_btype 查询标识码
 * 
 * @return void
 */
function getFundList($_acc, $status, $_st, $_et, $dno = "", $_btype = 31)
{
    $ret = array("data" => array(), "size" => 0);
    $retJson = gmServerCaller("GetPlayerBalanceRecord", array($_acc, $_btype, true, $dno, $_st, $_et, 1, 100));
    // output($retJson, "json");
    // $transRecordType = $GLOBALS["Record_Types"][2];
    $retJson = getArrayValue(0, array(), $retJson);
    $records = getArrayValue("data", array(), $retJson);
    
    foreach ($records as $_record) {
        $opType = getArrayValue("opType", 0, $_record);
        $typeStr = parseRecodeTypes(2, $opType);
        $status = (int)getArrayValue("checkStatus", 0, $_record);
        if ($status == 2) {
            $sStr = "成功";
        } else if ($status == 4) {
            $sStr = "已拒绝";
        } else if ($status == 1) {
            $sStr = "待审批";
        }
        $rData = array("index"=>getArrayValue("recordNum", 0, $_record),
            "btype"=>$typeStr,
            "dno"=>getArrayValue("dno", "", $_record),
            "amount"=>getArrayValue("amount", 0, $_record, true),
            "created"=>parseDate(getArrayValue("time", time(), $_record)),
            "remark"=>getArrayValue("note", "", $_record),
            "sname"=>getArrayValue("csStaff", "todo:客服", $_record),
            "status"=>$sStr
        );
        array_push($ret["data"], $rData);

    };
    $ret["size"] = count($ret["data"]);
    return $ret;
}

/**
 * 查询在线玩家接口的二次封装
 *
 * @param [type] $s_st      开始时间
 * @param [type] $s_et      结束时间
 * @param [type] $_stype    查询类型
 * @param [type] $_key      查询关键字
 * @param [type] $_startIdx 查询起始标志位
 * @param [type] $_count    查询数量
 * 
 * @return void
 */
function searchOnlinePlayer($s_st, $s_et, $_stype, $_key, $_startIdx, $_count)
{
    return gmServerCaller("SearchPlayer", array($s_st, $s_et, 1, 0, 0, $_stype, $_key, $_startIdx, $_count));
}

/**
 * 查询全部玩家接口的二次封装
 *
 * @param [type] $s_st      开始时间
 * @param [type] $s_et      结束时间
 * @param [type] $s_group   查询玩家组
 * @param [type] $_stype    查询类型
 * @param [type] $_key      查询关键字
 * @param [type] $_startIdx 查询起始标志位
 * @param [type] $_count    查询数量
 * 
 * @return void
 */
function searchAllPlayer($s_st, $s_et, $s_group, $_stype, $_key, $_startIdx, $_count)
{
    return gmServerCaller("SearchPlayer", array($s_st, $s_et, 0, 0, $s_group, $_stype, $_key, $_startIdx, $_count));
}

/**
 * 查询当天注册玩家接口的二次封装
 *
 * @param [type] $s_st      开始时间
 * @param [type] $s_et      结束时间
 * @param [type] $status    状态
 * @param [type] $_stype    查询类型
 * @param [type] $_key      查询关键字
 * @param [type] $_startIdx 查询起始标志位
 * @param [type] $_count    查询数量
 * 
 * @return void
 */
function searchRegPlayer($s_st, $s_et, $status,  $_stype, $_key, $_startIdx, $_count)
{
    return gmServerCaller("SearchPlayer", array($s_st, $s_et, 0, $status, 0, $_stype, $_key, $_startIdx, $_count));
}

/**
 * 初始化一个PDO数据链接
 *
 * @return void
 */
function initPDO()
{
    $dbConf = $GLOBALS["mysql"];
    $dbDesc = 'mysql:host=' . $dbConf["host"] . ";port=" . $dbConf["port"] . ";dbname=" . $dbConf["db"];
    $dbh = new PDO($dbDesc, $dbConf["user"], $dbConf["pwd"]);
    $dbh->exec("set names 'utf8'");
    return $dbh;
}


/**
 * DB 检查账号是否存在的方法
 *
 * @param [type] $account 玩家账号ID
 * 
 * @return void
 */
function dbCheckUser($account)
{
    $dbh = initPDO();
    $checkSQL = "SELECT * from gmusers where account=?";
    $user = $dbh->prepare($checkSQL);
    $user->bindValue(1, $account, PDO::PARAM_STR);
    $ret = $user->execute();
    $result = count($user->fetchAll(PDO::FETCH_ASSOC)) == 0?true:false;
    $dbh = null;
    return $result;
}

/**
 * DB 登录检查账号密码
 *
 * @param [type] $account 玩家账号ID
 * @param [type] $passwd  玩家账号密码
 *  
 * @return void
 */
function dbCheckLogin($account, $passwd)
{
    $dbh = initPDO();
    $checkSQL = "SELECT * from gmusers where account=? and password=?";
    $user = $dbh->prepare($checkSQL);
    $ret = $user->execute(array($account, $passwd));
    $result = count($user->fetchAll(PDO::FETCH_ASSOC)) == 1?true:false;
    $dbh = null;
    return $result;
}

/**
 * DB 创建账号
 *
 * @param [type] $account 账号
 * @param [type] $passwd  密码
 *
 * @return void
 */
function dbCreateUser($account, $passwd)
{
    $dbh = initPDO();
    $createSQL = "INSERT INTO gmusers (`account`, `password`, `regtime`, `lastlogintime`) VALUES (?, ?, ?, ?)";
    $stmt = $dbh->prepare($createSQL);
    $stmt->execute(array($account, $passwd, time(), time()));
    $dbh = null;
}




?>