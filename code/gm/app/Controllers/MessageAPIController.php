<?php
namespace App\Controllers;

use App\Config\Config;
use App\Libs\HttpRequest as http;

class MessageAPIController extends BaseController
{

    public static function addPlayerMessage($request)
    {
        $account = getArrayValue("playerid", "", $request);
        $content = getArrayValue("content", "", $request);
        $title = getArrayValue("title", "", $request);

        if (empty($account) || empty($account) || empty($account)){
            return ["code"=>404, "Message"=>"请提交正确的参数"];
        }else{
            $retJson = http::gmHttpCaller("SendMessageToPlayer", array($account, $title, $content));
            if (getArrayValue(0, "", $retJson) == 1){
                return ["code"=>200, "Message"=>""];
            }else{
                return ["code"=>404, "Message"=>"消息发送失败"];
            }
        }
    }
    
}