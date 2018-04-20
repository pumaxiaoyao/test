<?php
namespace App\ViewHelper;

use App\Config\AGConfig;
use App\Config\BBINConfig;
use App\Config\Config;
use App\Config\IBCConfig;
use App\Config\IGConfig;
use App\Config\NBConfig;

class FlowViewHelper extends BaseViewHelper
{
    public static function showWageredDatas($datas)
    {
        /**
         * 构建流水明细界面
         */
        $retdatas = array();

        $Total_Bet = 0;
        $Total_Bonus = 0;
        $Total_Winloss = 0;
        $Total_validBet = 0;

        $GPDataToCaller = [
            "IBC" => "makeIBCDataArray",
            "NB" => "makeNBDataArray",
            "IG" => "makeIGDataArray",
            "AG" => "makeAGDataArray",
            "BBIN" => "makeBBINDataArray",
        ];

        for ($x = 0; $x < count($datas); $x++) {
            $_data = $datas[$x];

            $platform = $_data["platform"];

            $_tmpData = call_user_func_array(
                ["App\ViewHelper\FlowViewHelper", $GPDataToCaller[$platform]],
                [$_data]
            );

            $_tmpArray = $_tmpData[0];
            $_pageData = $_tmpData[1];

            $Total_Bet += $_pageData[0];
            $Total_Bonus += $_pageData[1];
            $Total_validBet += $_pageData[2];
            $Total_Winloss += $_pageData[3];

            $retdatas[] = $_tmpArray;
        }

        return [$retdatas, [$Total_Bet, $Total_Bonus, 0 - $Total_Winloss, $Total_validBet]];
    }

    private static function makeIBCDataArray($data)
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

        $WinLoss = 0 - (float) getArrayValue("winLoseAmount", 0, $data, true);
        $BonusAmount = (float) $BetAmount - (float) $WinLoss;
        $_bonus = (float) $BonusAmount;

        $_bet = $BetAmount;
        $_validBet = $validAmount;
        if ((float) $WinLoss < 0) {
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
            $_winloss = (float) $WinLoss;
            $operStr = array("red", "99", $dno, $platform, "设为无效");
        } else {
            $validSTR = "无效";
            $operStr = array("green", "66", $dno, $platform, "设为有效");
            $_winloss = 0;
        }

        if (empty($transId)) {
            $transId = $betNo;
        }
        $contentStr = self::makeIBCContent($data);

        $tmpdata = array(
            getArrayValue($platform, "", Config::platform) . " - " . $game,
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
            $operStr,
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
    private static function makeNBDataArray($data)
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
        $dno = (int) getArrayValue("dno", "0", $data);
        // $account = getArrayValue(2, "", $contentStr);
        $matchNo = getArrayValue(3, "", $contentStr);
        $matchType = getArrayValue(4, "", $contentStr);
        $Odds = getArrayValue(5, "", $contentStr);
        $betAmount = (float) getArrayValue(6, 0, $contentStr);
        $companyWinLoss = 0 - (float) getArrayValue(7, 0, $contentStr);
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
        $showInfoline1 = NBConfig::NBbetTypeName[$gameType] . " 第" . $matchNo . "期";
        $showInfoline2 = $matchType . "@" . $Odds;
        $betInfos = array($showInfoline1, $showInfoline2);
        $contentStr = join("<br>", $betInfos);
        if (!empty($betTime)) {
            $betTime = date("Y-m-d", $betTime) . "<br/>" . date("H:i:s", $betTime);
        }

        $validAmount = abs($betAmount) < abs($companyWinLoss) ? abs($betAmount) : abs($companyWinLoss);
        if ($companyWinLoss < 0) {
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
            getArrayValue($platform, "", Config::platform) . " - " . $pGame,
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
            $operStr,
        );

        return array($tmpdata, array((float) $betAmount, (float) $BonusAmount, (float) $validAmount, (float) $validAmount));
    }

    /**
     * 构建IBC平台的订单数据
     *
     * @param [type] $data 数据
     *
     * @return void
     */
    private static function makeIBCContent($data)
    {
        /**
         * 构建内容解析，目前是支持IBC的内容
         */
        $content = json_decode(getArrayValue("content", "{}", $data), true);
        $ParlayRefNo = (int) getArrayValue("ParlayRefNo", 0, $content);
        if ($ParlayRefNo == 0) {
            /**
             * 单独注单的数据
             */
            $sportName = IBCConfig::sportsType[$content["SportType"]];

            $leagueName = $content["LeagueName"];
            $HomeIDName = $content["HomeIDName"];
            $AwayIDName = $content["AwayIDName"];
            $HDP = $content["HDP"];
            $HomeScore = $content["HomeScore"];
            $AwayScore = $content["AwayScore"];
            $BetTypeID = $content["BetType"];
            $TransactionTime = $content["TransactionTime"];
            $BetTeam = $content["BetTeam"];
            $OddsType = $content["OddsType"];
            $Odds = $content["Odds"];
            // {"TransId":103595390108,"PlayerName":"player001","TransactionTime":"2018-03-14T03:34:00.287","MatchId":24511953,"LeagueId":59647,
            //"LeagueName":"Dota 2 - \u4e16\u754c\u7535\u5b50\u7ade\u6280\u8fd0\u52a8\u4f1a","SportType":43,"AwayId":440869,"AwayIDName":"Team Serbia",
            //"HomeId":461483,"HomeIDName":"Volta7","MatchDatetime":"2018-03-14T04:59:59","BetType":20,"ParlayRefNo":0,"BetTeam":"h","HDP":0,"AwayHDP":0,
            //"HomeHDP":0,"Odds":7.25,"OddsType":3,"AwayScore":null,"HomeScore":null,"IsLive":"0","IsLucky":"False","Bet_Tag":"","LastBallNo":"",
            //"TicketStatus":"LOSE","Stake":10,"WinLoseAmount":-10,"AfterAmount":2.5,"WinLostDateTime":"2018-03-14T00:00:00","currency":"RMB",
            //"VersionKey":25035491}
            $BtConfig = getArrayValue($BetTypeID, "", IBCConfig::betTypeNames); // 会出现未配置情况，最好加入取值保护
            if (!$BtConfig) {
                $BetTypeStr = "todo:need more configs";
            } else {
                $BetTypeStr = $BtConfig["name"];
            }

            $BetArgus = getArrayValue("argus", array(), $BtConfig);
            if (!empty($BetArgus) && !empty($BetTeam) && !empty($OddsType)) {
                $btTeamStr = $BetArgus[$BetTeam];
                $otNameStr = IBCConfig::oddsType[$OddsType];
                $btOddStr = $btTeamStr . "@" . $otNameStr . " - (" . $Odds . ")";
            } else {
                $btOddStr = "todo: odds - " . $BetTeam . " - " . $Odds;
            }

            $showLeagueInfo = $sportName . " - " . $leagueName;
            $showTeamInfo = $HomeIDName . " vs " . $AwayIDName . "(" . $HDP . ")";
            $showScoreInfo = "(" . $AwayScore . " : " . $HomeScore . ")";

            $betInfos = [
                $showLeagueInfo,
                $showTeamInfo,
                $showScoreInfo,
                $BetTypeStr,
                $btOddStr,
                str_replace("T", " ", $TransactionTime),
            ];
            $contentStr = join("<br>", $betInfos);
        } else {
            /**
             * 串单的数据
             */
            $parleyData = getArrayValue("ParlayData", array(), $content);
            $parleyShowInfo = array();
            foreach ($parleyData as $_parley) {
                $sportType = $_parley["Parlay_SportType"];
                $sportName = IBCConfig::sportsType[$sportType];

                $leagueName = $_parley["LeagueName"];
                $HomeIDName = $_parley["Parlay_HomeIDName"];
                $AwayIDName = $_parley["Parlay_AwayIDName"];
                $HDP = $con_parleytent["Parlay_HDP"];
                $HomeScore = $con_parleytent["Parlay_HomeScore"];
                $AwayScore = $con_parleytent["Parlay_AwayScore"];
                $BetTypeID = $con_parleytent["Parlay_BetType"];
                $TransactionTime = $con_parleytent["Parlay_MatchDatetime"];

                $BetTeam = $con_parleytent["Parlay_BetTeam"];
                $Odds = $con_parleytent["Parlay_Odds"];
                $BtConfig = IBCConfig::betTypeNames[$BetTypeID];

                if (!empty($BtConfig)) {
                    $BetTypeStr = $BtConfig["name"];
                } else {
                    $BetTypeStr = "todo:need more configs";
                }

                $BetArgus = getArrayValue("argus", array(), $BtConfig);
                if (!empty($BetArgus) && !empty($BetTeam)) {
                    $btTeamStr = getArrayValue($BetTeam, "", $BetArgus);
                    $btOddStr = "@" . $btTeamStr . " - (" . $Odds . ")";
                } else {

                    $btOddStr = "todo: odds - " . $BetTeam . " - " . $Odds;
                }
                $showLeagueInfo = $sportName . " - " . $leagueName;
                $showTeamInfo = $HomeIDName . " vs " . $AwayIDName . "(" . $HDP . ")";
                $showScoreInfo = "(" . $AwayScore . " : " . $HomeScore . ")";

                $betInfos = [
                    $showLeagueInfo,
                    $showTeamInfo,
                    $showScoreInfo . $BetTypeStr . $btOddStr,
                    str_replace("T", " ", $TransactionTime),
                ];
                $_parleyInfo = join("<br>", $betInfos);
                array_push($parleyShowInfo, $_parleyInfo);
            }
            $contentStr = join("<br><br>", $parleyShowInfo);
        }
        return $contentStr;
    }

    private static function makeBBINDataArray($data)
    {
        // 显示游戏平台的名字
        $platform = $data["platform"];
        $game = $data["game"];
        $platformGame = $data["platformGame"];

        $gameName = BBINConfig::gameNames[$game];
        $gameNameToCell = $platform . " - " . $gameName;

        // 显示玩家账号
        $account = $data["account"];
        $accountToCell = [$account, $account];

        // 显示注单号
        $betId = $data["betId"];

        // 显示下注时间
        $updateTime = $data["updateTime"];

        $betTimeToCell = parseDate($updateTime);

        // 显示投注内容
        $contentJson = json_decode($data["content"], true);
        if ($platformGame == "Live-Games") {
            $gameType = $contentJson["GameType"];
            $liveConfig = BBINConfig::gametypes[$platformGame][$gameType];
            $gameTypeName = $liveConfig["betName"]; //获取下注名
            // 按行构建输出内容
            // 构建首行数据
            $showContentLine1 = $gameTypeName . "-" . $contentJson["SerialID"] . "-" . $contentJson["RoundNo"]; //获取下注房号、局号
            $contentList = [$showContentLine1];
            // 解析wager数据
            $wagerDetail = $contentJson["WagerDetail"];
            $betDetails = explode('*', $wagerDetail); //转换为数组
            for ($x = 0; $x < count($betDetails); $x++) {
                $_betDetail = explode(',', $betDetails[$x]);
                $_betOn = $_betDetail[0];
                $_betOnInfo = getArrayValue($_betOn, "未提供" . $gameType . "的betOn配置" . $_betOn, $liveConfig['betOn']);
                $contentList[] = $_betOnInfo . '(' . join(',', array_slice($_betDetail, 1, 3)) . ')';
            }
            // 结果和牌型
            $contentList[] = $contentJson["Result"] . "(" . $contentJson["Card"] . ")";
            // 输出显示内容
            $contentToCell = join('<br/>', $contentList);
        } else { //其它只需要写入游戏名即可
            $contentToCell = BBINConfig::gametypes[$platformGame][$contentJson["GameType"]];
        }
        // 显示下注、派彩、输赢、有效金额
        $stakeAmount = $data["stakeAmount"];
        $winLoseAmount = $data["winLoseAmount"];
        $corpWinLoseAmount = 0 - $winLoseAmount; // 公司输赢，与个人输赢相反
        $validStakeAmount = $data["validStakeAmount"];
        $bonusAmount = $winLoseAmount > 0 ? $winLoseAmount : 0; // 大于0的个人输赢，应该就是派彩

        if ($corpWinLoseAmount > 0) {
            $stakeToCell = ['green', number_format($stakeAmount, 2)];
            $bonusToCell = ['green', number_format($bonusAmount, 2)];
            $winLossToCell = ['green', number_format($corpWinLoseAmount, 2)];
            $validToCell = ['green', number_format($validStakeAmount, 2)];
        } else {
            $stakeToCell = ['red', number_format($stakeAmount, 2)];
            $bonusToCell = ['red', number_format($bonusAmount, 2)];
            $winLossToCell = ['red', number_format($corpWinLoseAmount, 2)];
            $validToCell = ['red', number_format($validStakeAmount, 2)];
        }
        // 显示游戏结算状态
        if ($data["isOver"]) {
            $gameStatusToCell = "结算完成";
        } else {
            $gameStatusToCell = "未结算";
        }

        // 显示注单是否有效状态
        $isRebateValid = $data["isRebateValid"];
        $dno = $data['dno'];
        if ($isRebateValid) {
            $rebateValidToCell = [$dno, "有效"];
            $operBtnToCell = ["red", "99", $dno, $platform, "设为无效"]; // JS按钮的状态值和参数
        } else {
            $rebateValidToCell = [$dno, "无效"];
            $operBtnToCell = ["green", "66", $dno, $platform, "设为有效"]; // JS按钮的状态值和参数
        }

        // 拼装数据返回
        $tmpdata = [
            $gameNameToCell,
            $accountToCell,
            $betId,
            $betTimeToCell,
            $contentToCell,
            $gameStatusToCell,
            $stakeToCell,
            $bonusToCell,
            $winLossToCell,
            $validToCell,
            $rebateValidToCell,
            $operBtnToCell,
        ];

        return [$tmpdata, [
            (float) $stakeAmount, // 下注统计数据
            (float) $bonusAmount, // 注单派彩数据
            (float) $corpWinLoseAmount, // 公司输赢数据
            (float) $validStakeAmount, // 有效投注数据
        ]];

    }

    private static function makeIGDataArray($data)
    {
        // 显示游戏平台的名字
        $platform = $data["platform"];
        $game = $data["game"];
        $platformGame = $data["platformGame"];

        $gameName = [
            "lotto" => "香港彩",
            "lottery" => "时时彩",
        ];

        $gameNameToCell = Config::platform[$platform] . ' - ' . $gameName[$game];

        // 显示玩家账号
        $account = $data["account"];

        $accountToCell = [$account, $account];

        // 显示注单号
        $betId = $data["betId"];

        // 显示下注时间
        $updateTime = $data["updateTime"];

        $betTimeToCell = parseDate($updateTime);

        // 显示投注内容
        $contentJson = json_decode($data["content"], true);
        if ($game == "lotto") { //香港彩
            $betOnId = (string) $contentJson["betOnId"];
            $betTypeId = $contentJson["betTypeId"];
            $betType = $contentJson["betTypeId"];
            $betDetails = json_decode($contentJson["betDetails"], true);
            $odds = $contentJson["odds"];
            $odds2 = $contentJson["odds2"];

            $gameNo = $contentJson["gameNo"];
            $betOnStr = getArrayValue($betOnId, "未配置的BetOnId-" . $betOnId, IGConfig::LottoBetonId);

            if ($betTypeId <= 49) {
                $betTypeStr = $betTypeId;
            } else {
                $betTypeStr = getArrayValue($betTypeId, "未配置的BetTypeId-" . $betTypeId, IGConfig::LottoBetTypeId);
            }
            $detailStr = [];
            foreach ($betDetails as $_detail) {
                if (mb_strlen($_detail) > 3 && substr($_detail, 0, 3) == "NO_") { //"NO_"开头只显示数值
                    $detailStr[] = substr($_detail, 3, strlen($_detail));
                } else {
                    $_detailStr = getArrayValue($_detail, "未配置的BetDetail-" . $_detail, IGConfig::LottoBetDetail);
                    $detailStr[] = $_detailStr;
                }
            }

            $oddsStr = $odds2 == 0 ? $odds : $odds . "-" . $odds2;
            if (count($betDetails) > 1) {
                $contentToCell = join("<br/>", [
                    $betOnStr . " - " . $betTypeStr,
                    join("/", $detailStr),
                    $gameNo . "期 @" . $oddsStr,
                ]);
            } else {
                $contentToCell = join("<br/>", [
                    $betOnStr . " - " . $betTypeStr,
                    $gameNo . "期 @" . $oddsStr,
                ]);
            }

        } elseif ($game == "lottery") { //时时彩
            /**
             * 生成下注内容
             */
            // 从content读取json数据
            $gameInfoId = $contentJson["gameInfoId"];
            $betOn = $contentJson["betOn"];
            $betType = $contentJson["betType"];
            $betTypeId = $contentJson["betTypeId"];
            $odds = $contentJson["odds"];
            // 获取IG配置数据
            $gameInfo = IGConfig::LotteryBetTypeName[$gameInfoId];
            $gameName = $gameInfo[0];
            $gameBetTypeKey = $gameInfo[1];
            $gameBetDetail = IGConfig::LotteryBetDetail[$gameBetTypeKey];
            $gameBetOnConfig = $gameBetDetail["betOn"];
            $gameBetTypeConfig = $gameBetDetail["betType"];
            $gameTray = $contentJson["tray"];
            $gameNo = $contentJson["gameNo"];
            
            // 解析数据
            if (mb_strlen($betOn) > 4 && substr($betOn, 0, 5) == "BALL_" && isset($gameBetOnConfig[$betOn])) { //betOn "BALL_"特殊处理
                $betOnStr = $gameBetOnConfig[$betOn];
                // $betOnStr = "第" . substr($betOn, 5, strlen($betOn)) . "球";
            } else {
                // $betOnStr = getArrayValue($betOn, "不存在的betOn配置" . $betOn, $gameBetOnConfig);
                $betOnStr = "第" . substr($betOn, 5, strlen($betOn)) . "球";
            }
            if (mb_strlen($betType) > 3 && substr($betType, 0, 3) == "NO_") { //"NO_"开头只显示数值
                $betTypeStr = substr($betType, 3, strlen($betType)) . "号";
            } else {
                $betTypeStr = getArrayValue($betType, "不存在的betType配置" . $betType, $gameBetTypeConfig);
            }

            if ($betOn == "SERIAL") { //连号则直接显示连号内容：该类型的字符串的第一组数值为真实下注行为。其他皆为複式
                $contentToCell = join("<br/>", [
                    $gameName . " - " . $betOnStr . " - " . $betTypeStr,
                    $contentJson["betDetails"],
                    $gameNo . "期 @" . $odds,
                ]);
            } else {
                $contentToCell = join("<br/>", [
                    $gameName . " - " . $betOnStr . " - " . $betTypeStr,
                    $gameNo . "期 @" . $odds,
                ]);
            }
        }

        // 显示游戏结算状态
        if ($data["isOver"]) {
            $gameStatusToCell = "结算完成";
        } else {
            $gameStatusToCell = "未结算";
        }

        // 显示下注、派彩、输赢、有效金额
        $stakeAmount = $data["stakeAmount"];
        $winLoseAmount = $data["winLoseAmount"];
        $corpWinLoseAmount = 0 - $winLoseAmount; // 公司输赢，与个人输赢相反
        $validStakeAmount = $data["validStakeAmount"];
        $bonusAmount = $winLoseAmount > 0 ? $winLoseAmount : 0; // 大于0的个人输赢，应该就是派彩

        if ($corpWinLoseAmount > 0) {
            $stakeToCell = ['green', number_format($stakeAmount, 2)];
            $bonusToCell = ['green', number_format($bonusAmount, 2)];
            $winLossToCell = ['green', number_format($corpWinLoseAmount, 2)];
            $validToCell = ['green', number_format($validStakeAmount, 2)];
        } else {
            $stakeToCell = ['red', number_format($stakeAmount, 2)];
            $bonusToCell = ['red', number_format($bonusAmount, 2)];
            $winLossToCell = ['red', number_format($corpWinLoseAmount, 2)];
            $validToCell = ['red', number_format($validStakeAmount, 2)];
        }

        // 显示注单是否有效状态
        $isRebateValid = $data["isRebateValid"];
        $dno = $data['dno'];
        if ($isRebateValid) {
            $rebateValidToCell = [$dno, "有效"];
            $operBtnToCell = ["red", "99", $dno, $platform, "设为无效"]; // JS按钮的状态值和参数
        } else {
            $rebateValidToCell = [$dno, "无效"];
            $operBtnToCell = ["green", "66", $dno, $platform, "设为有效"]; // JS按钮的状态值和参数
        }

        // 拼装数据返回
        $tmpdata = [
            $gameNameToCell,
            $accountToCell,
            $betId,
            $betTimeToCell,
            $contentToCell,
            $gameStatusToCell,
            $stakeToCell,
            $bonusToCell,
            $winLossToCell,
            $validToCell,
            $rebateValidToCell,
            $operBtnToCell,
        ];

        return [$tmpdata, [
            (float) $stakeAmount, // 下注统计数据
            (float) $bonusAmount, // 注单派彩数据
            (float) $corpWinLoseAmount, // 公司输赢数据
            (float) $validStakeAmount, // 有效投注数据
        ]];

    }

    public static function makeAGDataArray($data)
    {
        // 显示游戏平台的名字
        $platform = $data["platform"];
        $game = $data["game"];
        $platformGame = $data["platformGame"];
        // 显示投注内容
        $contentJson = json_decode($data["content"], true);

        /*$gameName = [
        "AGIN" => "AG国际厅",
        "YOPLAY" => "YOPlay",
        ];

        $gameNameToCell = join(" - ", [
        Config::platform[$platform],
        $gameName[$game],
        ]);*/

        // 显示玩家账号
        $account = $data["account"];

        $accountToCell = [$account, $account];

        // 显示注单号
        $betId = $data["betId"];

        // 显示下注时间
        $updateTime = $data["updateTime"];

        $betTimeToCell = parseDate($updateTime);

        // 构建AG Content

        $gameType = $contentJson["gameType"];
        $gameTypeConfig = AGConfig::gameType[$gameType];
        if (empty($gameTypeConfig)) {
            $contentToCell = "todo:need more config gametype:" . $gameType;
            $gameNameToCell = "todo:need more config gametype:" . $gameType;
        } else {
            $gameNameToCell = AGConfig::gameName[$gameTypeConfig[0]];
            if ($gameTypeConfig[0] == 1) { //AG真人
                $playType = $contentJson["playType"];
                if ($playType != 'null'&& AGConfig::gameBetOn[$playType]) {
                    $playType = AGConfig::gameBetOn[$playType];
                }
                $contentToCell = $contentJson["gameCode"] . "-" . $contentJson["tableCode"] . "<br/>" . $gameTypeConfig[1] . "-" . $playType;
            } else {
                $contentToCell = $gameTypeConfig[1];
            }

        }
        //注单数获取
        // 显示游戏结算状态
        if ($data["isOver"]) {
            $gameStatusToCell = "结算完成";
        } else {
            $gameStatusToCell = "未结算";
        }

        // 显示下注、派彩、输赢、有效金额
        $stakeAmount = $data["stakeAmount"];
        $winLoseAmount = $data["winLoseAmount"];
        $corpWinLoseAmount = 0 - $winLoseAmount; // 公司输赢，与个人输赢相反
        $validStakeAmount = $data["validStakeAmount"];
        $bonusAmount = $winLoseAmount > 0 ? $winLoseAmount : 0; // 大于0的个人输赢，应该就是派彩

        if ($corpWinLoseAmount > 0) {
            $stakeToCell = ['green', number_format($stakeAmount, 2)];
            $bonusToCell = ['green', number_format($bonusAmount, 2)];
            $winLossToCell = ['green', number_format($corpWinLoseAmount, 2)];
            $validToCell = ['green', number_format($validStakeAmount, 2)];
        } else {
            $stakeToCell = ['red', number_format($stakeAmount, 2)];
            $bonusToCell = ['red', number_format($bonusAmount, 2)];
            $winLossToCell = ['red', number_format($corpWinLoseAmount, 2)];
            $validToCell = ['red', number_format($validStakeAmount, 2)];
        }

        // 显示注单是否有效状态
        $isRebateValid = $data["isRebateValid"];
        $dno = $data['dno'];
        if ($isRebateValid) {
            $rebateValidToCell = [$dno, "有效"];
            $operBtnToCell = ["red", "99", $dno, $platform, "设为无效"]; // JS按钮的状态值和参数
        } else {
            $rebateValidToCell = [$dno, "无效"];
            $operBtnToCell = ["green", "66", $dno, $platform, "设为有效"]; // JS按钮的状态值和参数
        }

        // 拼装数据返回
        $tmpdata = [
            $gameNameToCell,
            $accountToCell,
            $betId,
            $betTimeToCell,
            $contentToCell,
            $gameStatusToCell,
            $stakeToCell,
            $bonusToCell,
            $winLossToCell,
            $validToCell,
            $rebateValidToCell,
            $operBtnToCell,
        ];

        return [$tmpdata, [
            (float) $stakeAmount, // 下注统计数据
            (float) $bonusAmount, // 注单派彩数据
            (float) $corpWinLoseAmount, // 公司输赢数据
            (float) $validStakeAmount, // 有效投注数据
        ]];
    }

    public static function showRebateHistoryHtml($datas, $rebateID)
    {
        $retdatas = array();
        for ($x = 0; $x < count($datas); $x++) {
            $account = getArrayValue("account", "TODO:缺失返回值", $datas[$x]);
            $agentAccount = getArrayValue("agentAccount", "", $datas[$x]);
            $name = urldecode(getArrayValue("name", "", $datas[$x]));
            $amount = getArrayValue("rebateAmount", "0", $datas[$x], true);
            $count = getArrayValue("rebate_betCount", 0, $datas[$x]);
            $platform = getArrayValue("platform", "", $datas[$x]);
            $game = getArrayValue("rebate_game", "", $datas[$x]);
            $groupName = getArrayValue("groupName", "", $datas[$x]);
            $stakeAmount = getArrayValue("rebate_stakeAmount", "0", $datas[$x], true);
            $winLoseAmount = getArrayValue("rebate_winLoseAmount", "0", $datas[$x], true);
            $time = getArrayValue("recordTime", "", $datas[$x]);
            $checkStatus = (int) getArrayValue("checkStatus", "1", $datas[$x]);
            if (!empty($time)) {
                $timeStr = date("Y-m-d", $time);
            } else {
                $timeStr = "TODO:缺失返回值";
            }

            if (empty($platform)) {
                $platformStr = "不限平台";
            } else {
                $platformStr = getArrayValue($platform, "", Config::platform);
            }

            $status = Config::statusMap[$checkStatus];

            $accountCell = self::makeAccHtml(["account" => $account]);
            $tmpdata = array(
                // "<input name=\"rakes\" class=\"form-control\" sid=\"".$x."\" uid=\"%ACCOUNT%\" gpid=\"".$platform."\" type=\"checkbox\">",
                $timeStr,
                $accountCell,
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
            $retdatas[] = $tmpdata;
        }
        return $retdatas;
    }
}
