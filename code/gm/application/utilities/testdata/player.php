<?php
session_start();

class Player{
    
    const TOTAL_PLAYER_COUNT = 100;//总的测试数据人数
    const SAMPLE_PLAYER_JSON = '{"id":1, "uid":201710180001,"account":"alien123", "password":"alien456", "nickname":"外星人","lastLoginIP":"60.177.54.44","lastLoginTime":"2017-10-17 12:00:00","lastActiveTime":"2017-10-17 14:07:00","onLineTime":"0","currentLoginIP":"60.177.54.44","currentLoginTime":"2017-10-17 22:00:00", "agent":"joker123","loginDomain":"alien123.com","agentLevel":"1","currency":"100","status":"正常", "gameplatformID":12306, "playerlevel":"初级会员","qq":"12345","birthday":"1991-06-12 18:07:13","phone":"13800138000","email":"12345@hotmail.com","registerTime":"2017-02-17 14:07:00","registerIP":"60.177.54.44"}';

    function __construct(){
        if (!isset($_SESSION["ALLPLAYERS"])){//session存储数据未起作用，bug待查
            self::makePlayers();
        }
    }

    function makePlayers(){
        $samplePlayer = json_decode(self::SAMPLE_PLAYER_JSON, true);
        
        $alldatas = array();//临时数据，这里是模拟，不做数据持久化
        //$count = (int)self::TOTAL_PLAYER_COUNT;
        for ($x=0;$x<self::TOTAL_PLAYER_COUNT;$x++){
            $samplePlayer["id"] = $x+1;
            $samplePlayer["uid"] = "2017101800".(string)$x;
            $samplePlayer["account"] = "alien".(string)$samplePlayer["id"];
            $samplePlayer["password"] = "alien".(string)$samplePlayer["id"];
            $samplePlayer["nickname"] = "大吉大利吃鸡-".(string)$samplePlayer["id"];
            $samplePlayer["agent"] = "agent-".(string)rand(1,20);
            $samplePlayer["currentLoginIP"] = "60.177.54.".(string)rand(20,60);
            $samplePlayer["lastLoginIP"] = "60.177.54.".(string)rand(20,60);
            $samplePlayer["registerIP"] = "60.177.54.".(string)rand(20,60);
            $alldatas[$x] = $samplePlayer;
        }
        $_SESSION["ALLPLAYERS"] = $alldatas;
    }


    function getonlineIDs(){
        $onlineCount = rand(1, 90);
        $onlineDatas = array();

        if (!isset($_SESSION["ALLPLAYERS"])){//session存储数据未起作用，bug待查
            self::makePlayers();
        }

        for ($x=0;$x<$onlineCount;$x++){
            do{
                $tmpid = rand(1, 100);
                $tmpplayer = $_SESSION["ALLPLAYERS"][$tmpid - 1];
            }while(array_key_exists($tmpid, $onlineDatas));
            $onlineDatas[$tmpplayer["id"]] = $tmpplayer;
        }

        echo json_encode($onlineDatas);
    }
    
    function kickdown(){
        $ret = array(
            "success"=>true,
            "response"=>array(),
            "msg"=>"已经踢了 - ".(string)$_POST["kickID"]
        );
        echo json_encode($ret);
    }
    
    function playerDetailBox(){
        if (isset($_POST["playerID"])){
            $playerID = $_POST["playerID"];
        }else{
            $playerID = "20171018001";
        }
        
        if (!isset($_SESSION["ALLPLAYERS"])){//session存储数据未起作用，bug待查
            self::makePlayers();
        }
        $playerdata = array();
        foreach($_SESSION["ALLPLAYERS"] as $idx=>$_player){
            if ($_player["uid"] == (string)$playerID){
                $playerdata = $_player;
            }
        }
        //print_r($playerdata);
        echo json_encode($playerdata);
    }

    function loginRecord(){
        $playerID = $_POST["playerID"];
        if (!isset($_SESSION["ALLPLAYERS"])){//session存储数据未起作用，bug待查
            self::makePlayers();
        }
        $records = array(
            array("id"=>1712,
                    "ip"=>"220.182.56.147",
                    "time"=>"2017-10-11 11:51:11",
                    "status"=>"login ok"),
            array("id"=>712,
                    "ip"=>"220.182.56.147",
                    "time"=>"2017-10-10 11:51:11",
                    "status"=>"login ok"),
            array("id"=>701,
                    "ip"=>"220.182.56.147",
                    "time"=>"2017-10-09 11:51:11",
                    "status"=>"login ok"),
            array("id"=>32,
                    "ip"=>"220.182.56.147",
                    "time"=>"2017-10-01 11:51:11",
                    "status"=>"login ok"),
        );
        echo json_encode($records);
    }

    function generate_code($length){
        return rand(pow(10,($length-1)), pow(10,$length)-1);
    }


    function transRecord(){
        $playerID = $_POST["playerID"];
        if (!isset($_SESSION["ALLPLAYERS"])){//session存储数据未起作用，bug待查
            self::makePlayers();
        }
        
        $recordsCounts = rand(5, 20);
        $records = array();
        for($x=1;$x<21;$x++){
            $recordType = rand(1,5);
            switch($recordType){
                case 1:
                    //存款
                    $orderType = "存款";
                    $orderID = self::generate_code(9);
                    $orderAmount = rand(1000, 99999999) / 100.0;
                    $descText = "存入平台账户";
                    $serviceStaff = "staff".(string)rand(1,100);
                    $orderTime = date("Y-m-d H:i:s", time());
                    $orderStatus = "成功";
                    break;
                case 2:
                    //取款
                    $orderType = "取款";
                    $orderID = self::generate_code(9);
                    $orderAmount = rand(1000, 99999999) / 100.0;
                    $descText = "取走款项";
                    $serviceStaff = "staff".(string)rand(1,100);
                    $orderTime = date("Y-m-d H:i:s", time());
                    $orderStatus = "成功";
                    break;
                case 3:
                    //红利
                    $orderType = "红利取款";
                    $orderID = self::generate_code(9);
                    $orderAmount = rand(1000, 99999999) / 100.0;
                    $descText = "分红红利";
                    $serviceStaff = "staff".(string)rand(1,100);
                    $orderTime = date("Y-m-d H:i:s", time());
                    $orderStatus = "成功";
                    break;
                case 4:
                    //返水
                    $orderType = "返水";
                    $orderID = self::generate_code(9);
                    $orderAmount = rand(1000, 99999999) / 100.0;
                    $descText = "返水";
                    $serviceStaff = "staff".(string)rand(1,100);
                    $orderTime = date("Y-m-d H:i:s", time());
                    $orderStatus = "成功";
                    break;
                case 5:
                    //转账
                    $orderType = "转账";
                    $orderID = self::generate_code(9);
                    $orderAmount = rand(1000, 99999999) / 100.0;
                    $descText = "转账";
                    $serviceStaff = "staff".(string)rand(1,100);
                    $orderTime = date("Y-m-d H:i:s", time());
                    $orderStatus = "成功";
                    break;
            }
            array_push($records, array($x, $orderType, $orderID, $orderAmount, $descText, $serviceStaff, $orderTime, $orderStatus));
        }
        
        echo json_encode($records);
    }

    function getSameIps(){
        $playerID = $_POST["playerID"];
        if (!isset($_SESSION["ALLPLAYERS"])){//session存储数据未起作用，bug待查
            self::makePlayers();
        }

        $playerdata = array();
        foreach($_SESSION["ALLPLAYERS"] as $idx=>$_player){
            if ($_player["uid"] === $playerID){
                $playerdata = $_player;
            }
        }
        $sameIPs = array();
        if (count($playerdata) > 0){
            $playerIPs = array($playerdata["registerIP"],$playerdata["lastLoginIP"],$playerdata["currentLoginIP"]);

            foreach($_SESSION["ALLPLAYERS"] as $idx=>$_player){
                if (in_array($_player["registerIP"], $playerIPs)){
                    array_push($sameIPs, array(
                        $_player["account"],
                        $_player["nickname"],
                        $_player["registerIP"],
                        $_player["registerTime"],
                    ));
                }
                if (in_array($_player["lastLoginIP"], $playerIPs)){
                    array_push($sameIPs, array(
                        $_player["account"],
                        $_player["nickname"],
                        $_player["lastLoginIP"],
                        $_player["lastLoginTime"],
                    ));
                }
                
                if (in_array($_player["currentLoginIP"], $playerIPs)){
                    array_push($sameIPs, array(
                        $_player["account"],
                        $_player["nickname"],
                        $_player["currentLoginIP"],
                        $_player["currentLoginTime"],
                    ));
                }
            }  
        }
        echo json_encode($sameIPs);
    }
    function getBankInfo(){
        $playerID = $_POST["playerID"];
        if (!isset($_SESSION["ALLPLAYERS"])){//session存储数据未起作用，bug待查
            self::makePlayers();
        }
        $bankinfo_count = rand(1, 5);
        $playerdata = array();
        foreach($_SESSION["ALLPLAYERS"] as $idx=>$_player){
            if ($_player["uid"] === $playerID){
                $playerdata = $_player;
            }
        }
        
        //print_r($playerdata) ;
        $bankinfo = array();
        if (count($playerdata) > 0){
            for($x=0;$x<$bankinfo_count;$x++)
            {
                $bankID = self::generate_code(5);
                $bankCode = "icbc";
                $bankName = "爱存不存";
                $cardNum = self::generate_code(11);
                $bankNode = "天地银行";
                $bankStatus = "有效";
                array_push($bankinfo, array(
                    $bankID, $bankCode, $bankName, $cardNum, $bankNode, $bankStatus
                ));
            }
        }
        echo json_encode($bankinfo);
    }

    function test1(){
        $ret = Base_GetPlayerLoginRecord("alien");
        print_r($ret);
    }
    function playerMessage(){
        $playerID = $_POST["playerID"];
        if (!isset($_SESSION["ALLPLAYERS"])){//session存储数据未起作用，bug待查
            self::makePlayers();
        }
        $msg_count = rand(0,10);
        $msginfo = array();
        for($x=0;$x<$msg_count;$x++){
            $_msg = array(
                "id"=>self::generate_code(5),
                "mtype"=>"0",
                "lvl"=>"1",
                "playerid"=>$playerID,
                "title"=>"测试标题".(string)$x,
                "content"=>"测试内容".(string)$x,
                "readed"=>"0",
                "readtime"=>"0",
                "created"=>date("Y-m-d H:i:s", time()),
                "updated"=>time(),
                "sno"=>"1001",
                "sname"=>"li001"
            );
            array_push($msginfo, $_msg);
        }
        echo json_encode($msginfo);
    }

    function playerActiveTable(){
        $playerID = $_POST["uid"];
        if (!isset($_SESSION["ALLPLAYERS"])){//session存储数据未起作用，bug待查
            self::makePlayers();
        }
        $playerdata = array();
        foreach($_SESSION["ALLPLAYERS"] as $idx=>$_player){
            if ($_player["uid"] === $playerID){
                $playerdata = $_player;
            }
        }
        $activeTable = array(
            "fanshui"=>0.00,
            "hongli"=>0.00,
            "cunkuanyouhui"=>0.00,
            "touzhu"=>0.00,
            "paicai"=>0.00,
            "gongsishuying"=>0.00,
            "youxiaotouzhu"=>0.00,
            "gongsitouzhu"=>0.00,
            "cunkuancishu"=>0.00,
            "cunkuanjine"=>0.00,
            "zuijincunkuan"=>0.00,
            "qukuancishu"=>0.00,
            "qukuanjine"=>0.00,
            "zuijinqukuan"=>0.00
        );
        echo json_encode($activeTable);
        }
    
}



?>