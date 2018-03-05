<?php

function httpGet($url, $_cookie){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_COOKIE, $_cookie);
    $ret = curl_exec($ch);
    curl_close($ch);
    return $ret;
}

function posturl($url, $data, $_cookie = ""){
    $ch = curl_init();
    // echo "ready to connect to :".$url."<br/>";
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
    $_json = json_encode($data);
    curl_setopt($ch, CURLOPT_POSTFIELDS,  $_json);
    //curl_setopt($ch, CURLOPT_COOKIEFILE, $_cookie);
    //curl_setopt($ch, CURLOPT_TIMEOUT, 1);              
    
    $ret = curl_exec($ch);
    //echo "data from posturl func: ".$ret;
    //$info = curl_getinfo($ch);
    if (curl_errno($ch)) {                
        return 'Errno'.curl_error($ch);           
    }else{
        curl_close($ch);
        return $ret;
    }
    
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

function loginSportsBook(){
    // login and get sessionToken.
    $host = "http://api.prod.ib.gsoft88.net/";
    $raw_ret = login();
    $_json = json_decode($raw_ret);
    
    $raw_ret = Processlogin($_json->sessionToken);
    echo $raw_ret;
}

?>