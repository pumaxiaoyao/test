<?php
header('Content-type:text/json'); 

function login(){
    $url = "http://api.prod.ib.gsoft88.net/api/Login?SecurityToken=12238EC18793D054EB7C676881961EBE&OpCode=ABETLICN&PlayerName=alien";
    //echo $url."<br/>--------------------------------<br/>";
    $ret = httpGet($url, "");
    return $ret;
}

function Processlogin($token){
    $url = "http://mkt.ib.abet.life/Deposit_ProcessLogin.aspx?lang=cs";
    //echo $url."<br/>--------------------------------<br/>";
    $ret = httpGet($url, "g=".$token);

    $sportsurl = "http://mkt.ib.abet.life/index.aspx";
    $pos = strpos($ret, "Object moved to ");
    if ($pos == false){
        return $ret;
    }else{
        return $sportsurl;
    }
    
}

function httpGet($url, $_cookie){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_COOKIE, $_cookie);
    $ret = curl_exec($ch);
    curl_close($ch);
    return $ret;
}



function posturl($url, $data, $_cookie){
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
    //curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_COOKIEFILE, $_cookie);
    curl_setopt($ch, CURLOPT_TIMEOUT, 0.1);              
    
    $ret = curl_exec($ch);
    //$info = curl_getinfo($ch);
    if (curl_errno($ch)) {                
        $this->ajaxReturn('Errno'.curl_error($ch) ,'JSON');           
    }
    curl_close($ch);
    return $ret;
}




function loginSportsBook(){
    // login and get sessionToken.
    $host = "http://api.prod.ib.gsoft88.net/";
    $raw_ret = login();
    $_json = json_decode($raw_ret);
    
    $raw_ret = Processlogin($_json->sessionToken);
    echo $raw_ret;
}


if(isset($_GET['m'])){
    $PAGECODE = $_GET['m'];
    switch ($PAGECODE){
        case "sportsbook":
            loginSportsBook();
            break;
    }
}
?>