<?php  
  
/** 
 * MVC路由功能简单实现 
 * @desc 简单实现MVC路由功能  
 */

registerViewHelper(array("GmViewHelper", "Message/MessageViewHelper"));
registerDataHelper(array("protoHelper", "dataHelper"));

class Message  
{  
    
    function platform()
    {  
        showPlatformMsg();    
    }  

    function player(){
        showPlayerMsg();
    }

    function playerMessageList(){
        output(Base_playerMsgList());
    }

    function agent(){
        showAgentMsg();
    }
    
    function agentMessageList(){
        output(Base_agentMsgList());
    }

    function addPlayerMessage($request){
        /**
         * 给玩家发送信息
         */
        $account = getArrayValue("playerid", "", $request);
        $content = getArrayValue("content", "", $request);
        $title = getArrayValue("title", "", $request);

        if (empty($account) || empty($account) || empty($account)){
            return output(array("code"=>404, "Message"=>"请提交正确的参数"), "json");
        }else{
            $retJson = gmServerCaller("SendMessageToPlayer", array($account, $title, $content));
            if (getArrayValue(0, "", $retJson) == 1){
                return output(array("code"=>200, "Message"=>""), "json");
            }else{
                return output(array("code"=>404, "Message"=>"消息发送失败"), "json");
            }
        }
    }

}  
  
  
?>  