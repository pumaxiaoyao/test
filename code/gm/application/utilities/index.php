<?php
/**
 * 测试的数据接口路由，仅用于调试后台请求
 */

define('APPPATH', trim(__DIR__ . '/'));
define('TESTDATA', APPPATH.'testdata/');

if (!isset($_POST)){
    echo '2222222'.json_encode(array("code"=>-1,"message"=>"invalid post data."));
}else{

    $root = $_SERVER['SCRIPT_NAME'];  
    $request = $_SERVER['REQUEST_URI'];  
    //echo $root."===".$request."<br/>";
    $URI = array();  
      
    //获得index.php 后面的地址     
    $url = trim(str_replace($root, '', $request), '/');  
    
    $URI = explode('/', $url); 
    
    if (count($URI) != 2){
        echo json_encode(array("code"=>-1, "message"=>"invalid url."));
    }else{
        $class = $URI[0];
        $func  = $URI[1];
        //把class加载进来     
        include(TESTDATA. $class . '.php');
        //实例化->将控制器首字母大写    
        $obj = ucfirst($class);
        call_user_func_array(array($obj, $func), $_POST);
    }
    
}



?>