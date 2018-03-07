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
    3 => "Football",
    4 => "Ice Hockey",
    5 => "Tennis",
    6 => "Volleyball",
    7 => "Billiards",
    8 => "Baseball",
    9 => "Badminton",
    10 => "Golf",
    11 => "Motorsports",
    12 => "Swimming",
    13 => "Politics",
    14 => "Water Polo",
    15 => "Diving",
    16 => "Boxing",
    17 => "Archery",
    18 => "Table Tennis",
    19 => "Weightlifting",
    20 => "Canoeing",
    21 => "Gymnastics",
    22 => "Athletics",
    23 => "Equestrian",
    24 => "Handball",
    25 => "Darts",
    26 => "Rugby",
    27 => "Cricket",
    28 => "Field Hockey",
    29 => "Winter Sport",
    30 => "Squash",
    31 => "Entertainment",
    32 => "Net Ball",
    33 => "Cycling",
    34 => "Fencing",
    35 => "Judo",
    36 => "M. Pentathlon",
    37 => "Rowing",
    38 => "Sailing",
    39 => "Shooting",
    40 => "Taekwondo",
    41 => "Triathlon",
    42 => "Wrestling",
    43 => "Esports",
    44 => "MuayThai",
    50 => "Cricket",
    99 => "OtherSports",
    151 => "HorseRacing",
    152 => "Greyhounds",
    153 => "Harness",
    154 => "HorseRacing FixedOdds",
    161 => "NumberGame",
    180 => "VirtualSoccer",
    190 => "VirtualSoccer",
    191 => "VirtualSoccer",
    192 => "VirtualSoccer",
    181 => "VirtualHorseRacing",
    182 => "VirtualGreyhound",
    183 => "VirtualSpeedway",
    184 => "VirtualF1",
    185 => "VirtualCycling",
    186 => "VirtualTennis",
    196 => "VirtualTennis",
    193 => "VirtualBasketBall",
    199 => "VirtualMixParlay",
    202 => "Keno",
    251 => "Casino",
    208 => "RNGGame",
    209 => "MiniGame",
    210 => "Mobile",
);

$GLOBALS["oddsType"] = array(
    1 => "马来西亚盘", // Malay Odds
    2 => "香港盘", // Hong Kong Odds
    3 => "Decimal盘", //Decimal Odds
    4 => "印度盘", //Indo Odds
    5 => "美国盘", //American Odds
);

$GLOBALS["betTypeName"] = array(
    "1" => array(
        "name" => "让球",
        "argus" => array("h" => "主队", "a" => "客队"),
    ),
    "2" => array(
        "name" => "单双盘",
        "argus" => array("h" => "单", "a" => "双"),
    ),
    "3" => array(
        "name" => "大小盘",
        "argus" => array("h" => "大", "a" => "小"),
    ),
    "4/413" => array(
        "name" => "波胆",
        "argus" => array("n1" => "n2", "n2" => "n1", "AOS" => "其他所有"),
    ),
    "5" => array(
        "name" => "全场.标准盘",
        "argus" => array("1" => "主队", "2" => "客队", "x" => "平"),
    ),
    "6" => array("name" => "总进球"),
    "7" => array("name" => "上半场让球"),
    "8" => array("name" => "上半场大小盘"),
    "9" => array("name" => "混合过关"),
    "10" => array("name" => "优胜冠军"),
    "11" => array("name" => "总角球数 "),
    "12" => array("name" => "上半场.单双盘"),
    "13" => array("name" => "零失球"),
    "14" => array("name" => "最先进球/最后进球"),
    "15" => array("name" => "上半场.标准盘"),
    "16" => array("name" => "半场.全场 "),
    "17" => array("name" => "下半场让球"),
    "18" => array("name" => "下半场大小盘"),
    "19" => array("name" => "Substitutes ( 替换)"),
    "20" => array(
        "name" => "独赢",
        "argus" => array("h" => "主队", "a" => "客队"),
    ),
    "21" => array("name" => "上半场独赢"),
    "22" => array("name" => "下一进球"),
    "23" => array("name" => "下一角球"),
    "24" => array("name" => "双重机会"),
    "25" => array("name" => "获胜球队"),
    "26" => array("name" => "双方/一方/双方皆不得分"),
    "27" => array("name" => "零失球的胜方"),
    "28" => array("name" => "三项让分投注"),
    "29" => array("name" => "串关"),
    "30" => array("name" => "上半场波胆"),
    "121" => array("name" => "主队 (不获胜球队)"),
    "122" => array("name" => "客队 (不获胜球队)"),
    "123" => array("name" => "和局/不是和局"),
    "124" => array("name" => "全场 1X2 亚洲盘"),
    "125" => array("name" => "上半场 1X2 亚洲盘"),
    "126" => array("name" => "上半场总进球"),
    "127" => array("name" => "上半场最先进球/最后进球"),
    "128" => array("name" => "半场 / 全场 单/双"),
    "133/438" => array("name" => "主队胜出两个半场"),
    "134/439" => array("name" => "客队胜出两个半场"),
    "135" => array("name" => "点球决胜"),
    "140/442" => array("name" => "进球最多的半场"),
    "141/443" => array("name" => "主队进球最多的半场"),
    "142/444" => array("name" => "客队进球最多的半场 "),
    "145" => array("name" => "两队皆进球 "),
    "146/433" => array("name" => "下半场两队皆进球"),
    "147/436" => array("name" => "主队两个半场皆进球"),
    "148/437" => array("name" => "客队两个半场皆进球 "),
    "149/440" => array("name" => "主队胜出其中一个半场"),
    "150/441" => array("name" => "客队胜出其中一个半场"),
    "151/410" => array("name" => "上半场双重机会"),
    "152/416" => array("name" => "上半场/全场波胆 "),
    "157" => array("name" => "单双盘"),
    "159/406" => array("name" => "准确的总进球 "),
    "160" => array("name" => "下一个进球 "),
    "161/407" => array("name" => "准确的主队总进球"),
    "162/409" => array("name" => "准确的客队总进球"),
    "163/144" => array("name" => "赛果/总进球大小"),
    "164" => array("name" => "加时赛下一个进球"),
    "165" => array("name" => "加时赛上半场波胆 "),
    "166" => array("name" => "加时赛波胆 "),
    "167" => array("name" => "加时赛上半场 1x2"),
    "168" => array("name" => "哪一队可晋级 "),
    "169" => array("name" => "下一个进球时间"),
    "170" => array("name" => "哪队进球"),
    "171/408" => array("name" => "淨胜球数"),
    "172/415" => array("name" => "赛果 /最先进球的球队"),
    "173" => array("name" => "是否有加时赛"),
    "174" => array("name" => "加时赛是否进球"),

);

$GLOBALS["NBbetTypeName"] = array(
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
