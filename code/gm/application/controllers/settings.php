<?php  
  
/** 
 * MVC路由功能简单实现 
 * @desc 简单实现MVC路由功能  
 */  
include "./application/utilities/utilities.php";
class Settings  
{  
  
    function playerLevel()
    {  
        echo makepage("", "settings/playerLevel", "");     
    } 

    function agentLevel(){
        echo makepage("", "settings/agentLevel", "");     
    }

    function gplist(){
        echo makepage("", "settings/gplist", "settings_gplist_footer");     
    }

    function csDept(){
        echo makepage("", "settings/csDept", "settings_csdept_footer");     
    }

    function csAcct(){
        echo makepage("", "settings/csAcct", "settings_csacct_footer");     
    }

    function ws(){
        echo makepage("", "settings/ws", "");      
    }

    function getSysConfig(){
        $ret = array(
            array("cate"=>"1500","itemkey"=>"activityimgsize","itemval"=>"1200x150"),
            array("cate"=>"1202","itemkey"=>"agentallowlogin","itemval"=>"ON"),
            array("cate"=>"1203","itemkey"=>"agentallowreg","itemval"=>"ON"),
            array("cate"=>"1202","itemkey"=>"agenterrloginlocked","itemval"=>"5"),
            array("cate"=>"1203","itemkey"=>"agentforbiddennames","itemval"=>"admin"),
            array("cate"=>"1202","itemkey"=>"agentloginclosedreason","itemval"=>"\u767b\u5f55\u7cfb\u7edf\u5347\u7ea7\u4e2d\uff0c\u5982\u6709\u7591\u95ee\uff0c\u8bf7\u8054\u7cfb\u5ba2\u670d\uff01"),
            array("cate"=>"1203","itemkey"=>"agentregclosedreason","itemval"=>"\u6ce8\u518c\u7cfb\u7edf\u5347\u7ea7\u4e2d\uff0c\u5982\u6709\u7591\u95ee\uff0c\u8bf7\u8054\u7cfb\u5ba2\u670d\uff01"), 
            array("cate"=>"2200","itemkey"=>"agentreqemail","itemval"=>"ON"),
            array("cate"=>"2200","itemkey"=>"agentreqphone","itemval"=>"ON"),
            array("cate"=>"2200","itemkey"=>"agentreqqq","itemval"=>"ON"),
            array("cate"=>"1301","itemkey"=>"agentwithdrawdaylimit","itemval"=>"5"),
            array("cate"=>"1301","itemkey"=>"agentwithdrawdaymax","itemval"=>"200000.00"),
            array("cate"=>"1301","itemkey"=>"agentwithdrawmax","itemval"=>"100000.00"),
            array("cate"=>"1301","itemkey"=>"agentwithdrawmin","itemval"=>"100.00"),
            array("cate"=>"1600","itemkey"=>"allow","itemval"=>"ON"),
            array("cate"=>"1300","itemkey"=>"allowdeposit","itemval"=>"ON"),
            array("cate"=>"1300","itemkey"=>"allowdepositofatm","itemval"=>"ON"),
            array("cate"=>"1300","itemkey"=>"allowdepositofebank","itemval"=>"ON"),
            array("cate"=>"1300","itemkey"=>"allowdepositofopay","itemval"=>"ON"),
            array("cate"=>"1200","itemkey"=>"allowlogin","itemval"=>"ON"),
            array("cate"=>"1300","itemkey"=>"allowprocesscount","itemval"=>"100"),
            array("cate"=>"1201","itemkey"=>"allowreg","itemval"=>"ON"),
            array("cate"=>"1400","itemkey"=>"allowupload","itemval"=>"ON"),
            array("cate"=>"1301","itemkey"=>"allowwithdraw","itemval"=>"ON"),
            array("cate"=>"2200","itemkey"=>"checkrealname","itemval"=>"OFF"),
            array("cate"=>"1100","itemkey"=>"csallowlogin","itemval"=>"ON"),
            array("cate"=>"1401","itemkey"=>"csallowupload","itemval"=>"ON"),
            array("cate"=>"1100","itemkey"=>"cserrloginlocked","itemval"=>"5"),
            array("cate"=>"1100","itemkey"=>"csloginclosedreason","itemval"=>"\u767b\u5f55\u7cfb\u7edf\u5347\u7ea7\u4e2d\uff0c\u5982\u6709\u7591\u95ee\uff0c\u8bf7\u8054\u7cfb\u5ba2\u670d\uff01"),
            array("cate"=>"1300","itemkey"=>"depositautoreceive","itemval"=>"ON"), array("cate"=>"1300","itemkey"=>"depositofatmdaylimit","itemval"=>"100"), array("cate"=>"1300","itemkey"=>"depositofatmmax","itemval"=>"1000000.00"), array("cate"=>"1300","itemkey"=>"depositofatmmin","itemval"=>"100.00"), array("cate"=>"1300","itemkey"=>"depositofebankdaylimit","itemval"=>"100"), array("cate"=>"1300","itemkey"=>"depositofebankmax","itemval"=>"1000000.00"), array("cate"=>"1300","itemkey"=>"depositofebankmin","itemval"=>"100.00"), array("cate"=>"1300","itemkey"=>"depositofopaydaylimit","itemval"=>"100"), array("cate"=>"1300","itemkey"=>"depositofopaymax","itemval"=>"1000000.00"), array("cate"=>"1300","itemkey"=>"depositofopaymin","itemval"=>"100"), array("cate"=>"1200","itemkey"=>"errloginlocked","itemval"=>"5"), array("cate"=>"1201","itemkey"=>"forbiddennames","itemval"=>"admin"), array("cate"=>"1600","itemkey"=>"from","itemval"=>""), array("cate"=>"1600","itemkey"=>"host","itemval"=>""), array("cate"=>"1200","itemkey"=>"loginclosedreason","itemval"=>"\u767b\u5f55\u7cfb\u7edf\u5347\u7ea7\u4e2d\uff0c\u5982\u6709\u7591\u95ee\uff0c\u8bf7\u8054\u7cfb\u5ba2\u670d\uff01."), array("cate"=>"2100","itemkey"=>"noticeaudio","itemval"=>"\/incloud\/newtask.wav"), array("cate"=>"1600","itemkey"=>"password","itemval"=>""), array("cate"=>"1600","itemkey"=>"port","itemval"=>""), array("cate"=>"2200","itemkey"=>"regbirthday","itemval"=>"OFF"), array("cate"=>"1201","itemkey"=>"regclosedreason","itemval"=>"\u6ce8\u518c\u7cfb\u7edf\u5347\u7ea7\u4e2d\uff0c\u5982\u6709\u7591\u95ee\uff0c\u8bf7\u8054\u7cfb\u5ba2\u670d\uff01"), array("cate"=>"2200","itemkey"=>"regemail","itemval"=>"ON"), array("cate"=>"2200","itemkey"=>"regqq","itemval"=>"OFF"), array("cate"=>"2200","itemkey"=>"reqphone","itemval"=>"ON"), array("cate"=>"1601","itemkey"=>"sitename","itemval"=>""), array("cate"=>"2200","itemkey"=>"usereditprofile","itemval"=>"ON"), array("cate"=>"1600","itemkey"=>"username","itemval"=>""), array("cate"=>"1301","itemkey"=>"watercheckonoff","itemval"=>"ON"), array("cate"=>"1301","itemkey"=>"withdrawdaylimit","itemval"=>"3"), array("cate"=>"1301","itemkey"=>"withdrawdaymax","itemval"=>"5000000"), array("cate"=>"1301","itemkey"=>"withdrawdistribute","itemval"=>""), array("cate"=>"1301","itemkey"=>"withdrawdotyn","itemval"=>"ON"), array("cate"=>"1301","itemkey"=>"withdrawmax","itemval"=>"1000000"), array("cate"=>"1301","itemkey"=>"withdrawmin","itemval"=>"100.00"), array("cate"=>"1301","itemkey"=>"withdrawpassword","itemval"=>"OFF"));
        echo json_encode($ret);
    }
}  
  
  
?>  