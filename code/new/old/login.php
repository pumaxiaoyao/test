<?php

function login(){
    $acc = $_POST["account"];
    $pwd = $_POST["password"];
    echo '成功登录<br/>';
    echo '账号是 '.$acc.'<br/>';
    echo '密码是 '.$pwd.'<br/>';
}

login();

?>