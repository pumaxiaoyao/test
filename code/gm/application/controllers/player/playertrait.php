<?php

/**
 * Player的API接口trait，用于提供给Js_Ajax请求的方法定义
 * 
 * @category Application/controllers/player
 * @package  Player
 * @author   alien <alien@alien.com>
 * @license  http://license.alien.com/license, alien
 * @link     null
 */
trait PlayerTrait
{
    /**
     * 获取在线玩家的数据的Api接口
     *
     * @param [array] $request URI请求的参数数组
     * 
     * @return void
     */
    static function onlineAjax($request)
    {
        $s_args = parseCommonRequestArgus($request);
        $s_type = getArrayValue("s_type", "", $request);//查询类别，account-账号，name-姓名，ip-IP，agent-代理，默认为account
        $s_key = getArrayValue("s_keyword", "", $request);//查询关键字
        // 后台查询数据
        $retJson = SearchOnlinePlayer($s_args[0], $s_args[1], $s_type, $s_key, $s_args[2], $s_args[3]);
        // 准备数据
        $retJson = getArrayValue(0, array(), $retJson);
        $retSize = (int)getArrayValue("size", 0, $retJson);
        $retData = getArrayValue("data", array(), $retJson);
        $ret = outputSearchData($retSize, $s_args[4], $s_args[3], showOnlineRoles($retData));
        return output($ret, "json");
    }

    /**
     * 获取所有玩家的数据的Api接口
     *
     * @param [array] $request URI请求的参数数组
     * 
     * @return void
     */
    static function listAjax1($request)
    {
        $s_args = parseCommonRequestArgus($request);
        $s_type = getArrayValue("s_type", "", $request);//查询类别，account-账号，name-姓名，ip-IP，agent-代理，默认为account
        $s_key = getArrayValue("s_keyword", "", $request);//查询关键字
        $s_group = getArrayValue("groupid", "", $request);//查询关键字
        $s_group = (empty($s_group))?0:$s_group;//默认从1开始查询
        // 获取后台查询数据
        $retJson = SearchAllPlayer($s_args[0], $s_args[1], $s_group, $s_type, $s_key, $s_args[2], $s_args[3]);
        // 准备数据
        $retJson = getArrayValue(0, array(), $retJson);
        $retSize = (int)getArrayValue("size", 0, $retJson);
        $retData = getArrayValue("data", array(), $retJson);
        $ret = outputSearchData($retSize, $s_args[4], $s_args[3], showAllRoles($retData));
        return output($ret, "json");
    }

    /**
     * 获取今天注册玩家的数据的Api接口
     *
     * @param [array] $request URI请求的参数数组
     * 
     * @return void
     */
    static function regDailyAjax($request)
    {
        $s_regday = getArrayValue("regday", parseDate(time(), 2), $request);//时间
        $request["s_StartTime"] = $s_regday." 00:00:00";
        $request["s_EndTime"] = $s_regday." 23:59:59";
        $s_args = parseCommonRequestArgus($request);
        $s_type = getArrayValue("s_type", "", $request);//查询类别，account-账号，name-姓名，ip-IP，agent-代理，默认为account
        $s_key = getArrayValue("s_keyword", "", $request);//查询关键字
        $s_status = (int)getArrayValue("s_status", 0, $request);//查询关键字
        
        $retJson = SearchRegPlayer($s_args[0], $s_args[1], $s_status, $s_type, $s_key, $s_args[2], $s_args[3]);
        $retJson = getArrayValue(0, array(), $retJson);
        $retSize = (int)getArrayValue("size", 0, $retJson);
        $retData = getArrayValue("data", array(), $retJson);
        $ret = outputSearchData($retSize, $s_args[4], $s_args[3], showRegRoles($retData));
        return output($ret, "json");
    }

    /**
     * 玩家详情界面 TAB3- 获取玩家的交易数据的Api接口
     *
     * @param [array] $request URI请求的参数数组
     * 
     * @return void
     */
    static function fundList($request)
    {
        $MemberName = getArrayValue("account", "", $request);
        $RequestBType = getArrayValue("btypes", 0, $request);
        if ($RequestBType != 0) {
            $_btypes = explode(",", urldecode($RequestBType));
            $_btype = array_sum($_btypes);
        } else {
            $_btype = 31;//传参搜索时，为空就真的空，不能替换为全部搜索
        }
        
        $rstatus = (int)getArrayValue("status", 1, $request);
        if ($rstatus === 1) {
            $RequestStatus = true;
        } else {
            $RequestStatus = false;
        }
        $RequestDno = getArrayValue("dno", "", $request);

        $RequestStart = parseTimeArgus("start", time() - 30 * 24 * 60 * 60, $request);
        $RequestEnd = parseTimeArgus("end", time(), $request);
        $ret = getFundList($MemberName, $RequestStatus, $RequestStart, $RequestEnd, $RequestDno,  $_btype);
        
        output($ret, "json");
    }


    /**
     * 玩家详情界面 TAB4 - 获取玩家的历史消息数据的Api接口
     *
     * @param [array] $request URI请求的参数数组
     * 
     * @return void
     */
    static function playerMessage($request)
    {
        $RequestMemberName = getArrayValue("account", "", $request);
        if (empty($RequestMemberName)) {
            return;
        }
        $retJson = gmServerCaller("GetPlayerMessage", array($RequestMemberName));
        $retData = getArrayValue(0, array(), $retJson);
        $ret = array("data"=>array());
        foreach ($retData as $_msg) {
            $_ = array(
                    "title" => getArrayValue("title", "", $_msg),
                    "content" => getArrayValue("content", "", $_msg),
                    "created" => parseDate(getArrayValue("time", "", $_msg)),
                    "readed" => (int)getArrayValue("messageStatus", 1, $_msg));
            array_pusha($ret["data"], $_);
        }
        return output($ret, "json");
    }

    /**
     * 玩家详情界面 TAB7 - 获取玩家银行卡信息
     *
     * @param [array] $request URI请求的参数数组
     * 
     * @return void
     */
    static function playerBankInfo($request)
    {
        $RequestMemberName = getArrayValue("account", "", $request);
        if (empty($RequestMemberName)) {
            return;
        }
        $retJson = gmServerCaller("GetPlayerBankCardInfo", array($RequestMemberName));
        
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
        return output($cardsData, "json");
    }
           
    

    /**
     * 获取客服对玩家的操作日志记录
     *
     * @param [type] $request URI参数
     * 
     * @return void
     */
    function getCsLog($request)
    {
        //不知道需要返回数据不，未找到数据原型
        //暂时无时间去分析js逆推数据格式
    }


    /**
     * 玩家详情界面 - 获取玩家的交易数据的Api接口
     *
     * @param [type] $request URI参数
     * 
     * @return void
     */
    function fundFlowAjax($request)
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
        
        $retJson = gmServerCaller("GetAllPlayerBalanceRecord", array($_btype, $s_args[0], $s_args[1], $s_type, $s_key, $s_args[2], $s_args[3]));
        $staticJson = getArrayValue(1, array(), $retJson);
        $retJson = getArrayValue(0, array(), $retJson);
        $retSize = (int)getArrayValue("size", 0, $retJson);
        $retData = getArrayValue("data", array(), $retJson);
        $pageData = makeFundFlowHtml($retData);
        $ret = outputSearchData($retSize, $s_args[4], $s_args[3], $pageData[0]);
        $pageStatic = getArrayValue(1, array(), $pageData);

        $ret["dpt"] = getArrayValue(1, 0, $staticJson);
        $ret["wtd"] = getArrayValue(2, 0, $staticJson);
        $ret["bonusdpt"] = getArrayValue(32, 0, $staticJson);
        $ret["rakeback"] = getArrayValue(16, 0, $staticJson);
        $ret["trans"] = getArrayValue(4, 0, $staticJson) + getArrayValue(8, 0, $staticJson);
        $ret["pdpt"] = getArrayValue(1, 0, $pageStatic);
        $ret["pwtd"] = getArrayValue(2, 0, $pageStatic);
        $ret["pbonus"] = getArrayValue(32, 0, $pageStatic);
        $ret["prakeback"] = getArrayValue(16, 0, $pageStatic);
        $ret["ptrans"] = getArrayValue(4, 0, $pageStatic) + getArrayValue(8, 0, $pageStatic);

        return output($ret, "json");
    }


    /**
     * 踢号下线的API
     *
     * @param [type] $request URI请求
     * 
     * @return void
     */
    function kickdown($request)
    {
        $RequestPlayer = getArrayValue("id", "", $request);
        if (empty($RequestPlayer)) {
            return false;
        }
        $retJson = gmServerCaller("KickPlayer", array($RequestPlayer));
        return output($retJson, "json");
    }

    /**
     * 锁定玩家的API
     *
     * @param [type] $request URI参数
     * 
     * @return void
     */
    function lockPlayer($request)
    {
        $RequestPlayer = getArrayValue("playerid", "", $request);
        $RequestAction = getArrayValue("action", "", $request);
        if (empty($RequestPlayer) || empty($RequestAction)) {
            return false;
        }
        if ($RequestAction == "unlock") {
            $retJson = gmServerCaller("UnlockPlayer", array($RequestPlayer));
        } else {
            $retJson = gmServerCaller("LockPlayer", array($RequestPlayer));
        }
        $ret = array("code"=>200, "Message"=>"");
        return output($ret, "json");
    }
    
    /**
     * 构建玩家活跃度界面
     *
     * @param [type] $request URI请求参数
     * 
     * @return void
     */
    static function playerActiveTable($request)
    {
        $RequestPlayer = getArrayValue("uid", "", $request);
        $RequestStart = parseTimeArgus("start", time() - 30 * 24 * 60 * 60, $request);
        $RequestEnd = parseTimeArgus("end", time(), $request);
        
        if (empty($RequestPlayer) || empty($RequestStart) || empty($RequestEnd)) {
            $retJson = array();
        } else {
            $retJson = gmServerCaller("GetPlayerStatisticsInfo", array($RequestPlayer, $RequestStart, $RequestEnd));
            $retJson = getArrayValue(0, array(), $retJson);
        }
        makeActiveHtml($retJson, $RequestStart, $RequestEnd);
    }

    /**
     * 资金调整界面 - 玩家名查询
     *
     * @param [type] $request URI参数
     * 
     * @return void
     */
    static function playerListModel($request)
    {
        $requestKey = getArrayValue("k", "", $request);
        // $retJson = gmServerCaller("", array($requestKey));
        $s_args = parseCommonRequestArgus($request);
        $s_type = getArrayValue("s_type", "", $request);//查询类别，account-账号，name-姓名，ip-IP，agent-代理，默认为account
        $s_key = getArrayValue("s_keyword", "", $request);//查询关键字
        $s_group = getArrayValue("groupid", "", $request);//查询关键字
        $s_group = (empty($s_group))?0:$s_group;//默认从1开始查询
        // 获取后台查询数据
        $retJson = SearchAllPlayer($s_args[0], $s_args[1], $s_group, "account", $requestKey, $s_args[2], 100);
        $retJson = getArrayValue(0, array(), $retJson);
        $memberData = array();
        foreach (getArrayValue("data", array(), $retJson) as $_member) {
            $name = getArrayValue("name", "", $_member);
            $account = getArrayValue("account", "", $_member);
            
            if ($requestKey !== "" && strpos($account, $requestKey) === false) {
                continue;
            }
            array_push($memberData, array("name"=>$name, "account"=>$account));
        }
        return output(makePlayerListHtml($memberData));
    }

    /**
     * 资金活跃界面 - 玩家名查询
     *
     * @param [type] $request URI参数
     * 
     * @return void
     */
    function findplayerbynames($request)
    {
        $requestNamas = getArrayValue("usernames", "", $request);
        if (!empty($requestNamas)) {
            $ret = array(array("playerid"=>"alien", "playername"=>"大兄弟"));
        } else {
            $ret = array();
        }
        return output($ret, 'json');
    }
        

    /**
     * 获取防套利数据，待接入
     *
     * @param [type] $request URI接口
     * 
     * @return void
     */
    function getSameIps($request)
    {
        $RequestPlayer = getArrayValue("uid", "", $request);
        return output("");
        // $sameIps = json_decode(getServerJSon("player/getSameIps", array("playerID"=>$uid)), true);

        // $page = file_get_contents("./application/controllers/playerdata/getSameIps.html");
        // $sameips_html = "";
        // if(count($sameIps)>0){
        //     foreach($sameIps as $_player){
        //         $_html = "<tr><td>";
        //         $_html = $_html.(string)$_player[0]."</td><td>";
        //         $_html = $_html.(string)$_player[1]."</td><td>";
        //         $_html = $_html.(string)$_player[2]."<br/><label ipTag='ipTag' ip='".(string)$_player[2]."'></label></td><td>";
        //         $_html = $_html.(string)$_player[3]."</td><td></tr>";
        //         $sameips_html = $sameips_html.$_html;
        //     }
        // }
        // $page = str_replace("%SAMEIPDATA%", $sameips_html, $page);
        // echo $page;
    }
    
    /**
     * 请求玩家登录日志的接口
     *
     * @param [type] $request URI
     * 
     * @return void
     */
    static function playerLoginRecord($request)
    {
        $RequestPlayer = getArrayValue("account", "", $request);
        $s_args = parseCommonRequestArgus($request);
        $retJson = gmServerCaller("GetPlayerLoginRecord", array($RequestPlayer, $s_args[2], $s_args[3]));
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
        return output($ret, "json");
    }
    /**
     * 银行卡详细数据
     *
     * @param [type] $request URI接口数据
     * 
     * @return void
     */
    function withdrawCard($request)
    {
        $card_idx = (int)getArrayValue("wdbankid", "", $request);
        $account  = getSessionValue("RequestMemberName", "");
        if (empty($account)) {
            return false;
        }
        if (isset($_SESSION[$account]["cards"])) {
            $page = readHtml("playerDetail/playerWithdrawCard");
            $memberCards = $_SESSION[$account]["cards"];
            $requestCard = $memberCards[$card_idx - 1];
            // print_r($requestCard);
            $bankType = $requestCard["bankType"];
            $options = "";
            foreach ($GLOBALS["BankTypes"] as $_type => $_card) {
                if ($_type == $bankType) {
                    $options = $options.'<option selected value="'.(string)$_type.'">'.$_card["name"]."</option>";
                } else {
                    $options = $options.'<option value="'.(string)$_type.'">'.$_card["name"]."</option>";
                }
            }
            $status = "";

            for ($x=0;$x<3;$x++) {
                if ($x == $requestCard["status"]) {
                    $status =$status.'<option value="'.(string)$x.'" selected="selected">'.$GLOBALS["BankStatusOptions"][$x]."</option>";
                } else {
                    $status =$status.'<option value="'.(string)$x.'">'.$GLOBALS["BankStatusOptions"][$x]."</option>";
                }
            }
            $page = str_replace("%CardIdx%", $card_idx, $page);
            $page = str_replace("%StatusOptions%", $status, $page);
            $page = str_replace("%registerBank%", urldecode($requestCard["registerBank"]), $page);
            $page = str_replace("%CardNo%", $requestCard["cardNo"], $page);
            $page = str_replace("%RealName%", urldecode($requestCard["name"]), $page);
            $page = str_replace("%BankOptions%", $options, $page);
        } else {
            $page = "";
        }
        output($page);
    }

    /**
     * 修改银行卡数据
     *
     * @param [array] $request URI请求数据
     * 
     * @return void
     */
    function editWDCard($request)
    {
        $errorRet = $GLOBALS["errorRet"];
        if (empty($RequestArgs)) {
            $retJson = array("success"=>false,"msg"=>"参数错误，请重试");
            output($retJson, "json");
            return;
        }
        $card_idx = (int)getArrayValue("wdbankid", 0, $request);
        $card_bankType = (int)getArrayValue("bankType", 0, $request);
        $realname = getArrayValue("account", "", $request);
        $card_no = getArrayValue("card", "", $request);
        $regBank = getArrayValue("banknode", "", $request);
        $card_status = (int)getArrayValue("status", 0, $request);

        $account  = getSessionValue("RequestMemberName", "");
        if (empty($account)) {
            $retJson = array("success"=>false,"msg"=>"参数错误，请重试");
            output($retJson, "json");
            return;
        }
        
        if (isset($_SESSION[$account]["cards"])) {
            $page = readHtml("playerDetail/playerWithdrawCard");
            $memberCards = $_SESSION[$account]["cards"];
            $requestCard = $memberCards[$card_idx - 1];
            $requestArgus = array($account, $card_idx, $card_bankType, $realname, $card_no, $regBank, $card_status);
            $ret = gmServerCaller("SetPlayerBankCardInfo", $requestArgus);
            
            if (empty(getArrayValue(0, "", $ret))) {
                $retJson = array("success"=>false,"msg"=>$ret[1]);
                output($retJson, "json");
                return;
            } else {
                $retJson = array("success"=>true,"msg"=>null,"response"=>array(
                    "status"=>$card_status,
                    "wdbankid"=>$card_idx,
                    "bankType"=>$card_bankType,
                    "account"=>urldecode($realname),
                    "card"=>$card_no,
                    "banknode"=>urldecode($regBank)));
                output($retJson, "json");
                return;
            }
        } else {
            $retJson = array("success"=>false,"msg"=>"参数错误，请重试");
            output($retJson, "json");
            return;
        }
    }

    /**
     * 保存玩家备注
     *
     * @param [type] $request URI参数
     * 
     * @return void
     */
    function saveRemark($request)
    {
        
        $account = getArrayValue("uid", "", $request);
        $remark = getArrayValue("remark", "", $request);
        
        if (empty($account) || empty($remark)) {
            return output(array("code"=>404, "Message"=>"error"), "json");
        }
        $retJson = gmServerCaller("ModifyPlayerNote", array($account, parseNote($remark)));
        
        if (getArrayValue(0, "", $retJson) == 1) {
            $retJson = array("code"=>200);
        } else {
            $retJson = array("code"=>404);
        }
        return output($retJson, "json");
    }
    
    /**
     * 修改玩家个人信息
     *
     * @param [type] $request URI参数
     * 
     * @return void
     */
    function editProf($request)
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

        $retJson = gmServerCaller("ModifyPlayerBaseInfo", array($RequestPlayer, $RequestName,  $RequestQQ, $RequestPhone, $Requestbirthday, $RequestEmail));
        if (getArrayValue(0, "", $retJson) == 1) {
            $ret = array("code"=>200, "Message"=>"玩家数据修改成功!");
        } else {
            $ret = array("code"=>404, "Message"=>"数据修改失败,请联系管理员!");
        }
        return output($ret, "json");
    }
    
    /**
     * 修改用户密码
     *
     * @param [type] $request URI参数
     * 
     * @return void
     */
    function resetpwd($request)
    {
        $RequestPlayer = getArrayValue("uid", "", $request);
        $RequestPasswd = getArrayValue("pwd", "", $request);
       
        if (empty($RequestPlayer) || empty($RequestPasswd)) {
            return false;
        }
        $retJson = gmServerCaller("ModifyPlayerPwd", array($RequestPlayer, $RequestPasswd));
        if (getArrayValue(0, "", $retJson) == 1) {
            $ret = array("code"=>200, "Message"=>"玩家数据修改成功!");
        } else {
            $ret = array("code"=>404, "Message"=>"数据修改失败,请联系管理员!");
        }
        return output($ret, "json");
    }
    
    /**
     * 修改代理
     *
     * @param [type] $request URI
     * 
     * @return void
     */
    static function changeAgent($request)
    {
        $playerId = getArrayValue("playerId", "", $request);
        $agentCode = getArrayValue("agentCode", "", $request);
        if (empty($playerId) || empty($agentCode)) {
            return output(array("code"=>500, "Message"=>"参数错误"), "json");
        }

        $retJson = gmServerCaller("SetPlayerAgent", array((int)$playerId, (int)$agentCode));

        if (getArrayValue(0, "", $retJson) == 1) {
            return output(array("code"=>200, "Message"=>""), "json");
        } else {
            return output(array("code"=>500, "Message"=>"error"), "json");
        }
        
    }

    /**
     * 校验用户，预留接口
     *
     * @return void
     */
    function checkPlayer()
    {
        //预留接口
    }
    

    /**
     * 预留接口
     *
     * @return void
     */
    function setGroup($request)
    {
        $groupId = (int)getArrayValue("groupid", 0, $request);
        $playerId = getArrayValue("playerid", "", $request);

        if ($groupId == 0 || empty($playerId)) {
            return output(array("code"=>500, "Message"=>"参数错误"), "json");
        } else {
            $retJson = gmServerCaller("SetPlayerGroup", array($playerId, $groupId));

            if (getArrayValue(0, "", $retJson) == 1) {
                return output(array("code"=>200, "Message"=>"修改成功"), "json");
            } else {
                return output(array("code"=>200, "Message"=>"修改失败"), "json");
            }
        }
    }

    /**
     * 预留接口
     *
     * @return void
     */
    function batchSetGroup()
    {
        //预留接口
    }

    /**
     * 预留接口
     *
     * @return void
     */
    function exportmember()
    {
        //预留接口    
    }

    /**
     * 预留接口
     *
     * @return void
     */
    function exportexcel()
    {
        echo "you will download a excel file in 5 seconds. but actually ,the function is not completely yet, so the file downloading is never appear to you.";
    }
}

?>