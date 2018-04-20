<?php

namespace App\Config;

use App\Controllers\PlayerRecordBalanceType;
use App\Controllers\CheckStatus;
use App\Controllers\PlayerStatus;
use App\Controllers\AgentStatus;
/**
 * 基础配置类
 */
class Config
{
    public const validatorConfig = [
        "home" => [
            "GET" => ["index", "Login", "Retrieve", "getcaptcha", "BettingRecords", "Registered"],
            "POST" => ["nameCheck"],
            "skey" => ["PlayerSessionID", "PlayerName", "PlayerLoginStatus"]
        ],
        "message" => [
            "GET" => [],
            "POST" => [],
            "skey" => ["AgentSessionID", "AgentName", "AgentLoginStatus"]
        ],
        "default" => [
            "GET" => [],
            "POST" => [],
            "skey" => ["PlayerSessionID", "PlayerName", "PlayerLoginStatus"]
        ],
        "help" => [
            "GET" => [],
            "POST" => [],
            "skey" => ["PlayerSessionID", "PlayerName", "PlayerLoginStatus"]
        ],
        "game" => [
            "GET" => ["sportsbook"],
            "POST" => [],
            "skey" => ["PlayerSessionID", "PlayerName", "PlayerLoginStatus"]
        ],
    
    ];

    public const base = [ // Page相关的配置
        "defaultTitle" => "Alien",
        "defaultPageKeywords" => "Alien",
        "defaultPageDesc" => "Alien",
        "maxCountPerPage" => 8, // 自定义分页器每页最大数据
    ];

    public const captcha = [
        
        "CAPTCHA_ID" => "ff3ec45a504c9c35ee0b4c09492871c5",
        "PRIVATE_KEY" => "820c9bb166c6e9750a1ffc76d8cd8a22",
    ];

    public const dataCenter = [
        // "host" => "127.0.0.1", // "47.91.199.24",
        // "port" => "7878",
        "host" => "47.91.199.24", // "47.91.199.24",
        "port" => "7878",
        "isDebug" => true,
        "server" => [
            "player"=>"GatePlayer",
            "agent"=>"GateAgent",
            "gm"=>"Gm",
        ]
    ];

    public const platform = [
        // "NB" => "牛博",
        "IBC" => "沙巴",
        "IG" => "IG埔京",
        "AG" => "AG游戏",
        "BBIN" => "BBIN"
    ];

    public const platformGame = [
        "sport", "pk", "lotto", "lottery" 
    ];

    public const bankTypes = [
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

    public const transMap = [
        "Deposit"=>PlayerRecordBalanceType::deposit,
        "Withdrawal"=>PlayerRecordBalanceType::withdrawal,
        "Transfer"=>PlayerRecordBalanceType::transactIn + PlayerRecordBalanceType::transactOut,
        "Adjustment"=>PlayerRecordBalanceType::bonus,
        "Rebate" => PlayerRecordBalanceType::rebate,
        "All"=> PlayerRecordBalanceType::deposit 
                + PlayerRecordBalanceType::withdrawal
                + PlayerRecordBalanceType::transactIn 
                + PlayerRecordBalanceType::transactOut 
                + PlayerRecordBalanceType::bonus
                + PlayerRecordBalanceType::rebate
    ];
    
    public const statusMap = [
        CheckStatus::wait=>"待审核",
        CheckStatus::agree=>"已审核",
        CheckStatus::refuse=>"已拒绝",
    ];
    
    public const playerStatusMap = [
        PlayerStatus::check => "待审核",
        PlayerStatus::ok => "正常",
        PlayerStatus::lock => "锁定",
        PlayerStatus::checkFail => "审核失败"
    ];

    public const agentStatusMap = [
        AgentStatus::check => "待审核",
        AgentStatus::ok => "正常",
        AgentStatus::lock => "锁定",
        AgentStatus::checkFail => "审核失败"
    ];

    public const opTypeMap = [
        PlayerRecordBalanceType::deposit => "存款",
        PlayerRecordBalanceType::withdrawal => "取款",
        PlayerRecordBalanceType::transactIn => "转入",
        PlayerRecordBalanceType::transactOut => "转出",
        PlayerRecordBalanceType::rebate => "返水",
        PlayerRecordBalanceType::bonus => "红利",
        PlayerRecordBalanceType::depositBonus => "存款优惠",
        PlayerRecordBalanceType::transactIn + PlayerRecordBalanceType::transactOut =>"转账"
    ];

    public const agStatusTransMap = [
        CheckStatus::agree => "待终审",
        CheckStatus::refuse => "已通过",
        CheckStatus::wait => "待初审",
    ];


    public const actStatusTransMap = [
        0 => "待上架",
        1 => "已上架",
        2 => "已下架",
        3 => "已删除"
    ];

}