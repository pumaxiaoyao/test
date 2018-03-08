<?php

require('config.php');
require('class/RequestHandler.class.php');
require('class/ClientResponseHandler.class.php');
require('class/PayHttpClient.class.php');

$resHandler = new ClientResponseHandler();
$reqHandler = new RequestHandler();
$pay = new PayHttpClient();
$cfg = new Config();
$reqHandler->setGateUrl($cfg->C('url'));
$reqHandler->setKey($cfg->C('key'));
$reqHandler->setParameter('service', 'pay.weixin.qrcode'); //接口类型
$reqHandler->setParameter('version', '1.0');
$reqHandler->setParameter('merchantId', $cfg->C('merchantId'));
$reqHandler->setParameter('orderNo', '2018020112301500016');
$reqHandler->setParameter('tradeDate', '20180201');
$reqHandler->setParameter('tradeTime', '123015');
$reqHandler->setParameter('amount', '100');
$reqHandler->setParameter('clientIp', '127.0.0.1');
$reqHandler->setParameter('notifyUrl', $cfg->C('notifyUrl'));
$reqHandler->createSign();

$pay->setReqContent($reqHandler->getGateURL(), $reqHandler->getParameterData());
if ($pay->call()) {
    $resHandler->setContent($pay->getResContent());
    //echo $pay->getResContent();
    $resHandler->setKey($reqHandler->getKey());
    if ($resHandler->verifySign()) {
        if ($resHandler->getParameter('repCode') == '0001') {
            // 扫码使用此网址显示二维码
            // 其他直接跳转至该网址
            echo json_encode($resHandler->getParameter('resultUrl'));
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