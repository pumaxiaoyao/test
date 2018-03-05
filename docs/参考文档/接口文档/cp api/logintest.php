<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>
<body>
<?php
	require('signstr.php');
	$userno='htest01';										//20<=len=>6
	$passwd='111hhh';    									//30<=len=>6
	$refurl='http://www.1230kj.com';								//HTTP_REFERER    NOT NULL
	//$url='http://192.168.1.12:30003/cp/login.php';
	$url=$gs_url.'login.php';
	$signstr=md5($key1.$userno.$key.$passwd.$refurl.$key2);    //MD5	
?>
<form method="post" action="<?=$url?>">
<div>
userno：<INPUT  type="text" name="uno" value="<?php echo $userno?>" >
passwd：<INPUT  type="text" name="pw"  value="<?php echo $passwd?>" >
<INPUT  type="hidden" name="refurl"  value="<?php echo $refurl?>" >
<input type="hidden" value="<?php echo $signstr?>" name="signstr" /><br />
<input type="submit" value="login"/>
</div>
</form>


</body>
</html>