<?php
session_start();
class Login{
    function vpkey(){
       echo json_encode($_POST); 
    }

    function GMlogin(){
        
        //echo json_encode($_POST);
        $request_name = $_POST["csname"];
        $request_pwd = $_POST["cspwd"];
        //$request_verifycode = $_POST["verifycode"];
        
        $allow_login = array(
            array("account"=>"alien123",
                    "password"=>"alien456",
                    "nickname"=>"今晚吃鸡大吉大利",
                    "balance"=>10000,

            ),
            array("account"=>"joker123",
            "password"=>"joker456",
            "nickname"=>"左手右手一个慢动作",
            "balance"=>200000,
            )
        );
        $login_result = false;
        $userdata = array();
        foreach($allow_login as $val){
            if($val["account"] == $request_name && $val["password"] == $request_pwd){
                $login_result = true;
                $userdata = $val;
            }
        }
        
        echo json_encode($userdata);//echo json_encode($userdata) ;
        // $ret = array("c"=>0, "d"=>null, "m"=>"ok");
        
        // if (!$login_result){
        //     $ret["c"] = 1007;
        //     $ret["m"] = 5;
        // }
        // echo json_encode($ret);
        //return $ret;
        
    }
}



?>