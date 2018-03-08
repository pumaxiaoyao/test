<?php

require('config.php');
require('class/RequestHandler.class.php');
require('class/ClientResponseHandler.class.php');
require('class/PayHttpClient.class.php');

$resHandler = new ClientResponseHandler();
$reqHandler = new RequestHandler();
$pay = new PayHttpClient();
$cfg = new Config();
$resHandler->setGateUrl($cfg->C('url'));
$resHandler->setKey($cfg->C('key'));
$resHandler->setParameter('service', 'trade.query'); //接口类型
$resHandler->setParameter('version', '1.0');
$resHandler->setParameter('merchantId', $cfg->C('merchantId'));
$resHandler->setParameter('orderNo', '2018011512301500001');
$resHandler->setParameter('tradeDate', '20180115');
$resHandler->setParameter('tradeTime', '123015');
$resHandler->createSign();

$pay->setReqContent($resHandler->getGateURL(), $resHandler->getAllParameters());
if ($pay->call()) {
    $resHandler->setContent($pay->getResContent());
    $resHandler->setKey($this->reqHandler->getKey());
    if ($resHandler->verifySign()) {
        if ($resHandler->getParameter('repCode') == '0001') {
            // 回传支付交易结果，详情请查看文档中的返回结果
            echo json_encode($resHandler->getParameter('resultCode'));
            exit();
        } else {
            echo json_encode(array('status' => 500, 'msg' => 'Error Code:' . $resHandler->getParameter('repCode') . ' Error Message:' . $resHandler->getParameter('repMsg')));
            exit();
        }
    }
} else {
    echo json_encode(array('status' => 500, 'msg' => 'Response Code:' . $pay->getResponseCode() . ' Error Info:' . $pay->getErrInfo()));
}
?>