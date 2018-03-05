<?php  
  
/** 
 * MVC路由功能简单实现 
 * @desc 简单实现MVC路由功能  
 */  
class Account  
{  
  
    function login()
    {  
        echo file_get_contents('./html/login.html');
    }  
}  
  
  
?>  