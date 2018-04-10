<?php
namespace App\Libs;
use App\Config\Config;
/**
 * 封装的Http请求
 *
 */
class HttpRequest
{
    // 生成实际要访问的数据中心地址
    private static function getBaseUrl($_sType)
    {
        $tags = Config::dataCenter["server"];
        $host = Config::dataCenter["host"];
        $port = Config::dataCenter["port"];
        return 'http://' . $host . ':' . $port . '/' . $tags[$_sType];
    }

    /**
     * 重新构建的通用Http访问接口
     *
     * @param [type] $_caller 命令
     * @param [type] $_argus  参数
     * @param [type] $_type   方法的数据中心类别，可选player, agent, gm
     * @return void
     */
    private static function httpCaller($_caller, $_argus, $_type)
    {
        $_request = array("call" => $_caller, "params" => json_encode($_argus));
        $servUrl = self::getBaseUrl($_type);
        $dataUrl = $servUrl . "?" . http_build_query($_request);//, "", '&amp;'); // 避免$para被解析成乱码
        $raw_ret = self::curlGet($dataUrl, $_request);
        $retJson = json_decode($raw_ret, true);
        $debugInfo = array(
            "URL" => $dataUrl,
            "request" => $_request,
            "return" => $retJson
        );
        $_SESSION["lastreq"] = $debugInfo; // 构建debug返回信息
        $_SESSION["caller"] = $_caller; // 构建debug返回信息
        return $retJson;
    }

    /**
     * CurlHttpGet 方法
     *
     * @param [type] $url     URL路径
     * @param [type] $data    参数
     * @param string $_cookie cookie
     *
     * @return void
     */
    private static function curlGet($url, $data, $_cookie = "")
    {
        $ch = curl_init();
        $_header = array("content-type: application/json;charset=UTF-8");
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $_header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        if (curl_errno($ch)) {
            return 'Errno' . curl_error($ch);
        } else {
            $ret = curl_exec($ch);
            curl_close($ch);
            return $ret;
        }
    }

    /**
     * CurlHttpGet 方法
     *
     * @param [type] $url     URL路径
     * @param [type] $data    参数
     * @param string $_cookie cookie
     *
     * @return void
     */
    private static function curlPost($url, $data, $_cookie = "")
    {
        $requestData = json_encode($data);
        $ch = curl_init();
        $_header = array("content-type: application/json;charset=UTF-8");
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $_header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        if (curl_errno($ch)) {
            return 'Errno' . curl_error($ch);
        } else {
            $ret = curl_exec($ch);
            curl_close($ch);
            return $ret;
        }
    }

    // 面向玩家数据的访问接口
    public static function playerHttpCaller($call, $param)
    {
        return self::httpCaller($call, $param, "player");
    }

    // 面向代理数据的访问接口
    public static function agentHttpCaller($call, $param)
    {
        return self::httpCaller($call, $param, "agent");
    }

    // 面向客服数据的访问接口
    public static function gmHttpCaller($call, $param)
    {
        return self::httpCaller($call, $param, "gm");
    }

    public static function outerHttpCaller($gt_url, $param)
    {
        return self::curlPost($gt_url, $param);
    }
}
