<?php

/**
 * 展示流水界面
 *
 * @return void
 */
function showWagered()
{
    $html = readHtml("flow/wagered");
    $s_st = date("Y-m-d H:i:s", time() - 24*60*60*30);
    $s_et = date("Y-m-d H:i:s", time());
    $html = str_replace("%STARTTIME%", $s_st, $html);
    $html = str_replace("%ENDTIME%", $s_et, $html);

    $page = array(
        makeHeaderPage(""),
        $html,
        makeFooterPage("wagered_footer"),
    );
    output(join("", $page));
}

function ShowGrant(){
    $page = array(
        makeHeaderPage(""),
        readHtml("flow/grant"),
        makeFooterPage("grant_footer"),
    );
    output(join("", $page));
}

function ShowHistory(){
    $html = readHtml("flow/history");
    $s_st = date("Y-m-d H:i:s", time() - 24*60*60*30);
    $s_et = date("Y-m-d H:i:s", time());
    $html = str_replace("%STARTTIME%", $s_st, $html);
    $html = str_replace("%ENDTIME%", $s_et, $html);

    $page = array(
        makeHeaderPage(""),
        $html,
        makeFooterPage("grant_footer"),
    );
    output(join("", $page));
}

/**
 * 构建流水明细界面
 *
 * @param [type] $datas 数据
 * 
 * @return void
 */
function showWageredDatas($datas)
{
    /**
     * 构建流水明细界面
     */
    $retdatas = array();

    $Total_Bet = 0;
    $Total_Bonus = 0;
    $Total_Winloss = 0;
    $Total_validBet = 0;

    for ($x=0;$x<count($datas);$x++) {
        $platform = getArrayValue("platform", "", $datas[$x]);
        $account = getArrayValue("account", "", $datas[$x]);
        if ($platform == "IBC") {
            $_tmpData = makeIBCDataArray($datas[$x]);
        } elseif ($platform == "NB") {
            $_tmpData = makeNBDataArray($datas[$x]);
        }

        $_tmpArray = $_tmpData[0];
        $_pageData = $_tmpData[1];
        for ($y=0;$y<count($_tmpArray);$y++) {
            $_tmpArray[$y] = str_replace("%ACCOUNT%", $account, $_tmpArray[$y]);
        }
        array_push($retdatas, $_tmpArray);
        $Total_Bet += $_pageData[0];
        $Total_Bonus += $_pageData[1];
        $Total_validBet += $_pageData[2];
        $Total_Winloss += $_pageData[3];
    }

    return array($retdatas, array($Total_Bet, $Total_Bonus, 0 - $Total_Winloss, $Total_validBet));
}

/**
 * 构建IBC的数据
 *
 * @param [type] $data 数据
 * 
 * @return void
 */
function makeIBCDataArray($data)
{
    $dno = getArrayValue("dno", "", $data);
    $transId = getArrayValue("transId", "", $data);
    $recordNum = getArrayValue("recordNum", "", $data);
    $recordType1 = getArrayValue("recordType1", "", $data);
    $layer = getArrayValue("groupName", "", $data);
    $time = getArrayValue("recordTime", "", $data);
    $account = getArrayValue("account", "", $data);
    $isRebateValid = getArrayValue("isRebateValid", 0, $data);
    $platform = getArrayValue("platform", "", $data);
    $betId = getArrayValue("betId", "", $data);
    $game = getArrayValue("game", "", $data);
    
    $validAmount = getArrayValue("validStakeAmount", "0", $data, true);
    if (!empty($time)) {
        $betTime = parseDate($time, 4);
    }
    $BetAmount = getArrayValue("stakeAmount", 0, $data, true);
    $status = getArrayValue("status", "", $data);

    $WinLoss = 0 - (float)getArrayValue("winLoseAmount", 0, $data, true);
    $BonusAmount = (float)$BetAmount - (float)$WinLoss ;
    $_bonus = (float)$BonusAmount;

    $_bet = $BetAmount;
    $_validBet = $validAmount;
    if ((float)$WinLoss < 0) {
        $betStr = array("red", number_format($BetAmount, 2));
        $winStr = array("red", number_format($WinLoss, 2));
        $bonusStr = array("red", number_format($BonusAmount, 2));
        $validAmountStr = array("red", number_format($validAmount, 2));
    } else {
        $betStr = array("green", number_format($BetAmount, 2));
        $winStr = array("green", number_format($WinLoss, 2));
        $bonusStr = array("green", number_format($BonusAmount, 2));
        $validAmountStr = array("green", number_format($validAmount, 2));
    }
    $betNo = getArrayValue(0, "", explode("_", $betId));
    
    $betResult = getArrayValue("isOver", "", $data);
    
    if ($betResult == "1") {
        $resultSTR = "结算完成";
    } else {
        $resultSTR = "待结算";
    }


    
    if ($isRebateValid == 1) {
        $validSTR = "有效";
        $_winloss = (float)$WinLoss;
        $operStr = array("red", "99", $dno, $platform, "设为无效");
    } else {
        $validSTR = "无效";
        $operStr = array("green", "66", $dno, $platform, "设为有效");
        $_winloss = 0;
    }
    
    if (empty($transId)) {
        $transId = $betNo;
    }
    $contentStr = makeIBCContentStr($data);
    
    $tmpdata = array(
        getArrayValue($platform, "", $GLOBALS["GP_Names"]). " - " .$game,
        array($account, $account),
        $transId,
        $betTime,
        $contentStr,
        $resultSTR,
        $betStr,
        $bonusStr,
        $winStr,
        $validAmountStr,
        array($recordNum, $validSTR),
        $operStr
    );

    return array($tmpdata, array($_bet, $_bonus, $_validBet, $_winloss));
}

/**
 * 构建NB平台数据
 *
 * @param [type] $data 数据
 * 
 * @return void
 */
function makeNBDataArray($data)
{
    $betId = getArrayValue("betId", "", $data);
    $recordNum = getArrayValue("recordNum", "", $data);
    $recordType1 = getArrayValue("recordType1", "", $data);
    
    $account = getArrayValue("account", "", $data);
    $platform = getArrayValue("platform", "", $data);
    
    $game = getArrayValue("game", "", $data);
    $pGame = getArrayValue("platformGame", "", $data);
    $content = getArrayValue("content", "", $data);
    $contentStr = explode("|", $content);

    if (count($contentStr) == 0) {
        return "";
    }

    $gameType = getArrayValue(0, "", $contentStr);
    $dno = (int)getArrayValue("dno", "0", $data);
    // $account = getArrayValue(2, "", $contentStr);
    $matchNo = getArrayValue(3, "", $contentStr);
    $matchType = getArrayValue(4, "", $contentStr);
    $Odds = getArrayValue(5, "", $contentStr);
    $betAmount = (float)getArrayValue(6, 0, $contentStr);
    $companyWinLoss = 0 - (float)getArrayValue(7, 0, $contentStr);
    $betTime = getArrayValue(8, "", $contentStr);
    $betResult = getArrayValue("isOver", "", $data);
    $rebateStatus = getArrayValue("isRebateValid", false, $data);
    if ($betResult == "1") {
        $resultSTR = "结算完成";

        $BonusAmount = $betAmount - $companyWinLoss;
    } else {
        $resultSTR = "待结算";
       
        $BonusAmount = 0;
    }

    if ($rebateStatus == 1) {
        $validSTR = "有效";
        $operStr = array("red", "99", $dno, $platform, "设为无效");
    } else {
        $validSTR = "无效";
        $operStr = array("green", "66", $dno, $platform, "设为有效");
    }
    $showInfoline1 = getArrayValue($gameType, "", $GLOBALS["NBbetTypeName"]) . " 第" . $matchNo."期";
    $showInfoline2 = $matchType."@".$Odds;
    $betInfos = array($showInfoline1,$showInfoline2);
    $contentStr = join("<br>", $betInfos);
    if (!empty($betTime)) {
        $betTime = date("Y-m-d", $betTime)."<br/>".date("H:i:s", $betTime);
    }
    
    $validAmount = abs($betAmount) < abs($companyWinLoss) ? abs($betAmount) : abs($companyWinLoss);
    if ($companyWinLoss < 0 ) {
        $betStr = array("red", number_format($betAmount, 2));
        $winStr = array("red", number_format($companyWinLoss, 2));
        $bonusStr = array("red", number_format($BonusAmount, 2));
        $validAmountStr = array("red", number_format($validAmount, 2));
    } else {
        $betStr = array("green", number_format($betAmount, 2));
        $winStr = array("green", number_format($companyWinLoss, 2));
        $bonusStr = array("green", number_format($BonusAmount, 2));
        $validAmountStr = array("green", number_format($validAmount, 2));
    }
    $tmpdata = array(
        getArrayValue($platform, "", $GLOBALS["GP_Names"]). " - " .$pGame,
        array($account, $account),
        $betId,
        $betTime,
        $contentStr,
        $resultSTR,
        $betStr,
        $bonusStr,
        $winStr,
        $validAmountStr,
        array($recordNum, $validSTR),
        $operStr
    );

    return array($tmpdata, array((float)$betAmount, (float)$BonusAmount, (float)$validAmount, (float)$validAmount));
}
/**
 * 构建NB平台的内容
 *
 * @param [type] $data 订单数据
 * 
 * @return void
 */
function makeNBContentStr($data)
{
    $content = getArrayValue("content", "", $data);
    $contentStr = explode("|", $content);

    if (count($contentStr) == 0) {
        return "";
    }

    $gameType = getArrayValue(0, "", $contentStr);
    $dno = getArrayValue(1, "", $contentStr);
    $account = getArrayValue(2, "", $contentStr);
    $matchNo = getArrayValue(3, "", $contentStr);
    $matchType = getArrayValue(4, "", $contentStr);
    $Odds = getArrayValue(5, "", $contentStr);
    $betAmount = getArrayValue(6, "", $contentStr);
    $companyWinLoss = getArrayValue(7, "", $contentStr);
    $betTime = getArrayValue(8, "", $contentStr);
    $betResult = getArrayValue(9, "", $contentStr);

    $showInfoline1 = getArrayValue($gameType, "", $GLOBALS["NBbetTypeName"]) . " 第" . $matchNo."期";
    $showInfoline2 = $matchType."@".$Odds;
    $betInfos = array($showInfoline1,$showInfoline2);
    $contentStr = join("<br>", $betInfos);
    return $contentStr;
}

/**
 * 构建IBC平台的订单数据
 *
 * @param [type] $data 数据
 * 
 * @return void
 */
function makeIBCContentStr($data)
{
    /**
     * 构建内容解析，目前是支持IBC的内容
     */
    $content = json_decode(getArrayValue("content", "{}", $data), true);
    $ParlayRefNo = (int)getArrayValue("ParlayRefNo", 0, $content);
    if ($ParlayRefNo == 0) {
        /**
         * 单独注单的数据
         */
        $sportType = getArrayValue("SportType", "", $content);
        $sportName = getArrayValue($sportType, "", $GLOBALS["sportsType"]);
        
        $leagueName = getArrayValue("LeagueName", "", $content);
        $HomeIDName = getArrayValue("HomeIDName", "", $content);
        $AwayIDName = getArrayValue("AwayIDName", "", $content);
        $HDP = getArrayValue("HDP", "", $content);
        $HomeScore = getArrayValue("HomeScore", "0", $content);
        $AwayScore = getArrayValue("AwayScore", "0", $content);
        $BetTypeID = (string)getArrayValue("BetType", "", $content);
        $TransactionTime = (string)getArrayValue("TransactionTime", " ", $content);
        
        $BetTeam = getArrayValue("BetTeam", "", $content);
        $OddsType = getArrayValue("OddsType", "", $content);
        $Odds = (string)getArrayValue("Odds", "0", $content);
        $BtConfig = getArrayValue($BetTypeID, array(), $GLOBALS["betTypeName"]);
        if (!empty($BtConfig)) {
            $BetTypeStr = $BtConfig["name"];
        } else {
            $BetTypeStr = "todo:need more configs";
        }
    
        $BetArgus = getArrayValue("argus", array(), $BtConfig);
        if (!empty($BetArgus) && !empty($BetTeam) && !empty($OddsType)) {
            $btTeamStr = getArrayValue($BetTeam, "", $BetArgus);
            $otNameStr = getArrayValue($OddsType, "", $GLOBALS["oddsType"]);
            $btOddStr = $btTeamStr . "@" . $otNameStr . " - (" . $Odds. ")";
        } else {
            $btOddStr = "todo: odds - " . $BetTeam . " - " . $Odds;
        }

        $showLeagueInfo = $sportName. " - ". $leagueName;
        $showTeamInfo = $HomeIDName . " vs ". $AwayIDName . "(". $HDP .")";
        $showScoreInfo = "(".$AwayScore . " : " . $HomeScore . ")";

        $betInfos = array(
            $showLeagueInfo,
            $showTeamInfo,
            $showScoreInfo,
            $BetTypeStr,
            $btOddStr,
            str_replace("T", " ", $TransactionTime),
            
        );
        $contentStr = join("<br>", $betInfos);
    } else {
        /**
         * 串单的数据
         */
        $parleyData = getArrayValue("ParlayData", array(), $content);
        $parleyShowInfo = array();
        foreach ($parleyData as $_parley) {
            $sportType = getArrayValue("Parlay_SportType", "", $_parley);
            $sportName = getArrayValue($sportType, "", $GLOBALS["sportsType"]);
            
            $leagueName = getArrayValue("LeagueName", "", $_parley);
            $HomeIDName = getArrayValue("Parlay_HomeIDName", "", $_parley);
            $AwayIDName = getArrayValue("Parlay_AwayIDName", "", $_parley);
            $HDP = getArrayValue("Parlay_HDP", "", $_parley);
            $HomeScore = getArrayValue("Parlay_HomeScore", "0", $_parley);
            $AwayScore = getArrayValue("Parlay_AwayScore", "0", $_parley);
            $BetTypeID = (string)getArrayValue("Parlay_BetType", "", $_parley);
            $TransactionTime = (string)getArrayValue("Parlay_MatchDatetime", " ", $_parley);
            
            $BetTeam = getArrayValue("Parlay_BetTeam", "", $_parley);
            $Odds = (string)getArrayValue("Parlay_Odds", "0", $_parley);
            $BtConfig = getArrayValue($BetTypeID, array(), $GLOBALS["betTypeName"]);
            if (!empty($BtConfig)) {
                $BetTypeStr = $BtConfig["name"];
            } else {
                $BetTypeStr = "todo:need more configs";
            }
                
            $BetArgus = getArrayValue("argus", array(), $BtConfig);
            if (!empty($BetArgus) && !empty($BetTeam)) {
                $btTeamStr = getArrayValue($BetTeam, "", $BetArgus);
                $btOddStr = "@" . $btTeamStr . " - (" . $Odds. ")";
            } else {
                
                $btOddStr = "todo: odds - " . $BetTeam . " - " . $Odds;
            }
            $showLeagueInfo = $sportName. " - ". $leagueName;
            $showTeamInfo = $HomeIDName . " vs ". $AwayIDName . "(". $HDP .")";
            $showScoreInfo = "(".$AwayScore . " : " . $HomeScore . ")";
    
            $betInfos = array(
                $showLeagueInfo,
                $showTeamInfo,
                $showScoreInfo . $BetTypeStr . $btOddStr,
                str_replace("T", " ", $TransactionTime),
            );
            $_parleyInfo = join("<br>", $betInfos);
            array_push($parleyShowInfo, $_parleyInfo);
        }
        $contentStr = join("<br><br>", $parleyShowInfo);
    }
    return $contentStr;
}

/**
 * 构建返水历史界面
 *
 * @param [type] $datas    返水数据
 * @param [type] $rebateID ID
 * 
 * @return void
 */
function showRebateHistoryHtml($datas, $rebateID)
{
    
    $retdatas = array();
    for ($x=0;$x<count($datas);$x++) {
        $account = getArrayValue("account", "TODO:缺失返回值", $datas[$x]);
        $agentAccount = getArrayValue("agentAccount", "", $datas[$x]);
        $name = urldecode(getArrayValue("name", "", $datas[$x]));
        $amount =  getArrayValue("rebateAmount", "0", $datas[$x], true);
        $count =  getArrayValue("rebate_betCount", 0, $datas[$x]);
        $platform = getArrayValue("platform", "", $datas[$x]);
        $game = getArrayValue("rebate_game", "", $datas[$x]);
        $groupName = getArrayValue("groupName", "", $datas[$x]);
        $stakeAmount = getArrayValue("rebate_stakeAmount", "0", $datas[$x], true);
        $winLoseAmount = getArrayValue("rebate_winLoseAmount", "0", $datas[$x], true);
        $time = getArrayValue("recordTime", "", $datas[$x]);
        $checkStatus = (int)getArrayValue("checkStatus", "1", $datas[$x]);
        if (!empty($time)) {
            $timeStr = date("Y-m-d", $time);
        } else {
            $timeStr = "TODO:缺失返回值";
        }

        if (empty($platform)) {
            $platformStr = "不限平台";
        } else {
            $platformStr = getArrayValue($platform, "", $GLOBALS["GP_NAMES"]);
        }

        if ($checkStatus == 2) {
            $status = "已结算";
        } else if ($checkStatus == 1) {
            $status = "待审核";
        } else {
            $status = "已拒绝";
        }
        $tmpdata = array(
            // "<input name=\"rakes\" class=\"form-control\" sid=\"".$x."\" uid=\"%ACCOUNT%\" gpid=\"".$platform."\" type=\"checkbox\">",
            $timeStr,
            "<span class='label label-info' style='cursor:pointer;' onclick='custom_getBalance(\"%ACCOUNT%\", \"%ACCOUNT%\")'>%ACCOUNT%</span>",
            $name,
            $groupName,
            $agentAccount,
            $game,
            $count,
            $stakeAmount,
            $winLoseAmount,
            $amount,
            $status,
            
        );
        
        for ($y=0;$y<count($tmpdata);$y++) {
            $tmpdata[$y] = str_replace("%ACCOUNT%", $account, $tmpdata[$y]);
        }
        array_push($retdatas, $tmpdata);

    }
    return $retdatas;
}

function showRebateListHtml($datas, $rebateId){
    
    $rebateAccount = getSessionValue("rebateAccount". $rebateId, array());
    $CanrebateAccount = array();//getSessionValue("CanrebateAccount". $rebateId, array());
    $retdatas = array();
    for($x=0;$x<count($datas);$x++){
        $account = getArrayValue("account", "TODO:缺失返回值", $datas[$x]);
        $agentName = getArrayValue("agentName", "", $datas[$x]);
        $name = urldecode(getArrayValue("name", "", $datas[$x]));
        $amount =  getArrayValue("amount", "0", $datas[$x], true);
        $count =  getArrayValue("count", 0, $datas[$x]);
        $platform = getArrayValue("platform", "", $datas[$x]);
        $game = getArrayValue("game", "", $datas[$x]);
        $groupName = getArrayValue("groupName", "", $datas[$x]);
        $rebate = getArrayValue("rebate", "0", $datas[$x], true);
        $winLoseAmount = getArrayValue("winLoseAmount", "0", $datas[$x], true);
        $time = getArrayValue("time", "", $datas[$x]);
        
        if (!empty($time)){
            $timeStr = date("Y-m-d", $time);
        }else{
            $timeStr = "TODO:缺失返回值";
        }

        if (empty($platform)){
            $platformStr = "不限平台";
        }else{
            $platformStr = getArrayValue($platform, "", $GLOBALS["GP_NAMES"]);
        }

        if(in_array($account, $rebateAccount)){
            $operHtml = "已返水";
            $status = "已结算";
        }else{
            $operHtml = makeFlowOperHtml($rebateId, $x);
            $status = "待结算";
            array_push($CanrebateAccount, $account);
        }

        $tmpdata = array(
            "<input name=\"rakes\" class=\"form-control\" sid=\"".$x."\" uid=\"%ACCOUNT%\" gpid=\"".$platform."\" type=\"checkbox\">",
            $timeStr,
            "<span class='label label-info' style='cursor:pointer;' onclick='custom_getBalance(\"%ACCOUNT%\", \"%ACCOUNT%\")'>%ACCOUNT%</span>",
            $name,
            $groupName,
            $agentName,
            $platformStr,
            $count,
            $amount,
            $winLoseAmount,
            $rebate,
            $status,
            $operHtml
        );
        
        for($y=0;$y<count($tmpdata);$y++){
            $tmpdata[$y] = str_replace("%ACCOUNT%", $account, $tmpdata[$y]);
        }
        array_push($retdatas, $tmpdata);
    }
    $_SESSION["CanrebateAccount". $rebateId] = $CanrebateAccount;

    return $retdatas;
}

function makeFlowOperHtml($rebateId, $GPID){
    return '<a href="#" class="btn btn-xs green" 
    onclick="rake('.$rebateId.',\'%ACCOUNT%\',\''.$GPID.'\',1);">给予返水</a>&nbsp;&nbsp;&nbsp;<a href="#" class="btn btn-xs red" 
    onclick="rake('.$rebateId.',\'%ACCOUNT%\',\''.$GPID.'\',0);">返零</a>';
}
?>