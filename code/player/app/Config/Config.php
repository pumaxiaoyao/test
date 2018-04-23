<?php

namespace App\Config;

use App\Controllers\PlayerRecordBalanceType as balaceType;
use App\Controllers\CheckStatus;
/**
 * 基础配置类
 */
class Config
{
    // 配置不需要验证Session键值是否有效的Action入口
    const validatorConfig = [
        "player" => [
            "ignore" => [
                "index",  // 首页
                "login", "retrieve", "getCaptcha", "BettingRecords", "register", "registerAccount", "namecheck", // 账号管理
                "iglottery", "iglotto", "lbcp","sportsbook", "aggame", "GetPlatformLogin", "bbgame", "LoginBBinGame",// 游戏
                "default", "helpText", "activities", "showDetail", "joinActivity"// 帮助
                    ],
            "skey" => "PlayerSessionID"
        ],
        "agent" => [
            "ignore" => [
                "index", "agentMode", "Policies", "Contact", // 首页
                "Apply", "checkAgentName", "login", "Retrieve", "getCaptcha",
                "agentReg" // 账号
            ],
            "skey" => "AgentSessionID"
        ]
    ];

    const base = [ // Page相关的配置
        "defaultTitle" => "Alien",
        "defaultPageKeywords" => "Alien",
        "defaultPageDesc" => "Alien",
        "maxCountPerPage" => 8, // 自定义分页器每页最大数据
        "needAjaxDebugInfo" => true, // 是否在Ajax请求的Json数据中添加debug信息返回
        "CAPTCHA_ID" => "ff3ec45a504c9c35ee0b4c09492871c5", // 极验配置参数 1
        "PRIVATE_KEY" => "820c9bb166c6e9750a1ffc76d8cd8a22", // 极验配置参数 2
    ];

    const platform = [
        "NB" => "牛博",
        "IBC" => "沙巴",
        "IG" => "埔京游戏",
        "AG" => "AG游戏",
        "BBIN" => "BBIN"
    ];

    const bankTypes = [
        1=>[
            "sn"=>"BOC", "name"=>"中国银行"
        ],
        2=>[
            "sn"=>"CCB", "name"=>"建设银行"
        ],
        3=>[
            "sn"=>"ICBC", "name"=>"工商银行"
        ],
        4=>[
            "sn"=>"ABC", "name"=>"农业银行"
        ],
        5=>[
            "sn"=>"CMB", "name"=>"招商银行"
        ],
        6=>[
            "sn"=>"CMBC", "name"=>"民生银行"
        ],
        10=>[
            "sn"=>"ECITIC", "name"=>"中信银行"
        ],
        11=>[
            "sn"=>"HXB", "name"=>"华夏银行"
        ],
        12=>[
            "sn"=>"CEB", "name"=>"光大银行"
        ],
        15=>[
            "sn"=>"CIB", "name"=>"兴业银行"
            ]
    ];

    const transMap = [
        "Deposit"=>balaceType::deposit,
        "Withdrawal"=>balaceType::withdrawal,
        "Transfer"=>balaceType::transactIn + balaceType::transactOut,
        "Adjustment"=>balaceType::bonus,
        "All"=> balaceType::deposit 
                + balaceType::withdrawal
                + balaceType::transactIn 
                + balaceType::transactOut 
                + balaceType::bonus
    ];
    
    const statusMap = [
        CheckStatus::wait=>"待审核",
        CheckStatus::agree=>"已审核",
        CheckStatus::refuse=>"已拒绝",
    ];

    const opTypeMap = [
        balaceType::deposit => "存款",
        balaceType::withdrawal => "取款",
        balaceType::transactIn => "转入",
        balaceType::transactOut => "转出",
        balaceType::rebate => "返水",
        balaceType::bonus => "红利",
        balaceType::depositBonus => "存款优惠",
        balaceType::transactIn + balaceType::transactOut =>"转账"
    ];
}