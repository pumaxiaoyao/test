<?php  
  

/**
 * MVC路由功能简单实现
 * @desc 简单实现MVC路由功能
 */
registerDataHelper(array("protoHelper", "dataHelper"));
registerViewHelper(array("GmViewHelper"));

/**
 * 账号相关操作
 */
class Account
{

    /**
     * 构建登录界面
     *
     * @return void
     */
    static function login()
    {  
        $page = array(
            readHtml("login")
        );
        output(join("", $page));
    } 

    function register(){
        $page = array(
            readHtml("register")
        );
        output(join("", $page));
    }
}  
  
  
?>  