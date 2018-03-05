<?php  

registerDataHelper(array("protoHelper","dataHelper"));
registerViewHelper(array("GmViewHelper", "player/PlayerViewHelper"));
registerCtrlHelper(array("player/playertrait"));

class Site  
{  
    static function getTaskList()
    {  
        output( array(
            "rega"=>array(),
            "wtda"=>array(),
            "wtdu"=>array(),
            "dptu"=>array(),
            "dptf"=>array(),
            "actv"=>array()
        ), "json");
    }
    
    function index(){
        showIndex();
    }

    static function getIpInfo($request){
        if (empty($request)){
            return;
        }else{
            $ReqHost = getArrayValue("ip", "", $request);
            if (empty($ReqHost)){
                return;
            }else{
                $ipsearcher = new Helper_IpLocation();
                $location = $ipsearcher->getlocation($ReqHost[1]);
                $ret = array("code"=>"0",
                    "data"=>array(
                        "country"=>$location["country"],
                        "region"=>"",
                        "city"=>$location["area"]
                    )
                );
                // print_r($ret);
                output($ret, "json");
            }
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