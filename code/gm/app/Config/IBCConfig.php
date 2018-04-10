<?php

namespace App\Config;
/**
 * 基础配置类
 */
class IBCConfig
{
    const sportsType = [
        1=>"Soccer",
        2=>"Basketball",
        3=>"Football",
        4=>"Ice Hockey",
        5=>"Tennis",
        6=>"Volleyball",
        7=>"Billiards",
        8=>"Baseball",
        9=>"Badminton",
        10=>"Golf",
        11=>"Motorsports",
        12=>"Swimming",
        13=>"Politics",
        14=>"Water Polo",
        15=>"Diving",
        16=>"Boxing",
        17=>"Archery",
        18=>"Table Tennis",
        19=>"Weightlifting",
        20=>"Canoeing",
        21=>"Gymnastics",
        22=>"Athletics",
        23=>"Equestrian",
        24=>"Handball",
        25=>"Darts",
        26=>"Rugby",
        27=>"Cricket",
        28=>"Field Hockey",
        29=>"Winter Sport",
        30=>"Squash",
        31=>"Entertainment",
        32=>"Net Ball",
        33=>"Cycling",
        34=>"Fencing",
        35=>"Judo",
        36=>"M. Pentathlon",
        37=>"Rowing",
        38=>"Sailing",
        39=>"Shooting",
        40=>"Taekwondo",
        41=>"Triathlon",
        42=>"Wrestling",
        43=>"Esports",
        44=>"MuayThai",
        50=>"Cricket",
        99=>"OtherSports",
        151=>"HorseRacing",
        152=>"Greyhounds",
        153=>"Harness",
        154=>"HorseRacing FixedOdds",
        161=>"NumberGame",
        180=>"VirtualSoccer",
        190=>"VirtualSoccer",
        191=>"VirtualSoccer",
        192=>"VirtualSoccer",
        181=>"VirtualHorseRacing",
        182=>"VirtualGreyhound",
        183=>"VirtualSpeedway",
        184=>"VirtualF1",
        185=>"VirtualCycling",
        186=>"VirtualTennis",
        196=>"VirtualTennis",
        193=>"VirtualBasketBall",
        199=>"VirtualMixParlay",
        202=>"Keno",
        251=>"Casino",
        208=>"RNGGame",
        209=>"MiniGame",
        210=>"Mobile"  
    ];

    const betTypeNames = [
        "1"=>[
            "name"=>"让球",
            "argus"=>["h"=>"主队", "a"=>"客队"]
                ],
        "2"=>[
            "name"=>"单双盘",
            "argus"=>["h"=>"单", "a"=>"双"]
        ],
        "3"=>[
            "name"=>"大小盘",
            "argus"=>["h"=>"大", "a"=>"小"]
        ],
        "4/413"=>[
            "name"=>"波胆",
            "argus"=>["n1"=>"n2", "n2"=>"n1", "AOS"=>"其他所有"]
        ],
        "5"=>[
            "name"=>"全场.标准盘",
            "argus"=>["1"=>"主队", "2"=>"客队", "x"=>"平"]
        ],
        "6"=>["name"=>"总进球"],
        "7"=>["name"=>"上半场让球"],
        "8"=>["name"=>"上半场大小盘"],
        "9"=>["name"=>"混合过关"],
        "10"=>["name"=>"优胜冠军"],
        "11"=>["name"=>"总角球数 "],
        "12"=>["name"=>"上半场.单双盘"],
        "13"=>["name"=>"零失球"],
        "14"=>["name"=>"最先进球/最后进球"],
        "15"=>["name"=>"上半场.标准盘"],
        "16"=>["name"=>"半场.全场 "],
        "17"=>["name"=>"下半场让球"],
        "18"=>["name"=>"下半场大小盘"],
        "19"=>["name"=>"Substitutes ( 替换)"],
        "20"=>[
            "name"=>"独赢",
            "argus"=>["h"=>"主队", "a"=>"客队"]
        ],
        "21"=>["name"=>"上半场独赢"],
        "22"=>["name"=>"下一进球"],
        "23"=>["name"=>"下一角球"],
        "24"=>["name"=>"双重机会"],
        "25"=>["name"=>"获胜球队"],
        "26"=>["name"=>"双方/一方/双方皆不得分"],
        "27"=>["name"=>"零失球的胜方"],
        "28"=>["name"=>"三项让分投注"],
        "29"=>["name"=>"串关"],
        "30"=>["name"=>"上半场波胆"],
        "121"=>["name"=>"主队 (不获胜球队)"],
        "122"=>["name"=>"客队 (不获胜球队)"],
        "123"=>["name"=>"和局/不是和局"],
        "124"=>["name"=>"全场 1X2 亚洲盘"],
        "125"=>["name"=>"上半场 1X2 亚洲盘"],
        "126"=>["name"=>"上半场总进球"],
        "127"=>["name"=>"上半场最先进球/最后进球"],
        "128"=>["name"=>"半场 / 全场 单/双"],
        "133/438"=>["name"=>"主队胜出两个半场"],
        "134/439"=>["name"=>"客队胜出两个半场"],
        "135"=>["name"=>"点球决胜"],
        "140/442"=>["name"=>"进球最多的半场"],
        "141/443"=>["name"=>"主队进球最多的半场"],
        "142/444"=>["name"=>"客队进球最多的半场 "],
        "145"=>["name"=>"两队皆进球 "],
        "146/433"=>["name"=>"下半场两队皆进球"],
        "147/436"=>["name"=>"主队两个半场皆进球"],
        "148/437"=>["name"=>"客队两个半场皆进球 "],
        "149/440"=>["name"=>"主队胜出其中一个半场"],
        "150/441"=>["name"=>"客队胜出其中一个半场"],
        "151/410"=>["name"=>"上半场双重机会"],
        "152/416"=>["name"=>"上半场/全场波胆 "],
        "157"=>["name"=>"单双盘"],
        "159/406"=>["name"=>"准确的总进球 "],
        "160"=>["name"=>"下一个进球 "],
        "161/407"=>["name"=>"准确的主队总进球"],
        "162/409"=>["name"=>"准确的客队总进球"],
        "163/144"=>["name"=>"赛果/总进球大小"],
        "164"=>["name"=>"加时赛下一个进球"],
        "165"=>["name"=>"加时赛上半场波胆 "],
        "166"=>["name"=>"加时赛波胆 "],
        "167"=>["name"=>"加时赛上半场 1x2"],
        "168"=>["name"=>"哪一队可晋级 "],
        "169"=>["name"=>"下一个进球时间"],
        "170"=>["name"=>"哪队进球"],
        "171/408"=>["name"=>"淨胜球数"],
        "172/415"=>["name"=>"赛果 /最先进球的球队"],
        "173"=>["name"=>"是否有加时赛"],
        "174"=>["name"=>"加时赛是否进球"],
        
    ];

    const oddsType = [
        1=>"马来西亚盘",// Malay Odds 
        2=>"香港盘",// Hong Kong Odds
        3=>"Decimal盘",//Decimal Odds
        4=>"印度盘",//Indo Odds
        5=>"美国盘",//American Odds
    ];
}