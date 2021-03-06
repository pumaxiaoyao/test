<?php

/**
 * http、https通信类
 * ============================================================================
 * api说明：
 * setReqContent($reqContent),设置请求内容
 * getResContent(), 获取应答内容
 * getErrInfo(),获取错误信息
 * setTimeOut($timeOut)， 设置超时时间，单位秒
 * getResponseCode(), 取返回的http状态码
 * call(),真正调用接口
 * 
 * ============================================================================
 *
 */
class PayHttpClient {

    //请求内容，无论post和get，都用get方式提供
    var $reqContent = array();
    //应答内容
    var $resContent;
    //错误信息
    var $errInfo;
    //超时时间
    var $timeOut;
    //http状态码
    var $responseCode;

    function __construct() {
        $this->PayHttpClient();
    }

    function PayHttpClient() {
        $this->reqContent = array();
        $this->resContent = "";

        $this->errInfo = "";

        $this->timeOut = 120;

        $this->responseCode = 0;
    }

    //设置请求内容
    function setReqContent($url, $data) {
        $this->reqContent['url'] = $url;
        $this->reqContent['data'] = $data;
    }

    //获取结果内容
    function getResContent() {
        return $this->resContent;
    }

    //获取错误信息
    function getErrInfo() {
        return $this->errInfo;
    }

    //设置超时时间,单位秒
    function setTimeOut($timeOut) {
        $this->timeOut = $timeOut;
    }

    //执行http调用
    function call() {
        //启动一个CURL会话
        $ch = curl_init();

        // 设置curl允许执行的最长秒数
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeOut);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        // 获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        //发送一个常规的POST请求。
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, $this->reqContent['url']);
        //要传送的所有数据
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->reqContent['data']);
        //标头
        $headers = array();
		$headers[] = 'Content-Type: application/x-www-form-urlencoded;charset=UTF-8';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // 执行操作
        $res = curl_exec($ch);
        $this->responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($res == NULL) {
            $this->errInfo = "call http err :" . curl_errno($ch) . " - " . curl_error($ch);
            curl_close($ch);
            return false;
        } else if ($this->responseCode != "200") {
            $this->errInfo = "call http err httpcode=" . $this->responseCode;
            curl_close($ch);
            return false;
        }

        curl_close($ch);
        $this->resContent = $res;


        return true;
    }

    function getResponseCode() {
        return $this->responseCode;
    }

}

?>