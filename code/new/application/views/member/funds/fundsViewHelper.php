<?php

registerViewHelper(array("member/funds/fundsViewCommonMethod"));

trait fundsViewHelper{
    use fundsViewCommonMethod;

    static function shouWarnInfo($checkName = false, $checkPhone = false, $checkCard = false){
        $MemberInfo = getSessionValue("memberinfo", array());
        // print_r($MemberInfo);
        $flag = true;
        $tag = "";
        $showMsg = "为了阁下的资金安全，绑定银行卡前，我们需要验证阁下的个人信息。";
        if (count($MemberInfo) == 0){
            $flag = false;
        }else{
            if ($checkName && empty(getArrayValue("RealName", "", $MemberInfo))){
                $flag = false;
                $tag = "AccountSetting";
                $showAction = "个人信息";
                $showMsg = "为了阁下的资金安全，绑定银行卡前，我们需要验证阁下的个人信息。";
            }elseif($checkPhone && empty(getArrayValue("Phone", "", $MemberInfo))){
                $flag = false;
                $tag = "AccountSetting?setting=phone";
                $showMsg = "为了阁下的资金安全，绑定银行卡前，我们需要验证阁下的手机号码。";
                $showAction = "绑定手机";
            }elseif($checkCard && empty(getArrayValue("isBindCard", "", $MemberInfo))){
                $flag = false;
                $showMsg = "为了阁下的资金安全，在进行提款操作时，我们需要验证阁下的个人信息。";
                $tag = "BankManager";
                $showAction = "绑定银行卡";
            }
        }
        
        $html = "";
        if (!$flag){
            $html = readHtml("member/info_warn");
            $html = str_replace("%ACTIONDESC%", $showAction, $html);
            $html = str_replace("%TAGDESC%", $showMsg, $html);
            $html = str_replace("%ToPath%", $tag, $html);
        }
        return array($flag, $html, $tag);
    }
    
    function deposit(){
        $LoginStatus = checkLoginStatus();
        if(!$LoginStatus[0]){
            LoginReset();
            return false;
        }
        $page = self::initAccsMemberInfoArea("deposit", "member/accountsetting_funds/funds_deposit_scripts");//array data.
        $checkResult = self::shouWarnInfo();
        if (!$checkResult[0]){
            array_push($page, $checkResult[1]);
        }else{
            array_push($page, readHtml("member/accountsetting_funds/funds_deposit"));
        }
        array_push($page, readHtml("common/commonfooter"));
        output(join("", $page));
    }

    function withdrawal(){
         
        $LoginStatus = checkLoginStatus();
        if(!$LoginStatus[0]){
            LoginReset();
            return false;
        }
        $page = self::initAccsMemberInfoArea("withdrawal", "member/accountsetting_funds/funds_withdrawal_scripts");//array data.
        
        $checkResult = self::shouWarnInfo(false, false, true);
        if (!$checkResult[0]){
            array_push($page, $checkResult[1]);
        }else{
            $records = getBankInfo($LoginStatus);
            $cardInfos = array();
            // print_r($records);
            foreach($records as $_idx => $_card){
                $btype = getArrayValue("bankType", "", $_card);
                $bankInfo = getArrayValue($btype, "", $GLOBALS["BankTypes"]);
                
                array_push($cardInfos, array(
                    "name"=>getArrayValue("name", "",$bankInfo),
                    "card"=>getArrayValue("cardNo", "", $_card),
                    "value"=> getArrayValue("id", "1",$_card),
                    "banksn"=>getArrayValue("sn", "",$_card)
                ));
            }
            
            array_push($page, self::makeBankInfoPage($cardInfos));
        }     
        
        array_push($page, readHtml("common/commonfooter"));
        output(join("", $page));
    }

    function transfer(){
        /**
         * 玩家交易操作
         */
        $page = self::initAccsMemberInfoArea("transfer", "member/accountsetting_funds/funds_transfer_scripts");//array data.
        
        $LoginStatus = checkLoginStatus();
        if(!$LoginStatus[0]){
            LoginReset();
            return false;
        }

        $memberinfo = getSessionValue("memberinfo", array());
        $MainBalance = getArrayValue("MainBalance", 0, $memberinfo, true);
       

        // $retJson = GmServerCaller("GetBankCardInfo", array($MemberName));//缺少可用平台列表
        // $GPList = array("MAIN"=>"中心钱包",
        //             "IBC"=>"体育");
        // $t_Html = "";
        // foreach($GPList as $_key => $_val){
        //     $t_Html = $t_Html. "<option value=\"".$_key."\">".$_val."</option>";
        // }
        // $transferHtml = str_replace("%MainBalance%", $MainBalance, $transferHtml);
        $checkResult = self::shouWarnInfo();
        if (!$checkResult[0]){
            array_push($page, $checkResult[1]);
        }else{
            $transferHtml = readHtml("member/accountsetting_funds/funds_transfer.1");
            array_push($page, $transferHtml);
        }      
        array_push($page, readHtml("common/commonfooter"));
        output(join("", $page));
    }

    function History($request){
        // GetBalanceRecord
        $page = self::initAccsMemberInfoArea("history", "member/accountsetting_funds/funds_history_scripts");//array data.
        $pageIndex = getArrayValue("pageIndex", "1", $request);
        $LoginStatus = checkLoginStatus();
        if(!$LoginStatus[0]){
            LoginReset();
            return false;
        }
        $s_et = time();
        $startTime = getArrayValue("starttime", "month", $request);
        $transtype = getArrayValue("TransferType", "All", $request);
        
        switch($transtype){
            case "All":
                // $optype1 = 3;// recordType 存款1 取款2
                $optype2 = 15;// balanceType 存款1 取款2 转出4 转入8 调整16 返水64 红利128 优惠256
                break;
            case "Deposit":
                // $optype1 = 1;
                $optype2 = 1;
                break;
            case "Withdrawal":
                // $optype1 = 2;
                $optype2 = 2;
                break;
            case "Transfer":
                // $optype1 = 3;
                $optype2 = 12;
                break;
            case "Adjustment":
                // $optype1 = 3;
                $optype2 = 32;
                break;
            default:
                // $optype1 = 3;
                $optype2 = 47;// 1 - 存款 , 2 - 取款 4 -转走,8- 转进, 128 -红利
                break;
        }
        
        $retJson = GmServerCaller("GetBalanceRecord", array($LoginStatus[3], $optype2, getTime($startTime), $s_et, 1, 9999));
        $showData = array();
        if(getArrayValue("code", "", $retJson) == 200){
            $srecords = getArrayValue("data", array(), $retJson);
            $records = getArrayValue("data", array(), $srecords[0]);
            $showHistory = self::makeHistoryInfoPage($records, $pageIndex, $startTime, $transtype);
        }
        $content = readHtml("member/accountsetting_funds/funds_history");

        $content = str_replace("%HistoryData%", $showHistory, $content);
        $content = str_replace("%historyTime%", $startTime, $content);
        $content = str_replace("%historyType%", $transtype, $content);
        array_push($page, $content);
        array_push($page, readHtml("common/commonfooter"));

        output(join("", $page));
    }

    static function makeHistoryInfoPage($records, $pageIndex, $startTime, $transtype)
    {
        $pageIndex = (int)$pageIndex;
        $mailCount = count($records);
        $maxCount = 8;
        $mailStart = $maxCount * ($pageIndex - 1);
        $mailPages = (int)ceil($mailCount / $maxCount);//真实的pages
        if ($mailCount < $mailStart){
            $pageIndex = 1;
            $mailStart = 0;
            
        }
        $maxMailNum = $mailStart + $maxCount;
        $allhtml = "";
        $showData = array();
        for($x=$mailStart;$x<$mailCount;$x++){
            if ($x >= $maxMailNum){
                continue;
            }
            $_record = $records[$x];
            
            $time = getArrayValue("recordTime", "", $_record);
            if (!empty($time)){
                $time = parseDate($time);
            }
            $transId = getArrayValue("dno", "", $_record);
            $opType = getArrayValue("opType", "", $_record);
            $rt_str = parseRecodeTypes(2, $opType);

            $amount = getArrayValue("amount", "0", $_record);
            $checkStatus = (int)getArrayValue("checkStatus", 0, $_record);

            
            if($checkStatus == 1){
                $checkStatus = "待审核";
            }elseif ($checkStatus == 2){
                $checkStatus = "发放中";
            }elseif ($checkStatus == 4){
                $checkStatus = "被拒绝";
            }else{
                $checkStatus = "成功";
            }

            $temp = "<tr>";
            $temp = $temp."<td>".(string)($x+1)."</td>";
            $temp = $temp."<td>".$time."</td>";
            $temp = $temp."<td>".$transId."</td>";
            $temp = $temp."<td>".$rt_str."</td>";
            $temp = $temp."<td>".$amount."</td>";
            $temp = $temp."<td>".$checkStatus."</td></tr>";
            
            array_push($showData, $temp) ;
        }
        $allhtml = join("", $showData);

        if ($mailPages > 1){
            $_html = '<tr><td colspan="6" style="background:#f5f5f5"><span class="page"><strong>';

            for($y=0;$y<$mailPages;$y++){
                $idx = $y + 1;
                if ($idx == $pageIndex){
                    $_html = $_html . "<strong><span>" . $idx . "</span></strong>";
                }else{
                    $_html = $_html . "<a href=\"History?pageIndex=".$idx ."&starttime=".$startTime."&TransferType=".$transtype."\"><span>" . $idx . "</span></a>";
                }

                if ($idx == $mailPages){
                    $_html = $_html . "</strong><a  href=\"History?pageIndex=".$idx."&starttime=".$startTime."&TransferType=".$transtype."\" class=\"nextPage\"><span>下一页</span></a></span></td></tr>";
                }

            }
            $allhtml = $allhtml.$_html;
        }

        return $allhtml;
    }

    /**
     * 银行卡界面
     */
    static function BankManager(){
        $page = self::initAccsMemberInfoArea("bankmanager", "member/accountsetting_funds/funds_bankmanager_scripts");//array data.
    
        $LoginStatus = checkLoginStatus();
        if(!$LoginStatus[0]){
            LoginReset();
            return false;
        }
        
        $checkResult = self::shouWarnInfo(true , true, false);
        if (!$checkResult[0] && $checkResult[2] != "BankManager"){
            array_push($page, $checkResult[1]);
        }else{
            $records = getBankInfo($LoginStatus);
            $cardInfos = array();
            foreach($records as $_idx => $_card){
                $btype = getArrayValue("bankType", "", $_card);
                $bankInfo = getArrayValue($btype, "", $GLOBALS["BankTypes"]);
                array_push($cardInfos, array(
                    "name"=>urldecode(getArrayValue("name", "",$bankInfo)),
                    "card"=>getArrayValue("cardNo", "", $_card),
                    "value"=>getArrayValue("id", "", $_card),
                    "banksn"=>getArrayValue("sn", "",$bankInfo)
                ));
            }
            
            array_push($page, self::makeCardsInfoPage($cardInfos));
        }      
        array_push($page, readHtml("common/commonfooter"));
        output(join("", $page));
    }
        
}
?>