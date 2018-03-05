<?php
class Test{
    
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