<?php

trait registerViewHelper{
   /**
    * 注册相关的页面构建方法
   */
    function main(){
        self::reglogin();
    }

    function reglogin(){
        $page = array(
            makeHeader("member/register/register_header_metas","member/register/register_header_script"),
            readHtml("member/register/register_login")
        );
        output(join("", $page));
    }

    function Registered(){
        $page = array(
            makeHeader("member/register/register_header_metas","member/register/register_header_script"),
            readHtml("member/register/register"),
        );
        output(join("", $page));
    }

    function Registeredok(){
        $page = array(
            makeHeader("member/register/registerok_header_metas","member/register/registerok_header_scripts"),
            makeNav(),
            readHtml("member/register/registerok"),
            readHtml("common/commonfooter")
        );
        output(join("", $page));
    }

    /**
     * 找回密码的界面
     *
     * @return void
     */
    static function showRetrieve(){
        $page = array(
            makeHeader("member/register/registerok_header_metas","member/register/retrieve_header_scripts"),
            makeNav(),
            readHtml("member/register/retrieve"),
            readHtml("common/commonfooter")
        );
        $page = join("", $page);

        $page .= "<script>";
        $interval = getSessionValue("GetPhoneCodeTime", 0) + 60 - time();
        if ($interval >0) {
            $page .= "var LastPhoneCode=true; var PhoneCodeInterval=".$interval.";";
        } else {
            $page .= "var LastPhoneCode=false; var PhoneCodeInterval=0;";
        }
        
        $intervalMail = getSessionValue("GetMailCodeTime", 0) + 60 - time();
        if ($intervalMail > 0) {
            $page .= "var LastMailCode=true; var MailCodeInterval=".$intervalMail.";";
        } else {
            $page .= "var LastMailCode=false; var MailCodeInterval=0;";
        }
        
        $page .= "</script>";
        output($page);
    }
}
?>