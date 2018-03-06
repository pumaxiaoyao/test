<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>
<body>
<?php
	require('signstr.php');
	$userno='alien44';		//20<=len=>6
	$passwd='alien44';		//30<=len=>6
	$opstyle=1;				//1:查看帳戶餘額，2:轉入金額，3:轉出金額，4：鎖定，5：解鎖，6:修改密碼，7:查詢轉入轉出款記錄
	$qty='alien44';				/*轉入轉出金額或要修改的密碼(提交過來的新密碼會重新ＭＤ５加密,長度大於６位，小於30位),不能包含敏感關鍵字及特殊字符：
							如“insert，delete，update，drop，union，backup，load_file，concat，intofile，hex，\\，/”,　　　轉入轉出金額及查詢請傳入orderid			
							轉入、轉出、鎖定、解鎖、修改密碼執行成功會反回：“SUCCESS”　　，不成功則返回：“FAILURE”
							查詢轉入轉出款記錄狀態成功返回：“SUCCESS”　　，不成功則返回：“FAILURE”												*/	
	$orderid=time()+mt_rand(1, 10000); //len<15
	//$orderid='1508516551';
	// $qty='1111hhhh';
	$url=$gs_url.'bm.php';
	$signstr=md5($key1.$userno.$key.$passwd.$opstyle.$qty.$key2.$orderid);    //MD5	
?>
<form method="post" action="<?php echo $url;?>">
<div>
userno:<INPUT  type="text" name="uno" value="<?php echo $userno?>" >
pwd:<INPUT  type="text" name="pw"  value="<?php echo $passwd?>" >
<input type="hidden" value="<?php echo $signstr?>" name="signstr" >
opstyle:<input type="text" value="<?php echo $opstyle?>" name="opstyle" >
qty:<input type="text" value="<?php echo $qty?>" name="qty" >
orderid:<input type="text" value="<?php echo $orderid?>" name="orderid" >
<input type="submit" value="OK"  />
</div>
</form>

</body>
</html>