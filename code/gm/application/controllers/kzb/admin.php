<?php
/**
 * 提供admin功能，包括安全密钥，账号登录等
 */
registerDataHelper(array("protoHelper", "dataHelper"));

/**
 * Admin功能
 * 
 */
class Admin
{
   
    /**
     * 返回安全密钥
     *
     * @return void
     */
    function vpkey()
    {
        // 生成加密、解密的密钥相关，用于login时的密码加密计算
        // RSA加密方式，返回公钥，给客户端进行解析
        output(Base_GetVpKey(), "json");
    }

    /**
     * 注册后台账号 - 测试用接口
     *
     * @param [type] $request URI参数
     * 
     * @return void
     */
    function register($request)
    {
        $regAccount = getArrayValue("acc", "", $request);
        $regPasswd = getArrayValue("pwd", "", $request);

        if (empty($regAccount) || empty($regPasswd)) {
            return output("cannot finished register operation.");
        } 

        if (!dbCheckUser($regAccount)) {
            return output("cannot register input account because it's already exists.");
        }

        dbCreateUser($regAccount, $regPasswd);

        return output("account created.");
    }

    

    /**
     * 后台用户登录
     *
     * @param [type] $request URI参数
     * 
     * @return void
     */
    function login($request)
    {
        $verifycode = getArrayValue("verifycode", "", $request);
        $account = getArrayValue("csname", "", $request);
        $passwd = getArrayValue("cspwd", "", $request);


        $ret = array("c"=>0, "d"=>null, "m"=>"ok");
        if (empty($verifycode)) {
            $ret["c"] = 995;
        } elseif (!isset($_SESSION["verifycode"])) {
            $ret["c"] = 991;
        } elseif ($_SESSION["verifycode"] != $verifycode) {
            $ret["c"] = 998;
        }

        if ($ret["c"] == 0) {
            $MAX_TRY_LOGIN = 5;//需要置于外部配置
            $LoginTime = time();
            if (!isset($_SESSION["Trylogin"])) {
                // 没有session字段，就初始化一下
                $_SESSION["Trylogin"] = $MAX_TRY_LOGIN;
                $_SESSION["LastTryLoginTime"] = $LoginTime;
            }
    
            if (time() - $_SESSION["LastTryLoginTime"] > 15 * 60) {
                // 15分钟，就重置次数和时间
                $_SESSION["Trylogin"] = $MAX_TRY_LOGIN;
                $_SESSION["LastTryLoginTime"] = $LoginTime;
            }
            
            if (dbCheckLogin($account, $passwd)) {
                // 登录成功，有数据即表示成功
                $_SESSION["Account"] = $account;
                $_SEESION["Trylogin"] = $MAX_TRY_LOGIN;
                $_SESSION["LastTryLoginTime"] = $LoginTime;
                $ret["c"] = 0;
            } else {
                $_SESSION["Account"] = '';
    
                if ($_SESSION["Trylogin"] > 0) {
                    $_SESSION["Trylogin"] -= 1;
                    $_SESSION["LastTryLoginTime"] = time(); //记录时间，一定时间后，恢复次数为5次
                    $ret["c"] = 1007;
                    $ret["m"] = $_SESSION["Trylogin"];
                } else {
                    // 错误次数达到上限，具体错误提示文字看error.js中的定义
                    $_SESSION["Trylogin"] = 0;
                    $ret["c"] = 1006;
                    $ret["m"] = $_SESSION["Trylogin"];
                }
            }
        }
        return output($ret, "json");
    }

}  
  
  
?>  
