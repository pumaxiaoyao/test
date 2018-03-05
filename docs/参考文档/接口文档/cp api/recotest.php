<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>
<body>
<?php
	require('signstr.php');
	
	//********************************gametype**********************************************
	$gametypeAry=array('ssl'=>'上海時時樂','sd'=>'福彩3D','ps'=>'體彩排列三','cqssc'=>'重慶時時彩','lhc'=>'香港六閤彩','klsf'=>'廣東快樂十分','tjklsf'=>'天津快樂十分','tjssc'=>'天津時時彩',
					  'jsks'=>'江苏快３','jlks'=>'吉林快３','pk'=>'北京賽車','cqklsf'=>'重慶幸运农场','klfp'=>'北京快乐8','bjks'=>'北京快３','gxklsf'=>'廣西快樂十分','hnklsf'=>'湖南快樂十分',
					  'sdsyxw'=>'山东11選5','gdsyxw'=>'广东11選5','jlsyxw'=>'吉林11選5','xjssc'=>'新疆時時彩','jssb'=>'江苏骰寶','jlsb'=>'吉林骰寶','xyft'=>'幸運飛艇');
	//********************************End gametype**********************************************
	
	
	
	$gametype='pk';								//	NOT NULL
	$recoid='8108';									//  NULL ,GAME KEY ID
	$date=strtotime('2017-11-23 00:00:00');		//	NOT NULL
	$userno='htest01';									//	NULL
	//sql demo:select * from gametype where id>=$recoid and date>=$date and userno=$userno order by id limit 1000;    Every time 1000 ;
	
	// echo 彩票代码|KEY ID|用户帐号|期數|投注内容|赔率|下注金额|输赢结果|下单时间|结算标志(0:未结算，1:已结算)
	

	$signstr=md5($key1.$userno.$key.$recoid.$date.$gametype.$key2);    //MD5
	
	
	$url=$gs_url.'reco.php';	
?>
<form method="post" action="<?php echo $url;?>">
<div>
    recoid:<input name="recoid" type="text"   value="<?php echo $recoid;?>" />
    <input name="dt" type="hidden"   value="<?php echo $date;?>" />
    userno:<INPUT type="text" name="uno" value="<?php echo $userno;?>" >
    <input type="hidden" value="<?=$signstr?>" name="signstr" />
    gametype:<input type="text" value="<?=$gametype?>" name="gametype" />
    <input type="submit" value="GET RECO"  />
</div>
</form>

</body>
</html>