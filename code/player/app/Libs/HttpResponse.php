<?php
namespace App\Libs;
use App\Config\Config;
/**
 * 封装的Http响应
 *
 */
class HttpResponse
{
    // 输出方法
    public static function render($_data, $_type = "html", $_method = 1){
        if (isset($_data["type"]))
            $_type = $_data["type"];
        if ($_type == "html")
            echo $_data;
        elseif ($_type == "json")
            if ($_method == 1)
                echo json_encode(HttpResponse::parseResponse($_data));
            else
                echo json_encode($_data);
        else
            var_dump($_data);
    }


    // 暂时的响应数据处理方法，仅供player返回处理
    // 非逻辑中间件
    private static function parseResponse($retJson)
    {
        $retData = [];
        if ($retJson && isset($retJson[0]) && $retJson[0] === "FORCETOTEXT") {
            $retData["type"] = "html";
            // $retJson = array_slice($retJson, 1);
            return $retJson[1];
        }

        if (Config::base["needAjaxDebugInfo"]) {
            $retData["Debug"] = \getSessionValue("lastreq", []);
        };
            
        
        $retData["data"] = $retJson;
        return $retData;
    }
}