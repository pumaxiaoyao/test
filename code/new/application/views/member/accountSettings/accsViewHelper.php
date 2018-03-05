<?php
/**
 * accountsetting 类的扩充方法
 */
trait accsViewHelper{
    
    function showAccountSetting(){
        /**
         * 构建基础的AccountSetting主页界面
         */
        $page = self::initAccsMemberInfoArea("basicinfo");//array data.
        array_push($page, self::showBaseInfo());
        array_push($page, readHtml("common/commonfooter"));
        output(join("", $page));
    }

    
    static function initAccsMemberInfoArea($pagename, $pageScripts = ''){
        /**
         * 初始化账号中心界面的公共区域界面内容
         * makeNav导航栏的方法，是每次都会获取一次服务器角色数据，并存入session中 
         * 导航栏后面的界面所需的数据，都从session中读取
         */
        return array(
            makeHeader("member/accountsetting/accountsetting_header_metas", $pageScripts),
            makeNav(),
            self::setOnShowPagename(self::initMemberInfoPage(), $pagename)
        );
    }

    static function initMemberInfoPage(){
        /**
         * 初始化账号管理界面的角色数据页面，该页面应该仅在有数据时显示
         */
        $page = readHtml("member/accountsetting/accountsetting_common");
        $LoginStatus = checkLoginStatus();
        if ($LoginStatus[0]){
            $memberinfo = getSessionValue("memberinfo", array());
            $_phone = getArrayValue("Phone", "", $memberinfo);
            $_email = getArrayValue("Email", "", $memberinfo);
            $_name = getArrayValue("RealName", "", $memberinfo);
            $_card = getArrayValue("isBindCard", "", $memberinfo);
            $_balance = getArrayValue("MainBalance", 0, $memberinfo, true);
            $safetyInfos = array();
            //评估安全等级的数组
            $_t = array($_phone, $_email, $_name, $_card);
            foreach ( $_t as $_value){
                if (!empty($_value)){
                    array_push($safetyInfos, true);
                }
            }
            $safetyCounts = count($safetyInfos);
            if ($safetyCounts == 4){
                $SafetyLevelWords = "高";
            }elseif($safetyCounts > 1){
                $SafetyLevelWords = "中";
            }else{
                $SafetyLevelWords = "低";
            }
            $replaceWords = array(
                "LoginMemberName"=>$LoginStatus[2],
                "AccountSafetyLevel"=>$SafetyLevelWords,
                "PhoneBindStatus"=>empty($_phone)?"":"on",
                "EmailBindStatus"=>empty($_email)?"":"on",
                "UserinfoBindStatus"=>empty($_name)?"":"on",
                "BankcardBindStatus"=>empty($_card)?"":"on",
                "MainBalance"=>$_balance,
                "SafetyRate"=>$safetyCounts * 100 /4,
            );
    
            foreach($replaceWords as $_key=>$_val){
                $page = str_replace('%'.$_key.'%', $_val, $page);
            }
            
        }else{
            LoginReset();
        }
        return $page;
    }

    static function setOnShowPagename($page, $pageName){
        /**
         * 根据传入的参数，为页面的名字pageName, 以及页面head区域的不同js配置
         * 此方法只能用于accountsetting页面，其他页面不生效
         */
        $pageSwitchs = array(
            "depositSwitch", "withdrawalSwitch", "transferSwitch", "historySwitch", "bankmanagerSwitch",
            "basicinfoSwitch", "receiveboxSwitch", "bettingrecordsSwitch"
        );
        foreach($pageSwitchs as $_pageswitch){
            if (strtolower($_pageswitch) == strtolower($pageName)."switch"){
                $page = str_replace('%'.$_pageswitch.'%', "on", $page);
            }else{
                $page = str_replace('%'.$_pageswitch.'%', "", $page);
            }
        }
        return $page;
    }
    
    function showBaseInfo(){
        /** 
         * 根据角色数据，刷新角色基础数据页面
        */
        $page = readHtml("member/accountsetting/accountsetting");
        $replaceContents = array(
            "%BasicInfoHtml%" => self::makeAccsBaseInfoPage(),
            "%SettingMailHtml%" => self::makeAccsMailPage(),
            "%SettingPhoneHtml%" => self::makeAccsPhonePage(),
        );
        foreach($replaceContents as $_k=>$_v){
            $page = str_replace($_k, $_v, $page);
        }
        return $page;
    }

    function makeAccsBaseInfoPage(){
        /**
         * 构建基础信息的界面
         * 从session中获取数据，不需要取值，session的数据来源于makeNav的更新
         * 按照需求，去除了原来有的性别，地址等信息显示
         */
        $page = readHtml("member/accountsetting/accountsetting_basicinfo");
        $LoginStatus = checkLoginStatus();
        if ($LoginStatus[0]){
            $memberinfo = getSessionValue("memberinfo", array());
            $_name = getArrayValue("RealName", "", $memberinfo);
            $IsFirstName = empty($_name);
            if ($IsFirstName){
                $RealName = "";
                $isFirstName_Html = '<input name="FirstName" type="text" id="FirstName" placeholder="真实姓名" class="r_inptut inputwd300" style="width: 150px" />';
                $SaveBtn = '<button id="information_bt" type="button" class="as_but inputwd300"> 保存</button>';
            }else{
                $RealName = $_name;
                $isFirstName_Html = "";
                $SaveBtn = "";
            }

            $replaceWords = array(
                "IsFirstNameHtml"=>$isFirstName_Html,
                "RealName"=>urldecode($_name),
                "SAVEBTN"=>$SaveBtn
            );
    
            foreach($replaceWords as $_key=>$_val){
                $page = str_replace('%'.$_key.'%', $_val, $page);
            }
        }
        return $page;
    }
    
    function makeAccsPhonePage(){
        /**
         * 构建手机信息界面
         * 
         */
        $LoginStatus = checkLoginStatus();
        if ($LoginStatus[0]){
            $memberinfo = getSessionValue("memberinfo", array());
            if (empty($memberinfo["Phone"])){
                $page = readHtml("member/accountsetting/accountsetting_unBindPhone");
            }else{
                $page = readHtml("member/accountsetting/accountsetting_BindPhone");
                $page = str_replace("%BindPhoneNumber%", $memberinfo["Phone"], $page);
            }
        }else{
            $page = "";
        }
        $page .= "<script>";
        $interval = getSessionValue("GetPhoneCodeTime", 0) + 60 - time();
        if ($interval >0) {
            $page .= "var LastPhoneCode=true; var PhoneCodeInterval=".$interval.";";
        } else {
            $page .= "var LastPhoneCode=false; var PhoneCodeInterval=0;";
        }
        $intervalUnPhone = getSessionValue("GetUnPhoneCodeTime", 0) + 60 - time();
        if ($intervalUnPhone > 0) {
            $page .= "var LastUnPhoneCode=true; var UnPhoneCodeInterval=".$intervalUnPhone.";";
        } else {
            $page .= "var LastUnPhoneCode=false; var UnPhoneCodeInterval=0;";
        }
        $intervalMail = getSessionValue("GetMailCodeTime", 0) + 60 - time();
        if ($intervalMail > 0) {
            $page .= "var LastMailCode=true; var MailCodeInterval=".$intervalMail.";";
        } else {
            $page .= "var LastMailCode=false; var MailCodeInterval=0;";
        }
        $intervalUnMail = getSessionValue("GetUnMailCodeTime", 0) + 60 - time();
        if ($intervalUnMail > 0) {
            $page .= "var LastUnMailCode=true; var UnMailCodeInterval=".$intervalUnMail.";";
        } else {
            $page .= "var LastUnMailCode=false; var UnMailCodeInterval=0;";
        }
        $page .= "</script>";

        return $page;
    }
    
    function makeAccsMailPage(){
        /**
         * 构建邮件界面
         */
        $LoginStatus = checkLoginStatus();
        if ($LoginStatus[0]){
            $memberinfo = getSessionValue("memberinfo", array());
            if (empty($memberinfo["Email"])){
                $page = readHtml("member/accountsetting/accountsetting_unBindMail");
            }else{
                $page = readHtml("member/accountsetting/accountsetting_BindMail");
                $page = str_replace("%BindEmailAddr%", urldecode($memberinfo["Email"]), $page);
            }
        }else{
            $page = "";
        }
        return $page;
    }
    
    
    function makeSendBoxMailPage($sendmails){
        // $page = readHtml("member/accountsetting/accountsetting_sendbox");
        // $allmails = '';
        // foreach($sendmails as $_mail){
        //     $_html = readHtml("/member/accountsetting/accountsetting_singlemail");
        //     $_html = str_replace("%mailid%", $_mail["mailid"], $_html);
        //     $_html = str_replace("%mailtime%", $_mail["recvtime"], $_html);
        //     $_html = str_replace("%mailstatus%", $_mail["status"], $_html);
        //     $_html = str_replace("%mailmessage%", $_mail["message"], $_html);
        //     $allmails = $allmails.$_html;
        // }
        // $page = str_replace("%allsendmails%", $allmails, $page);
        // return $page;
    }
    
    function makebetGPRecordsPage($gp, $records){
        $page = readHtml("member/accountsetting/accountsetting_bettingrecord");
        $_html = readHtml("member/accountsetting/ac_betRecord_IBC");
        $totalCount = 0;
        $totalFlow = 0;
        $totalWinLose = 0;
        $allHtml = "";
        
        $record = getArrayValue("data", array(), $records);
        foreach($record as $_record){
            $betCount = getArrayValue("betCount", 1, $_record);
            $betFlow = getArrayValue("amount", 0, $_record);
            $winLose = getArrayValue("winLoseAmount", 0, $_record);
            $totalCount += (int)$betCount;
            $totalFlow += (int)$betFlow;
            $totalWinLose += (int)$winLose;
            
            $sportType = getArrayValue("sportType", "", $_record);
            $oddsType = getArrayValue("oddsType", "", $_record);
            $st_name = getArrayValue($sportType, "", $GLOBALS["sportsType"]);
            $ot_name = getArrayValue($oddsType, "", $GLOBALS["oddsType"]);
            $html = "<tr><td>".$st_name."</td>";
            $html = $html."<td>".$ot_name."</td>";
            $html = $html."<td>".getArrayValue("odds", "", $_record)."</td>";
            $html = $html."<td>".$betCount."</td>";
            $html = $html."<td>".$betFlow."</td>";
            $html = $html."<td><span class='green'>".$winLose."</span></td></tr>";
            $allHtml = $allHtml . $html;    
        }
        
        $_html = str_replace("%ALLBETRECORD%", $allHtml, $_html);
        $_html = str_replace("%productName%", $gp, $_html);
        $_html = str_replace("%BETTYPE%", getArrayValue("BETTYPE", "", $record), $_html);
        $_html = str_replace("%BETRATE%", getArrayValue("BETRATE", "", $record), $_html);
        $_html = str_replace("%BETCOUNT%", $totalCount, $_html);
        $_html = str_replace("%BETFLOW%", $totalFlow, $_html);
        $_html = str_replace("%WINLOSE%", $totalWinLose, $_html);
        $page = str_replace("%AllBettingRecords%", $_html, $page);
        
        return $page;

    }


    function makebettingRecordsPage($bettingrecords){
        $page = readHtml("member/accountsetting/accountsetting_bettingrecord");
        $allrecords = '<tr>
        <th>产品</th><th>笔数</th><th>投注流水</th><th>输赢</th>
        </tr>';
        $totalCounts = 0;
        $totalAmount = 0;
        $totalResult = 0;
        foreach($bettingrecords as $gpId=>$_record){
            $totalCounts += (int)$_record["data"]["count"];
            $totalAmount += (int)$_record["data"]["stake"];
            $totalResult += (int)$_record["data"]["winLose"];
            $_html = readHtml("member/accountsetting/accountsetting_singlerecord");
            $_html = str_replace("%productName%", $_record["name"], $_html);
            $_html = str_replace("%ProductID%", $gpId, $_html);
            $_html = str_replace("%bettingCount%", $_record["data"]["count"], $_html);
            $_html = str_replace("%bettingAmount%", $_record["data"]["stake"], $_html);
            $_html = str_replace("%BettingResult%", $_record["data"]["winLose"], $_html);
            $allrecords = $allrecords.$_html;
        }
        $allrecords = $allrecords.'<tr class="total"><td>总计</td><td>%TotalCounts%</td><td>%TotalAmount%</td><td>
        <span class="green">%TotalResult%</span></td></tr>';
        $page = str_replace("%AllBettingRecords%", $allrecords, $page);
        $page = str_replace("%TotalCounts%", $totalCounts, $page);
        $page = str_replace("%TotalAmount%", $totalAmount, $page);
        $page = str_replace("%TotalResult%", $totalResult, $page);
        return $page;
    }

    function initBetRecordJSHtml($startTime){
        // $queryArgus = $_SERVER["QUERY_STRING"];
        // if(empty($queryArgus)){
        //     $stimeHtml = "today";
        // }else{
        //     $allowTags = array("today", "3day", "week", "month");
        //     $stime = explode("=", $queryArgus);
        //     if (count($stime) != 2){
        //         $stimeHtml = "today";
        //     }elseif(in_array($stime[1], $allowTags)){
        //         $stimeHtml = $stime[1];
        //     }else{
        //         $stimeHtml = "today";
        //     }
        // }
        return '<script>var historyTime = "'.$startTime.'";</script>';
    }
    
    function MsDetail($request){
        /**
         * 消息详情界面
         */
        $LoginStatus = checkLoginStatus();
        if(!$LoginStatus[0]){
            LoginReset();
            return false;
        }
        $mailId = getArrayValue("messageid", 1, $request);
        $mailType = getArrayValue("type", 1, $request);
        $retJson = GmServerCaller("ReadMessage", array($LoginStatus[3], (int)$mailId));
        
        if (getArrayValue("code", "", $retJson) == 200){
            $mail = getArrayValue(0, array(), $retJson["data"]);
            $mailHtml = readHtml("member/accountsetting/accountsetting_openmail");
            $replaceStr = array(
                "MailType"=>$mailType,
                "MailId"=>$mailId,
                "MailTitle"=>urldecode(getArrayValue("title", "", $mail)),
                "MailTime"=>parseDate((int)getArrayValue("time", "", $mail)),
                "MailContent"=>urldecode(getArrayValue("content", "", $mail))
            );
            foreach($replaceStr as $_key => $_val){
                $mailHtml = str_replace("%".$_key."%", $_val, $mailHtml);
            }
            return output($mailHtml);
        }else{
            return false;
        }
    }

    static function makeReceiveBoxMailPage($receivemails, $pageIndex){
        $pageIndex = (int)$pageIndex;
        $mails = getArrayValue(0, array(), $receivemails);

        $mailCount = count($mails);
        $page = readHtml("member/accountsetting/accountsetting_receivebox");

        
        $maxCount = 8;
        $mailStart = $maxCount * ($pageIndex - 1);
        $mailPages = (int)ceil($mailCount / $maxCount);//真实的pages
        if ($mailCount < $mailStart){
            $pageIndex = 1;
            $mailStart = 0;
            
        }
        $maxMailNum = $mailStart + $maxCount;
        $allmails = "";
        // $allmails = 'page count is '. $mailPages . "page is start from " . $mailStart;
        for($x=$mailStart;$x<$mailCount;$x++){
            if ($x >= $maxMailNum){
                continue;
            }
            $_mail = $mails[$x];
            $mailStatus = (int)getArrayValue("messageStatus", 0, $_mail);
            if ($mailStatus == 1){
                $mailStatus = "未读";
            }else{
                $mailStatus = "已读";
            }
                
            $_html = readHtml("member/accountsetting/accountsetting_singlemail");
            $_html = str_replace("%mailid%", getArrayValue("recordNum", "", $_mail), $_html);
            $_html = str_replace("%mailtime%", parseDate((int)getArrayValue("time", "", $_mail)), $_html);
            $_html = str_replace("%mailstatus%", $mailStatus, $_html);
            $_html = str_replace("%mailmessage%", urldecode(getArrayValue("title", "", $_mail)), $_html);
            
            $allmails = $allmails.$_html;
        }
        if ($mailPages > 1){
            $_html = '<tr><td colspan="5" style="background:#f5f5f5"><span class="page"><strong>';

            for($y=0;$y<$mailPages;$y++){
                $idx = $y + 1;
                if ($idx == $pageIndex){
                    $_html = $_html . "<strong><span>" . $idx . "</span></strong>";
                }else{
                    $_html = $_html . "<a href=\"receivebox?pageIndex=".$idx ."\"><span>" . $idx . "</span></a>";
                }

                if ($idx == $mailPages){
                    $_html = $_html . "</strong><a  href=\"receivebox?pageIndex=".$idx."\" class=\"nextPage\"><span>下一页</span></a></span></td></tr>";
                }

            }
            $allmails = $allmails.$_html;
        }
        
        $page = str_replace("%allreceivemails%", $allmails, $page);
        return $page;
    }
    
}
?>