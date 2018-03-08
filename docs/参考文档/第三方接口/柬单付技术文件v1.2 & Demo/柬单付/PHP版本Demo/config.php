<?php

class Config {

    private $cfg = array(
        'url' => 'https://pay.jdanfpay.com/gateway',
        'merchantId' => '180001', //测试商户号，商户上线需改为自己正式的
        'key' => 'ec5dd8b1dc5ed9522ab83bbba10b1c4b', //测试密钥，商户上线需改为自己正式的
        'notifyUrl' => 'http://localhost/response.html' //异步回调通知地址，商户上线需改为自己正式的
    );

    public function C($cfgName) {
        return $this->cfg[$cfgName];
    }

}

?>