<?php
/** 
 * Index.php
 * MVC路由功能简单实现 
 * 
 * @desc    简单实现MVC路由功能
 * @author  alien <alien@alien.com>
 * @version GIT:<11111>
 */

date_default_timezone_set('Asia/Shanghai');

define('APPPATH', trim(__DIR__ . '/'));
define('CONTROLLER', APPPATH.'application/controllers/');
define('THIRDPARTIES', APPPATH.'application/thirdparties/');
define('UTILITIES', APPPATH.'application/utilities/');

require UTILITIES."constructor.php";
registerCommonHelper();


/**
 * Router 主函数
 * 获取URI参数，加载PHP脚本，封装request参数
 * 
 * @return null
 */
function main()
{
    $ValidRootPath = array("zh-cn", "kzb", "common");
    $needLoginMethod = array("verifycode", "login", "httpsRequest");
    $reRirectMethod = array(
        "list"=>"allRoles"
    );
    //获得请求地址     
    $root = $_SERVER['SCRIPT_NAME'];  
    $request = explode("/", $_SERVER['PATH_INFO']);  
    $querystr = explode("&", $_SERVER['QUERY_STRING']);
    if (count($request) == 3) {
        $ControllerPath = "zh-cn";
        $ClassName = getArrayValue(1, "account", $request);
        $MethodName = getArrayValue(2, "login", $request);
    } else {
        $ControllerPath = getArrayValue(1, "zh-cn", $request);
        $ClassName = getArrayValue(2, "account", $request);
        $MethodName = getArrayValue(3, "login", $request);
    }
    $ClassFilePath = $ControllerPath . '/' . $ClassName;
    //检查跟路径是否合法
    if (!in_array($ControllerPath, $ValidRootPath)) {
        //header("location:/".INDEXPAGE);
        $ControllerPath = "zh-cn";
    }
    //检查跳转的目标脚本是否存在
    // if(!is_file($ClassFilePath)){
    //     echo "classFile ". $ClassFilePath ." not exists";
    //     //header("location:/".INDEXPAGE);
    //     return;
    // }
    
    if (!in_array($MethodName, $needLoginMethod)) {
        if (empty($_SESSION["Account"])) {
            header("location:/");
            return;
        }
    }

    if (in_array($MethodName, array_keys($reRirectMethod))) {
        // 替换部分与PHP内部定义非法的特殊方法名，比如 list....
        $MethodName = $reRirectMethod[$MethodName];
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
        registerCtrlHelper(array($ClassFilePath));

        $_SESSION["PageClass"] = strtolower($ClassName);
        $_SESSION["PageMethod"] = strtolower($MethodName);
        $_SESSION["QueryArgus"] = parseArgus($querystr);
        $_SESSION["PostJsons"] = parsePost();


        $func_query = getSessionValue("QueryArgus", array());
        $func_posts = getSessionValue("PostJsons", array());
        if (!empty($func_posts)) {
            $func_argus = $func_posts;
        } elseif (!empty($func_query)) {
            $func_argus = $func_query;
        } else {
            $func_argus = array();
        }
        if ($ClassName == "error") {
            echo "error page.";
        } else {
            call_user_func_array(
                array(ucfirst($ClassName), $MethodName),  
                array($func_argus)
            );
        }
        
    }
}

/**
 * 解析URI的Post参数
 * 解析后，存储在Session中
 * 
 * @return postArgus
 */
function parsePost()
{
    $_PostData = file_get_contents('php://input');
    if (strpos($_PostData, "=")!==false) {
        $ret = parseArgus(explode("&", $_PostData));
    } else {
        $ret = json_decode($_PostData, true);
    }
    return $ret;
}

/**
 * 解析URI的Get参数
 * 接续后，存储在session中
 * 
 * @param string $querys - 获取的query字符串
 * 
 * @return array
 */
function parseArgus($querys)
{
    $ret = array();
    foreach ($querys as $_query) {
        if (!empty($_query)) {
            $_q = explode("=", $_query);
            $ret[$_q[0]] = $_q[1];
        }
    }
    return $ret;
}

main(); 
?>