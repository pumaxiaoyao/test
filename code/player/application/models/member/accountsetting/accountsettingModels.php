<?php
function initall(){
    $names = array("", "kodo");
    $sexy  = array("1", "2");
    $mails = array("", "tencent.qq.com");
    $phone = array("", "13800138000");
    $cards = array("", "8198561595684458");
    
    $_SESSION["memberinfo"] = array(
        "MemberName"=>"loginTest",
        "MemberUID"=>rand(1,200),
        "MemberPWD"=>"password",
        "BasicInfo"=>array(
                            "realName"=>$names[array_rand($names)],
                            "sex"=>$sexy[array_rand($sexy)],//1-male,2-female
                            "birthday"=>"1997-7-1",
                            "address"=>array(
                                        "province"=>"1",
                                        "city"=>"1",
                                        "area"=>"1"
                            ),
                            "street"=>"美国有达州",
                        ),
        "email"=>$mails[array_rand($mails)],
        "phone"=>$phone[array_rand($phone)],
        "bankCard"=>$cards[array_rand($cards)],
        "mainBalance"=>(float)rand(100, 10000)/1.0,
        );
}

?>