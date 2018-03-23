<?php

/**
 * 系统配置及常用参数配置脚本，提供后台大部分配置内容
 * 为便于使用，全部载入Global变量中
 *
 */
$GLOBALS["ParsePlayerRecordBalanceType"]= [
    1 => PlayerRecordBalanceType::deposit,
    2 => PlayerRecordBalanceType::withdrawal,
    3 => PlayerRecordBalanceType::bonus,
];


$GLOBALS["mysql"] = array(
    "host" => "localhost",
    "port" => 3306,
    "db" => "gm",
    "user" => "root",
    "pwd" => "123456",
);
$GLOBALS["Titles"] = array(
    "index" => "Alien - 首页",
    "member" => "Alien - 用户",
    "sportsbook" => "Alien - 体育投注",
);
$GLOBALS["WebKeyWords"] = "alienPlay,alienPlay官网,alienPlay体育,alienPlay滚球,alienPlay app,alienPlay nba,alienPlay足球,alienPlay亚洲";
$GLOBALS["WebDescription"] = "alienPlay是全球第一家,全方位app综合娱乐平台,alienPlay非常注重客户体验及个人隐私安全,我们将会在移动客户端,带给大家前所未有的极致体验";
$GLOBALS["retstruc"] = array("code" => 500, "Message" => "", "data" => array());
$GLOBALS["errorRet"] = array("code" => 999, "Message" => "fatal error", "data" => array());

$GLOBALS["GP_Names"] = array(
    "MAIN" => "主账户",
    "IBC" => "沙巴体育",
    "NB" => "牛博彩票",
);
$GLOBALS["Record_Types"] = array(
    0 => array(
        1 => "update",
        2 => "replace",
    ), //common

    1 => array( //login
        1 => "登录",
        2 => "登出",
    ),
    2 => array( //balance
        1 => "存款",
        2 => "取款",
        4 => "转入",
        8 => "转出",
        16 => "返水",
        32 => "红利",
        64 => "存款优惠",
    ),
    3 => array( //apply
        1 => "存款",
        2 => "取款",
    ),
    4 => array( //platformOP
        1 => "转入",
        2 => "转出",
    ),
    5 => array( //bettype
        1 => "投注",
        2 => "投注结果",
    ),
    6 => array( //withdrawalLimitType
        1 => "限制",
    ),
    7 => array( //recordFlowType
        1 => "流水",
    ),
    8 => array( //message type
        1 => "消息",
    ),

);

$GLOBALS["depositOpCode"] = array(
    1 => "待审核",
    2 => "通过",
    3 => "失败",
);

$GLOBALS["roleStatusCode"] = array(
    1 => "未激活",
    2 => "正常",
    3 => "锁定",
    4 => "删除",
);

$GLOBALS["BankTypes"] = array(
    1 => array("sn" => "BOC", "name" => "中国银行"),
    2 => array("sn" => "CCB", "name" => "建设银行"),
    3 => array("sn" => "ICBC", "name" => "工商银行"),
    4 => array("sn" => "ABC", "name" => "农业银行"),
    5 => array("sn" => "CMB", "name" => "招商银行"),
    6 => array("sn" => "CMBC", "name" => "民生银行"),
    10 => array("sn" => "ECITIC", "name" => "中信银行"),
    11 => array("sn" => "HXB", "name" => "华夏银行"),
    12 => array("sn" => "CEB", "name" => "光大银行"),
    15 => array("sn" => "CIB", "name" => "兴业银行"),
);

$GLOBALS["BankStatusOptions"] = array(0 => "未知", 1 => "有效", 2 => "无效");

$GLOBALS["sportsType"] = array(
	1 => "足球",
	2 => "篮球",
	3 => "美式足球",
	4 => "冰上曲棍球",
	5 => "网球",
	6 => "排球",
	7 => "斯诺克/台球",
	8 => "棒球",
	9 => "羽毛球",
	10 => "高尔夫球",
	11 => "赛车",
	12 => "游泳",
	13 => "政治",
	14 => "水球",
	15 => "跳水",
	16 => "拳击",
	17 => "射箭",
	18 => "乒乓球",
	19 => "举重",
	20 => "皮划艇",
	21 => "体操",
	22 => "田径",
	23 => "马术",
	24 => "手球",
	25 => "飞镖",
	26 => "橄榄球",
	28 => "曲棍球",
	29 => "冬季运动",
	30 => "壁球",
	31 => "娱乐",
	32 => "篮网球",
	33 => "自行车",
	34 => "击剑",
	35 => "柔道",
	36 => "现代五项",
	37 => "划船",
	38 => "帆船",
	39 => "射击",
	40 => "跆拳道",
	41 => "铁人三项",
	42 => "角力",
	43 => "电子竞技",
	44 => "泰拳",
	50 => "板球",
	99 => "其他",
	151 => "赛马",
	152 => "赛狗",
	153 => "赛马车",
	154 => "赛马固定赔率",
	161 => "百练赛",
	162 => "娱乐厅",
	180 => "虚拟足球",
	181 => "虚拟赛马",
	182 => "虚拟赛狗",
	183 => "虚拟沙地摩托车",
	184 => "虚拟赛车",
	185 => "虚拟自行车",
	186 => "虚拟网球",
	202 => "快乐彩",
	251 => "娱乐城",
	208 => "电子游戏",
	209 => "迷你电子游戏",
	210 => "手机版电子游戏",
	204 => "Colossus足彩",
	219 => "捕鱼天下",
	220 => "彩票（Keno Lottery）",
	211 => "欧博",
	212 => "Macau Games",
	190 => "虚拟足球联赛",
	191 => "虚拟足球国家杯",
	192 => "虚拟足球欧洲",
	193 => "虚拟篮球",
	194 => "虚拟赛马",
	195 => "虚拟赛狗",
	196 => "虚拟网球",
	199 => "Virtual Sports Parlay",
);

$GLOBALS["oddsType"] = array(
    1 => "马来西亚盘", // Malay Odds
    2 => "香港盘", // Hong Kong Odds
    3 => "Decimal盘", //Decimal Odds
    4 => "印度盘", //Indo Odds
    5 => "美国盘", //American Odds
);

$GLOBALS["betTypeName"] = array(
		//		"title" => "ReplaceX","ReplaceXY",将下注类型中的X和Y进行替换
		//		"detail" =>"GetTeamName","KeyInfo",将下注明细中数据进行对应处理
    "1" => array(
        "name" => "让球",
        "argus" => array(
			"h" => "主队", 
			"a" => "客队",
		),
    ),
    "2" => array(
        "name" => "单双盘",
        "argus" => array(
			"h" => "单", 
			"a" => "双",
		),
    ),
    "3" => array(
        "name" => "大小盘",
        "argus" => array(
			"h" => "大", 
			"a" => "小",
		),
    ),
    "4" => array(		//特殊
        "name" => "波胆",
 		"detail" => "KeyInfo",
   ),
    "5" => array(
        "name" => "全场.标准盘",
        "argus" => array(
			"1" => "主队", 
			"2" => "客队", 
			"x" => "平",
		),
    ),
    "6" => array("name" => "总进球",
        "argus" => array(
			"0-1" => "n2",
			"2-3" => "n1", 
			"4-6" => "其他所有",
			"7-over" => "7 球以上",
		),
	),
    "7" => array(
		"name" => "上半场让球",
        "argus" => array(
			"h" => "主队", 
			"a" => "客队",
		),	
	),
    "8" => array(
		"name" => "上半场大小盘",
        "argus" => array(
			"h" => "大", 
			"a" => "小",
		),
	),
    "9" => array(
		"name" => "混合过关"
	),
    "10" => array(		//特殊
		"name" => "优胜冠军",
		"detail" => "GetTeamName",
	),
	"11" => array(
		"name"=>"总角球数（足球）",
		"argus" => array(
		),
	),
	"12" => array(
		"name"=>"上半场.单双盘",
		"argus" => array(
			"h" => "主队", 
			"a" => "客队",
		),
	),
	"13" => array(
		"name"=>"零失球（足球）",
		"argus" => array(
			"HY"=>"主队有失球",
			"HN"=>"主队没失球",
			"AY"=>"客队有失球",
			"AN"=>"主队没失球",
		),
	),
	"14" => array(
		"name"=>"最先进球/最后进球（足球）",
		"argus" => array(
			"1 : 1"=>"主队最先进球",
			"1 : 2"=>"主队最后进球",
			"2 : 1"=>"客队最先进球",
			"2 : 2"=>"客队最后进球",
			"0 : 0"=>"没有任何进球",
		),
	),
	"15" => array(
		"name"=>"上半场.标准盘",
		"argus" => array(
			"1"=>"主队",
			"x"=>"平局",
			"2"=>"客队",
		),
	),
	"16" => array(
		"name"=>"半场.全场（足球）",
		"argus" => array(
			"00"=>"半场平局/全场平局",
			"01"=>"半场平局/全场主队赢",
			"02"=>"半场平局/全场客队赢",
			"10"=>"半场主队赢/全场平局",
			"11"=>"半场主队赢/全场主队赢",
			"12"=>"半场主队赢/全场客队赢",
			"20"=>"半场客队赢/全场平局",
			"21"=>"半场客队赢/全场主队赢",
			"22"=>"半场客队赢/全场客队赢",
		),
	),
	"17" => array(
		"name"=>"下半场让球（足球）",
		"argus" => array(
			"h"=>"主队",
			"a"=>"客队",
		),
	),
	"18" => array(
		"name"=>"下半场大小盘（足球）",
		"argus" => array(
			"o"=>"大",
			"u"=>"小",
		),
	),
	"19" => array(
		"name"=>"Substitutes",
		"argus" => array(
		),
	),
	"20" => array(
		"name"=>"独赢",
		"argus" => array(
			"h"=>"主队",
			"a"=>"客队",
		),
	),
	"21" => array(
		"name"=>"上半场独赢",
		"argus" => array(
			"h"=>"主队",
			"a"=>"客队",
		),
	),
	"22" => array(
		"name"=>"得下一分（足球）",
		"argus" => array(
			"h"=>"主队",
			"a"=>"客队",
		),
	),
	"23" => array(	//未开设
		"name"=>"下一角球",
		"argus" => array(
		),
	),
	"24" => array(
		"name"=>"双重机会（足球）",
		"argus" => array(
			"1x"=>"主队赢/平局",
			"12"=>"主队赢/客队赢",
			"2x"=>"客队赢/平局",
		),
	),
	"25" => array(
		"name"=>"获胜球队（足球）",
		"argus" => array(
			"h"=>"主队",
			"a"=>"客队",
		),
	),
	"26" => array(
		"name"=>"双方/一方/两者皆不得分（足球）",
		"argus" => array(
			"o"=>"一方得分",
			"n"=>"都没得分",
			"p"=>"双方都得分",
		),
	),
	"27" => array(
		"name"=>"零失球的胜方（足球）",
		"argus" => array(
			"h"=>"主队",
			"a"=>"客队",
		),
	),
	"28" => array(
		"name"=>"三项让分投注（足球）",
		"argus" => array(
			"1"=>"主队",
			"x"=>"平局",
			"2"=>"客队",
		),
	),
	"29" => array(
		"name"=>"串关（其他）",
		"argus" => array(
		),
	),
	"30" => array(
		"name"=>"上半场波胆（足球）",
		"argus" => array(
			"4 : 0"=>"4 比 0 以上",
			"0 : 4"=>"0 比 4 以上",
		),
	),
	"31" => array(		//特殊
		"name"=>"独赢（赛马）",
		"detail" => "GetTeamName",
	),
	"32" => array(		//特殊
		"name"=>"位置（赛马）",
		"detail" => "GetTeamName",
	),
	"33" => array(		//特殊
		"name"=>"独赢/位置（赛马）",
		"detail" => "GetTeamName",
	),
	"41" => array(		//特殊
		"name"=>"独赢.英国彩池（赛马）",
		"detail" => "GetTeamName",
	),
	"42" => array(		//特殊
		"name"=>"位置.英国彩池（赛马）",
		"detail" => "GetTeamName",
	),
	"43" => array(		//特殊
		"name"=>"独赢/位置.英国彩池（赛马）",
		"detail" => "GetTeamName",
	),
	"71" => array(	//不处理
		"name"=>"娱乐城游戏（娱乐城）",
		"argus" => array(
		),
	),
	"81" => array(
		"name"=>"第一球大/小（百练赛）",
		"argus" => array(
			"h"=>"大",
			"a"=>"小",
		),
	),
	"82" => array(
		"name"=>"最后一球大/小（百练赛）",
		"argus" => array(
			"h"=>"大",
			"a"=>"小",
		),
	),
	"83" => array(
		"name"=>"第一球单/双（百炼赛）",
		"argus" => array(
			"h"=>"单",
			"a"=>"双",
		),
	),
	"84" => array(
		"name"=>"最后一球单/双（百练赛）",
		"argus" => array(
			"h"=>"单",
			"a"=>"双",
		),
	),
	"85" => array(
		"name"=>"大/小（百练赛）",
		"argus" => array(
			"h"=>"大",
			"a"=>"小",
		),
	),
	"86" => array(
		"name"=>"单/双（百练赛）",
		"argus" => array(
			"h"=>"单",
			"a"=>"双",
		),
	),
	"87" => array(
		"name"=>"下一个高/低（百练赛）",
		"argus" => array(
			"h"=>"高",
			"a"=>"低",
		),
	),
	"88" => array(
		"name"=>"斗士（百练赛）",
		"argus" => array(
			"h"=>"第二球",
			"a"=>"第三球",
		),
	),
	"89" => array(
		"name"=>"下一球组合（百练赛）",
		"argus" => array(
			"1 : 1"=>"大单",
			"1 : 2"=>"大双",
			"2 : 1"=>"小单",
			"2 : 2"=>"小双",
		),
	),
	"90" => array(	//特殊
		"name"=>"数盘（百练赛）",
		"detail" => "KeyInfo",
	),
	"121" => array(
		"name"=>"主队（不获胜球队）（足球）",
		"argus" => array(
			"x"=>"平局",
			"a"=>"客队",
		),
	),
	"122" => array(
		"name"=>"客队（不获胜球队）（足球）",
		"argus" => array(
			"H"=>"主队",
			"X"=>"平局",
		),
	),
	"123" => array(
		"name"=>"和局/不是和局（足球）",
		"argus" => array(
			"h"=>"和局",
			"a"=>"非和局",
		),
	),
	"124" => array(
		"name"=>"全场1X2亚洲盘（足球）",
		"argus" => array(
			"1"=>"主队",
			"x"=>"平局",
		),
	),
	"125" => array(
		"name"=>"上半场1X2亚洲盘（足球）",
		"argus" => array(
			"1"=>"主队",
			"x"=>"平局",
			"2"=>"客队",
		),
	),
	"126" => array(
		"name"=>"上半场总进球（足球）",
		"argus" => array(
			"0-1"=>"0-1 球",
			"2-3"=>"2-3 球",
			"4-over"=>"4 球以上",
		),
	),
	"127" => array(
		"name"=>"上半场最先进球/最后进球（足球）",
		"argus" => array(
			"11"=>"主队最先进球",
			"12"=>"主队最后进球",
			"21"=>"客队最先进球",
			"22"=>"客队最后进球",
			"00"=>"没有任何进球",
		),
	),
	"128" => array(
		"name"=>"半场/全场单/双（足球）",
		"argus" => array(
			"oo"=>"半场单，全场单",
			"oe"=>"半场单，全场双",
			"eo"=>"半场双，全场单",
			"ee"=>"半场双，全场双",
		),
	),
	"133" => array(
		"name"=>"主队胜出两个半场（足球）",
		"argus" => array(
			"y"=>"是",
			"n"=>"否",
		),
	),
	"134" => array(
		"name"=>"客队胜出两个半场（足球）",
		"argus" => array(
			"y"=>"是",
			"n"=>"否",
		),
	),
	"135" => array(
		"name"=>"点球决胜（足球）",
		"argus" => array(
			"y"=>"是",
			"n"=>"否",
		),
	),
	"140" => array(
		"name"=>"进球最多的半场（足球）",
		"argus" => array(
			"1h"=>"上半场",
			"2h"=>"下半场",
			"tie"=>"一样多",
		),
	),
	"141" => array(
		"name"=>"主队进球最多的半场（足球）",
		"argus" => array(
			"1h"=>"上半场",
			"2h"=>"下半场",
			"tie"=>"一样多",
		),
	),
	"142" => array(
		"name"=>"客队进球最多的半场（足球）",
		"argus" => array(
			"1h"=>"上半场",
			"2h"=>"下半场",
			"tie"=>"一样多",
		),
	),
	"143" => array(			//	todo:细节等待官方文档补充
		"name"=>"上半场分数/总进球数",
		"detail" => "KeyInfo",
	),
	"144" => array(
		"name"=>"赛果/总进球大小（足球）",
		"argus" => array(
			"HU"=>"主场/小",
			"HO"=>"主场/大",
			"DU"=>"平局/小",
			"DO"=>"平局/大",
			"AU"=>"客队/小",
			"AO"=>"客队/大",
		),
	),
	"145" => array(
		"name"=>"两队皆进球（足球）",
		"argus" => array(
			"y"=>"是",
			"n"=>"否",
		),
	),
	"146" => array(
		"name"=>"下半场两队皆进球（足球）",
		"argus" => array(
			"y"=>"是",
			"n"=>"否",
		),
	),
	"147" => array(
		"name"=>"主队两个半场皆进球（足球）",
		"argus" => array(
			"y"=>"是",
			"n"=>"否",
		),
	),
	"148" => array(
		"name"=>"客队两个半场皆进球（足球）",
		"argus" => array(
			"y"=>"是",
			"n"=>"否",
		),
	),
	"149" => array(
		"name"=>"主队胜出其中一个半场（足球）",
		"argus" => array(
			"y"=>"是",
			"n"=>"否",
		),
	),
	"150" => array(
		"name"=>"客队胜出其中一个半场（足球）",
		"argus" => array(
			"y"=>"是",
			"n"=>"否",
		),
	),
	"151" => array(
		"name"=>"上半场双重机会（足球）",
		"argus" => array(
			"1x"=>"主队或平局",
			"2x"=>"客队或平局",
			"12"=>"主队或客队",
		),
	),
	"152" => array(		//特殊
		"name"=>"上半场/全场波胆（足球）",
		"detail" => "KeyInfo",
	),
	"153" => array(
		"name"=>"局数获胜者（网球）",
		"argus" => array(
			"h"=>"主队",
			"a"=>"客队",
		),
	),
	"154" => array(//特殊
		"name"=>"第x盘获胜者（网球）",
		"title" => "ReplaceX",
		"argus" => array(
			"h"=>"主队",
			"a"=>"客队",
		),
	),
	"155" => array(//特殊
		"name"=>"第x盘局数获胜者（网球）",
		"title" => "ReplaceX",
		"argus" => array(
			"h"=>"主队",
			"a"=>"客队",
		),
	),
	"156" => array(//特殊
		"name"=>"第x盘局数大小盘（网球）",
		"title" => "ReplaceX",
		"argus" => array(
			"h"=>"主队",
			"a"=>"客队",
		),
	),
	"157" => array(
		"name"=>"单双盘（足球）",
		"argus" => array(
			"h"=>"单",
			"a"=>"双",
		),
	),
	"159" => array( //特殊
		"name"=>"准确的总进球（足球）",
		"detail" => "KeyInfo",
	),
	"160" => array(
		"name"=>"下一个进球（足球）",
		"argus" => array(
			"1"=>"主队",
			"x"=>"无",
			"2"=>"客队",
		),
	),
	"161" => array(//特殊
		"name"=>"准确的主队总进球（足球）",
		"detail" => "KeyInfo",
	),
	"162" => array(//特殊
		"name"=>"准确的客队总进球（足球）",
		"detail" => "KeyInfo",
	),
	"163" => array(
		"name"=>"赛果/总进球大小（足球）",
		"argus" => array(
			"HU"=>"主队/小",
			"HO"=>"主队/大",
			"DU"=>"平局/小",
			"DO"=>"平局/大",
			"AU"=>"客队/小",
			"AO"=>"客队/大",
		),
	),
	"164" => array(
		"name"=>"加时赛下一个进球（足球）",
		"argus" => array(
			"1"=>"主队",
			"x"=>"无",
			"2"=>"客队",
		),
	),
	"165" => array(//特殊
		"name"=>"加时赛上半场波胆（足球）",
		"detail" => "KeyInfo",
	),
	"166" => array(//特殊
		"name"=>"加时赛波胆（足球）",
		"detail" => "KeyInfo",
	),
	"167" => array(
		"name"=>"加时赛上半场1x2（足球）",
		"argus" => array(
			"1"=>"加时赛上半场主队",
			"x"=>"加时赛上半场平局",
			"2"=>"加时赛上半场客队",
		),
	),
	"168" => array(
		"name"=>"哪一队可晋级（足球）",
		"argus" => array(
			"h"=>"主队",
			"a"=>"客队",
		),
	),
	"169" => array(//特殊
		"name"=>"下一个进球时间（足球）",
		"detail" => "KeyInfo",
	),
	"170" => array(
		"name"=>"哪队进球（足球）",
		"argus" => array(
			"H"=>"主队",
			"A"=>"客队",
			"B"=>"都有",
			"N"=>"都无",
		),
	),
	"171" => array(
		"name"=>"净胜球数（足球）",
		"argus" => array(
			"H1"=>"主队净赢1球",
			"H2"=>"主队净赢2球",
			"H3"=>"主队净赢3球",
			"D"=>"平局",
			"A1"=>"客队净赢1球",
			"A2"=>"客队净赢2球",
			"A3"=>"客队净赢3球",
			"NG"=>"无进球",
		),
	),
	"172" => array(
		"name"=>"赛果/最先进球的球队（足球）",
		"argus" => array(
			"HH" => "主队/主队",
			"HD" => "主队/平局",
			"HA" => "主队/客队",
			"AH" => "客队/主队",
			"AD" => "客队/平局",
			"AA" => "客队/客队",
			"NO" => "无进球",
		),
	),
	"173" => array(
		"name"=>"加时赛–是/否（足球）",
		"argus" => array(
			"Y" => "是",
			"N" => "否",
		),
	),
	"174" => array(
		"name"=>"加时赛/进球（足球）",
		"argus" => array(
			"Y" => "是",
			"N" => "否",
		),
	),
	"175" => array(
		"name"=>"获胜的方式（足球）",
		"argus" => array(
			"HR" => "主队/正规赛",
			"HE" => "主队/加时赛",
			"HP" => "主队/点球决胜",
			"AR" => "客队/正规赛",
			"AE" => "客队/加时赛",
			"AP" => "客队/点球决赛",
		),
	),
	"176" => array(
		"name"=>"前10分钟1X2（足球）",
		"argus" => array(
			"1" => "主队",
			"X" => "平局",
			"2" => "客队",
		),
	),
	"177" => array(
		"name"=>"下半场1X2（足球）",
		"argus" => array(
			"1" => "下半场主队",
			"X" => "下半身平局",
			"2" => "下半场客队",
		),
	),
	"178" => array(
		"name"=>"下半场大小盘（足球）",
		"argus" => array(
			"O" => "大",
			"U" => "小",
		),
	),
	"179" => array(		//特殊
		"name"=>"准确的上半场总进球（足球）",
		"detail" => "KeyInfo",
	),
	"180" => array(
		"name"=>"上半场下一个进球（足球）",
		"argus" => array(
			"1" => "主队",
			"x" => "无",
			"2" => "客队",
		),
	),
	"181" => array(		//特殊
		"name"=>"上半场准确的主队进球（足球）",
		"detail" => "KeyInfo",
	),
	"182" => array(		//特殊
		"name"=>"上半场准确的客队进球（足球）",
		"detail" => "KeyInfo",
	),
	"184" => array(
		"name"=>"下半场单双盘（足球）",
		"argus" => array(
			"O" => "单",
			"E" => "双",
		),
	),
	"185" => array(
		"name"=>"下半场获胜球队（足球）",
		"argus" => array(
			"h" => "主队",
			"a" => "客队",
		),
	),
	"186" => array(
		"name"=>"下半场双重机会（足球）",
		"argus" => array(
			"HD" => "主队/平局",
			"HA" => "主隊/客隊",
			"DA" => "平局/客隊",
		),
	),
	"187" => array(		//特殊
		"name"=>"准确的下半场总进球（足球）",
		"detail" => "KeyInfo",
	),
	"188" => array(
		"name"=>"上半场双方球队皆进球（足球）",
		"argus" => array(
			"Y" => "是",
			"N" => "否",
		),
	),
	"189" => array(
		"name"=>"两个半场大1.5球–是/否（足球）",
		"argus" => array(
			"Y" => "是",
			"N" => "否",
		),
	),
	"190" => array(
		"name"=>"两个半场小1.5球–是/否（足球）",
		"argus" => array(
			"Y" => "是",
			"N" => "否",
		),
	),
	"191" => array(
		"name"=>"上半场获胜球队（足球）",
		"argus" => array(
			"h" => "主队",
			"a" => "客队",
		),
	),
	"192" => array(		//特殊
		"name"=>"特定时间的第一个进球（10分钟）（足球）",
		"detail" => "KeyInfo",
	),
	"193" => array(		//特殊
		"name"=>"特定时间的第一个进球（15分钟）（足球）",
		"detail" => "KeyInfo",
	),
	"194" => array(
		"name"=>"角球单双盘（足球）",
		"argus" => array(
			"O" => "单",
			"E" => "双",
		),
	),
	"195" => array(		//特殊
		"name"=>"主队准确的角球（足球）",
		"detail" => "KeyInfo",
	),
	"196" => array(		//特殊
		"name"=>"客队准确的角球（足球）",
		"detail" => "KeyInfo",
	),
	"197" => array(
		"name"=>"主队角球数大小盘（足球）",
		"argus" => array(
			"O" => "大",
			"U" => "小",
		),
	),
	"198" => array(
		"name"=>"客队角球数大小盘（足球）",
		"argus" => array(
			"O" => "大",
			"U" => "小",
		),
	),
	"199" => array(	//特殊
		"name"=>"角球总数（足球）",
		"detail" => "KeyInfo",
	),
	"200" => array(	//特殊
		"name"=>"上半场主队准确的角球数（足球）",
		"detail" => "KeyInfo",
	),
	"201" => array(	//特殊
		"name"=>"上半场客队准确的角球数（足球）",
		"detail" => "KeyInfo",
	),
	"202" => array(	//特殊
		"name"=>"上半场角球总数（足球）",
		"detail" => "KeyInfo",
	),
	"203" => array(
		"name"=>"上半场角球总数单双盘（足球）",
		"argus" => array(
			"O" => "单",
			"E" => "双",
		),
	),
	"204" => array(
		"name"=>"上半场主队角球数大小盘（足球）",
		"argus" => array(
			"O" => "大",
			"U" => "小",
		),
	),
	"205" => array(
		"name"=>"上半场客队角球数大小盘（足球）",
		"argus" => array(
			"O" => "大",
			"U" => "小",
		),
	),
	"206" => array(
		"name"=>"第一个角球（足球）",
		"argus" => array(
			"H" => "主队",
			"A" => "客队",
			"N" => "无",
		),
	),
	"207" => array(
		"name"=>"上半场第一个角球（足球）",
		"argus" => array(
			"H" => "主队",
			"A" => "客队",
			"N" => "无",
		),
	),
	"208" => array(
		"name"=>"最后一个角球（足球）",
		"argus" => array(
			"H" => "主队",
			"A" => "客队",
			"N" => "无",
		),
	),
	"209" => array(
		"name"=>"上半场最后一个角球（足球）",
		"argus" => array(
			"H" => "主队",
			"A" => "客队",
			"N" => "无",
		),
	),
	"210" => array(
		"name"=>"球员驱逐离场（足球）",
		"argus" => array(
			"Y" => "是",
			"N" => "否",
		),
	),
	"211" => array(
		"name"=>"上半场球员驱逐离场（足球）",
		"argus" => array(
			"Y" => "是",
			"N" => "否",
		),
	),
	"212" => array(
		"name"=>"主队球员驱逐离场（足球）",
		"argus" => array(
			"Y" => "是",
			"N" => "否",
		),
	),
	"213" => array(
		"name"=>"上半场主队球员驱逐离场（足球）",
		"argus" => array(
			"Y" => "是",
			"N" => "否",
		),
	),
	"214" => array(
		"name"=>"客队球员驱逐离场（足球）",
		"argus" => array(
			"Y" => "是",
			"N" => "否",
		),
	),
	"215" => array(
		"name"=>"上半场客队球员驱逐离场（足球）",
		"argus" => array(
			"Y" => "是",
			"N" => "否",
		),
	),
	"221" => array(
		"name"=>"下一分钟（足球）",
		"argus" => array(
			"2" => "进球-是",
			"4" => "角球-是",
			"8" => "任意球",
			"16" => "龙门球",
			"32" => "界外球",
		),
	),
	"222" => array(
		"name"=>"下五分钟（足球）",
		"argus" => array(
			"2" => "进球-是",
			"-2" => "进球-否",
			"4" => "角球-是",
			"-4" => "角球-否",
			"128" => "点球",
		),
	),
	"223" => array(
		"name"=>"下一分钟首先会发生什么（足球）",
		"argus" => array(
			"1" => "无",
			"2" => "进球-是",
			"4" => "角球-是",
			"8" => "任意球",
			"16" => "龙门球",
			"32" => "界外球",
		),
	),
	"224" => array(
		"name"=>"下五分钟首先会发生什么（足球）",
		"argus" => array(
			"1" => "无",
			"2" => "进球-是",
			"4" => "角球-是",
			"64" => "罚牌",
			"128" => "点球",
		),
	),
	"225" => array(
		"name"=>"下一分钟定点球（足球）",
		"argus" => array(
			"1" => "否",
			"44" => "是",
		),
	),
	"401" => array(
		"name"=>"主队大小盘",
		"argus" => array(
			"o" => "大",
			"u" => "小",
		),
	),
	"402" => array(
		"name"=>"客队大小盘",
		"argus" => array(
			"o" => "大",
			"u" => "小",
		),
	),
	"403" => array(
		"name"=>"上半场主队大小盘",
		"argus" => array(
			"o" => "大",
			"u" => "小",
		),
	),
	"404" => array(
		"name"=>"上半场客队大小盘",
		"argus" => array(
			"o" => "大",
			"u" => "小",
		),
	),
	"405" => array(//特殊
		"name"=>"下半场波胆（足球）",
		"detail" => "KeyInfo",
	),
	"406" => array(//特殊
		"name"=>"准确的总进球（足球）",
		"detail" => "KeyInfo",
	),
	"407" => array(//特殊
		"name"=>"准确的主队总进球（足球）",
		"detail" => "KeyInfo",
	),
	"408" => array(
		"name"=>"净胜球数（足球）",
		"argus" => array(
			"H1" => "主队净赢1球",
			"H2" => "主队净赢2球",
			"H3" => "主队净赢3球",
			"D" => "平局",
			"A1" => "客队净赢1球",
			"A2" => "客队净赢2球",
			"A3" => "客队净赢3球",
			"NG" => "无进球",
		),
	),
	"409" => array(//特殊
		"name"=>"准确的客队总进球（足球）",
		"detail" => "KeyInfo",
	),
	"410" => array(
		"name"=>"上半场双重机会（足球）",
		"argus" => array(
			"1x" => "主队或平局",
			"2x" => "客队或平局",
			"12" => "主队或客队",
		),
	),
	"411" => array(
		"name"=>"上半场获胜球队（足球）",
		"argus" => array(
			"h" => "主队",
			"a" => "客队",
		),
	),
	"412" => array(//特殊
		"name"=>"准确上半场总进球（足球）",
		"detail" => "KeyInfo",
	),
	"413" => array(//特殊
		"name"=>"波胆（足球）",
		"detail" => "KeyInfo",
	),
	"414" => array(//特殊
		"name"=>"上半场波胆（足球）",
		"detail" => "KeyInfo",
	),
	"416" => array(//特殊
		"name"=>"上半场/全场波胆（足球）",
		"detail" => "KeyInfo",
	),
	"417" => array(
		"name"=>"两队皆进球/赛果（足球）",
		"argus" => array(
			"yh" => "对/主场",
			"ya" => "對/客隊",
			"yd" => "對/和局",
			"nh" => "否/客隊",
			"na" => "否/客隊",
			"nd" => "否/平局",
		),
	),
	"418" => array(
		"name"=>"两队皆进球/总进球数（足球）",
		"argus" => array(
			"yo" => "對&大於",
			"yu" => "對&小於",
			"no" => "否&大於",
			"nu" => "否&小於",
		),
	),
	"419" => array(
		"name"=>"预测进第一个球的半场（足球）",
		"argus" => array(
			"1h" => "上半場",
			"2h" => "下半場",
			"n" => "上下半場都沒有進球",
		),
	),
	"420" => array(
		"name"=>"主队于哪个半场先进球（足球）",
		"argus" => array(
			"1h" => "上半場",
			"2h" => "下半場",
			"n" => "上下半場都沒有進球",
		),
	),
	"421" => array(
		"name"=>"客队于哪个半场先进球（足球）",
		"argus" => array(
			"1h" => "上半場",
			"2h" => "下半場",
			"n" => "上下半場都沒有進球",
		),
	),
	"422" => array(
		"name"=>"最先进两个球的球队（足球）",
		"argus" => array(
			"h" => "主队",
			"a" => "客队",
			"n" => "没有",
		),
	),
	"423" => array(
		"name"=>"最先进三个球的球队（足球）",
		"argus" => array(
			"h" => "主队",
			"a" => "客队",
			"n" => "没有",
		),
	),
	"424" => array(
		"name"=>"第一个进球方式（足球）",
		"argus" => array(
			"s" => "射门",
			"h" => "头球",
			"p" => "点球",
			"fk" => "任意球",
			"og" => "乌龙球",
			"ng" => "没进球",
		),
	),
	"425" => array(
		"name"=>"落后反超获胜的球队（足球）",
		"argus" => array(
			"h" => "主队",
			"a" => "客队",
		),
	),
	"426" => array(
		"name"=>"上半场净胜球数（足球）",
		"argus" => array(
			"h1" => "主队赢1球",
			"h2+" => "主队赢2球以上",
			"d" => "进球且平局",
			"a1" => "客队赢1球以上",
			"a2+" => "客队赢2球以上",
			"ng" => "没进球",
		),
	),
	"427" => array(
		"name"=>"上半场双方球队皆进球（足球）",
		"argus" => array(
			"Y" => "是",
			"N" => "否",
		),
	),
	"428" => array(
		"name"=>"下半场单双盘（足球）",
		"argus" => array(
			"O" => "单",
			"E" => "双",
		),
	),
	"429" => array(	//特殊
		"name"=>"准确的下半场总进球（足球）",
		"detail" => "KeyInfo",
	),
	"430" => array(
		"name"=>"下半场1X2（足球）",
		"argus" => array(
			"1" => "下半场主队",
			"X" => "下半身平局",
			"2" => "下半场客队",
		),
	),
	"431" => array(
		"name"=>"下半场双重机会（足球）",
		"argus" => array(
			"1" => "下半场主队",
			"X" => "下半身平局",
			"2" => "下半场客队",
		),
	),
	"432" => array(
		"name"=>"下半场获胜球队（足球）",
		"argus" => array(
			"h" => "主队",
			"a" => "客队",
		),
	),
	"433" => array(
		"name"=>"下半场两队皆进球（足球）",
		"argus" => array(
			"y" => "是",
			"n" => "否",
		),
	),
	"434" => array(
		"name"=>"两个半场大1.5球–是/否（足球）",
		"argus" => array(
			"y" => "是",
			"n" => "否",
		),
	),
	"435" => array(
		"name"=>"两个半场小1.5球–是/否（足球）",
		"argus" => array(
			"y" => "是",
			"n" => "否",
		),
	),
	"436" => array(
		"name"=>"主队两个半场皆进球（足球）",
		"argus" => array(
			"y" => "是",
			"n" => "否",
		),
	),
	"437" => array(
		"name"=>"客队两个半场皆进球（足球）",
		"argus" => array(
			"y" => "是",
			"n" => "否",
		),
	),
	"438" => array(
		"name"=>"主队胜出两个半场（足球）",
		"argus" => array(
			"y" => "是",
			"n" => "否",
		),
	),
	"439" => array(
		"name"=>"客队胜出两个半场（足球）",
		"argus" => array(
			"y" => "是",
			"n" => "否",
		),
	),
	"440" => array(
		"name"=>"主队胜出其中一个半场（足球）",
		"argus" => array(
			"y" => "是",
			"n" => "否",
		),
	),
	"441" => array(
		"name"=>"客队胜出其中一个半场（足球）",
		"argus" => array(
			"y" => "是",
			"n" => "否",
		),
	),
	"442" => array(
		"name"=>"进球最多的半场（足球）",
		"argus" => array(
			"1h" => "上半场",
			"2h" => "下半场",
			"tie" => "一样多",
		),
	),
	"443" => array(
		"name"=>"主队进球最多的半场（足球）",
		"argus" => array(
			"1h" => "上半场",
			"2h" => "下半场",
			"tie" => "一样多",
		),
	),
	"444" => array(
		"name"=>"客队进球最多的半场（足球）",
		"argus" => array(
			"1h" => "上半场",
			"2h" => "下半场",
			"tie" => "一样多",
		),
	),
	"445" => array(
		"name"=>"两队皆进球上半场/下半场（足球）",
		"argus" => array(
			"yy" => "有/有",
			"yn" => "有/沒有",
			"ny" => "沒有/有",
			"nn" => "沒有/沒有",
		),
	),
	"446" => array(
		"name"=>"主队均进球上半场/下半场（足球）",
		"argus" => array(
			"yy" => "有/有",
			"yn" => "有/沒有",
			"ny" => "沒有/有",
			"nn" => "沒有/沒有",
		),
	),
	"447" => array(
		"name"=>"客队均进球上半场/下半场（足球）",
		"argus" => array(
			"yy" => "有/有",
			"yn" => "有/沒有",
			"ny" => "沒有/有",
			"nn" => "沒有/沒有",
		),
	),
	"448" => array(		//细节等待官方文档补充
		"name"=>"最后进球的队",
		"detail" => "KeyInfo",
		),
	),
	"449" => array(		//细节等待官方文档补充
		"name"=>"双重机会/总进球数",
		"detail" => "KeyInfo",
		),
	),
	"450" => array(		//细节等待官方文档补充
		"name"=>"单双盘/总进球数",
		"detail" => "KeyInfo",
		),
	),
	"451" => array(		//细节等待官方文档补充
		"name"=>"两队皆进球/双重机会",
		"detail" => "KeyInfo",
		),
	),
	"452" => array(		//细节等待官方文档补充
		"name"=>"进球最多的半场(双项)",
		"detail" => "KeyInfo",
		),
	),
	"453" => array(		//细节等待官方文档补充
		"name"=>"上半场三项让分投注",
		"detail" => "KeyInfo",
		),
	),
	"454" => array(		//细节等待官方文档补充
		"name"=>"双重机会/最先进球的队",
		"detail" => "KeyInfo",
		),
	),
	"455" => array(		//细节等待官方文档补充
		"name"=>"第一个进球时段",
		"detail" => "KeyInfo",
		),
	),
	"456" => array(		//细节等待官方文档补充
		"name"=>"上半场两队皆进球/赛果",
		"detail" => "KeyInfo",
		),
	),
	"457" => array(		//细节等待官方文档补充
		"name"=>"上半场两队皆进球/总进球数",
		"detail" => "KeyInfo",
		),
	),
	"458" => array(		//细节等待官方文档补充
		"name"=>"亚洲1x2",
		"detail" => "KeyInfo",
		),
	),
	"459" => array(		//细节等待官方文档补充
		"name"=>"上半场亚洲1x2",
		"detail" => "KeyInfo",
		),
	),
	"460" => array(		//细节等待官方文档补充
		"name"=>"哪个球队会赢5+球",
		"detail" => "KeyInfo",
		),
	),
	"461" => array(
		"name"=>"主队大小盘",
		"argus" => array(
			"o" => "大",
			"u" => "小",
		),
	),
	"462" => array(
		"name"=>"客队大小盘",
		"argus" => array(
			"o" => "大",
			"u" => "小",
		),
	),
	"463" => array(
		"name"=>"上半场主队大小盘",
		"argus" => array(
			"o" => "大",
			"u" => "小",
		),
	),
	"464" => array(
		"name"=>"上半场客队大小盘",
		"argus" => array(
			"o" => "大",
			"u" => "小",
		),
	),
	"501" => array(
		"name"=>"比赛获胜者（板球）",
		"argus" => array(
			"H" => "主队",
			"A" => "客队",
		),
	),
	"601" => array(	//特殊
		"name"=>"净胜分数14项（篮球）",
		"detail" => "KeyInfo",
	),
	"602" => array(	//特殊
		"name"=>"净胜分数12项（篮球）",
		"detail" => "KeyInfo",
	),
	"603" => array(
		"name"=>"赛节得分最高的球队（篮球）",
		"argus" => array(
			"H" => "主队",
			"A" => "客队",
		),
	),
	"604" => array(
		"name"=>"最先得分球队（篮球）",
		"argus" => array(
			"H" => "主队",
			"A" => "客队",
		),
	),
	"605" => array(
		"name"=>"最后得分球队（篮球）",
		"argus" => array(
			"H" => "主队",
			"A" => "客队",
		),
	),
	"606" => array(//特殊
		"name"=>"上半场首先获得X分（篮球）",
		"title" => "ReplaceX",
		"argus" => array(
			"H" => "主队",
			"A" => "客队",
		),
	),
	"607" => array(//特殊
		"name"=>"下半场首先获得X分（篮球）",
		"title" => "ReplaceX",
		"argus" => array(
			"H" => "主队",
			"A" => "客队",
		),
	),
	"608" => array(//特殊
		"name"=>"上半场净胜分数13项（篮球）",
		"detail" => "KeyInfo",
	),
	"609" => array(//特殊
		"name"=>"第X节让球盘（篮球）",
		"title" => "ReplaceX",
		"argus" => array(
			"H" => "主队",
			"A" => "客队",
		),
	),
	"610" => array(//特殊
		"name"=>"第X节大小盘（篮球）",
		"title" => "ReplaceX",
		"argus" => array(
			"O" => "大",
			"U" => "小",
		),
	),
	"611" => array(//特殊
		"name"=>"第X节单双盘（篮球）",
		"title" => "ReplaceX",
		"argus" => array(
			"O" => "单",
			"U" => "双",
		),
	),
	"612" => array(//特殊
		"name"=>"第X节独赢（篮球）",
		"title" => "ReplaceX",
		"argus" => array(
			"H" => "主队",
			"A" => "客队",
		),
	),
	"613" => array(//特殊
		"name"=>"第X节首先获得Y分（篮球）",
		"title" => "ReplaceXY",
		"argus" => array(
			"H" => "主队",
			"A" => "客队",
		),
	),
	"614" => array(//特殊
		"name"=>"第X节的净胜分数7项（篮球）",
		"detail" => "KeyInfo",
	),
	"615" => array(//特殊
		"name"=>"第X节主队大小盘（篮球）",
		"title" => "ReplaceX",
		"argus" => array(
			"O" => "大",
			"U" => "小",
		),
	),
	"616" => array(//特殊
		"name"=>"第X节客队大小盘（篮球）",
		"title" => "ReplaceX",
		"argus" => array(
			"O" => "大",
			"U" => "小",
		),
	),
	"617" => array(//特殊
		"name"=>"第X节最后得分球队（篮球）",
		"title" => "ReplaceX",
		"argus" => array(
			"H" => "主队",
			"A" => "客队",
		),
	),
	"1011" => array(
		"name"=>"捕鱼天下（捕鱼天下）",
	),
	"1031" => array(
		"name"=>"Max5D 60（彩票）",
	),
	"1032" => array(
		"name"=>"Max5D 90（彩票）",
	),
	"1033" => array(
		"name"=>"Max3D 60（彩票）",
	),
	"1034" => array(
		"name"=>"Max3D 90（彩票）",
	),
	"1035" => array(
		"name"=>"Max11x5 60（彩票）",
	),
	"1036" => array(
		"name"=>"Max11x5 90（彩票）",
	),
	"1037" => array(
		"name"=>"MaxDice 60（彩票）",
	),
	"1201" => array(
		"name"=>"让球（虚拟足球）",
	),
	"1203" => array(
		"name"=>"大小盘2.5（虚拟足球）",
	),
	"1204" => array(
		"name"=>"波胆（虚拟足球）",
	),
	"1205" => array(
		"name"=>"1X2（虚拟足球）",
	),
	"1206" => array(
		"name"=>"总进球（虚拟足球）",
	),
	"1220" => array(
		"name"=>"独赢（虚拟网球）",
	),
	"1224" => array(
		"name"=>"双重机会（虚拟足球）",
	),
	"1231" => array(
		"name"=>"独赢（虚拟赛事）",
	),
	"1232" => array(
		"name"=>"位置（虚拟赛事）",
	),
	"1233" => array(
		"name"=>"独赢/位置（虚拟赛事）",
	),
	"1235" => array(
		"name"=>"波胆（虚拟网球）",
	),
	"1236" => array(
		"name"=>"总得分（虚拟网球）",
	),
	"1237" => array(
		"name"=>"连赢（虚拟赛车）",
	),
	"1238" => array(
		"name"=>"三重彩（虚拟赛车）",
	),
	"1301" => array(
		"name"=>"独赢&获胜者",
		"argus" => array(
			"h" => "主队",
			"a" => "客队",
		),
	),
	"1302" => array(		//特殊
		"name"=>"盘数波胆",
		"detail" => "KeyInfo",
	),
	"1303" => array(
		"name"=>"局数单双盘",
		"argus" => array(
			"h" => "主队",
			"a" => "客队",
		),
	),
	"1305" => array(
		"name"=>"盘数获胜者",
		"argus" => array(
			"h" => "单",
			"a" => "双",
		),
	),
	"1306" => array(
		"name"=>"局数大小盘",
		"argus" => array(
			"o" => "大",
			"u" => "小",
		),
	),
	"1308" => array(
		"name"=>"局数获胜者",
		"argus" => array(
			"h" => "主队",
			"a" => "客队",
		),
	),
	"1311" => array(	//特殊
		"name"=>"第X盘获胜者（3rd）",
		"title" => "ReplaceX",
		"argus" => array(
			"h" => "主队",
			"a" => "客队",
		),
	),
	"1312" => array(	//特殊
		"name"=>"第X盘大小盘（3rd）",
		"title" => "ReplaceX",
		"argus" => array(
			"h" => "主队",
			"a" => "客队",
		),
	),
	"1316" => array(	//特殊
		"name"=>"第X盘局数获胜者",
		"title" => "ReplaceX",
		"argus" => array(
			"h" => "主队",
			"a" => "客队",
		),
	),
	"1317" => array(	//特殊
		"name"=>"第X盘波胆",
		"title" => "ReplaceX",
		"detail" => "KeyInfo",
	),
	"1318" => array(	//特殊
		"name"=>"第X盘局数单双盘",
		"title" => "ReplaceX",
		"argus" => array(
			"o" => "单",
			"e" => "双",
		),
	),
	"1324" => array(	//特殊
		"name"=>"第X盘-第Y局获胜者",
		"title" => "ReplaceXY",
		"argus" => array(
			"h" => "主队",
			"a" => "客队",
		),
	),
	"2101" => array(
		"name"=>"百家乐（RNG–RNG Game）",
	),
	"2102" => array(
		"name"=>"斗大（RNG–RNG Game）",
	),
	"2103" => array(
		"name"=>"21点（RNG–RNG Game）",
	),
	"2104" => array(
		"name"=>"扑克三重奏（RNG–RNG Game）",
	),
	"2105" => array(
		"name"=>"赌场德州扑克（RNG–RNG Game）",
	),
	"2106" => array(
		"name"=>"牌九扑克（RNG–RNG Game）",
	),
	"2107" => array(
		"name"=>"迷你轮盘（RNG–RNG Game）",
	),
	"2108" => array(
		"name"=>"超级轮盘（RNG–RNG Game）",
	),
	"2109" => array(
		"name"=>"骰宝（RNG–RNG Game）",
	),
	"2110" => array(
		"name"=>"对J高手（RNG–RNG Game）",
	),
	"2111" => array(
		"name"=>"超级轮盘（快）（RNG–RNG Game）",
	),
	"2112" => array(
		"name"=>"21点（完美对子）（RNG–RNG Game）",
	),
	"2113" => array(
		"name"=>"免佣金百家乐（RNG–RNG Game）",
	),
	"2114" => array(
		"name"=>"鱼虾蟹（RNG–RNG Game）",
	),
	"2115" => array(
		"name"=>"龙虎（RNG–RNG Game）",
	),
	"2116" => array(
		"name"=>"三公（RNG–RNG Game）",
	),
	"2117" => array(
		"name"=>"幸运轮（RNG–RNG Game）",
	),
	"2118" => array(
		"name"=>"番摊（RNG–RNG Game）",
	),
	"2119" => array(
		"name"=>"纸牌转轮（RNG–RNG Game）",
	),
	"2120" => array(
		"name"=>"德州扑克（RNG–RNG Game）",
	),
	"2121" => array(
		"name"=>"开牌21点（RNG–RNG Game）",
	),
	"2122" => array(
		"name"=>"三张拉米（RNG–RNG Game）",
	),
	"2123" => array(
		"name"=>"红狗（RNG–RNG Game）",
	),
	"2124" => array(
		"name"=>"多轮轮盘（RNG–RNG Game）",
	),
	"2125" => array(
		"name"=>"灵猴高低（RNG–RNG Game）",
	),
	"2126" => array(
		"name"=>"麻将高低（RNG–RNG Game）",
	),
	"2127" => array(
		"name"=>"基诺快门（RNG–RNG Game）",
	),
	"2128" => array(
		"name"=>"基诺（RNG–RNG Game）",
	),
	"2129" => array(
		"name"=>"赛马王（RNG–RNG Game）",
	),
	"2130" => array(
		"name"=>"斗王（RNG–RNG Game）",
	),
	"2131" => array(
		"name"=>"玛雅之物（RNG–RNG Game）",
	),
	"2132" => array(
		"name"=>"恭喜发财（RNG–RNG Game）",
	),
	"2133" => array(
		"name"=>"爱神邱比特（RNG–RNG Game）",
	),
	"2134" => array(
		"name"=>"射龙门（RNG–RNG Game）",
	),
	"2135" => array(
		"name"=>"吃果果（刮刮乐）（RNG–RNG Game）",
	),
	"2136" => array(
		"name"=>"圣诞礼物（RNG–RNG Game）",
	),
	"2137" => array(
		"name"=>"敲敲蛋（刮刮乐）（RNG–RNG Game）",
	),
	"2138" => array(
		"name"=>"打地鼠（RNG–RNG Game）",
	),
	"2139" => array(
		"name"=>"趣味广场（刮刮乐）（RNG–RNG Game）",
	),
	"2140" => array(
		"name"=>"烈火奥运（RNG–RNG Game）",
	),
	"2141" => array(
		"name"=>"吧台寿司（RNG–RNG Game）",
	),
	"2142" => array(
		"name"=>"野球九宫格（RNG–RNG Game）",
	),
	"2143" => array(
		"name"=>"对10高手（RNG–RNG Game）",
	),
	"2144" => array(
		"name"=>"4线对J高手（RNG–RNG Game）",
	),
	"2145" => array(
		"name"=>"25线对J高手（RNG–RNG Game）",
	),
	"2146" => array(
		"name"=>"50线对J高手（RNG–RNG Game）",
	),
	"2147" => array(
		"name"=>"泰山（RNG–RNG Game）",
	),
	"2148" => array(
		"name"=>"楚河汉界（RNG–RNG Game）",
	),
	"2149" => array(
		"name"=>"财神到（RNG–RNG Game）",
	),
	"2150" => array(
		"name"=>"钱来也（RNG–RNG Game）",
	),
	"2151" => array(
		"name"=>"五狐四海（RNG–RNG Game）",
	),
	"2152" => array(
		"name"=>"西游记（RNG–RNG Game）",
	),
	"2153" => array(
		"name"=>"冬之雪（RNG–RNG Game）",
	),
	"2154" => array(
		"name"=>"星座星空（RNG–RNG Game）",
	),
	"2155" => array(
		"name"=>"十二生肖（RNG–RNG Game）",
	),
	"2156" => array(
		"name"=>"水浒传（RNG–RNG Game）",
	),
	"2157" => array(
		"name"=>"我们是冠军（RNG–RNG Game）",
	),
	"2158" => array(
		"name"=>"疯狂医院（RNG–RNG Game）",
	),
	"2159" => array(
		"name"=>"麻将英雄传（RNG–RNG Game）",
	),
	"2160" => array(
		"name"=>"万圣派对（RNG–RNG Game）",
	),
	"2161" => array(
		"name"=>"快乐僵尸（RNG–RNG Game）",
	),
	"2162" => array(
		"name"=>"球迷俱乐部（RNG–RNG Game）",
	),
	"2163" => array(
		"name"=>"国色天香（RNG–RNG Game）",
	),
	"2164" => array(
		"name"=>"忍者英雄（RNG–RNG Game）",
	),
	"2165" => array(
		"name"=>"反转青楼（RNG–RNG Game）",
	),
	"2166" => array(
		"name"=>"福禄寿（RNG–RNG Game）",
	),
	"2167" => array(
		"name"=>"大魔术师（RNG–RNG Game）",
	),
	"2168" => array(
		"name"=>"财神到（双喜临门）（RNG–RNG Game）",
	),
	"2169" => array(
		"name"=>"铁拳（RNG–RNG Game）",
	),
	"2170" => array(
		"name"=>"泰山（双喜临门）（RNG–RNG Game）",
	),
	"2171" => array(
		"name"=>"谜龙谷（RNG–RNG Game）",
	),
	"2172" => array(
		"name"=>"西部牛仔（RNG–RNG Game）",
	),
	"2173" => array(
		"name"=>"恐龙世界（RNG–RNG Game）",
	),
	"2174" => array(
		"name"=>"美丽纹身（RNG–RNG Game）",
	),
	"2175" => array(
		"name"=>"Mamak档（RNG–RNG Game）",
	),
	"2176" => array(
		"name"=>"海乐团（RNG–RNG Game）",
	),
	"2177" => array(
		"name"=>"套现（RNG–RNG Game）",
	),
	"2201" => array(
		"name"=>"（迷你）百家乐（RNG–Mini Game）",
	),
	"2202" => array(
		"name"=>"（迷你）赌场扑克（RNG–Mini Game）",
	),
	"2203" => array(
		"name"=>"（迷你）21点（RNG–Mini Game）",
	),
	"2204" => array(
		"name"=>"（迷你）对J高手（RNG–Mini Game）",
	),
	"2205" => array(
		"name"=>"（迷你）骰宝（RNG–Mini Game）",
	),
	"2206" => array(
		"name"=>"（迷你）Money Slot（RNG–Mini Game）",
	),
	"2301" => array(
		"name"=>"（Mobile）百家乐（RNG–Mobile）",
	),
	"2302" => array(
		"name"=>"（Mobile）赌场德州扑克（RNG–Mobile）",
	),
	"2303" => array(
		"name"=>"（Mobile）21点（RNG–Mobile）",
	),
	"2304" => array(
		"name"=>"（Mobile）泰山（RNG–Mobile）",
	),
	"2305" => array(
		"name"=>"（Mobile）财神到（RNG–Mobile）",
	),
	"2306" => array(
		"name"=>"（Mobile）骰宝（RNG–Mobile）",
	),
	"2307" => array(
		"name"=>"（Mobile）国色天香（RNG–Mobile）",
	),
	"2308" => array(
		"name"=>"（Mobile）大魔术师（RNG–Mobile）",
	),
	"2309" => array(
		"name"=>"（Mobile）反转青楼（RNG–Mobile）",
	),
	"2310" => array(
		"name"=>"Mobile）迷你轮盘（RNG–Mobile）",
	),
	"2311" => array(
		"name"=>"Baccarat Super 6（RNG–Mobile）",
	),
	"2312" => array(
		"name"=>"Blackjack Perfect Pair（RNG–Mobile）",
	),
	"2314" => array(
		"name"=>"开牌21点（RNG–Mobile）",
	),
	"2401" => array(
		"name"=>"百家乐（欧博）",
	),
	"2402" => array(
		"name"=>"VIP百家乐（欧博）",
	),
	"2403" => array(
		"name"=>"轮盘（欧博）",
	),
	"2404" => array(
		"name"=>"骰宝（欧博）",
	),
	"2405" => array(
		"name"=>"龙虎（欧博）",
	),
	"2701" => array(
		"name"=>"全场.标准盘（虚拟足球联赛，虚拟足球国家）",
	),
	"2702" => array(
		"name"=>"半场.标准盘（虚拟足球联赛，虚拟足球国家）",
	),
	"2703" => array(
		"name"=>"大小盘（虚拟足球联赛，虚拟足球国家）",
	),
	"2704" => array(
		"name"=>"半场大小盘（虚拟足球联赛，虚拟足球国家）",
	),
	"2705" => array(
		"name"=>"让球（虚拟足球联赛，虚拟足球国家）",
	),
	"2706" => array(
		"name"=>"上半场让球（虚拟足球联赛，虚拟足球国家）",
	),
	"2707" => array(
		"name"=>"波胆（虚拟足球联赛，虚拟足球国家）",
	),
	"2799" => array(
		"name"=>"混合过关（虚拟足球联赛，虚拟足球国家）",
	),
	"4002" => array(
		"name"=>"BigHaul（Macau Games）",
	),
	"4003" => array(
		"name"=>"BushidoCode（Macau Games）",
	),
	"4004" => array(
		"name"=>"CasinoStudPoker（Macau Games）",
	),
	"4005" => array(
		"name"=>"CatchtheWaves（Macau Games）",
	),
	"4008" => array(
		"name"=>"DancingLions（Macau Games）",
	),
	"4009" => array(
		"name"=>"DragonKing（Macau Games）",
	),
	"4010" => array(
		"name"=>"DragonsandPearls（Macau Games）",
	),
	"4011" => array(
		"name"=>"Fish'O'Mania（Macau Games）",
	),
	"4012" => array(
		"name"=>"FortunePanda（Macau Games）",
	),
	"4013" => array(
		"name"=>"GodofWealth（Macau Games）",
	),
	"4014" => array(
		"name"=>"GoldofRa（Macau Games）",
	),
	"4015" => array(
		"name"=>"GuardianLion（Macau Games）",
	),
	"4018" => array(
		"name"=>"KingofTime（Macau Games）",
	),
	"4019" => array(
		"name"=>"LadyLuck（Macau Games）",
	),
	"4020" => array(
		"name"=>"MysticRiches（Macau Games）",
	),
	"4021" => array(
		"name"=>"PhoenixPrincess（Macau Games）",
	),
	"4022" => array(
		"name"=>"Roulette（Macau Games）",
	),
	"4023" => array(
		"name"=>"TempleTreasures（Macau Games）",
	),
	"4024" => array(
		"name"=>"ThaiDragon（Macau Games）",
	),
	"4025" => array(
		"name"=>"TreasureReef（Macau Games）",
	),
	"4026" => array(
		"name"=>"Venetia（Macau Games）",
	),
	"4028" => array(
		"name"=>"WildDolphin（Macau Games）",
	),
	"4029" => array(
		"name"=>"WolfQuest（Macau Games）",
	),
	"18000" => array(
		"name"=>"Colossus Bets（Colossus足彩）",
	),
	"18001" => array(
		"name"=>"Pool Bet（Colossus足彩）",
	),
	"18002" => array(
		"name"=>"Cash-Out（Colossus足彩）",
	),
	"18004" => array(
		"name"=>"Consolation Prize（Colossus足彩）",
	),
	"18005" => array(
		"name"=>"Jackpot Prize（Colossus足彩）",
	),
);

$GLOBALS["NBbetTypeName"] = array(			//牛博
    "ssl" => "上海时时乐",
    "sd" => "福彩3D",
    "ps" => "体彩排列三",
    "cqssc" => "重庆时时彩",
    "lhc" => "香港六合彩",
    "klsf" => "广东快乐十分",
    "tjklsf" => "天津快乐十分",
    "tjssc" => "天津时时彩",
    "jsks" => "江苏快3",
    "jlks" => "吉林快3",
    "pk" => "北京赛车",
    "cqklsssl" => "上海时时乐",
    "sd" => "福彩3D",
    "ps" => "体彩排列三",
    "cqklsf" => "重庆幸运农场",
    "klfp" => "北京快乐8",
    "bjks" => "北京快3",
    "gxklsf" => "广西快乐十分",
    "hnklsf" => "湖南快乐十分",
    "sdsyxw" => "山东11选5",
    "gdsyxw" => "广东11选5",
    "jlsyxw" => "吉林11选5",
    "xjssc" => "新疆时时彩",
    "jssb" => "江苏骰宝",
    "jlsb" => "吉林骰宝",
    "xyft" => "幸运飞艇");
$GLOBALS["IGSSCBetTypeName"] = array(	//IG时时彩-游戏类型
	1 => ["广东快乐十分",1],
	2 => ["重庆时时彩",2],
	3 => ["北京赛车[PK10]",3],
	4 => ["江苏骰宝[快3]",4],
	5 => ["幸运农场",1],
	6 => ["天津时时彩",2],
	7 => ["新疆时时彩",2],
	8 => ["江西时时彩",2],
	9 => ["云南时时彩",2],
	10 => ["上海时时彩",6],
	11 => ["天津快乐十分",1],
	12 => ["广西快乐十分",5],
	13 => ["湖南快乐十分",1],
	14 => ["安徽快3",4],
	15 => ["广西快3",4],
	16 => ["吉林快3",4],
	17 => ["幸运飞艇",3],
	18 => ["广东11选5",7],
	19 => ["江西11选5",7],
	20 => ["山东11选5",7],
	21 => ["北京11选5",7],
	22 => ["上海11选5",7],
	23 => ["辽宁11选5",7],
	24 => ["湖北11选5",7],
	25 => ["江苏11选5",7],
	26 => ["安徽11选5",7],
	27 => ["北京快乐8",8],
	28 => ["澳洲快乐8",8],
	29 => ["韩国快乐8",8],
	30 => ["加拿大卑斯快乐8",8],
	31 => ["加拿大西部快乐8",8],
	32 => ["斯洛伐克快乐8",8],
	33 => ["马耳他快乐8",8],
	34 => ["台湾宾果",8],
	35 => ["东京快乐8",8],
	36 => ["福彩3D",9],
	37 => ["体彩3D",9],
	38 => ["云南快乐十分",1],
	39 => ["北京快8PC蛋蛋",10],
	40 => ["澳洲快8PC蛋蛋",10],
	41 => ["韩国快8PC蛋蛋",10],
	42 => ["加拿大快8PC蛋蛋",10],
	43 => ["加拿大大西部快8PC蛋蛋",10],
	44 => ["斯洛伐克PC蛋蛋",10],
	45 => ["马耳他PC蛋蛋",10],
	46 => ["台湾宾果PC蛋蛋",10],
	47 => ["东京快乐8PC蛋蛋",10],
	48 => ["极速赛车",3],
	49 => ["极速时时彩",2],
	50 => ["一分赛车",3],
	51 => ["一分时时彩",2],
	52 => ["极速快乐十分",1],
	53 => ["极速十一选五",7],
	54 => ["极速快三",4],
	55 => ["极速快乐8",8],
	56 => ["极速3D",9],
	57 => ["极速PC蛋蛋",10],
	58 => ["极速六合彩",11],
);
$GLOBALS["IGSSCBetDetail"] = array(	//IG时时彩-游戏明细：todo:NO_n对应n点未写入
	"1" => array(
		"betOn"=> array(
			"ANYONE" => "正码",
			"TOTAL" => "总和",
			"D_T_T" => "龙虎",
			"SERIAL" => "连码",
		),
		"betType"=>array(
			"BIG" => "大",
			"SMALL" => "小",
			"ODD" => "单",
			"EVEN" => "双",
			"TAIL_BIG" => "尾大",
			"TAIL_SMALL" => "尾小",
			"SUM_ODD" => "合单",
			"SUM_EVEN" => "合双",
			"ZHONG" => "中",
			"FA" => "發",
			"BAI" => "白",
			"EAST" => "東",
			"SOUTH" => "南",
			"WEST" => "西",
			"NORTH" => "北",
			"DRAGON" => "龙",
			"TIGER" => "虎",
			"OPTIONAL_2" => "任选二",
			"OPTIONAL_2_GROUP_STR" => "选二连直",
			"GROUP_2" => "选二连组",
			"OPTIONAL_3" => "任选三",
			"OPTIONAL_FIRST3_STR" => "选三前直",
			"GROUP_FIRST3" => "选三前组",
			"OPTIONAL_4" => "任选四",
			"OPTIONAL_5" => "任选五",
		),
	),
	"2" => array(
		"betOn"=> array(
			"TOTAL" => "总和",
			"D_T_T" => "龙虎和",
			"FIRST3" => "前三",
			"MIDDLE3" => "中三",
			"LAST3" => "后三",
			"SERIAL" => "连码",
			"SPAN_FIRST3" => "跨度前三",
			"SPAN_MIDDLE3" => "跨度中三",
			"SPAN_LAST3" => "跨度后三",
			"SUM_OOXXX" => "万千位和",
			"SUM_OXOXX" => "万佰位和",
			"SUM_OXXOX" => "万拾位和",
			"SUM_OXXXO" => "万个位和",
			"SUM_XOOXX" => "千佰位和",
			"SUM_XOXOX" => "千拾位和",
			"SUM_XOXXO" => "千个位和",
			"SUM_XXOOX" => "佰拾位和",
			"SUM_XXOXO" => "佰个位和",
			"SUM_XXXOO" => "拾个位和",
		),
		"betType"=>array(
			"BIG" => "大",
			"SMALL" => "小",
			"ODD" => "单",
			"EVEN" => "双",
			"DRAGON" => "龙",
			"TIGER" => "虎",
			"TIE" => "和",
			"THREE_EQUAL" => "豹子",
			"THREE_STRAIGHT" => "顺子",
			"THREE_PAIR" => "对子",
			"THREE_HALF_STRAIGHT" => "半順",
			"THREE_CHAOS" => "杂六",
			"ZHI" => "质",
			"HE" => "合",
			"COMBIN_1_FIRST3" => "一字前三",
			"COMBIN_1_MIDDLE3" => "一字中三",
			"COMBIN_1_LAST3" => "一字后三",
			"COMBIN_1_5" => "全五",
			"COMBIN_2_FIRST3" => "二字前三",
			"COMBIN_2_MIDDLE3" => "二字中三",
			"COMBIN_2_LAST3" => "二字后三",
			"COMBIN_3_FIRST3" => "三字前三",
			"COMBIN_3_MIDDLE3" => "三字中三",
			"COMBIN_3_LAST3" => "三字后三",
			"COMBIN_2_2_FIRST3" => "二字前三对子",
			"COMBIN_2_2_MIDDLE3" => "二字中三对子",
			"COMBIN_2_2_LAST3" => "二字后三对子",
			"COMBIN_3_2_FIRST3" => "三字前三对子",
			"COMBIN_3_2_MIDDLE3" => "三字中三对子",
			"COMBIN_3_2_LAST3" => "三字后三对子",
			"COMBIN_3_3_FIRST3" => "三字前三豹子",
			"COMBIN_3_3_MIDDLE3" => "三字中三豹子",
			"COMBIN_3_3_LAST3" => "三字后三豹子",
			"OOXXX" => "二定位万千位",
			"OXOXX" => "二定位万佰位",
			"OXXOX" => "二定位万拾位",
			"OXXXO" => "二定位万个位",
			"XOOXX" => "二定位千佰位",
			"XOXOX" => "二定位千拾位",
			"XOXXO" => "二定位千个位",
			"XXOOX" => "二定位佰拾位",
			"XXOXO" => "二定位佰个位",
			"XXXOO" => "二定位拾个位",
			"OOOXX" => "三定位前三",
			"XOOOX" => "三定位中三",
			"XXOOO" => "三定位后三",
			"GROUP3_FIRST3" => "组选三前三",
			"GROUP3_MIDDLE3" => "组选三中三",
			"GROUP3_LAST3" => "组选三后三",
			"GROUP6_FIRST3" => "组选六前三",
			"GROUP6_MIDDLE3" => "组选六中三",
			"GROUP6_LAST3" => "组选六后三",
		),	
	),
	"3" => array(
		"betOn"=> array(
			"TOTAL" => "总和",
			"D_T_T" => "龙虎和",
			"FIRST3" => "前三",
			"MIDDLE3" => "中三",
			"LAST3" => "后三",
			"SERIAL" => "连码",
			"SPAN_FIRST3" => "跨度前三",
			"SPAN_MIDDLE3" => "跨度中三",
			"SPAN_LAST3" => "跨度后三",
			"SUM_OOXXX" => "万千位和",
			"SUM_OXOXX" => "万佰位和",
			"SUM_OXXOX" => "万拾位和",
			"SUM_OXXXO" => "万个位和",
			"SUM_XOOXX" => "千佰位和",
			"SUM_XOXOX" => "千拾位和",
			"SUM_XOXXO" => "千个位和",
			"SUM_XXOOX" => "佰拾位和",
			"SUM_XXOXO" => "佰个位和",
			"SUM_XXXOO" => "拾个位和",
		),
		"betType"=>array(
			"BIG" => "大",
			"SMALL" => "小",
			"ODD" => "单",
			"EVEN" => "双",
			"DRAGON" => "龙",
			"TIGER" => "虎",
			"TIE" => "和",
			"THREE_EQUAL" => "豹子",
			"THREE_STRAIGHT" => "顺子",
			"THREE_PAIR" => "对子",
			"THREE_HALF_STRAIGHT" => "半順",
			"THREE_CHAOS" => "杂六",
			"ZHI" => "质",
			"HE" => "合",
			"COMBIN_1_FIRST3" => "一字前三",
			"COMBIN_1_MIDDLE3" => "一字中三",
			"COMBIN_1_LAST3" => "一字后三",
			"COMBIN_1_5" => "全五",
			"COMBIN_2_FIRST3" => "二字前三",
			"COMBIN_2_MIDDLE3" => "二字中三",
			"COMBIN_2_LAST3" => "二字后三",
			"COMBIN_3_FIRST3" => "三字前三",
			"COMBIN_3_MIDDLE3" => "三字中三",
			"COMBIN_3_LAST3" => "三字后三",
			"COMBIN_2_2_FIRST3" => "二字前三对子",
			"COMBIN_2_2_MIDDLE3" => "二字中三对子",
			"COMBIN_2_2_LAST3" => "二字后三对子",
			"COMBIN_3_2_FIRST3" => "三字前三对子",
			"COMBIN_3_2_MIDDLE3" => "三字中三对子",
			"COMBIN_3_2_LAST3" => "三字后三对子",
			"COMBIN_3_3_FIRST3" => "三字前三豹子",
			"COMBIN_3_3_MIDDLE3" => "三字中三豹子",
			"COMBIN_3_3_LAST3" => "三字后三豹子",
			"OOXXX" => "二定位万千位",
			"OXOXX" => "二定位万佰位",
			"OXXOX" => "二定位万拾位",
			"OXXXO" => "二定位万个位",
			"XOOXX" => "二定位千佰位",
			"XOXOX" => "二定位千拾位",
			"XOXXO" => "二定位千个位",
			"XXOOX" => "二定位佰拾位",
			"XXOXO" => "二定位佰个位",
			"XXXOO" => "二定位拾个位",
			"OOOXX" => "三定位前三",
			"XOOOX" => "三定位中三",
			"XXOOO" => "三定位后三",
			"GROUP3_FIRST3" => "组选三前三",
			"GROUP3_MIDDLE3" => "组选三中三",
			"GROUP3_LAST3" => "组选三后三",
			"GROUP6_FIRST3" => "组选六前三",
			"GROUP6_MIDDLE3" => "组选六中三",
			"GROUP6_LAST3" => "组选六后三",
		),
	),
	"4" => array(
		"betOn"=> array(
			"BALL_1" => "冠军",
			"BALL_2" => "亚军",
			"BALL_3" => "第三名",
			"BALL_4" => "第四名",
			"BALL_5" => "第五名",
			"BALL_6" => "第六名",
			"BALL_7" => "第七名",
			"BALL_8" => "第八名",
			"BALL_9" => "第九名",
			"BALL_10" => "第十名",
			"GOLD_SILVER" => "冠亚",
		),
		"betType"=>array(
			"BIG" => "大",
			"SMALL" => "小",
			"ODD" => "单",
			"EVEN" => "双",
			"DRAGON" => "龙",
			"TIGER" => "虎",
			"BIG_ODD" => "大单",
			"BIG_EVEN" => "大双",
			"SMALL_ODD" => "小单",
			"SMALL_EVEN" => "小双",
		),
	),
	"5" => array(
		"betOn"=> array(
			"ANYONE" => "三军",
			"TRIPLE" => "围骰",
			"ANY_TRIPLE" => "全骰",
			"SPEC_TWO" => "长牌",
			"PAIR" => "短牌",
			"TOTAL_BIG_SMALL" => "大小",
			"TOTAL_NUMBER" => "点数",
		),
		"betType"=>array(
			"BIG" => "大",
			"SMALL" => "小",
			"SPEC_1_2" => "12",
			"SPEC_1_3" => "13",
			"SPEC_1_4" => "14",
			"SPEC_1_5" => "15",
			"SPEC_1_6" => "16",
			"SPEC_2_3" => "23",
			"SPEC_2_4" => "24",
			"SPEC_2_5" => "25",
			"SPEC_2_6" => "26",
			"SPEC_3_4" => "34",
			"SPEC_3_5" => "35",
			"SPEC_3_6" => "36",
			"SPEC_4_5" => "45",
			"SPEC_4_6" => "46",
			"SPEC_5_6" => "56",
		),
	),
	"6" => array(
		"betOn"=> array(
			"ANYONE" => "正码",
			"TOTAL" => "总和",
			"D_T_T" => "龙虎",
		),
		"betType"=>array(
			"BIG" => "大",
			"SMALL" => "小",
			"ODD" => "单",
			"EVEN" => "双",
			"TAIL_BIG" => "尾大",
			"TAIL_SMALL" => "尾小",
			"SUM_ODD" => "合单",
			"SUM_EVEN" => "合双",
			"RED" => "红",
			"BLUE" => "蓝",
			"GREEN" => "绿",
			"CHUN" => "春",
			"XIA" => "夏",
			"QIU" => "秋",
			"DONG" => "冬",
			"DRAGON12" => "龙(1-2)",
			"DRAGON13" => "龙(1-3)",
			"DRAGON14" => "龙(1-4)",
			"DRAGON15" => "龙(1-5)",
			"DRAGON23" => "龙(2-3)",
			"DRAGON24" => "龙(2-4)",
			"DRAGON25" => "龙(2-5)",
			"DRAGON34" => "龙(3-4)",
			"DRAGON35" => "龙(3-5)",
			"DRAGON45" => "龙(4-5)",
			"TIGER12" => "虎(1-2)",
			"TIGER13" => "虎(1-3)",
			"TIGER14" => "虎(1-4)",
			"TIGER15" => "虎(1-5)",
			"TIGER23" => "虎(2-3)",
			"TIGER24" => "虎(2-4)",
			"TIGER25" => "虎(2-5)",
			"TIGER34" => "虎(3-4)",
			"TIGER35" => "虎(3-5)",
			"TIGER45" => "虎(4-5)",
			"TIGER" => "虎",
			"JIN" => "金",
			"MU" => "木",
			"SHUI" => "水",
			"HUO" => "火",
			"TU" => "土",
		),
	),
	"7" => array(
		"betOn"=> array(
			"TOTAL" => "总和",
			"D_T_T" => "龙虎和",
			"ANYONE" => "正码",
			"SERIAL" => "连码",
		),
		"betType"=>array(
			"BIG" => "大",
			"SMALL" => "小",
			"ODD" => "单",
			"EVEN" => "双",
			"TAIL_BIG" => "尾大",
			"TAIL_SMALL" => "尾小",
			"OPTIONAL_2" => "任选 2 中 2",
			"OPTIONAL_3" => "任选 3 中 3",
			"OPTIONAL_4" => "任选 4 中 4",
			"OPTIONAL_5" => "任选 5 中 5",
			"OPTIONAL_6" => "任选 6 中 5",
			"OPTIONAL_7" => "任选 7 中 5",
			"OPTIONAL_8" => "任选 8 中 5",
			"GROUP_2" => "组选前 2",
			"GROUP_FIRST3" => "组选前 3",
			"OPTIONAL_2_GROUP_STR" => "直选前 2",
			"OPTIONAL_FIRST3_STR" => "直选前 3",
			"DRAGON" => "龙",
			"TIGER" => "虎",
			"TIE" => "和",
		),
	),
	"8" => array(
		"betOn"=> array(
			"TOTAL" => "总和",
			"BEFORE_AFTER" => "前后",
			"ODD_EVEN" => "单双",
			"ANYONE" => "正码",
		),
		"betType"=>array(
			"BIG" => "大",
			"SMALL" => "小",
			"ODD" => "单",
			"EVEN" => "双",
			"BEFORE_MORE" => "前多",
			"AFTER_MORE" => "后多",
			"BEFORE_AFTER_TIE" => "前后和",
			"ODD_MORE" => "单多",
			"EVEN_MORE" => "双多",
			"ODD_EVEN_TIE" => "单双和",
			"JIN" => "金",
			"MU" => "木",
			"SHUI" => "水",
			"HUO" => "火",
			"TU" => "土",
			"SUM_810" => "810",
			"BIG_ODD" => "大单",
			"BIG_EVEN" => "大双",
			"SMALL_ODD" => "小单",
			"SMALL_EVEN" => "小双",
		),
	),
	"9" => array(
		"betOn"=> array(
			"TOTAL" => "总和",
			"D_T_T" => "龙虎和",
			"ANYONE" => "正码",
			"SERIAL3" => "连 3",
			"SPAN" => "跨度",
			"SUM_OOX" => "佰拾和",
			"SUM_OXO" => "佰个和",
			"SUM_XOO" => "个拾和",
			"TOTAL_TAIL" => "总和尾",
			"SERIAL" => "连码",
			"SUM_OOX_TAIL" => "佰拾和尾",
			"SUM_OXO_TAIL" => "佰个和尾",
			"SUM_XOO_TAIL" => "个拾和尾",
		),
		"betType"=>array(
			"BIG" => "大",
			"SMALL" => "小",
			"ODD" => "单",
			"EVEN" => "双",
			"DRAGON" => "龙",
			"TIGER" => "虎",
			"TIE" => "和",
			"THREE_EQUAL" => "豹子",
			"THREE_STRAIGHT" => "顺子",
			"THREE_PAIR" => "对子",
			"THREE_HALF_STRAIGHT" => "半顺",
			"THREE_CHAOS" => "杂六",
			"ZHI" => "质",
			"HE" => "合",
			"TAIL_BIG" => "尾大",
			"TAIL_SMALL" => "尾小",
			"TAIL_ZHI" => "尾质",
			"TAIL_HE" => "尾和",
			"COMBIN_2" => "二字",
			"COMBIN_2_2" => "二字组合对子",
			"COMBIN_3_2" => "三字组合对子",
			"COMBIN_3_3" => "三字组合豹子",
			"OOX" => "二定位佰拾位",
			"OXO" => "二定位佰个位",
			"XOO" => "二定位拾个位",
			"OOO" => "三定位",
			"GROUP3_OPTION_5" => "5 位数组选 3",
			"GROUP3_OPTION_6" => "6 位数组选 3",
			"GROUP3_OPTION_7" => "7 位数组选 3",
			"GROUP3_OPTION_8" => "8 位数组选 3",
			"GROUP3_OPTION_9" => "9 位数组选 3",
			"GROUP3_OPTION_10" => "10 位数组选 3",
			"GROUP6_OPTION_4" => "4 位数组选 6",
			"GROUP6_OPTION_5" => "5 位数组选 6",
			"GROUP6_OPTION_6" => "6 位数组选 6",
			"GROUP6_OPTION_7" => "7 位数组选 6",
			"GROUP6_OPTION_8" => "8 位数组选 6",
			"COMBIN_COMPLEX" => "复式组合",
			"NO_0_4" => "二定位和 0~4",
			"NO_14_18" => "二定位和 14~18",
			"NO_0_6" => "总和 0~6",
			"NO_21_27" => "总和 21~27",
		),
	),
	"10" => array(
		"betOn"=> array(
			"TOTAL" => "总和",
			"SERIAL" => "连码",
		),
		"betType"=>array(
			"BIG" => "大",
			"SMALL" => "小",
			"ODD" => "单",
			"EVEN" => "双",
			"MIN" => "极小",
			"MAX" => "极大",
			"BIG_ODD" => "大单",
			"BIG_EVEN" => "大双",
			"SMALL_ODD" => "小单",
			"SMALL_EVEN" => "小双",
			"GREEN" => "绿",
			"BLUE" => "蓝",
			"RED" => "红",
			"THREE_EQUAL" => "豹子",
			"GROUP_3_TE" => "特码包三",
		),
	),
	"11" => array(
		"betOn"=> array(
			"TEMA_A" => "特码 A",
			"TEMA_B" => "特码 B",
			"ZHENGMA_A" => "正码 A",
			"ZHENGMA_B" => "正码 B",
			"ZHENGTE_1" => "正 1 特",
			"ZHENGTE_2" => "正 2 特",
			"ZHENGTE_3" => "正 3 特",
			"ZHENGTE_4" => "正 4 特",
			"ZHENGTE_5" => "正5特",
			"ZHENGTE_6" => "正6特",
			"SERIAL_3_3" => "三全中",
			"SERIAL_3_2" => "三中二[中二]",
			"SERIAL_3_2_3" => "三中二[中三]",
			"SERIAL_2_2" => "二全中",
			"SERIAL_2_TE" => "二中特[中二]",
			"SERIAL_2_TE_TE" => "二中特[中特]",
			"SERIAL_TE" => "特串",
			"GUOGUAN" => "过关",
			"SHENXIAO_TE" => "特肖",
			"TEMA_TOU" => "特码头",
			"TEMA_WEI" => "特码尾",
			"WUXING" => "五行",
			"BANBO" => "半波",
			"QIMA_ODD" => "七码单",
			"QIMA_EVEN" => "七码双",
			"QIMA_BIG" => "七码大",
			"QIMA_SMALL" => "七码小",
			"SHENXIAO6_2" => "二肖",
			"SHENXIAO6_3" => "三肖",
			"SHENXIAO6_4" => "四肖",
			"SHENXIAO6_5" => "五肖",
			"SHENXIAO6_6" => "六肖",
			"SHENXIAO_1_Y" => "一肖中",
			"SHENXIAO_1_N" => "一肖不中",
			"WEISHU_Y" => "尾数中",
			"WEISHU_N" => "尾数不中",
			"SHENXIAOLIAN_Y_2" => "二肖连中",
			"SHENXIAOLIAN_Y_3" => "三肖连中",
			"SHENXIAOLIAN_Y_4" => "四肖连中",
			"SHENXIAOLIAN_Y_5" => "五肖连中",
			"SHENXIAOLIAN_N_2" => "二肖连不中",
			"SHENXIAOLIAN_N_3" => "三肖连不中",
			"SHENXIAOLIAN_N_4" => "四肖连不中",
			"SHENXIAOLIAN_N_5" => "五肖连不中",
			"WEISHULIAN_Y_2" => "二尾连中",
			"WEISHULIAN_Y_3" => "三尾连中",
			"WEISHULIAN_Y_4" => "四尾连中",
			"WEISHULIAN_N_2" => "二尾连不中",
			"WEISHULIAN_N_3" => "三尾连不中",
			"WEISHULIAN_N_4" => "四尾连不中",
			"BUZHONG_5" => "五不中",
			"BUZHONG_6" => "六不中",
			"BUZHONG_7" => "七不中",
			"BUZHONG_8" => "八不中",
			"BUZHONG_9" => "九不中",
			"BUZHONG_10" => "十不中",
			"ZHONG1_5" => "五选中一",
			"ZHONG1_6" => "六选中一",
			"ZHONG1_7" => "七选中一",
			"ZHONG1_8" => "八选中一",
			"ZHONG1_9" => "九选中一",
			"ZHONG1_10" => "十选中一",
			"TEPING_1" => "特平中一",
			"TEPING_2" => "特平中二",
			"TEPING_3" => "特平中三",
			"TEPING_4" => "特平中四",
			"TEPING_5" => "特平中五",
		),
		"betType"=>array(
			"ODD" => "单",
			"EVEN" => "双",
			"BIG" => "大",
			"SMALL" => "小",
			"SUM_ODD" => "合单",
			"SUM_EVEN" => "合双",
			"TAIL_BIG" => "尾大",
			"TAIL_SMALL" => "尾小",
			"RED" => "红",
			"GREEN" => "绿",
			"BLUE" => "蓝",
			"SHU" => "鼠",
			"NIU" => "牛",
			"HU" => "虎",
			"TU" => "兔或土",
			"LONG" => "龙",
			"SHE" => "蛇",
			"MA" => "马",
			"YANG" => "羊",
			"HOU" => "猴",
			"JI" => "鸡",
			"GOU" => "狗",
			"ZHU" => "猪",
			"JIN" => "金",
			"MU" => "木",
			"SHUI" => "水",
			"HUO" => "火",
			"TU" => "土或兔",
			"RED_ODD" => "红单",
			"RED_EVEN" => "红双",
			"RED_BIG" => "红大",
			"RED_SMALL" => "红小",
			"BLUE_ODD" => "蓝单",
			"BLUE_EVEN" => "蓝双",
			"BLUE_BIG" => "蓝大",
			"BLUE_SMALL" => "蓝小",
			"GREEN_ODD" => "绿单",
			"GREEN_EVEN" => "绿双",
			"GREEN_BIG" => "绿大",
			"GREEN_SMALL" => "绿小",
			"Z_ODD_1" => "正 1 单",
			"Z_ODD_2" => "正 2 单",
			"Z_ODD_3" => "正 3 单",
			"Z_ODD_4" => "正 4 单",
			"Z_ODD_5" => "正 5 单",
			"Z_ODD_6" => "正 6 单",
			"Z_EVEN_1" => "正 1 双",
			"Z_EVEN_2" => "正 2 双",
			"Z_EVEN_3" => "正 3 双",
			"Z_EVEN_4" => "正 4 双",
			"Z_EVEN_5" => "正 5 双",
			"Z_EVEN_6" => "正 6 双",
			"Z_BIG_1" => "正 1 大",
			"Z_BIG_2" => "正 2 大",
			"Z_BIG_3" => "正 3 大",
			"Z_BIG_4" => "正 4 大",
			"Z_BIG_5" => "正 5 大",
			"Z_BIG_6" => "正 6 大",
			"Z_SMALL_1" => "正 1 小",
			"Z_SMALL_2" => "正 2 小",
			"Z_SMALL_3" => "正 3 小",
			"Z_SMALL_4" => "正 4 小",
			"Z_SMALL_5" => "正 5 小",
			"Z_SMALL_6" => "正 6 小",
			"Z_RED_1" => "正 1 红",
			"Z_RED_2" => "正 2 红",
			"Z_RED_3" => "正 3 红",
			"Z_RED_4" => "正 4 红",
			"Z_RED_5" => "正 5 红",
			"Z_RED_6" => "正 6 红",
			"Z_BLUE_1" => "正 1 蓝",
			"Z_BLUE_2" => "正 2 蓝",
			"Z_BLUE_3" => "正 3 蓝",
			"Z_BLUE_4" => "正 4 蓝",
			"Z_BLUE_5" => "正 5 蓝",
			"Z_BLUE_6" => "正 6 蓝",
			"Z_GREEN_1" => "正 1 绿",
			"Z_GREEN_2" => "正 2 绿",
			"Z_GREEN_3" => "正 3 绿",
			"Z_GREEN_4" => "正 4 绿",
			"Z_GREEN_5" => "正 5 绿",
			"Z_GREEN_6" => "正 6 绿",
		),
	),
);
$GLOBALS["IGXGCbetonId"] = array(	//IG香港彩-游戏类型
	"0" => "特碼A",
	"1" => "特碼B",
	"2" => "正碼A",
	"3" => "正碼B",
	"5" => "正碼特1",
	"6" => "正碼特2",
	"7" => "正碼特3",
	"8" => "正碼特4",
	"9" => "正碼特5",
	"10" => "正碼特6",
	"11" => "三全中",
	"12" => "三中二[中二]",
	"13" => "三中二[中三]",
	"14" => "二全中",
	"15" => "二中特[中二]",
	"16" => "二中特[中特]",
	"17" => "特串",
	"18" => "過關",
	"19" => "特肖",
	"20" => "特碼頭",
	"21" => "特碼尾",
	"22" => "五行",
	"23" => "半波",
	"24" => "七碼單",
	"25" => "七碼雙",
	"26" => "七碼大",
	"27" => "七碼小",
	"28" => "二肖",
	"29" => "三肖",
	"30" => "四肖",
	"31" => "五肖",
	"32" => "六肖",
	"33" => "一肖中",
	"34" => "一肖不中",
	"35" => "尾數中",
	"36" => "尾數不中",
	"37" => "二肖連中",
	"38" => "三肖連中",
	"39" => "四肖連中",
	"40" => "五肖連中",
	"41" => "二肖連不中",
	"42" => "三肖連不中",
	"43" => "四肖連不中",
	"44" => "五肖連不中",
	"45" => "二尾連中",
	"46" => "三尾連中",
	"47" => "四尾連中",
	"48" => "二尾連不中",
	"49" => "三肖連不中",
	"50" => "四尾連不中",
	"51" => "五不中",
	"52" => "六不中",
	"53" => "七 不中",
	"54" => "八不中",
	"55" => "九不中",
	"56" => "十不中",
	"57" => "五中一",
	"58" => "六中一",
	"59" => "七中一",
	"60" => "八中一",
	"61" => "九中一",
	"62" => "十中一",
	"63" => "1粒任中",
	"64" => "2粒任中",
	"65" => "3粒任中",
	"66" => "4粒任中",
	"67" => "5粒任中",
);
$GLOBALS["IGXGCbetTypeId"] = array(	//IG香港彩-游戏类型
	"50" => "單",
	"51" => "雙",
	"52" => "大",
	"53" => "小",
	"54" => "合單",
	"55" => "合雙",
	"56" => "尾大",
	"57" => "尾小",
	"58" => "紅",
	"59" => "綠",
	"60" => "藍",
	"61" => "鼠",
	"62" => "牛",
	"63" => "虎",
	"64" => "免",
	"65" => "龍",
	"66" => "蛇",
	"67" => "馬",
	"68" => "羊",
	"69" => "猴",
	"70" => "雞",
	"71" => "狗",
	"72" => "豬",
	"73" => "金",
	"74" => "木",
	"75" => "水",
	"76" => "火",
	"64" => "土或兔",
	"77" => "红單",
	"78" => "红双",
	"79" => "红大",
	"80" => "红小",
	"81" => "蓝單",
	"82" => "蓝双",
	"83" => "蓝大",
	"84" => "蓝小",
	"85" => "綠單",
	"86" => "綠双",
	"87" => "綠大",
	"88" => "綠小",
	"89" => "正碼 1 單",
	"90" => "正碼 2 單",
	"91" => "正碼 3 單",
	"92" => "正碼 4 單",
	"93" => "正碼 5 單",
	"94" => "正碼 6 單",
	"95" => "正碼 1 雙",
	"96" => "正碼 2 雙",
	"97" => "正碼 3 雙",
	"98" => "正碼 4 雙",
	"99" => "正碼 5 雙",
	"100" => "正碼 6 雙",
	"101" => "正碼 1 大",
	"102" => "正碼 2 大",
	"103" => "正碼 3 大",
	"104" => "正碼 4 大",
	"105" => "正碼 5 大",
	"106" => "正碼 6 大",
	"107" => "正碼 1 小",
	"108" => "正碼 2 小",
	"109" => "正碼 3 小",
	"110" => "正碼 4 小",
	"111" => "正碼 5 小",
	"112" => "正碼 6 小",
	"113" => "正碼 1 紅",
	"114" => "正碼 2 紅",
	"115" => "正碼 3 紅",
	"116" => "正碼 4 紅",
	"117" => "正碼 5 紅",
	"118" => "正碼 6 紅",
	"119" => "正碼 1 藍",
	"120" => "正碼 2 藍",
	"121" => "正碼 3 藍",
	"122" => "正碼 4 藍",
	"123" => "正碼 5 藍",
	"124" => "正碼 6 藍",
	"125" => "正碼 1 綠",
	"126" => "正碼 2 綠",
	"127" => "正碼 3 綠",
	"128" => "正碼 4 綠",
	"129" => "正碼 5 綠",
	"130" => "正碼 6 綠",
);
$GLOBALS["IGXGCbetDetails"] = array(//IG香港彩-下注明细
	"ODD" => "單",
	"EVEN" => "雙",
	"BIG" => "大",
	"SMALL" => "小",
	"SUM_ODD" => "合單",
	"SUM_EVEN" => "合雙",
	"TAIL_BIG" => "尾大",
	"TAIL_SMALL" => "尾小",
	"RED" => "紅",
	"GREEN" => "綠",
	"BLUE" => "藍",
	"SHU" => "鼠",
	"NIU" => "牛",
	"HU" => "虎",
	"TU" => "免",
	"LONG" => "龍",
	"SHE" => "蛇",
	"MA" => "馬",
	"YANG" => "羊",
	"HOU" => "猴",
	"JI" => "雞",
	"GOU" => "狗",
	"ZHU " => "豬",
	"JIN" => "金",
	"MU" => "木",
	"SHUI" => "水",
	"HUO" => "火",
	"TU" => "土",
	"RED_ODD " => "红單",
	"RED_EVEN" => "红双",
	"RED_BIG" => "红大",
	"RED_SMALL" => "红小",
	"BLUE_ODD" => "蓝單",
	"BLUE_EVEN" => "蓝双",
	"BLUE_BIG" => "蓝大",
	"BLUE_SMALL" => "蓝小",
	"GREEN_ODD" => "綠單",
	"GREEN_EVEN" => "綠双",
	"GREEN_BIG" => "綠大",
	"GREEN_SMALL" => "綠小",
	"Z_ODD_1" => "正碼 1 單",
	"Z_ODD_2" => "正碼 2 單",
	"Z_ODD_3" => "正碼 3 單",
	"Z_ODD_4" => "正碼 4 單",
	"Z_ODD_5" => "正碼 5 單",
	"Z_ODD_6" => "正碼 6 單",
	"Z_EVEN_1" => "正碼 1 雙",
	"Z_EVEN_2" => "正碼 2 雙",
	"Z_EVEN_3" => "正碼 3 雙",
	"Z_EVEN_4" => "正碼 4 雙",
	"Z_EVEN_5" => "正碼 5 雙",
	"Z_EVEN_6" => "正碼 6 雙",
	"Z_BIG_1" => "正碼 1 大",
	"Z_BIG_2" => "正碼 2 大",
	"Z_BIG_3 " => "正碼 3 大",
	"Z_BIG_4" => "正碼 4 大",
	"Z_BIG_5" => "正碼 5 大",
	"Z_BIG_6" => "正碼 6 大",
	"Z_SMALL_1" => "正碼 1 小",
	"Z_SMALL_2" => "正碼 2 小",
	"Z_SMALL_3" => "正碼 3 小",
	"Z_SMALL_4" => "正碼 4 小",
	"Z_SMALL_5" => "正碼 5 小",
	"Z_SMALL_6" => "正碼 6 小",
	"Z_RED_1" => "正碼 1 紅",
	"Z_RED_2" => "正碼 2 紅",
	"Z_RED_3" => "正碼 3 紅",
	"Z_RED_4" => "正碼 4 紅",
	"Z_RED_5" => "正碼 5 紅",
	"Z_RED_6" => "正碼 6 紅",
	"Z_BLUE_1" => "正碼 1 藍",
	"Z_BLUE_2" => "正碼 2 藍",
	"Z_BLUE_3" => "正碼 3 藍",
	"Z_BLUE_4" => "正碼 4 藍",
	"Z_BLUE_5" => "正碼 5 藍",
	"Z_BLUE_6" => "正碼 6 藍",
	"Z_GREEN_1" => "正碼 1 綠",
	"Z_GREEN_2" => "正碼 2 綠",
	"Z_GREEN_3" => "正碼 3 綠",
	"Z_GREEN_4" => "正碼 4 綠",
	"Z_GREEN_5" => "正碼 5 綠",
	"Z_GREEN_6" => "正碼 6 綠",
)
$GLOBALS["AGGameTypeInfo"] = array (
	"AG捕鱼" => array(
		"dataType"=>"HSR",
		"transferType" => "HTR",		//还有一个养鱼的HPR未处理
	),	
	"AG电游" => array(
		"dataType"=>"EBR",
		"transferType" => "TR",
	),	
	"AG真人" => array(
		"dataType"=>"GR",
		"transferType" => "TR",
	),	
	
	
)
$GLOBALS["AGCasinoGameTypeId"] = array(	//AG 视讯游戏类别
	"BAC" => "百家乐",
	"CBAC" => "包桌百家乐",
	"LINK" => "多台",
	"DT" => "龙虎",
	"SHB" => "骰宝",
	"ROU" => "轮盘",
	"FT" => "番摊",
	"LBAC" => "竞咪百家乐",
	"ULPK" => "终极德州扑克",
	"SBAC" => "保险百家乐",
	"NN" => "牛牛",
	"BJ" => "21 点",
	"ZJH" => "炸金花",
);
$GLOBALS["AGCasinoPlayTypeId"] = array(	//AG 视讯下注类型(AG的游戏与玩法不需要直接挂靠）
	"1" => "庄",
	"2" => "闲",
	"3" => "和",
	"4" => "庄对",
	"5" => "闲对",
	"6" => "大",
	"7" => "小",
	"8" => "莊保險",
	"9" => "閑保險",
	"11" => "庄免佣",
	"12" => "庄龙宝",
	"13" => "闲龙宝",
	"21" => "龙",
	"22" => "虎",
	"23" => "和（龙虎）",
	"41" => "大",
	"42" => "小 ",
	"43" => "单",
	"44" => "双",
	"45" => "全围",
	"46" => "围 1",
	"47" => "围 2 ",
	"48" => "围 3",
	"49" => "围 4 ",
	"50" => "围 5 ",
	"51" => "围 6",
	"52" => "单点 1 ",
	"53" => "单点 2 ",
	"54" => "单点 3 ",
	"55" => "单点 4 ",
	"56" => "单点 5",
	"57" => "单点 6 ",
	"58" => "对子 1 ",
	"59" => "对子 2",
	"60" => "对子 3 ",
	"61" => "对子 4",
	"62" => "对子 5 ",
	"63" => "对子 6",
	"64" => "组合 12 ",
	"65" => "组合 13",
	"66" => "组合 14 ",
	"67" => "组合 15",
	"68" => "组合 16",
	"69" => "组合 23",
	"70" => "组合 24",
	"71" => "组合 25 ",
	"72" => "组合 26 ",
	"73" => "组合 34 ",
	"74" => "组合 35",
	"75" => "组合 36",
	"76" => "组合 45",
	"77" => "组合 46 ",
	"78" => "组合 56",
	"79" => "和值 4",
	"80" => "和值 5 ",
	"81" => "和值 6",
	"82" => "和值 7",
	"83" => "和值 8",
	"84" => "和值 9",
	"85" => "和值 10",
	"86" => "和值 11",
	"87" => "和值 12",
	"88" => "和值 13",
	"89" => "和值 14",
	"90" => "和值 15",
	"91" => "和值 16",
	"92" => "和值 17",
	"101" => "直接注",
	"102" => "分注",
	"103" => "街注",
	"104" => "三數",
	"105" => "4 個號碼",
	"106" => "角注",
	"107" => "列注(列 1)",
	"108" => "列注(列 2)",
	"109" => "列注(列 3)",
	"110" => "線注",
	"111" => "打一",
	"112" => "打二",
	"113" => "打三",
	"114" => "紅",
	"115" => "黑",
	"116" => "大",
	"117" => "小",
	"118" => "單",
	"119" => "雙",
	"130" => "1 番",
	"131" => "2 番",
	"132" => "3 番",
	"133" => "4 番",
	"134" => "1 念 2",
	"135" => "1 念 3",
	"136" => "1 念 4",
	"137" => "2 念 1",
	"138" => "2 念 3",
	"139" => "2 念 4",
	"140" => "3 念 1",
	"141" => "3 念 2",
	"142" => "3 念 4",
	"143" => "4 念 1",
	"144" => "4 念 2",
	"145" => "4 念 3",
	"146" => "角(1,2)",
	"147" => "單",
	"148" => "角(1,4)",
	"149" => "角(2,3)",
	"150" => "雙",
	"151" => "角(3,4)",
	"152" => "1,2 四 通",
	"153" => "1,2 三 通",
	"154" => "1,3 四 通",
	"155" => "1,3 二 通",
	"156" => "1,4 三 通",
	"157" => "1,4 二 通",
	"158" => "2,3 四 通",
	"159" => "2,3 一 通",
	"160" => "2,4 三 通",
	"161" => "2,4 一 通",
	"162" => "3,4 二 通",
	"163" => "3,4 一 通",
	"164" => "三門(3,2,1)",
	"165" => "三門(2,1,4)",
	"166" => "三門(1,4,3)",
	"167" => "三門(4,3,2)",
	"180" => "底注+盲注",
	"181" => "一倍加注",
	"182" => "二倍加注",
	"183" => "三倍加注",
	"184" => "四倍加注",
	"211" => "闲 1 平倍",
	"212" => "闲 1 翻倍",
	"213" => "闲 2 平倍",
	"214" => "闲 2 翻倍",
	"215" => "闲 3 平倍",
	"216" => "闲 3 翻倍",
	"220" => "底注",
	"221" => "分牌",
	"222" => "保险",
	"223" => "分牌保险",
	"224" => "加注",
	"225" => "分牌加注",
	"226" => "完美对子",
	"227" => "21+3",
	"228" => "旁注",
	"229" => "旁注分牌",
	"230" => "旁注保险",
	"231" => "旁注分牌保险",
	"232" => "旁注加注",
	"233" => "旁注分牌加注",
	"260" => "龙",
	"261" => "凤",
	"262" => "对 8 以上",
	"263" => "同花",
	"264" => "顺子",
	"265" => "豹子",
	"266" => "同花顺",
);
