<?php  

class Player  
{  
    function mcbalance(){
        $ret = array(
            "code"=>0,
            "data"=>array("gpid"=>"main","val"=>array("main"=>"1238.7000","withdraw"=>"0.00"))
        );
        echo json_encode($ret);
        
    }

    function lock(){
        
    }


}  
  
  
?>  