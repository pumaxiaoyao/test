﻿<? header("content-Type: text/html; charset=UTF-8");?>
<?php
	
	include_once("./merchant.php");
	
	/*
	initial all the payment parameters,please refer to  the api files about the parameters
    */

		
    $merchant_code = "1118004517";//merchant ID 1118004517,please change to yours
	
	$interface_version = "V3.0";
	
	$sign_type = "RSA-S";	
	
	$service_type ="single_trade_query" ;	
	
	$order_no = "20160518095201";	
	
	$trade_no = "";	
	
	/*
	data encrypt and get the value of "sign parameter",you can ignore it 
	*/

	$signStr = "";
		
	$signStr = $signStr."interface_version=".$interface_version."&";	
	
	$signStr = $signStr."merchant_code=".$merchant_code."&";	
			
	$signStr = $signStr."order_no=".$order_no."&";
	
	
	$signStr = $signStr."service_type=".$service_type;	
			
	if($trade_no != ""){	
			
			$signStr = $signStr."&trade_no=".$trade_no;	
	}
	
	
	$merchant_private_key= openssl_get_privatekey($merchant_private_key);
	
	openssl_sign($signStr,$sign_info,$merchant_private_key,OPENSSL_ALGO_MD5);
	
	$sign = base64_encode($sign_info);
	
	
	
?>
<!-- submit all the API parameters to Dinpay request address https://query.dinpay.com/query -->
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	</head>
	<body onLoad="javascript:document.getElementById('queryForm').submit();">
		<form  id="queryForm" action="https://query.dinpay.com/query" method="post"  target="_self">
			<input type="hidden" name="interface_version" value="<?php echo $interface_version?>" />
			<input type="hidden" name="service_type" value="<?php echo $service_type?>" />
			<input type="hidden" name="merchant_code" value="<?php echo $merchant_code?>" />
			<input type="hidden" name="sign_type" value="<?php echo $sign_type?>" />
			<input type="hidden" name="sign" value="<?php echo $sign?>" />
			<input type="hidden" name="order_no" value="<?php echo $order_no?>" />
			<input type="hidden" name="trade_no" value="<?php echo $trade_no?>" />
		</form>
	</body>
</html>
