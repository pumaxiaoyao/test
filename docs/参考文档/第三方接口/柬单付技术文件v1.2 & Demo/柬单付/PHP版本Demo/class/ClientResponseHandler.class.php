<?php

/**
 * 后台应答类
 * ============================================================================
 * api说明：
 * getKey()/setKey(),获取/设置密钥
 * getContent() / setContent(), 获取/设置原始内容
 * getParameter()/setParameter(),获取/设置参数值
 * getAllParameters(),获取所有参数
 * verifySign(),验证签名,true:是 false:否
 * getDebugInfo(),获取debug信息
 * 
 * ============================================================================
 *
 */
class ClientResponseHandler {

    /** 密钥 */
    var $key;

    /** 应答的参数 */
    var $parameters;

    /** debug信息 */
    var $debugInfo;
    //原始内容
    var $content;

    function __construct() {
        $this->ClientResponseHandler();
    }

    function ClientResponseHandler() {
        $this->key = "";
        $this->parameters = array();
        $this->debugInfo = "";
        $this->content = "";
    }

    /**
     * 获取密钥
     */
    function getKey() {
        return $this->key;
    }

    /**
     * 设置密钥
     */
    function setKey($key) {
        $this->key = $key;
    }

    //设置原始内容
    function setContent($content) {
        $this->content = $content;

        foreach (explode('&', $content) as $couple) {
            list ($key, $val) = explode('=', $couple);
            $this->parameters[$key] = $val;
        }
    }

    //获取原始内容
    function getContent() {
        return $this->content;
    }

    /**
     * 获取参数值
     */
    function getParameter($parameter) {
        return isset($this->parameters[$parameter]) ? $this->parameters[$parameter] : '';
    }

    /**
     * 设置参数值
     */
    function setParameter($parameter, $parameterValue) {
        $this->parameters[$parameter] = $parameterValue;
    }

    /**
     * 获取所有请求的参数
     * @return array
     */
    function getAllParameters() {
        return $this->parameters;
    }

    /**
     * 验证签名,规则是:按参数名称a-z排序,遇到空值的参数不参加签名。
     * true:是
     * false:否
     */
    function verifySign() {
    	$a = $this->parameters;
    	$a['key'] = $this->getKey();
        $signPars = "";
        ksort($a);
        foreach ($a as $k => $v) {
            if ("sign" != $k && "" != $v) {
                $signPars .= $k . "=" . $v . "&";
            }
        }
	    $signPars = substr($signPars, 0, strlen($signPars) - 1);
        $sign = strtolower(md5($signPars));
        echo $signPars.'<br/>';

        $tmpSign = strtolower($this->getParameter("sign"));

        //debug信息
        $this->_setDebugInfo($signPars . " => sign:" . $sign .
                " resSign:" . $this->getParameter("sign"));

        return $sign == $tmpSign;
    }

    /**
     * 获取debug信息
     */
    function getDebugInfo() {
        return $this->debugInfo;
    }

    /**
     * 设置debug信息
     */
    function _setDebugInfo($debugInfo) {
        $this->debugInfo = $debugInfo;
    }
}

?>