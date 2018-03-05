<?php  
/** 
 * MVC路由功能简单实现 
 * @desc 简单实现MVC路由功能 
 * 注意需要php.ini中session_autostart的开启，否则代码中要申明session_start();
 */
   
date_default_timezone_set('Asia/Shanghai');
define('APPPATH', trim(__DIR__ . '/'));
define('CONTROLLER', APPPATH.'application/controllers/');
include("./application/utilities/constructor.php");
registerCommonHelper();

function main(){
    /**
     * 路由主控制函数
     * 解析URI路径，及Request（GET/POST）的参数
     * 通过call_user_func_array动态调用方法执行
     */
    $ValidRootPath = array("zh-cn", "api", "agent");
    $needLoginMethod = array("AccountSetting", "Registeredok", "gu");
    
    //获得请求地址     
    $root = $_SERVER['SCRIPT_NAME'];  
    $request = explode("/", $_SERVER['PATH_INFO']);  
    $querystr = explode("&", $_SERVER['QUERY_STRING']);
    $ControllerPath = getArrayValue(1, "zh-cn", $request);
    $ClassName = getArrayValue(2, "index", $request);
    // $ClassName = empty($ClassName)?"index":$ClassName;
    $MethodName = getArrayValue(3, "main", $request);
    // $MethodName = empty($MethodName)?"main":$MethodName;
    $ClassFilePath = $ControllerPath . '/' . $ClassName;

    //检查根路径是否合法
    if (!in_array(strtolower($ControllerPath), $ValidRootPath)){
        //header("location:/".INDEXPAGE);
        return;
    }
    
    if(in_array($MethodName, $needLoginMethod)){
        if(isset($_SESSION["memberinfo"]) && count($_SESSION["memberinfo"])>0){
            // do nothing.
        }else{
            // session_unset();
            // session_destroy();
            // setcookie(session_name(),'',time()-3600);
            // header("location:/zh-cn/member");
            // return;
        }
    }
    switch ($MethodName) {
        /**
         * 校验验证码，静态调用会出现无法解析未图片的情况
         */
    case "verifycode":
        registerCtrlHelper(array("verifycode/ValidateCode.class"));
        $_vc = new ValidateCode();
        $_vc->doimg();
        $_SESSION['verifycode'] = $_vc->getCode();
        break;
    default:
        //注册并加载CGI访问的PHP脚本
        registerCtrlHelper(array($ClassFilePath));
        $_SESSION["PageClass"] = strtolower($ClassName);
        $_SESSION["QueryArgus"] = parseArgus($querystr);
        parsePost();
        $func_query = getSessionValue("QueryArgus", array());
        $func_posts = getSessionValue("PostJsons", array());
        // echo "query is "; print_r($func_query);
        // echo "posts is "; print_r($func_posts);
        if (!empty($func_posts)){
            $func_argus = $func_posts;
        }elseif(!empty($func_query)){
            $func_argus = $func_query;
        }else{
            $func_argus = array();
        }
        
        //调用内部function
        //传递参数，只能是indexedArray，不能是key-val...不如从session去取
        // print_r(array(ucfirst($ClassName), $MethodName));
        $result = call_user_func_array(
            array(ucfirst($ClassName), $MethodName),  
            array($func_argus)
        );
    }
        // if (!$result){
        //     output($GLOBALS["errorRet"], "json");
        // }
}

function parsePost(){
    $_PostData = file_get_contents('php://input');
    // echo "_PostData is ";print_r(json_decode($_PostData, true));
    // echo "str pos is ".strstr(":", $_PostData);
    if (strpos($_PostData, "=")!==false){
        $_SESSION["PostJsons"] = parseArgus(explode("&", $_PostData));
    }else{
        $_SESSION["PostJsons"] = json_decode($_PostData, true);
    }
    // echo "session post json is "; print_r($_SESSION["PostJsons"]);
}

function parseArgus($querys){
    $ret = array();
    // print_r($querys);
    foreach($querys as $_query){
        if (!empty($_query)){
            $_q = explode("=", $_query);
            $ret[$_q[0]] = $_q[1];
        }
    }
    return $ret;
}
main();

?>  