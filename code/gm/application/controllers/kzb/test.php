<?php

include_once "./application/utilities/utilities.php";
include_once "./application/views/GmViewHelper.php";
include_once "./application/models/datamodels.php";
include_once "./application/models/dataHelper.php";

class Test{

    function testGetLoginRecord(){
        $retJson = Base_GetPlayerLoginRecord("alien");
        print_r($retJson);
    }

    function testSetBankinfo(){
        $_bank = array_rand($GLOBALS["BankTypes"]);
        $_acc = "alien";
        $_index = 1;
        $_name = "科";
        $_cardNo = "6266 8209 8728 3293";
        $_regBank = "河南省周口市农业银行支行";
        $_status = 1;
        // print_r(array($_acc, $_index, $_bank, $_name, $_cardNo, $_regBank, $_status));
        // $ret = Base_SetPlayerBankCardInfo($_acc, $_index, $_bank, $_name, $_cardNo, $_regBank, $_status);
        // print_r($ret);

        echo "<br/>----------------------------<br/>";
        $ret = Base_GetPlayerBankCardInfo($_acc);
        echo json_encode($ret);

    }
    function TestOnlineAjax(){
        $searchType = "account";
        $searchKey = "";
        $startIndex = 1;
        $count = 3;
        $sEcho = 1;
        $retJson = Base_SearchOnlinePlayer($searchType, $searchKey, $startIndex, $count);
        if (!empty($retJson)){
            $totalOnlineCount = $retJson[0]["size"];
            $showOnlineRoles = $retJson[0]["data"];
            $showOnlineCount = count($showOnlineRoles);
            $aaData = showOnlineRoles($showOnlineRoles);
            $ret = array(
                "sEcho"=>$sEcho,
                "iTotalRecords"=>$totalOnlineCount,
                "iTotalDisplayRecords"=>count($showOnlineRoles),
                "aaData"=>$aaData,
            );
            output($ret, "json");
        }
    }
    
    function TestRoleDetail($playerID){
        $RequestMemberName = getArrayValue("id", "", $playerID);
        $errorRet = $GLOBALS["errorRet"];
        if(empty($RequestMemberName)){
            return $errorRet;
        }
        echo $RequestMemberName;
        $retJson = Base_GetPlayerBaseInfo($RequestMemberName);
        print_r(json_encode($retJson[0]));

    }
        
    function test1(){
        $ret = Base_GetPlayerLoginRecord("alien");
        print_r($ret);
    }
    
    function TestActiveTable(){
        date_default_timezone_set('PRC');
        $RequestPlayer = "kodo1222";
        $RequestStart = date('Y-m-d H:i:s',  time() - 30 * 24 * 60 * 60);
        $RequestEnd = date('Y-m-d H:i:s', time());
        $retJson = Base_GetPlayerStatisticsInfo($RequestPlayer, $RequestStart, $RequestEnd);
        print_r($retJson);
    }


    function getRemoteHost(){
        $configFile = "./config.ini";
        $content = file_get_contents($configFile);
        $config_args = explode("=", $content);
        $remoteServer = "暂无配置";
        if (count($config_args) == 2){
            $remoteServer = $config_args[1];
            }
        
        echo $remoteServer;
    }


    function getRemoteHostRet(){
        $configFile = "./config.ini";
        $content = file_get_contents($configFile);
        $config_args = explode("=", $content);
        $remoteServer = "暂无配置";
        if (count($config_args) == 2){
            $remoteServer = $config_args[1];
            }
        echo $remoteServer;
    }
    
    function ModifyRemoteHost(){
        echo file_get_contents("./config.html");
    }
    
    function setRemoteHost(){
        if(!isset($_POST["Host"])){
            echo "{'code':0, 'msg':'no post argus.'}";
        }else{
            $data = 'RemoteServer='.$_POST["Host"];
            file_put_contents("./config.ini",$data);
            header("location:/kzb/test/ModifyRemoteHost");
        }
        
    }
}

?>