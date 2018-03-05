<?php

class PublicView{

    function getcaptcha(){
        #echo getcwd();
        //使用极验的验证码接口
        return output(StartCaptcha());
    }


    function captcha(){
        // 自己实现的普通的验证码模式
    }

    function gu(){
        
    }
}
?>