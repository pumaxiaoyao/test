<?php  
/** 
 * MVC路由功能简单实现 
 * @desc 简单实现MVC路由功能 
 */  
//定义application路径     

define('APPPATH', trim(__DIR__ . '/'));
define('CONTROLLER', APPPATH.'application/controllers');
define('THIRDPARTIES', APPPATH.'application/thirdparties');

//print_r( );
//获得请求地址     
$root = $_SERVER['SCRIPT_NAME'];  
$request = $_SERVER['REQUEST_URI'];  
  
$URI = array();  
  
//获得index.php 后面的地址     
$url = trim(str_replace($root, '', $request), '/');  
//如果为空，则是访问根地址 

$defaultPage = false;
if (empty($url)) {  
    //默认控制器和默认方法  
    $defaultPage = true;
    
} else {
    $URI = explode('/', $url);
    $URI_Length = count($URI);
    if (!in_array($URI[0], array("zh-cn","API")) || $URI_Length == 1){
        $defaultPage = true;
    }else{
        $langs = $URI[0];
        $class = $URI[1];
        $funcs = "main";
        $argus = array();
        if($URI_Length > 2){
            $funcs = $URI[2];
        }
    }
}

if($defaultPage){
    echo "defaultPage argus is ";
    echo $request;
    //header("location:/zh-cn/index/");  
}else{
    $classFile = CONTROLLER. '/'. $langs . '/' . $class . '.php';
    if(!is_file($classFile)){
        echo "classFile". $classFile ." exists argus is ";
        echo !is_file($classFile);
        //header("location:/zh-cn/index");  
    }else{
        include($classFile);
        $_args = explode("?", $funcs);
        $func_func = $_args[0];
        //把class加载进来 
        $c = file_get_contents($classFile);
        $m = 'function '.$func_func;
        if (!strstr($c, 'function '.$func_func)){
            echo "undefined ".$m;
            //header("location:/zh-cn/index");
        }else{
            $_SESSION["PageClass"] = strtolower($class);
            if (count($_args) > 1){
                $func_args = array_slice( $_args, 2);
            }else{
                $func_args = array();
            }
            switch($func_func){
                default:
                    //分离参数
                    $uri_args = array();
                    if (count($func_args) > 0){
                        foreach(explode("&", $func_args) as $_val){
                            array_push($uri_args, explode("=", $_val)[1]);
                        }
                    }
                    $_POST["URIARGUS"] = $uri_args;
                    // print_r($_POST) ;
                    // if (count($_POST) > 0){
                    //     foreach($_POST as $_v){
                    //         array_push($uri_args, $_v);
                    //     }
                    // }
                    //实例化->将控制器首字母大写    
                    $obj = ucfirst($class);
                    //调用内部function
                    //传递参数，只能是indexedArray 
                    //echo json_encode($_POST);
                    $_POST["json"] = file_get_contents('php://input');
                    //echo json_encode($_POST),6766;
                    call_user_func_array(array($obj, $func_func),  $_POST);
                }
            }
        }
}

?>  