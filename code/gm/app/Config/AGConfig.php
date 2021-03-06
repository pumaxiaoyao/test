<?php

namespace App\Config;

/**
 *基础配置类
 */
class AGConfig
{
    const gameName = [
        1 => "AG视讯",
        2 => "AG电游",
        3 => "AG捕鱼",
        4 => "AG体育",
    ];
    const gameType = [
		//---------真人视讯
		"BAC" => [1,"百家乐"],
		"CBAC" => [1,"包桌百家乐"],
		"LINK" => [1,"多台"],
		"DT" => [1,"龙虎"],
		"SHB" => [1,"骰宝"],
		"ROU" => [1,"轮盘"],
		"FT" => [1,"番摊"],
		"LBAC" => [1,"竞咪百家乐"],
		"ULPK" => [1,"终极德州扑克"],
		"SBAC" => [1,"保险百家乐"],
		"NN" => [1,"牛牛"],
		"BJ" => [1,"21 点"],
		"ZJH" => [1,"炸金花"],
		//---------AG电游
		"SL1" => [2,"巴西世界杯"],
		"SL2" => [2,"疯狂水果店"],
		"SL3" => [2,"3D水族馆"],
		"PK_J" => [2,"视频扑克(杰克高手)"],
		"SL4" => [2,"极速赛车"],
		"PKBJ" => [2,"新视频扑克(杰克高手)"],
		"FRU" => [2,"水果拉霸"],
		"SLM1" => [2,"美女沙排(沙滩排球)"],
		"SLM2" => [2,"运财羊(新年运财羊)"],
		"SLM3" => [2,"武圣传"],
		"SC01" => [2,"幸运老虎机"],
		"TGLW" => [2,"极速幸运轮"],
		"SLM4" => [2,"武则天"],
		"TGCW" => [2,"赌场战争"],
		"SB01" => [2,"太空漫游"],
		"SB02" => [2,"复古花园"],
		"SB03" => [2,"关东煮"],
		"SB04" => [2,"牧场咖啡"],
		"SB05" => [2,"甜一甜屋"],
		"SB06" => [2,"日本武士"],
		"SB07" => [2,"象棋老虎机"],
		"SB08" => [2,"麻将老虎机"],
		"SB09" => [2,"西洋棋老虎机"],
		"SB10" => [2,"开心农场"],
		"SB11" => [2,"夏日营地"],
		"SB12" => [2,"海底漫游"],
		"SB13" => [2,"鬼马小丑"],
		"SB14" => [2,"机动乐园"],
		"SB15" => [2,"惊吓鬼屋"],
		"SB16" => [2,"疯狂马戏团"],
		"SB17" => [2,"海洋剧场"],
		"SB18" => [2,"水上乐园"],
		"SB25" => [2,"土地神"],
		"SB26" => [2,"布袋和尚"],
		"SB27" => [2,"正财神"],
		"SB28" => [2,"武财神"],
		"SB29" => [2,"偏财神"],
		"SB19" => [2,"空中战争"],
		"SB20" => [2,"摇滚狂迷"],
		"SB21" => [2,"越野机车"],
		"SB22" => [2,"埃及奥秘"],
		"SB23" => [2,"欢乐时光"],
		"SB24" => [2,"侏罗纪"],
		"AV01" => [2,"性感女仆"],
		"XG01" => [2,"龙珠"],
		"XG02" => [2,"幸运8"],
		"XG03" => [2,"闪亮女郎"],
		"XG04" => [2,"金鱼"],
		"XG05" => [2,"中国新年"],
		"XG06" => [2,"海盗王"],
		"XG07" => [2,"鲜果狂热"],
		"XG08" => [2,"小熊猫"],
		"XG09" => [2,"大豪客"],
		"SB30" => [2,"灵猴献瑞"],
		"SB31" => [2,"天空守护者"],
		"PKBD" => [2,"百搭二王"],
		"PKBB" => [2,"红利百搭"],
		"SB32" => [2,"齐天大圣"],
		"SB33" => [2,"糖果碰碰乐"],
		"SB34" => [2,"冰河世界"],
		"FRU2" => [2,"水果拉霸2"],
		"TG01" => [2,"21点(电子游戏)"],
		"TG02" => [2,"百家乐(电子游戏)"],
		"TG03" => [2,"轮盘(电子游戏)"],
		"SB35" => [2,"欧洲列强争霸"],
		"SB36" => [2,"捕鱼王者"],
		"SB37" => [2,"上海百乐门"],
		"SB38" => [2,"竞技狂热"],
		"SB39" => [2,"太空水果"],
		"SB40" => [2,"秦始皇"],
		"TA01" => [2,"多手二十一点低额投注"],
		"TA02" => [2,"多手二十一点"],
		"TA05" => [2,"1手二十一点"],
		"TA07" => [2,"Hilo低额投注"],
		"TA0C" => [2,"3手Hilo高额投注"],
		"TA0Z" => [2,"5手杰克高手"],
		"TA12" => [2,"1手杰克高手"],
		"TA17" => [2,"1手百搭小丑"],
		"TA18" => [2,"10手百搭小丑"],
		"TA1C" => [2,"1手百搭二王"],
		"TA1F" => [2,"50手百搭二王"],
		"TA0U" => [2,"经典轿车"],
		"TA0V" => [2,"星际大战"],
		"TA0W" => [2,"海盗夺宝"],
		"TA0X" => [2,"巴黎茶座"],
		"TA0Y" => [2,"金龙献宝"],
		"XG10" => [2,"龙舟竞渡"],
		"XG11" => [2,"中秋佳节"],
		"XG12" => [2,"韩风劲舞"],
		"XG13" => [2,"美女大格斗"],
		"XG14" => [2,"龙凤呈祥"],
		"XG16" => [2,"黄金对垒"],
		"TA0P" => [2,"怪兽食坊"],
		"TA0S" => [2,"足球竞赛"],
		"TA0L" => [2,"无法无天"],
		"TA0M" => [2,"法老秘密"],
		"TA0N" => [2,"烈火战车"],
		"TA0O" => [2,"捕猎季节"],
		"TA0Q" => [2,"日与夜"],
		"TA0R" => [2,"七大奇迹"],
		"TA0T" => [2,"珠光宝气"],
		"TA1O" => [2,"欧洲轮盘(移动版)"],
		"TA1L" => [2,"欧洲轮盘(桌面版)"],
		"SV41" => [2,"富贵金鸡"],
		"DTA0" => [2,"赛亚烈战"],
		"SX02" => [2,"街头烈战"],
		"SC03" => [2,"金拉霸"],
		"SB45" => [2,"猛龙传奇"],
		"DTAR" => [2,"英雄荣耀"],
		"DTB1" => [2,"快乐农庄"],
		"DTAM" => [2,"封神榜"],
		"DTAZ" => [2,"摇滚之夜"],
		"SB49" => [2,"金龙珠"],
		"DTA8" => [2,"五行世界"],
		"DTAB" => [2,"梦幻森林"],
		"DTAF" => [2,"财神到"],
		"DTAG" => [2,"新年到"],
		"DTAQ" => [2,"龙凤呈祥"],
		"DTAT" => [2,"福禄寿"],
		"SB50" => [2,"XIN哥来了"],
		"YFP" => [2,"水果派对"],
		"YDZ" => [2,"德州牛仔"],
		"YBIR" => [2,"飞禽走兽"],
		"YMFD" => [2,"森林舞会多人版"],
		"YFD" => [2,"森林舞会"],
		"YBEN" => [2,"奔驰宝马"],
		"YHR" => [2,"极速赛马"],
		"YMFR" => [2,"水果拉霸多人版"],
		"YGS" => [2,"猜猜乐"],
		"YFR" => [2,"水果拉霸"],
		"YMGS" => [2,"猜猜乐多人版"],
		"YMBN" => [2,"百人牛牛"],
		"YGFS" => [2,"多宝水果拉霸"],
		"YJFS" => [2,"彩金水果拉霸"],
		"YMBI" => [2,"飞禽走兽多人版"],
		"YMBA" => [2,"牛牛对战"],
		"YMBZ" => [2,"奔驰宝马多人版"],
		"YMAC" => [2,"动物狂欢"],
		//-------------AG捕鱼
		"HUNTER" => [3,"捕鱼王"],
		//-------------AG体育
		"FIFA" => [4,"体育"],
		"SPTA" => [4,"AG体育"],
    ];
    const gameBetOn = [
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
	];
}
