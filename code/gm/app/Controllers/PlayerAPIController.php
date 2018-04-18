<?php
namespace App\Controllers;

use App\Config\Config;
use App\Libs\HttpRequest as http;
use App\ViewHelper\PlayerViewHelper as viewHelper;

class PlayerAPIController extends BaseController
{
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
    private static function searchOnlinePlayer($s_st, $s_et, $_stype, $_key, $_startIdx, $_count)
    {
        return http::gmHttpCaller("SearchPlayer", array(0, $s_et, 1, 0, 0, $_stype, $_key, $_startIdx, $_count));
    }


    
    public static function SearchAllPlayer($s_st, $s_et, $s_group, $_stype, $_key, $_startIdx, $_count)
    {
        return http::gmHttpCaller("SearchPlayer", array(0, $s_et, 0, 0, $s_group, $_stype, $_key, $_startIdx, $_count));
    }

    private static function SearchRegPlayer($s_st, $s_et, $status,  $_stype, $_key, $_startIdx, $_count)
    {
        return http::gmHttpCaller("SearchPlayer", array($s_st, $s_et, 0, $status, 0, $_stype, $_key, $_startIdx, $_count));
    }

    public static function onlineAjax($request)
    {
        $s_args = parseCommonRequestArgus($request);
        $s_type = getArrayValue("s_type", "", $request); //查询类别，account-账号，name-姓名，ip-IP，agent-代理，默认为account
        $s_key = getArrayValue("s_keyword", "", $request); //查询关键字
        // 后台查询数据
        $retJson = self::SearchOnlinePlayer($s_args[0], $s_args[1], $s_type, $s_key, $s_args[2], $s_args[3]);
        // 准备数据
        $retJson = $retJson ? $retJson[0] : [];
        $retSize = (int) getArrayValue("size", 0, $retJson);
        $retData = getArrayValue("data", array(), $retJson);
        return [
            "sEcho" => $s_args[4],
            "iTotalRecords" => $retSize,
            "iTotalDisplayRecords" => $retSize, //floor($sSize / $sCount), //取整，用于页数
            "aaData" => viewHelper::showOnlineRoles($retData),
        ];
    }

    public static function findplayerbynames($request)
    {
        $requestNamas = getArrayValue("usernames", "", $request);
        if (!empty($requestNamas)) {
            $ret = array(array("playerid"=>"alien", "playername"=>"大兄弟"));
        } else {
            $ret = array();
        }
        return $ret;
    }

    public static function listAjax1($request)
    {
        $s_args = parseCommonRequestArgus($request);
        $s_type = getArrayValue("s_type", "", $request);//查询类别，account-账号，name-姓名，ip-IP，agent-代理，默认为account
        $s_key = getArrayValue("s_keyword", "", $request);//查询关键字
        $s_group = getArrayValue("groupid", "", $request);//查询关键字
        $s_group = (empty($s_group))?0:$s_group;//默认从1开始查询
        // 后台查询数据
        $retJson = self::SearchAllPlayer($s_args[0], $s_args[1], $s_group, $s_type, $s_key, $s_args[2], $s_args[3]);;
        // 准备数据
        $retJson = $retJson ? $retJson[0] : [];
        $retSize = (int) getArrayValue("size", 0, $retJson);
        $retData = getArrayValue("data", array(), $retJson);
        return [
            "sEcho" => $s_args[4],
            "iTotalRecords" => $retSize,
            "iTotalDisplayRecords" => $retSize, //floor($sSize / $sCount), //取整，用于页数
            "aaData" => viewHelper::showAllRoles($retData),
        ];
    }

    public static function regDailyAjax($request)
    {
        $s_regday = getArrayValue("regday", parseDate(time(), 2), $request);//时间
        $request["s_StartTime"] = $s_regday." 00:00:00";
        $request["s_EndTime"] = $s_regday." 23:59:59";

        $s_args = parseCommonRequestArgus($request);
        $s_type = getArrayValue("s_type", "", $request);//查询类别，account-账号，name-姓名，ip-IP，agent-代理，默认为account
        $s_key = getArrayValue("s_keyword", "", $request);//查询关键字
        $s_status = (int)getArrayValue("s_status", 0, $request);//查询关键字
        // 后台查询数据
        $retJson = self::SearchRegPlayer($s_args[0], $s_args[1], $s_status, $s_type, $s_key, $s_args[2], $s_args[3]);;
        // 准备数据
        $retJson = $retJson ? $retJson[0] : [];
        $retSize = (int) getArrayValue("size", 0, $retJson);
        $retData = getArrayValue("data", array(), $retJson);
        return [
            "sEcho" => $s_args[4],
            "iTotalRecords" => $retSize,
            "iTotalDisplayRecords" => $retSize, //floor($sSize / $sCount), //取整，用于页数
            "aaData" => viewHelper::showRegRoles($retData),
        ];
    }

    public static function fundFlowAjax($request)
    {
        $s_args = parseCommonRequestArgus($request);
        $RequestBType = getArrayValue("s_btype", 0, $request);
        if ($RequestBType != 0) {
            $_btypes = explode(",", urldecode($RequestBType));
            $_btype = array_sum($_btypes);
        } else {
            $_btype = 63;
        }        
        $s_type = getArrayValue("s_type", "account", $request);
        $s_key = getArrayValue("s_keyword", '', $request);
        $admin = getArrayValue("admin", "", $request);
        $s_gpid = getArrayValue("s_gpid", 0, $request);
        
        $retJson = http::gmHttpCaller("GetAllPlayerBalanceRecord", array($_btype, $s_args[0], $s_args[1], $s_type, $s_key, $s_args[2], $s_args[3]));
        $staticJson = getArrayValue(1, array(), $retJson);

        $retJson = $retJson ? $retJson[0] : [];
        $retSize = (int) getArrayValue("size", 0, $retJson);
        $retData = getArrayValue("data", array(), $retJson);
        $pageData = viewHelper::showFundFlowHtml($retData);
        $pageStatic = $pageData[1];
        return [
            "sEcho" => $s_args[4],
            "iTotalRecords" => $retSize,
            "iTotalDisplayRecords" => $retSize, //floor($sSize / $sCount), //取整，用于页数
            "aaData" => $pageData[0],
            "dpt" => getArrayValue(1, 0, $staticJson),
            "wtd" => getArrayValue(2, 0, $staticJson),
            "bonusdpt" => getArrayValue(32, 0, $staticJson),
            "rakeback" => getArrayValue(16, 0, $staticJson),
            "trans" => getArrayValue(4, 0, $staticJson) + getArrayValue(8, 0, $staticJson),
            "pdpt"=> getArrayValue(1, 0, $pageStatic),
            "pwtd" => getArrayValue(2, 0, $pageStatic),
            "pbonus" => getArrayValue(32, 0, $pageStatic),
            "prakeback" => getArrayValue(16, 0, $pageStatic),
            "ptrans" => getArrayValue(4, 0, $pageStatic) + getArrayValue(8, 0, $pageStatic)
        ];
    }

    public static function getPlayerBaseInfo($request)
    {
        $ret = http::gmHttpCaller("GetPlayerBaseInfo", [$request["id"]]);
        $retData = $ret[0];
        return [
            "name" => $retData["name"],
            "layer" => $retData["groupName"],
            "status" => $retData["status"],
            "agent" => $retData["agentAccount"],
            "qq" => $retData["qq"],
            "cellPhoneNo" => $retData["cellPhoneNo"],
            "email" => $retData["email"],
            "joinTime" => parseDate($retData["joinTime"]),
            "joinIp" => $retData["joinIp"],
            "lastLoginTime" => parseDate($retData["lastLoginTime"]),
            "balance" => $retData["balance"],
        ];
    }

    public static function getPlayerStaticInfo($request)
    {
        $start = getArrayValue("start", "", $request);
        $end = getArrayValue("end", "", $request);

        $start = empty($start) ? time() - 60 * 24 * 60 * 30 : strtotime($start);
        $start = $start < 0 ? 0 : $start;

        $end = empty($end) ? time() : strtotime($end);
        $end = $end < 0 ? 0 : $end;

        $ret = http::gmHttpCaller("GetPlayerStatisticsInfo", [$request["uid"], $start, $end]);
        $retData = $ret[0];
        return $retData;
    }

    /**
     * 获取可以用的平台配置
     *
     * @param [type] $request URI参数
     *
     * @return void
     */
    public static function getPlatforms($request)
    {
        $account = $request["account"];
        // platform

        $balanceJson = http::gmHttpCaller("GetPlayerBalanceAmount", array($account, "MAIN"));
        if (isset($balanceJson[0]) && $balanceJson[0] == 1) {
            $MainBalance = $balanceJson[2];
            if (!array_key_exists($account, $_SESSION)) {
                $_SESSION[$account] = [];
            }
            $_SESSION[$account]["MAIN"] = $MainBalance;

            $GPList = Config::platform;
            $GPList["MAIN"] = "主账户";

            $GPData = [];
            foreach ($GPList as $_gp => $_gpname) {
                $_ = ["id" => $_gp, "name" => $_gpname, "status" => 1, "i" => "0", "s" => "", "e" => "", "flag" => 1, "nb" => 0];
                array_push($GPData, $_);
            }
            return [
                "code" => 0,
                "data" => [$GPData, (string) $MainBalance],
            ];
        };
    }

    public static function getGpBalance($request)
    {
        $account = $request["account"];
        $gp = $request["gpid"];
        return http::gmHttpCaller("GetPlayerBalanceAmount", array($account, $gp));
    }

    public static function fundReclaim($request)
    {
        $account = $request["account"];
        $gp = $request["gpid"];
        $amount = $request["amount"];
        return http::gmHttpCaller("TransactIn", array($account, $amount, $gp));
    }

    public static function doTransfer($request)
    {
        $account = $request["account"];
        $TransAmount = (float)$request["amount"];
        $TransFrom = $request["tout"];
        $TransTo = $request["tin"];

        if (empty($account) || empty($TransAmount) || empty($TransFrom) || empty($TransTo)) {
            return ["c"=>1236,"m"=>"","d"=>null]; 
        }

        if ($TransFrom == $TransTo) {
            return ["c"=>1080,"m"=>"不能同平台互转","d"=>null]; 
        }
        
        if ($TransFrom == "MAIN") {
            //主账户转出

            $retJson = http::gmHttpCaller("TransactOut", [$account, $TransAmount, $TransTo]);
        } else {
            //主账户转入
            $retJson = http::gmHttpCaller("TransactIn", [$account, $TransAmount, $TransFrom]);
        }

        if ($retJson[0]) {
            return ["c"=>0,"m"=>"","d"=>null]; 
        } else {
            return ["c"=>1080,"m"=>"转账失败，请联系运维","d"=>null]; 
        } 
    }


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
    public static function getFundList($_acc, $status, $_st, $_et, $dno = "", $_btype = 31)
    {
        $retJson = http::gmHttpCaller("GetPlayerBalanceRecord", array($_acc, $_btype, true, $dno, $_st, $_et, 1, 100));
        $records = $retJson["data"];
        $ret = ["size" => count($records), "data" => []];
        for ($x = 0; $x < count($records); $x ++ ) {
            $_record = $records[$x];
            $opType = getArrayValue("opType", 0, $_record);
            $typeStr = Config::opTypeMap[$opType];
            $status = $_record["checkStatus"];
            
            $rData = [
                "index"=>$x + 1,
                "btype"=>$typeStr,
                "dno"=>$_record["dno"],
                "amount"=>$_record["amount"],
                "created"=>parseDate(getArrayValue("time", time(), $_record)),
                "remark"=>$_record["note"],
                "sname"=>getArrayValue("csStaff", "todo:客服", $_record),
                "status"=>Config::statusMap[$status]
            ];
            array_push($ret["data"], $rData);

        };
        return $ret;
    }

    public static function getPlayerMessages($request)
    {
        $account = $request["account"];
        
        $retJson = http::gmHttpCaller("GetPlayerMessage", [$account]);
        $retData = getArrayValue(0, [], $retJson);
        $ret = ["data"=>[]];
        foreach ($retData as $_msg) {
            $_ = array(
                "title" => getArrayValue("title", "", $_msg),
                "content" => getArrayValue("content", "", $_msg),
                "created" => parseDate(getArrayValue("time", "", $_msg)),
                "readed" => (int)getArrayValue("messageStatus", 1, $_msg));
            array_push($ret["data"], $_);
        }
        return $ret;
    }


    
    /**
     * 请求玩家登录日志的接口
     *
     * @param [type] $request URI
     * 
     * @return void
     */
    public static function playerLoginRecord($request)
    {
        $RequestPlayer = getArrayValue("account", "", $request);
        $s_args = parseCommonRequestArgus($request);
        $retJson = http::gmHttpCaller("GetPlayerLoginRecord", array($RequestPlayer, $s_args[2], $s_args[3]));
        $retData = getArrayValue(0, array(), $retJson);

        $ret = array("data"=>array());
        foreach ($retData["data"] as $key=>$_ret) {
            if (getArrayValue("opType", "", $_ret) == 1) {
                array_push($ret["data"], array(
                    "index"=>getArrayValue("recordNum", "", $_ret),
                    "loginIp"=>getArrayValue("ip", "", $_ret),
                    "timestr"=>parseDate(getArrayValue("recordTime", "", $_ret)),
                    "remark"=>getArrayValue("note", "", $_ret),
                    "way"=>getArrayValue("way", "", $_ret),
                    "domain"=>getArrayValue("domain", "", $_ret),
                ));
            }
            
        }
        return $ret;
    }


    /**
     * 玩家详情界面 TAB7 - 获取玩家银行卡信息
     *
     * @param [array] $request URI请求的参数数组
     * 
     * @return void
     */
    public static function playerBankInfo($request)
    {
        $RequestMemberName = getArrayValue("account", "", $request);
        if (empty($RequestMemberName)) {
            return;
        }
        $retJson = http::gmHttpCaller("GetPlayerBankCardInfo", array($RequestMemberName));
        
        $cardsData = array("data"=>array());
        if (count($retJson) > 0) {
            $_SESSION[$RequestMemberName]["cards"] = $retJson[0];
            foreach ($retJson[0] as $_idx => $_card) {
                $btype = getArrayValue("bankType", "", $_card);
                $bankInfo = getArrayValue($btype, "", $GLOBALS["BankTypes"]);
                $_bankName = getArrayValue("name", "", $bankInfo);
                $_bankSN = getArrayValue("sn", "", $bankInfo);
                $_cardNo = getArrayValue("cardNo", "", $_card);
                $_cardIdx = getArrayValue("id", "", $_card);;
                $_regBank = getArrayValue("registerBank", "", $_card);
                $_status = getArrayValue("status", "", $_card);
                
                $_ = array(
                    "idx"=>$_cardIdx,
                    "sn"=>$_bankSN,
                    "bname"=>$_bankName,
                    // "pname"=>$realname,
                    "card"=>$_cardNo,
                    "bank"=>$_regBank,
                    "status"=>($_status == 1)?'<span class="label label-success">有效</span>':'<span class="label label-important">无效</span>',
                );
                array_push($cardsData["data"], $_);
            };
        }
        return $cardsData;
    }

    public static function changeAgent($request)
    {
        $playerId = $request["playerId"];
        $agentCode = $request["agentCode"];

        $retJson = http::gmHttpCaller("SetPlayerAgent", array((int)$playerId, (int)$agentCode));

        if (getArrayValue(0, "", $retJson) == 1) {
            return ["code"=>200, "Message"=>""];
        } else {
            return ["code"=>500, "Message"=>"error"];
        }
    }

    public static function adjust($request)
    {
        $account = getArrayValue("uid", "", $request);
        $atype = (int)getArrayValue("atype", 1, $request); // 调整类型， 1为增加，2为减少
        $amount = (float)getArrayValue("amount", 0, $request, true); // 调整金额
        if ($atype == 2){
            $amount = 0 - $amount;
        }
        if (empty($account)){
            $ret = array("c"=>404, "m"=>"请输入玩家账号", "d"=>null); 
        }else{
            $argus = array(
                    getArrayValue("uid", "", $request), // 调整玩家的账号
                    $amount,
                    urldecode(getArrayValue("remark", "", $request)), // 备注
                    "", //调试期间,暂时为空, getArrayValue("bcid", "", $request), // 平台银行卡的编号，包网商的配置
                    (float)getArrayValue("flows", 0, $request, true), // 调整取款流水的金额
                    "IBC",//调试期间,默认为IBC getArrayValue("gpid", "0", $request), // 对应平台ID，0为全平台
                    
                );
            
            $retJson = http::gmHttpCaller("PlayerAdjustBalanceAmount", $argus);
            if (getArrayValue(0, "", $retJson) == 1){
                $ret = array("c"=>0, "m"=>"adjust balance success", "d"=>$retJson); 
            }else{
                $ret = array("c"=>404, "m"=>$retJson[1], "d"=>$retJson); 
            }
        }
        return $ret;
    }

    public static function bonus($request)
    {

        $atype = (int)getArrayValue("atype", 1, $request); // 调整类型， 1为增加，2为减少
        $amount = (float)getArrayValue("amount", 0, $request, true); // 调整金额
        $account = getArrayValue("uid", "", $request);
        $note = urldecode(getArrayValue("remark", "", $request));
        $flow = (float)getArrayValue("flows", 0, $request, true);
        $gpId = getArrayValue("gpid", "", $request);
        if ($atype == 2){
            $amount = 0 - $amount;
        }
        if (empty($account)){
            $ret = array("c"=>404, "m"=>"请输入玩家账号", "d"=>null); 
        }else{
            $argus = array(
                $account, // 调整玩家的账号
                $amount,
                $note, // 备注
                0, //getArrayValue("actid", "", $request), // 对应平台ID，0为全平台
                $flow, // 流水限制金额
                $gpId, // 对应平台ID，0为全平台
            );
        
            $retJson = http::gmHttpCaller("PlayerGrantBonus", $argus);
            if (getArrayValue(0, "", $retJson) == 1){
                $ret = array("c"=>0, "m"=>"adjust balance success", "d"=>$retJson); 
            }else{
                $ret = array("c"=>404, "m"=>$retJson[1], "d"=>$retJson); 
            }
        }
        
        return $ret;
    }

    public static function pass($request)
    {
        $argus = array(
            getArrayValue("dno", "", $request), // 申请的订单号
            (float)getArrayValue("actual", 0, $request, true), // 真实的资金数量
            (float)getArrayValue("ddeals", 0,  $request, true), // 存款补助金额
            (float)getArrayValue("bonus", 0, $request, true), // 本次红利金额

            (float)getArrayValue("flows", 0, $request, true), // 取款流水限制
            getArrayValue("dgpid", 0, $request), // 存款流水限平台
            getArrayValue("bgpid", 0, $request), // 红利流水限平台
            getArrayValue("actid", 0, $request), // 对应的活动ID
            urldecode(getArrayValue("dealremark", "TODO", $request)), // 备注信息

        );

        $retJson = http::gmHttpCaller("DepositApplyAgree", $argus);
        if (getArrayValue(0, "", $retJson) == 1) {
            $ret = array("c"=>0, "m"=>"adjust balance success", "d"=>$retJson); 
        } else {
            $ret = array("c"=>404, "m"=>getArrayValue(1, "科多没有写错误原因", $retJson), "d"=>$retJson); 
        }
        return $ret;
    }

    public static function refuse($request){

        $requestdno = getArrayValue("dno", "", $request);
        $remark  = getArrayValue("dealremark", "TODO", $request);

        if (empty($requestdno) || empty($remark)){
            return false;
        }

        $retJson = http::gmHttpCaller("DepositApplyRefuse", array($requestdno, $remark));
        if (getArrayValue(0, "", $retJson) == 1){
            $ret = array("c"=>0, "m"=>"adjust balance success", "d"=>$retJson); 
        }else{
            $ret = array("c"=>404, "m"=>getArrayValue(1, "科多没有写错误原因", $retJson), "d"=>$retJson); 
        }
        return $ret;
    }

    public static function setGroup($request)
    {
        $groupId = (int)getArrayValue("groupid", 0, $request);
        $playerId = getArrayValue("playerid", "", $request);

        if ($groupId == 0 || empty($playerId)) {
            return ["code"=>500, "Message"=>"参数错误"];
        } else {
            $retJson = http::gmHttpCaller("SetPlayerGroup", array($playerId, $groupId));

            if (getArrayValue(0, "", $retJson) == 1) {
                return ["code"=>200, "Message"=>"修改成功"];
            } else {
                return ["code"=>200, "Message"=>"修改失败"];
            }
        }
    }

    public static function saveRemark($request)
    {
             
        $account = getArrayValue("uid", "", $request);
        $remark = getArrayValue("remark", "", $request);
        
        if (empty($account) || empty($remark)) {
            return ["code"=>404, "Message"=>"error"];
        }
        $retJson = http::gmHttpCaller("ModifyPlayerNote", array($account, parseNote($remark)));
        
        if (getArrayValue(0, "", $retJson) == 1) {
            $retJson = array("code"=>200);
        } else {
            $retJson = array("code"=>404);
        }
        return $retJson;
    }

    public static function lockPlayer($request)
    {
        $RequestPlayer = getArrayValue("playerid", "", $request);
        $RequestAction = getArrayValue("action", "", $request);
        if (empty($RequestPlayer) || empty($RequestAction)) {
            return [false];
        }
        if ($RequestAction == "unlock") {
            $retJson = http::gmHttpCaller("UnlockPlayer", array($RequestPlayer));
        } else {
            $retJson = http::gmHttpCaller("LockPlayer", array($RequestPlayer));
        }
        $ret = array("code"=>200, "Message"=>"");
        return $ret;
    }

    public static function kickdown($request)
    {
        $RequestPlayer = getArrayValue("id", "", $request);
        if (empty($RequestPlayer)) {
            return false;
        }
        $retJson = http::gmHttpCaller("KickPlayer", array($RequestPlayer));
        return $retJson;
    }

    public static function getDetailInfo($request)
    {
        $account = $request["id"];
        $_SESSION["RequestMemberName"] = $account;


        $retJson = http::gmHttpCaller("GetPlayerBaseInfo", array($account));
        $playerdata = getArrayValue(0, array(), $retJson);
        
        $groupName = getArrayValue("groupName", 0, $playerdata);
        $status = getArrayValue("status", 0, $playerdata);
        $timeTag = getArrayValue("joinTime", "", $playerdata);
        $t =[
            "account"=>$account,
            "name"=>getArrayValue("name", "", $playerdata),
            "layer"=>$groupName,
            "status"=>Config::playerStatusMap[$status],
            "agent"=>getArrayValue("agentName", "", $playerdata),
            "qq"=>getArrayValue("qq", "", $playerdata),
            "cellPhoneNo"=>getArrayValue("cellPhoneNo", "", $playerdata),
            "birthDate"=>getArrayValue("birthDate", "", $playerdata),
            "email"=>getArrayValue("email", "", $playerdata),
            "joinTime"=>parseDate($timeTag),
            "joinIp"=>getArrayValue("joinIp", "", $playerdata),
            "lastLoginTime"=>parseDate(getArrayValue("lastLoginTime", "", $playerdata)),
            "mainBalance"=>getArrayValue("mainBalance", "", $playerdata),
        ];
        return $t;
    }

    public static function editProf($request)
    {
        $RequestPlayer = getArrayValue("uid", "", $request);
        $RequestEmail = urldecode(getArrayValue("email", "", $request));
        $RequestQQ = getArrayValue("qq", "", $request);
        $RequestPhone = getArrayValue("mobile", "", $request);
        $Requestbirthday = urldecode(getArrayValue("birthday", "", $request));
        $RequestName = urldecode(getArrayValue("realname", "", $request));
        if (empty($RequestPlayer)) {
            return false;
        }

        $retJson = http::gmHttpCaller("ModifyPlayerBaseInfo", array($RequestPlayer, $RequestName,  $RequestQQ, $RequestPhone, $Requestbirthday, $RequestEmail));
        if (getArrayValue(0, "", $retJson) == 1) {
            $ret = array("code"=>200, "Message"=>"玩家数据修改成功!");
        } else {
            $ret = array("code"=>404, "Message"=>"数据修改失败,请联系管理员!");
        }
        return $ret;
    }

    public static function resetpwd($request)
    {
        $RequestPlayer = getArrayValue("uid", "", $request);
        $RequestPasswd = getArrayValue("pwd", "", $request);
       
        if (empty($RequestPlayer) || empty($RequestPasswd)) {
            return false;
        }
        $retJson = http::gmHttpCaller("ModifyPlayerPwd", array($RequestPlayer, $RequestPasswd));
        if (getArrayValue(0, "", $retJson) == 1) {
            $ret = array("code"=>200, "Message"=>"玩家数据修改成功!");
        } else {
            $ret = array("code"=>404, "Message"=>"数据修改失败,请联系管理员!");
        }
        return $ret;
    }
}
