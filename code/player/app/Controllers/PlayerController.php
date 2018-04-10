<?php
namespace App\Controllers;

use App\Config\Config;
use App\Controllers\Def;
use App\Controllers\PlayerAPIController as PlayerAPI;
use App\Core\View;
use App\Libs\GeetestLib as GT;

class PlayerController extends BaseController
{

    /**
     * 玩家首页
     */
    public static function index()
    {
        $factory = View::getView();
        $pageArgs = PlayerAPI::makePageArgs();
        return $factory->make('Player.Home.home', $pageArgs)
            ->render();
    }

    /**
     * 玩家注册界面
     */
    public static function register()
    {
        $factory = View::getView();
        $pageArgs = PlayerAPI::makePageArgs();
        return $factory->make('Player.manage.register.register', $pageArgs)
            ->render();
    }

    /**
     * 玩家登录界面
     */
    public static function login()
    {
        $factory = View::getView();
        $pageArgs = PlayerAPI::makePageArgs();
        return $factory->make('Player.manage.login.login', $pageArgs)
            ->render();
    }

    public static function retrieve()
    {
        $factory = View::getView();
        $pageArgs = PlayerAPI::makePageArgs();
        return $factory->make('Player.manage.retrieve.retrieve', $pageArgs)
            ->render();
    }

    /**
     * 调用极验的接口进行验证码校验
     * TODO：后台对校验接口的二次审核
     */
    public static function getCaptcha()
    {
        $GtSdk = new GT(Config::base["CAPTCHA_ID"], Config::base["PRIVATE_KEY"]);
        $data = array(
            "user_id" => "test", # 网站用户id
            "client_type" => "web", #web:电脑上的浏览器；h5:手机上的浏览器，包括移动应用内完全内置的web_view；native：通过原生SDK植入APP应用的方式
            "ip_address" => "47.91.199.24", # 请在此处传输用户请求验证时所携带的IP
        );
        $status = $GtSdk->pre_process($data, 1);
        $_SESSION['gtserver'] = $status;
        $_SESSION['user_id'] = $data['user_id'];
        return $GtSdk->get_response_str();
    }


    public static function registerok()
    {
        $factory = View::getView();
        $pageArgs = PlayerAPI::makePageArgs();
        return $factory->make('Player.manage.registerok.registerok', $pageArgs)
            ->render();
    }

    public static function accountSetting($request)
    {
        /**
         * 用户中心界面及处理
         */
        $factory = View::getView();
        $pageArgs = PlayerAPI::makeASPageArgs();
        return $factory->make('Player.AccountSetting.home.home', $pageArgs)
            ->render();
    }

    public static function receivebox($request)
    {
        $factory = View::getView();
        $pageArgs = PlayerAPI::makeASPageArgs();
        $pageIndex = getArrayValue("pageIndex", "1", $request);
        $recvMails = PlayerAPI::getMailData($pageIndex);
        $showMailInfo = paginate($recvMails, Config::base["maxCountPerPage"], $pageIndex);
        $pageArgs["recvMails"] = $showMailInfo[0];
        $pageArgs["maxPage"] = $showMailInfo[1];
        $pageArgs["curPage"] = $showMailInfo[2];
        return $factory->make('Player.AccountSetting.message.layout', $pageArgs)
            ->render();
    }

    public static function MsDetail($request)
    {
        $factory = View::getView();
        $mailId = getArrayValue("messageid", 1, $request);
        $mailType = getArrayValue("type", 1, $request);
        $mailInfo = PlayerAPI::getMailDetailData($mailId);
        
        $mail = $mailInfo[0]?$mailInfo[1]:[];

        $t = [
            "MailType"=>$mailType,
            "MailId"=>$mailId,
            "MailTitle"=>getArrayValue("title", "", $mail),
            "MailTime"=>parseDate((int)getArrayValue("time", "", $mail)),
            "MailContent"=>getArrayValue("content", "", $mail)
        ];

        return $factory->make('Player.AccountSetting.msgDetail.content', $t)
            ->render();
    }
    
    public static function BettingRecords($request)
    {
        $factory = View::getView();
        $pageArgs = PlayerAPI::makeASPageArgs();
        $pageArgs["startTime"] = getArrayValue("starttime", "month", $request);
        // $requestGP = getArrayValue("productid", "", $request);
        $pageArgs["BetRecords"] = PlayerAPI::getBetRecordData($pageArgs["startTime"]);
        return $factory->make('Player.AccountSetting.betrecord.layout', $pageArgs)
            ->render();
    }

    public static function deposit($request)
    {
        $factory = View::getView();
        $pageArgs = PlayerAPI::makeASPageArgs();

        return $factory->make('Player.AccountSetting.deposit.layout', $pageArgs)
            ->render();
    }
    public static function withdrawal($request)
    {
        $factory = View::getView();
        $pageArgs = PlayerAPI::makeASPageArgs();
        $cards = PlayerAPI::getBankInfo();
        $cardsToShow = [];
        foreach ($cards as $card) {
            if ($card["status"] == 1){
                $bankInfo = Config::bankTypes[$card["bankType"]];
                array_push($cardsToShow,[
                    "sn"=>$bankInfo["sn"],
                    "name"=>$bankInfo["name"],
                    "cardNo"=>"&nbsp; ****&nbsp; ****&nbsp; ****&nbsp; ".substr($card["cardNo"], -4), // 显示后4位
                    "id"=>$card["id"]
                ]);
            } 
        }
        $pageArgs["cards"] = $cardsToShow;
        return $factory->make('Player.AccountSetting.withdrawal.layout', $pageArgs)
            ->render();
    }

    public static function transfer($request)
    {
        $factory = View::getView();
        $pageArgs = PlayerAPI::makeASPageArgs();
        
        $platforms = [];
        foreach (array_keys(Config::platform) as $gp) {
            array_push($platforms, "'" . $gp . "'");
        }
        $pageArgs["ValidPlatforms"] = join(",", $platforms);
        
        
        $pageArgs["GPS"] = Config::platform;
        return $factory->make('Player.AccountSetting.transfer.layout', $pageArgs)
            ->render();
    }

    public static function History($request)
    {
        $factory = View::getView();
        $pageArgs = PlayerAPI::makeASPageArgs();
        $pageIndex = getArrayValue("pageIndex", "1", $request);
        $startTime = getArrayValue("starttime", "month", $request);
        $transtype = getArrayValue("TransferType", "All", $request);
        $a = Config::statusMap;
        $optype = Config::transMap[$transtype];
        $records = PlayerAPI::getTransctRecords($optype, $startTime);
        $recordInfo = paginate($records["data"], Config::base["maxCountPerPage"], $pageIndex);
        $dataForBlade = [];
        for ($x=0;$x<count($recordInfo[0]);$x++) {
            $record = $recordInfo[0][$x];
            $_ = [
                "id"=>$x + 1,
                "time"=>\parseDate(\getArrayValue("recordTime","0",$record)),
                "dno"=>\getArrayValue("dno","",$record),
                "status"=>Config::statusMap[(int)getArrayValue("checkStatus","",$record)],
                "amount"=>\getArrayValue("amount","",$record),
                "optype"=>Config::opTypeMap[\getArrayValue("opType","",$record)],
            ];
            array_push($dataForBlade, $_);
        }
        $pageArgs["historyType"] = "All";
        $pageArgs["historyTime"] = "month";

        $pageArgs["records"] = $dataForBlade;
        $pageArgs["maxPage"] = $recordInfo[1];
        $pageArgs["curPage"] = $recordInfo[2];

        return $factory->make('Player.AccountSetting.history.layout', $pageArgs)
            ->render();
    }



    public static function BankManager($request)
    {
        $factory = View::getView();
        $pageArgs = PlayerAPI::makeASPageArgs();
        $cards = PlayerAPI::getBankInfo();
        
        $cardsToShow = [];
        foreach ($cards as $card) {
            if ($card["status"] == 1){
                $bankInfo = Config::bankTypes[$card["bankType"]];
                array_push($cardsToShow,[
                    "sn"=>$bankInfo["sn"],
                    "name"=>$bankInfo["name"],
                    "cardNo"=>substr($card["cardNo"], -4), // 显示后4位
                    "id"=>$card["id"]
                ]);
            } 
        }
        $pageArgs["cards"] = $cardsToShow;
        return $factory->make('Player.AccountSetting.bankCards.layout', $pageArgs)
            ->render();
    }
}
