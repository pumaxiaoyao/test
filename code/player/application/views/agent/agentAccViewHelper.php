<?php
/**
* 注册相关的页面构建方法
*/
trait agentAccViewHelper{

    /**
     * 构建Agent的通用滑动展示界面
     *
     * @param [type] $pageid 默认显示的页面
     * 
     * @return void
     */
    static function makeAgentCommonPage($pageid)
    {
        $page = array(
            makeAgentHeader("index/main_header_metas","promotions/promotions_header_scripts"),
            makeAgentNav(),
            
            readHtml("agents/index"),
            "<script>
                $(function () {
                    $('#iview').iView({
                        pauseTime: 7000,
                        directionNav: false,
                        controlNav: true,
                        tooltipY: 0,
                        timerOpacity: 0,
                        startSlide:" .$pageid . "
                    });
                })
            </script>",
            readHtml("common/commonfooter")
        );
        return join("", $page);
    }
    
    /**
     * 构建代理申请的界面
     *
     * @return void
     */
    static function index()
    {
        return output(self::makeAgentCommonPage(0));
    }

    /**
     * 代理-合营模式的界面
     *
     * @return void
     */
    static function agentMode()
    {
        return output(self::makeAgentCommonPage(1));
    }

    
    /**
     * 代理-佣金政策的界面
     *
     * @return void
     */
    static function Policies()
    {
        return output(self::makeAgentCommonPage(2));
    }

    /**
     * 代理-联系我们的界面
     *
     * @return void
     */
    static function Contact()
    {
        return output(self::makeAgentCommonPage(3));
    }

    /**
     * 构建代理申请的界面
     *
     * @return void
     */
    static function apply()
    {
        $LoginStatus = checkAgentLoginStatus();
        $page = array(
            makeAgentHeader("index/main_header_metas","promotions/promotions_header_scripts"),
            makeAgentNav(),
            str_replace("%agentboss%", $LoginStatus[2],readHtml("agents/apply")),
            readHtml("common/commonfooter")
        );
        
        $LoginStatus = checkAgentLoginStatus();
        array_push($page, "<script>var agentboss=\"". $LoginStatus[2] ."\"</script>");
        
        output(join("", $page));
    }


    
    static function showAgentAccount()
    {
        $page = array(
            makeAgentHeader("index/main_header_metas","promotions/promotions_header_scripts"),
            makeAgentNav(),
            setOnShowAgentPageName(initAgentInfoPage(), "agentAccount"),
            self::showAgentBaseInfo(),
            readHtml("common/commonfooter")
        );
        output(join("", $page));
    }

    function showAgentBaseInfo(){
        /** 
         * 根据角色数据，刷新角色基础数据页面
        */
        $page = readHtml("agents/agentInfo/agentAccount");
        $replaceContents = array(
            "%BasicInfoHtml%" => self::makeAgentBaseInfoPage(),
            "%SettingMailHtml%" => self::makeAccsMailPage(),
            "%SettingPhoneHtml%" => self::makeAccsPhonePage(),
        );
        foreach($replaceContents as $_k=>$_v){
            $page = str_replace($_k, $_v, $page);
        }
        return $page;
    }

    
    function makeAccsMailPage(){
        /**
         * 构建邮件界面
         */
        $LoginStatus = checkAgentLoginStatus();
        if ($LoginStatus[0]){
            $agentInfos = getSessionValue("agentInfos", array());
            if (empty($agentInfos["Email"])){
                $page = readHtml("member/accountsetting/accountsetting_unBindMail");
            }else{
                $page = readHtml("member/accountsetting/accountsetting_BindMail");
                $page = str_replace("%BindEmailAddr%", getArrayValue("Email", "", $agentInfos), $page);
            }
        }else{
            $page = "";
        }
        return $page;
    }

    function makeAgentBaseInfoPage(){
        /**
         * 构建基础信息的界面
         * 从session中获取数据，不需要取值，session的数据来源于makeNav的更新
         * 按照需求，去除了原来有的性别，地址等信息显示
         */
        $page = readHtml("agents/agentInfo/agentBaseinfo");
        $LoginStatus = checkAgentLoginStatus();
        if ($LoginStatus[0]){
            $agentInfos = getSessionValue("agentInfos", array());
            $_name = getArrayValue("RealName", "", $agentInfos);
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
        $LoginStatus = checkAgentLoginStatus();
        if ($LoginStatus[0]){
            $agentInfos = getSessionValue("agentInfos", array());
            if (empty($agentInfos["Phone"])){
                $page = readHtml("member/accountsetting/accountsetting_unBindPhone");
            }else{
                $page = readHtml("member/accountsetting/accountsetting_BindPhone");
                $page = str_replace("%BindPhoneNumber%", $agentInfos["Phone"], $page);
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

    static function memberReports($request)
    {
        $page = array(
            makeAgentHeader("index/main_header_metas","promotions/promotions_header_scripts"),
            makeAgentNav(),
            setOnShowAgentPageName(initAgentInfoPage(), "memberReports"),
            readHtml("agents/reports/memberReports"),
            readHtml("common/commonfooter")
        );
        output(join("", $page));
    }

    /**
     * 构建下线会员列表数据
     *
     * @param [type] $ret
     * @return void
     */
    static function showMemberRepHtml($ret)
    {
        $html = "";
        $data = getArrayValue("data", array(), $ret);
        $pdep = 0;
        $pwithd = 0;
        $pbet = 0;
        $pwin = 0;
        for ($x=0;$x<count($data);$x++) {
            $_data = $data[$x];
            $depsit = getArrayValue("depositAmount", 0, $_data);
            $pdep += $depsit; 
            $withDrawal = getArrayValue("withdrawalAmount", 0, $_data);
            $pwithd += $withDrawal;
            $bet = getArrayValue("stakeAmount", 0, $_data);
            $pbet += $bet;
            $winLoss = getArrayValue("winLoseAmount", 0, $_data);
            $pwin += $winLoss;
            $onlineTime = getArrayValue("onlineTime", 0, $_data);
            $name = getArrayValue("name", "", $_data);
            $joinTime = getArrayValue("joinTime", 0, $_data);
            $idx = $x + 1;
            if ($onlineTime == 0) {
                $onlineTag = "<td>". $_data["account"] . "</td>";
            } else {
                if ($onlineTime < 0){
                    $onlineTag = "<td class='green'>". $_data["account"] . "(在线)</td>";
                }elseif( $onlineTime < 60) {
                    $onlineTag = "<td>". $_data["account"] . "(1分钟内)</td>";
                } else {
                    $onlineTag = "<td>". $_data["account"] . "(". self::parseTimeTag($onlineTime) ."前)</td>";
                }
            }
            $_html = "<tr><td>". $idx . "</td>";
            $_html .= $onlineTag;
            $_html .= "<td>" . $name . "</td>";
            $_html .= "<td>" . parseDate($joinTime, 2) . "</td>";
            $_html .= "<td>" . $depsit . "</td>";
            $_html .= "<td>" . $withDrawal . "</td>";
            $_html .= "<td>" . $bet . "</td>";
            $_html .= "<td>" . $winLoss . "</td></tr>";
            $html .= $_html;
        }
        $html .= "<tr><td colspan='4'>合计</td><td>".$pdep."</td><td>".$pwithd."</td><td>".$pbet."</td><td>".$pwin."</td></tr>";
        return $html;
    }

    static function settleDetail($request)
    {
        
        $data = getSessionValue("GameCommision", array());
        $month = getArrayValue("month", "", $request);
        $commisionHtml = getArrayValue($month, array(), $data);
        $gcHtml = getArrayValue("gc", "", $commisionHtml);
        $ccHtml = getArrayValue("cc", "", $commisionHtml);
        $srHtml = readHtml("agents/reports/settleReport");
        $srHtml = str_replace("{{GameCommisionData}}", $gcHtml, $srHtml);
        $srHtml = str_replace("{{ChildCommisionData}}", $ccHtml, $srHtml);

        return output($srHtml);


    }

    function showBenifitReport($ret)
    {
        $html = "";
        foreach ($ret as $_data) {
            
            $month = getArrayValue("month", "", $_data);
            $validPlayerCount = getArrayValue("ValidPlayerCount", 0, $_data);
            $platformCommision = getArrayValue("platformCommision", 0, $_data);
            $costAllocation = getArrayValue("costAllocation", 0, $_data);
            $lastMonthLeftAMount = getArrayValue("lastMonthLeftAmount", 0, $_data);
            $nextMonthLeftAMount = getArrayValue("lastMonthLeftAmount", 0, $_data);
            $adjustmentAmount = getArrayValue("adjustmentAmount", 0, $_data);
            $commisionAmount = getArrayValue("commisionAmount", 0, $_data);
            $commisionResultAmount = getArrayValue("commisionResultAmount", 0, $_data);
            $checkStatus = (string)getArrayValue("checkStatus", "1", $_data);
            switch ($checkStatus){
                case "1":
                    $status = "<td>待初审</td>";
                    break;
                case "2":
                    $status = "<td class='green'>已初审</td>";
                    break;
                case "8":
                    $status = "<td class='green'>已终审</td>";
                    break;
                case "16":
                    $status = "<td class='red'>锁定</td>";
                    break;
            }

            $_html = "<tr><td>". $month . "</td>";
            $_html .= "<td>" . $validPlayerCount . "</td>";
            
            $_html .= "<td><a href=\"javascript:void(0);\" class='agentDetailBtn' onclick=\"detail('" . $month. "', '1')\"><i class='fa fa-building-o'></i>". $platformCommision . "</a></td>";
            $_html .= "<td><a href=\"javascript:void(0);\" class='agentDetailBtn' onclick=\"detail2('" . $month. "', '1')\"><i class='fa fa-building-o'></i>". $costAllocation . "</a></td>";
            $_html .= "<td>" . $lastMonthLeftAMount . "</td>";
            $_html .= "<td>" . $adjustmentAmount . "</td>";
            $_html .= "<td>" . $commisionAmount . "</td>";
            $_html .= "<td>" . $nextMonthLeftAMount . "</td>";
            $_html .= "<td>" . $commisionResultAmount . "</td>";
            $_html .= $status . "</tr>";
            $html .= $_html;
            $gcData = self::makeGameCommissionHtml($_data);
            $gcHtml = $gcData[0];
            
            $ccHtml = self::makeChildCommissionHtml($_data, $gcData[1]);
            $caHtml = self::makeChildCostAlloation($_data);
            if (!isset($_SESSION["GameCommision"])) {
                $_SESSION["GameCommision"] = array();
            }
            
            $_SESSION["GameCommision"][$month]= array("gc"=>$gcHtml, "cc"=>$ccHtml, "ca"=>$caHtml);
        }
        return $html;
    }

    /**
     * 生成成本分摊界面的Html
     *
     * @param [type] $data 数据
     * 
     * @return void
     */
    static function makeChildCostAlloation($data)
    {
        $caHtml = "";
        $childStr = getArrayValue("childStr", "", $data);

        $depositBonusAllocationAmount = (float)getArrayValue("depositBonusAllocationAmount", 0, $data);
        $depositBonusAmount = (float)getArrayValue("depositBonusAmount", 0, $data);
        $depositBonusRate = sprintf("%.2f", getArrayValue("depositBonusRate", 0, $data) *100);

        $bonusAllocationAmount = (float)getArrayValue("bonusAllocationAmount", 0, $data);
        $bonusAmount = (float)getArrayValue("bonusAmount", 0, $data);
        $bonusRate = sprintf("%.2f", getArrayValue("bonusRate", 0, $data) *100);

        $rebateAllocationAmount = (float)getArrayValue("rebateAllocationAmount", 0, $data);
        $rebateAmount = (float)getArrayValue("rebateAmount", 0, $data);
        $rebateRate = sprintf("%.2f", getArrayValue("rebateRate", 0, $data) *100);
        // AgentAllocationData

        $caHtml = "<tr><th>".$depositBonusAllocationAmount."</th>";
        $caHtml .= "<th>".$depositBonusRate."%</th>";
        $caHtml .= "<th>".$depositBonusAmount."</th>";

        $caHtml .= "<th>".$bonusAllocationAmount."</th>";
        $caHtml .= "<th>".$bonusRate."%</th>";
        $caHtml .= "<th>".$bonusAmount."</th>";

        $caHtml .= "<th>".$rebateAllocationAmount."</th>";
        $caHtml .= "<th>".$rebateRate."%</th>";
        $caHtml .= "<th>".$rebateAmount."</th></tr>";

        $lineChargeRate = sprintf("%.2f", getArrayValue("lineChargeRate", 0, $data) *100);
        
        
        $ccHtml = "";
        $totalDeposit = 0;
        $totalBonus = 0;
        $totalRebate = 0;
        if (!empty($childStr)) {
            $childData = json_decode($childStr, true);
            foreach ($childData as $cData) {
                $roleId = getArrayValue("roleId", "", $cData);

                $_depositBonusAllocationAmount = (float)getArrayValue("depositBonusAllocationAmount", 0, $cData);
                $_depositBonusAmount = (float)getArrayValue("depositBonusAmount", 0, $cData);
                $_depositBonusRate = sprintf("%.2f", getArrayValue("depositBonusRate", 0, $cData) *100);
                
                $_bonusAllocationAmount = (float)getArrayValue("bonusAllocationAmount", 0, $cData);
                $_bonusAmount = (float)getArrayValue("bonusAmount", 0, $cData);
                $_bonusRate = sprintf("%.2f", getArrayValue("bonusRate", 0, $cData) *100);

                $_rebateAllocationAmount = (float)getArrayValue("rebateAllocationAmount", 0, $cData);
                $_rebateAmount = (float)getArrayValue("rebateAmount", 0, $cData);
                $_rabateRate = sprintf("%.2f", getArrayValue("rabateRate", 0, $cData) *100);
                
                $totalDeposit += $_depositBonusAllocationAmount;
                $totalBonus += $_bonusAllocationAmount;
                $totalRebate += $_rebateAllocationAmount;

                $ccHtml .= "<tr><td>" . $roleId . "</td>";
                $ccHtml .= "<td>" . $_depositBonusAllocationAmount . "</td>";
                $ccHtml .= "<td>" . $_depositBonusRate . "%</td>";
                $ccHtml .= "<td>" . $_depositBonusAmount . "</td>";
                $ccHtml .= "<td>" . $_bonusAllocationAmount . "</td>";
                $ccHtml .= "<td>" . $_bonusRate . "%</td>";
                $ccHtml .= "<td>" . $_bonusAmount . "</td>";
                $ccHtml .= "<td>" . $_rebateAllocationAmount . "</td>";
                $ccHtml .= "<td>" . $_rabateRate . "%</td>";
                $ccHtml .= "<td>" . $_rebateAmount . "</td></tr>";
            }

        }

        $ccHtml .= "<tr><td>实际承担费用</td>";
        $ccHtml .= "<td colspan=2>存款优惠</td>";
        $ccHtml .= "<td>". ($depositBonusAllocationAmount - $totalDeposit) ."</td>";
        $ccHtml .= "<td colspan=2>红利</td>";
        $ccHtml .= "<td>". ($bonusAllocationAmount - $totalBonus) ."</td>";
        $ccHtml .= "<td colspan=2>返水</td>";
        $ccHtml .= "<td>". ($rebateAllocationAmount - $totalRebate) ."</td>";

        return array($caHtml, $ccHtml);
    }
    static function makeChildCommissionHtml($data, $TotalCommision)
    {   
        $ccHtml = "";
        $childStr = getArrayValue("childStr", "", $data);
        $lineChargeRate = sprintf("%.2f", getArrayValue("lineChargeRate", 0, $data) *100);
        $totalLineCommision = 0;
        if (!empty($childStr)) {
            $childData = json_decode($childStr, true);

            foreach ($childData as $cData) {
                $roleId = getArrayValue("roleId", "", $cData);
                $commisionAmount = getArrayValue("pumpingCommisionAmount", 0 , $cData);
                $waterAmount = getArrayValue("pumpingWaterAmount", 0 , $cData);
                $totalAmount = $commisionAmount + $waterAmount;
                $lineAmount = getArrayValue("lineChargeAmount", 0 , $cData);
                $totalLineCommision += $lineAmount;
                $ccHtml .= "<tr><td>" . $roleId . "</td>";
                $ccHtml .= "<td>" . $commisionAmount . "</td>";
                $ccHtml .= "<td>" . $waterAmount . "</td>";
                $ccHtml .= "<td>" . $totalAmount . "</td>";
                $ccHtml .= "<td>" . $lineChargeRate . "%</td>";
                $ccHtml .= "<td>" . $lineAmount . "</td></tr>";
            }
        }
        $ccHtml .= "<tr><td>代理线佣金</td>";
        $ccHtml .= "<td>" . $TotalCommision . "</td>";
        $ccHtml .= "<td>下线佣金合计</td>";
        $ccHtml .= "<td>" . $totalLineCommision . "</td>";
        $ccHtml .= "<td>实际结算佣金</td>";
        $ccHtml .= "<td>" . ($TotalCommision - $totalLineCommision) . "</td>";
        return $ccHtml;
    }

    /**
     * 构建佣金报表页面
     *
     * @param [type] $data 数据
     * 
     * @return void
     */
    static function makeGameCommissionHtml($data)
    {
        $crHtml = "";
        $gameStr = getArrayValue("gameStr", "", $data);
        $TotalWinLose = 0;
        $TotalCommision = 0;
        $TotalWater = 0;
        $TotalStake = 0;
        $lineChargeRate = sprintf("%.2f", getArrayValue("lineChargeRate", 0, $data) *100);
        
        if (!empty($gameStr)) {
            $gameData = json_decode($gameStr, true);

            foreach ($gameData as $gpName=>$gpData) {
                $winlose = getArrayValue("winLoseAmount", 0, $gpData);
                $commision = getArrayValue("pumpingCommisionAmount", 0, $gpData);
                $water = getArrayValue("pumpingWaterAmount", 0, $gpData);
                $stake = getArrayValue("validStakeAmount", 0, $gpData);
                $TotalWinLose += $winlose;
                $TotalCommision += $commision;
                $TotalWater += $water;
                $TotalStake += $stake;

                $PCR = sprintf("%.2f", getArrayValue("pumpingCommisionRate", 0, $gpData) * 100);
                $PWR = sprintf("%.2f", getArrayValue("pumpingWaterRate", 0, $gpData) * 100);
                $crHtml .= "<tr><td>". $gpName . "</td>";
                $crHtml .= "<td>". $winlose . "</td>";
                $crHtml .= "<td>". $PCR . "%</td>";
                $crHtml .= "<td>". $commision . "</td>";
                $crHtml .= "<td>". $stake . "</td>";
                $crHtml .= "<td>". $PWR . "%</td>";
                $crHtml .= "<td>". $water . "</td></tr>";
            }
        }
        $crHtml .= "<tr><td>小计</td>";
        $crHtml .= "<td>". $TotalWinLose ."</td><td></td>";
        $crHtml .= "<td>". $TotalCommision ."</td>";
        $crHtml .= "<td>". $TotalStake ."</td><td></td>";
        $crHtml .= "<td>". $TotalWater ."</td></tr>";

        $lineCommision = (1 - $lineChargeRate / 100) * $TotalCommision;
        $crHtml .= "<tr><td>平台合计</td>";
        $crHtml .= "<td>". $TotalCommision ."</td>";
        $crHtml .= "<td>线路费</td>";
        $crHtml .= "<td>". $lineChargeRate ."%</td>";
        $crHtml .= "<td>代理线佣金</td>";
        $crHtml .= "<td colspan='2'>". $lineCommision ."</td></tr>";
        return array($crHtml, $lineCommision);
    }
    
    /**
     * 构建投注历史数据界面
     *
     * @param [type] $ret
     * @return void
     */
    function showwdHistoryRepHtml($ret)
    {
        $html = "";
        $data = getArrayValue("data", array(), $ret);
        for ($x=0;$x<count($data);$x++) {
            $_data = $data[$x];
            $time = getArrayValue("recordTime", "", $_data);
            $dno = getArrayValue("dno", "", $_data);
            $amount = getArrayValue("amount", 0, $_data);
            $wdfee = getArrayValue("wdfee", 0, $_data);
            $amountResult = getArrayValue("amountResult", 0, $_data);
            $checkStatus = (string)getArrayValue("checkStatus", "1", $_data);
            $note = getArrayValue("note", "无", $_data);
            if ($checkStatus == "1") {
                $status = "<td>待审核</td>";
            } else if ($checkStatus == "2") {
                $status = "<td class=\"green\">已通过</td>";
            } else {
                $status = "<td class=\"red\">已拒绝</td>";
            }

            $_html = "<tr><td>". parseDate($time, 2) . "</td>";
            $_html .= "<td>" .$dno . "</td>";
            $_html .= "<td>" . $amount . "</td>";
            $_html .= "<td>" . $wdfee . "</td>";
            $_html .= "<td>" . $amountResult . "</td>";
            $_html .= $status;
            $_html .= "<td>" . $note . "</td></tr>";
            $html .= $_html;
        }
        return $html;
    }


    

    /**
     * 构建每日报表数据界面
     *
     * @param [type] $ret
     * @return void
     */
    function showDailyRepHtml($ret)
    {
        $html = "";
        $data = getArrayValue("summary", array(), $ret);
        
        for ($x=0;$x<count($data);$x++) {
            $_data = $data[$x];
            $tddate = getArrayValue("date", "", $_data);
            $tddata = getArrayValue("data", array(), $_data);
            
            $tBet = 0;
            $tWin = 0;
            $_tds = "";
            foreach ($tddata as $_td) {
                $tBet += $_td["bet"];
                $tWin += $_td["winloss"];
                $_tds .= "<td>". $_td["bet"]. "/". $_td["winloss"] . "</td>"; 
            }
            $_html = "<tr><td>". $tddate. "</td>";
            $_html .= "<td>". $tBet. "/". $tWin . "</td>";
            $_html .= $_tds . "</tr>";
            
            $html .= $_html;
        }
        return $html;
    }
    function parseTimeTag($onlineTime)
    {
        if ( $onlineTime < 60) {
            $onlineTag = "1分钟内";
        } elseif ( $onlineTime < 60 * 60 ) {
            $onlineTag = $onlineTime / 60 ."分钟内";
        } elseif ( $onlineTime < 60 * 60 * 24) {
            $onlineTag = floor($onlineTime / 3600) ."小时";
            $modTag = floor(($onlineTime % 3600) / 60);
            if ($modTag != 0) {
                $onlineTag .= $modTag . "分钟";
            }
        } elseif ( $onlineTime < 60 * 60 * 24 * 7 ) {
            $onlineTag = floor($onlineTime / (3600 * 24)) ."天";
            $modTag = floor(($onlineTime % (3600 * 24)) / 3600);
            if ($modTag != 0) {
                $onlineTag .= $modTag . "小时";
            }
        } elseif ( $onlineTime < 60 * 60 * 24 * 30 ) {
            $onlineTag = floor($onlineTime / (3600 * 24 * 7)) ."周";
            $modTag = floor(($onlineTime % (3600 * 24)) / (3600 * 24));
            if ($modTag != 0) {
                $onlineTag .= $modTag . "天";
            }
        } elseif ( $onlineTime < 60 * 60 * 24 * 30 * 12 ) {
            $onlineTag = floor($onlineTime / (3600 * 24 * 30) ) ."月";
            $modTag = floor(($onlineTime % (3600 * 24 * 30)) / (3600 * 24));
            if ($modTag != 0) {
                $onlineTag .= $modTag . "天";
            }
        }
        return $onlineTag;
    }  
    static function agentReports()
    {
        $LoginStatus = checkAgentLoginStatus();
        if(!$LoginStatus[0]){
            AgentLoginReset();
            return false;
        }
        $retJson = agentServerCaller("GetChildAgents", array($LoginStatus[3]));
        $retData = getArrayValue("data", array(), $retJson);
        $retData = getArrayValue(0, array(), $retData);
        unset($retJson["data"]);

        $page = array(
            makeAgentHeader("index/main_header_metas","promotions/promotions_header_scripts"),
            makeAgentNav(),
            setOnShowAgentPageName(initAgentInfoPage(), "agentReports"),
            self::showAgentReportsHtml($retData),
            readHtml("common/commonfooter")
        );
        output(join("", $page));
    }

    static function showAgentReportsHtml($ret)
    {
        $page = readHtml("agents/reports/agentReports");
        $_SESSION["agentInfos"];
        $agentInfos = getSessionValue("agentInfos", array());
        $agentLv = (int)getArrayValue("Level", 1, $agentInfos);

        if ($agentLv < 3) {
            $addAgentBtn = '<button onclick="addNewAgent()" style="float:right;" class="addAgentbtn addAgentbtnbg"><span>新增代理</span></button>';
        } else {
            $addAgentBtn = "";
        }

        
        // $data = getArrayValue("data", array(), $ret);
        $html = "";
        for ($x=0;$x<count($ret);$x++) {
            $_data = $ret[$x];
            $account = getArrayValue("account", "", $_data);
            $name = getArrayValue("name", "", $_data);
            $joinTime = getArrayValue("joinTime", 0, $_data);
            $layerName = getArrayValue("layerName", "", $_data);
            $roleId = getArrayValue("roleId", "", $_data);
            $memberCount = getArrayValue("memberCount", "无数据", $_data);
            $idx = $x + 1;
            $status = (string)getArrayValue("status", "2", $_data);
            if ($status == "2") {
                $stag = "<td class='green'>正常</td>";
            } else if ($status == "1") {
                $stag = "<td class='green'>待审核</td>";
            } else if ($status == "3") {
                $stag = "<td class='red'>锁定中</td>";
            } else {
                $stag = "<td class='red'>审核失败</td>";
            }
            $_html = "<tr><td>".$idx."</td>";
            $_html .= "<td>". $account. "</td>";
            $_html .= "<td>". $name . "</td>";
            $_html .= "<td>". parseDate($joinTime, 2). "</td>";
            $_html .= "<td>". $layerName. "</td>";
            $_html .= "<td>". $roleId. "</td>";
            $_html .= "<td>". $memberCount . "</td>";
            $_html .= $stag. "</tr>";
            $html .= $_html;
        }
        $page = str_replace("%agentReportsData%", $html, $page);
        $page = str_replace("%agentReportBtn%", $addAgentBtn, $page);
        
        return $page;
    }

    static function benifitReports()
    {
        $LoginStatus = checkAgentLoginStatus();
        if(!$LoginStatus[0]){
            AgentLoginReset();
            return false;
        }
        $retJson = agentServerCaller("GetSettleStatement", array($LoginStatus[3]));
        $retData = getArrayValue("data", array(), $retJson);
        $retData = getArrayValue(0, array(), $retData);
        unset($retJson["data"]);

        $page = array(
            makeAgentHeader("index/main_header_metas","promotions/promotions_header_scripts"),
            makeAgentNav(),
            setOnShowAgentPageName(initAgentInfoPage(), "benifitReports"),
            self::showBenifitHtml($retJson),
            readHtml("common/commonfooter")
        );
        output(join("", $page));
        
    }

    static function showBenifitHtml($ret)
    {
        $page = readHtml("agents/reports/benifitReports");
        
        $data = getArrayValue("data", array(), $ret);
        
        $html = "";
        for ($x=0;$x<count($data);$x++) {
            $_data = $data[$x];
            $_html = "<tr><td>". $_data["date"]."</td>";
            $_html .= "<td>". $_data["validMember"]. "</td>";
            $_html .= "<td><a href='javascript:void(0);' class='agentDetailBtn' onclick='detail(\"201710\",\"1\")'><i class='fa fa-building-o'></i>". $_data["gpCommission"]." </a></td>";
            $_html .= "<td><a href='javascript:void(0);' class='agentDetailBtn'  onclick='detail2(\"201710\",\"1\")'><i class='fa fa-building-o'></i>". $_data["gpCost"]." </a></td>";
            $_html .= "<td>". $_data["lastMonth"]. "</td>";
            $_html .= "<td>". $_data["manualAdjust"]. "</td>";
            $_html .= "<td>". $_data["commission"]. "</td>";
            $_html .= "<td>". $_data["nextMonth"]. "</td>";
            $_html .= "<td>". $_data["realAmount"]. "</td>";
            $_html .= "<td>". $_data["status"]. "</td></tr>";
            $html .= $_html;
        }
        $page = str_replace("%BenifitReportData%", $html, $page);
        return $page;
    }



    static function settleDetail2($request)
    {
        $data = getSessionValue("GameCommision", array());
        $month = getArrayValue("month", "", $request);
        $commisionHtml = getArrayValue($month, array(), $data);
        $caHtmlData = getArrayValue("ca", array(), $commisionHtml);
        
        $caHtaml1 = getArrayValue(0, "", $caHtmlData);
        $caHtaml2 = getArrayValue(1, "", $caHtmlData);

        $Html = readHtml("agents/reports/settleReport1");
        $Html = str_replace("{{AgentAllocationData}}", $caHtaml1, $Html);
        $Html = str_replace("{{ChildAllocationData}}", $caHtaml2, $Html);

        return output($Html);


    }

    static function agentWithdrawl()
    {
        $LoginStatus = checkAgentLoginStatus();
        if(!$LoginStatus[0]){
            AgentLoginReset();
            return false;
        }
        $page = array(
            makeAgentHeader("index/main_header_metas","promotions/promotions_header_scripts"),
            makeAgentNav(),
            setOnShowAgentPageName(initAgentInfoPage(), "agentWithdrawl"),
        );

        $checkResult = self::shouWarnInfo(false, false, true);
        if (!$checkResult[0]){
            array_push($page, $checkResult[1]);
        }else{
            $records = getAgentBankInfo($LoginStatus);
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

    static function makeBankInfoPage($bankinfos){
        $page = readHtml("agents/funds/agentWithdrawl");
        $allCards = "";
        for($x=0;$x<count($bankinfos);$x++){
            $_html = '';
            $_card = $bankinfos[$x];

            if ($x === 0){
                $_html = '<label class="on"  style="border: 1px solid #c8cccf; width: 300px" for="bankradiogroup'.$x.'">
                            <input type="radio" id="bankradiogroup'.$x.'" name="bankradio" value="%VALUE%"/>
                            <b>%BANK% %CARD%</b></label>';
            }else{
                $_html = '<label style="border: 1px solid #c8cccf; width: 300px" for="bankradiogroup'.$x.'">
                <input type="radio" id="bankradiogroup'.$x.'"  name="bankradio" value="%VALUE%"/><b>
                    %BANK% %CARD%</b></label>';
            }
            // $_html = str_replace("%CARDID%", $_card["id"], $_html);
            $_html = str_replace("%BANKSN%", $_card["banksn"], $_html);
            $_html = str_replace("%VALUE%", $_card["value"], $_html);
            $_html = str_replace("%BANK%", $_card["name"], $_html);
            $_html = str_replace("%CARD%", "&nbsp; ****&nbsp; ****&nbsp; ****&nbsp; ".substr($_card["card"], -4), $_html);
            // $_html = .$_html."</i>";
            $allCards = $allCards.$_html;
        }
        return str_replace("%ALLCARDSINFO%", $allCards, $page);
    }


    static function bankManager()
    {
        $page = array(
            makeAgentHeader("index/main_header_metas","promotions/promotions_header_scripts"),
            makeAgentNav(),
            setOnShowAgentPageName(initAgentInfoPage(), "bankManager"),
            
        );
        $LoginStatus = checkAgentLoginStatus();
        if(!$LoginStatus[0]){
            AgentLoginReset();
            return false;
        }
        
        $checkResult = self::shouWarnInfo(true , true, false);
        if (!$checkResult[0] && $checkResult[2] != "BankManager"){
            array_push($page, $checkResult[1]);
        }else{
            $records = getAgentBankInfo($LoginStatus);
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

    /**
     * 构建前台的银行卡界面数据
     *
     * @param [type] $bankinfos 银行卡数据
     * 
     * @return void
     */
    static function makeCardsInfoPage($bankinfos)
    {
        
        $page = readHtml("agents/funds/bankManager");
        $allCards = "";
        for ($x=0;$x<count($bankinfos);$x++) {
            $_html = '<li><i class="%BANKSN%"></i>%BANKNAME% (尾号%BANKCARD%)<a onclick="delbank(this, %CARDVALUE%)">删除</a></li>';
            $_card = $bankinfos[$x];
            $_html = str_replace("%BANKSN%", $_card["banksn"], $_html);
            $_html = str_replace("%BANKNAME%", $_card["name"], $_html);
            $_html = str_replace("%BANKCARD%", substr($_card["card"], -4), $_html);
            $_html = str_replace("%CARDVALUE%", $_card["value"], $_html);
            $allCards = $allCards.$_html;
        }
        $page = str_replace("%RealName%", urldecode($_SESSION["agentInfos"]["RealName"]), $page);
        $page = str_replace("%BANKCARDLIST%", $allCards, $page);

        return str_replace("%BANKCARDLIST%", $allCards, $page);
    }
    

    static function shouWarnInfo($checkName = false, $checkPhone = false, $checkCard = false){
        $agentInfos = getSessionValue("agentInfos", array());
        // print_r($MemberInfo);
        $flag = true;
        $tag = "";
        $showMsg = "为了阁下的资金安全，绑定银行卡前，我们需要验证阁下的个人信息。";
        if (count($agentInfos) == 0){
            $flag = false;
        }else{
            if ($checkName && empty(getArrayValue("RealName", "", $agentInfos))){
                $flag = false;
                $tag = "agentAccount";
                $showAction = "个人信息";
                $showMsg = "为了阁下的资金安全，绑定银行卡前，我们需要验证阁下的个人信息。";
            }elseif($checkPhone && empty(getArrayValue("Phone", "", $agentInfos))){
                $flag = false;
                $tag = "agentAccount?setting=phone";
                $showMsg = "为了阁下的资金安全，绑定银行卡前，我们需要验证阁下的手机号码。";
                $showAction = "绑定手机";
            }elseif($checkCard && empty(getArrayValue("isBindCard", "", $agentInfos))){
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

    static function agentInfo()
    {
        $page = array(
            makeAgentHeader("index/main_header_metas","promotions/promotions_header_scripts"),
            makeAgentNav(),
            setOnShowAgentPageName(initAgentInfoPage(), "agentInfo")
        );

        
        // $retJson = array("code"=>200, "agentInfo"=>array("agentCode"=>1002, "domain"=>array(
        //     array("type"=>1, "site"=>"http://baidu.com"),array("type"=>2, "site"=>"http://baidu1.com"),array("type"=>1, "site"=>"http://baidu.com"),
        // )));
        $domainHtml = readHtml("agents/agentInfo/agentInfo");
        $html = "";
        // foreach ($retJson["agentInfo"]["domain"] as $_domain) {
        //     if ($_domain["type"] == 1){
        //         $ttag = "合营域名";
        //     } else {
        //         $ttag = "独立域名";
        //     }
        //     $_html = "<tr><td>". $ttag . "</td>";
        //     $_html .= "<td style='float:left;text-align:center'>". $_domain["site"] . "</td></tr>";
        //     $html .= $_html;
        // }
        $domainHtml = str_replace("%AgentCode%", "" , $domainHtml);
        $domainHtml = str_replace("%AgentDomain%", $html, $domainHtml);
        array_push($page, $domainHtml);
        array_push($page, readHtml("common/commonfooter"));
        return output(join("", $page));
    }

    static function receivebox($request)
    {
        $page = array(
            makeAgentHeader("index/main_header_metas","promotions/promotions_header_scripts"),
            makeAgentNav(),
            setOnShowAgentPageName(initAgentInfoPage(), "receivebox"),
        );
        $pageIndex = getArrayValue("pageIndex", "1", $request);
        $LoginStatus = checkAgentLoginStatus();
        if(!$LoginStatus[0]){
            AgentLoginReset();
            return false;
        }
        $retJson = agentServerCaller("GetMessages", array($LoginStatus[3]));// TODO:该请求后台未做好
        
        if($retJson["code"] == 200){
            array_push($page, self::makeReceiveBoxMailPage($retJson["data"], $pageIndex) );
        }else{
            array_push($page, self::makeReceiveBoxMailPage(array(), $pageIndex));
        }
        array_push($page, readHtml("common/commonfooter"));
        output(join("", $page));
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
                
            $_html = readHtml("agents/agentInfo/agentinfo_singlemail");
            $_html = str_replace("%mailid%", getArrayValue("recordNum", "", $_mail), $_html);
            $_html = str_replace("%mailtime%", parseDate((int)getArrayValue("time", "", $_mail)), $_html);
            $_html = str_replace("%mailstatus%", $mailStatus, $_html);
            $_html = str_replace("%mailmessage%", getArrayValue("title", "", $_mail), $_html);
            
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

    function MsDetail($request){
        /**
         * 消息详情界面
         */
        $LoginStatus = checkAgentLoginStatus();
        if(!$LoginStatus[0]){
            AgentLoginReset();
            return false;
        }
        $mailId = getArrayValue("messageid", 1, $request);
        $mailType = getArrayValue("type", 1, $request);
        $retJson = agentServerCaller("ReadMessage", array($LoginStatus[3], (int)$mailId));
        
        if (getArrayValue("code", "", $retJson) == 200){
            $mail = getArrayValue(0, array(), $retJson["data"]);
            $mailHtml = readHtml("member/accountsetting/accountsetting_openmail");
            $replaceStr = array(
                "MailType"=>$mailType,
                "MailId"=>$mailId,
                "MailTitle"=>getArrayValue("title", "", $mail),
                "MailTime"=>parseDate((int)getArrayValue("time", "", $mail)),
                "MailContent"=>getArrayValue("content", "", $mail)
            );
            foreach($replaceStr as $_key => $_val){
                $mailHtml = str_replace("%".$_key."%", $_val, $mailHtml);
            }
            return output($mailHtml);
        }else{
            return false;
        }
    }

    
    function showAgentInfoHtml($domainData) {
        $html = "";
        $roleId = "";
        foreach ($domainData as $_domain) {
            $_html = "<tr><td>合营域名</td>";
            $_html .= "<td style=\"float:left;text-align:center\">" . getArrayValue("domain", "", $_domain) . "</td></tr>";
            $html .= $_html;
            $roleId = getArrayValue("roleId", 0, $_domain);
        }
        return array($html, $roleId);

    }
    /**
     * 构建投注历史数据界面
     *
     * @param [type] $ret
     * @return void
     */
    function showBetHistoryHtml($ret)
    {
        $html = "";
        $data = getArrayValue("data", array(), $ret);
        
        for ($x=0;$x<count($data);$x++) {
            $_data = $data[$x];
            $account = getArrayValue("account", "", $_data);
            $dno = getArrayValue("betId", "", $_data);
            $time = getArrayValue("recordTime", "", $_data);
            $platform = getArrayValue("platform", "", $_data);
            if ($platform == "IBC") {
                $content = self::makeIBCDataArray($_data);
            } elseif ($platform == "NB") {
                $content = self::makeNBDataArray($_data);
            }
            // $content = $_tmpData[0];
            $amount = getArrayValue("stakeAmount", "", $_data);
            $winlose = getArrayValue("winLoseAmount", "", $_data);
            if ($winlose > 0) {
                $status = "<td class='green'>赢</td>";
                $winloseStr = "<td class='green'>". $winlose ."</td>";
            } else {
                $status = "<td class='red'>输</td>";
                $winloseStr = "<td class='red'>". $winlose ."</td>";
            }
             
            
            $_html = "<tr><td>". $account . "</td>";
            $_html .= "<td>" . $dno . "</td>";
            $_html .= "<td>" . parseDate($time, 4) . "</td>";
            $_html .= "<td>" . $content . "</td>";
            $_html .= $status;
            $_html .= "<td>" . $amount . "</td>";
            $_html .= $winloseStr. "</tr>";
            
            $html .= $_html;
        }
        return $html;
    }

    /**
     * 构建NB平台数据
     *
     * @param [type] $data 数据
     * 
     * @return void
     */
    static function makeNBDataArray($data)
    {
        $transId = getArrayValue("transId", "", $data);
        $recordNum = getArrayValue("recordNum", "", $data);
        
        $account = getArrayValue("account", "", $data);
        $platform = getArrayValue("platform", "", $data);
        
        $game = getArrayValue("game", "", $data);
        $content = getArrayValue("content", "", $data);
        $contentStr = explode("|", $content);

        if (count($contentStr) == 0) {
            return "";
        }

        $gameType = getArrayValue(0, "", $contentStr);
        $dno = getArrayValue(1, "", $contentStr);
        // $account = getArrayValue(2, "", $contentStr);
        $matchNo = getArrayValue(3, "", $contentStr);
        $matchType = getArrayValue(4, "", $contentStr);
        $Odds = getArrayValue(5, "", $contentStr);
        $betAmount = (float)getArrayValue(6, 0, $contentStr);
        $companyWinLoss = (float)getArrayValue(7, 0, $contentStr);
        $betTime = getArrayValue(8, "", $contentStr);
        $betResult = getArrayValue(9, "", $contentStr);
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
            $operStr = array("red", "99", $dno, $recordNum, "", "设为无效");
        } else {
            $validSTR = "无效";
            $operStr = array("green", "66", $dno, $recordNum, "", "设为有效");
        }
        $showInfoline1 = getArrayValue($gameType, "", $GLOBALS["NBbetTypeName"]) . " 第" . $matchNo."期";
        $showInfoline2 = $matchType."@".$Odds;
        $betInfos = array($showInfoline1,$showInfoline2);
        $contentStr = join("<br>", $betInfos);
        
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
        
        // return array($contentStr, $betAmount, $companyWinLoss);
        return $contentStr;
    }

    /**
     * 构建IBC平台的订单数据
     *
     * @param [type] $data 数据
     * 
     * @return void
     */
    static function makeIBCDataArray($data)
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
}


?>