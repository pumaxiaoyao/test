<?php

trait memberCenter_Interfaces{
    
    function sendbox(){
        initAccountSettingPage("receivebox");
        $sendMails = array(
            array(
                "mailid"=>29248,
                "recvtime"=>"2017/9/22 17:53:05",
                "message"=>"这是一条测试信息，你看到了就对了",
                "status"=>"已读",
            ),
            array(
                "mailid"=>29249,
                "recvtime"=>"2017/9/22 17:53:05",
                "message"=>"这是一条测试信息，你看到了就对了",
                "status"=>"未读",
            ),
        );
        echo makeSendBoxMailPage($sendMails);
    }

    function receivebox(){
        initAccountSettingPage("receivebox");
        $receivemails = array(
            array(
                "mailid"=>29248,
                "recvtime"=>"2017/9/22 17:53:05",
                "message"=>"这是一条测试信息，你看到了就对了",
                "status"=>"已读",
            ),
            array(
                "mailid"=>29249,
                "recvtime"=>"2017/9/22 17:53:05",
                "message"=>"这是一条测试信息，你看到了就对了",
                "status"=>"未读",
            ),
        );
        echo makeReceiveBoxMailPage($receivemails);
        
    }

    function writeMessage(){
        initAccountSettingPage("receivebox");
        echo makewriteMessagePage();
        
    }

    function MessageDetail(){
    }

    function AccountSetting(){
        
        initAccountSettingPage("basicinfo");

        $page = readHtml("member/accountsetting/accountsetting");
        $page = str_replace("%BasicInfoHtml%", makeAccsBasicInfoPage(), $page);
        $page = str_replace("%SettingMailHtml%", makeAccsMailPage(), $page);
        $page = str_replace("%SettingPhoneHtml%", makeAccsPhonePage(), $page);
        
        echo $page;
    }

    function BettingRecords(){
        initAccountSettingPage("bettingrecords");
        $bettingRecords = array(
            array(
                "name"=>"LB快乐彩",
                "counts"=>"15",
                "amount"=>"15000",
                "result"=>"-500",
            ),
            array(
                "name"=>"体育",
                "counts"=>"5",
                "amount"=>"6000",
                "result"=>"100",
            ),
            array(
                "name"=>"金碧娱乐城",
                "counts"=>"5",
                "amount"=>"3000",
                "result"=>"500",
            ),
            array(
                "name"=>"AG娱乐城",
                "counts"=>"96",
                "amount"=>"600000",
                "result"=>"10100",
            ),
            array(
                "name"=>"PT老虎机",
                "counts"=>"6",
                "amount"=>"1000",
                "result"=>"-100",
            ),
        );
        $queryArgus = $_SERVER["QUERY_STRING"];
        if (!empty($queryArgus)){
            $splitargus = explode("&", $queryArgus);
            if (count($splitargus) == 2){
                $stime = explode("=", $splitargus[0])[1];
                $pid = explode("=", $splitargus[1])[1];
                $stimeHtml = !empty($stime)?$stime:'today';
                $pidHtml = !empty($pid)?$pid:'0';
                echo '<script>var historyTime = "'.$stimeHtml.'";var historyid = "'.$pidHtml.'";</script>';
            }
        }
        echo makebettingRecordsPage($bettingRecords);
        print_r($_SERVER["QUERY_STRING"]);
    }
        
}
?>