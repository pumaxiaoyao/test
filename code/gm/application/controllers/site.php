<?php  
session_start();

include "./application/utilities/utilities.php";
include "./application/thirdparties/ipsearch/ipsearch.php";

$_SESSION["Title"] = "Alien - 首页";

class Site  
{  
    function getTaskList()
    {  
        $ret = array(
            "rega"=>array(),
            "wtda"=>array(),
            "wtdu"=>array(),
            "dptu"=>array(),
            "dptf"=>array(),
            "actv"=>array()
        );
        echo json_encode($ret);
    }
    
    function index(){
        echo makePage("", "index", "");  
    }

    function getIpInfo($args){
        $iphost = explode('=', $args);
        if ($iphost[0] == 'ip'){
            $ipsearcher = new Helper_IpLocation();
            $location = $ipsearcher->getlocation($iphost[1]);
            // echo $location["country"].$location["area"];
            $ret = array(
                "code"=>"0",
                "data"=>array(
                    "country"=>$location["country"],
                    "region"=>"",
                    "city"=>$location["area"]
                )
            );
            echo json_encode($ret);
        }
        
    }

    function logout(){
        if (isset($_SESSION["Account"])){
            session_unset();
            session_destroy();
            setcookie(session_name(), "", time() - 3600);
        }
        header("location:/");
    }
}  
  
  
?>  