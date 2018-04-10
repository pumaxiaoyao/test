<?php
namespace App\Controllers;

use App\Config\Config;
use App\Controllers\Def;
use App\Controllers\AgentAPIController as AgentAPI;
use App\Core\View;
use App\Libs\GeetestLib as GT;

class AgentController extends BaseController
{
    public static function index()
    {
        $factory = View::getView();
        $pageArgs = AgentAPI::makePageArgs();
        $pageArgs["pageid"] = 0;
        return $factory->make('Agent.index.layout', $pageArgs)
            ->render();
    }

    public static function agentMode()
    {
        $factory = View::getView();
        $pageArgs = AgentAPI::makePageArgs();
        $pageArgs["pageid"] = 1;
        return $factory->make('Agent.index.layout', $pageArgs)
            ->render();
    }

    public static function Policies()
    {
        $factory = View::getView();
        $pageArgs = AgentAPI::makePageArgs();
        $pageArgs["pageid"] = 2;
        return $factory->make('Agent.index.layout', $pageArgs)
            ->render();
    }

    public static function Contact()
    {
        $factory = View::getView();
        $pageArgs = AgentAPI::makePageArgs();
        $pageArgs["pageid"] = 3;
        return $factory->make('Agent.index.layout', $pageArgs)
            ->render();
    }

    public static function Apply()
    {
        $factory = View::getView();
        $pageArgs = AgentAPI::makePageArgs();
        return $factory->make('Agent.apply.layout', $pageArgs)
            ->render();
    }

    public static function Retrieve()
    {
        $factory = View::getView();
        $pageArgs = AgentAPI::makePageArgs();
        return $factory->make('Agent.apply.layout', $pageArgs)
            ->render();
    }
    public static function AccountSetting()
    {
        $factory = View::getView();
        $pageArgs = AgentAPI::makeASPageArgs();
        $_SESSION["bladeArgs"] = $pageArgs;
        return $factory->make('Agent.AccountSetting.home.home', $pageArgs)
            ->render();
    }

    public static function agentWithdrawl()
    {
        $factory = View::getView();
        $pageArgs = AgentAPI::makeASPageArgs();
        $cards = AgentAPI::getBankInfo();
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
        return $factory->make('Agent.AccountSetting.withdrawl.layout', $pageArgs)
            ->render();
    }

    public static function BankManager($request)
    {
        $factory = View::getView();
        $pageArgs = AgentAPI::makeASPageArgs();
        $cards = AgentAPI::getBankInfo();
        
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
        return $factory->make('Agent.AccountSetting.bankCards.layout', $pageArgs)
            ->render();
    }

    public static function agentInfo($request)
    {
        $factory = View::getView();
        $pageArgs = AgentAPI::makeASPageArgs();
        return $factory->make('Agent.AccountSetting.agentInfo.layout', $pageArgs)
            ->render();
    }

    public static function receivebox($request)
    {
        $factory = View::getView();
        $pageArgs = AgentAPI::makeASPageArgs();
        $pageIndex = getArrayValue("pageIndex", "1", $request);
        $recvMails = AgentAPI::getMailData($pageIndex);
        $showMailInfo = paginate($recvMails, Config::base["maxCountPerPage"], $pageIndex);
        $pageArgs["recvMails"] = $showMailInfo[0];
        $pageArgs["maxPage"] = $showMailInfo[1];
        $pageArgs["curPage"] = $showMailInfo[2];


        return $factory->make('Agent.AccountSetting.receivebox.layout', $pageArgs)
            ->render();
    }

    public static function MsDetail($request){
        $factory = View::getView();
        $mailId = getArrayValue("messageid", 1, $request);
        $mailType = getArrayValue("type", 1, $request);
        $mailInfo = AgentAPI::getMailDetailData($mailId);
        
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

    
    public static function memberReports()
    {
        $factory = View::getView();
        $pageArgs = AgentAPI::makeASPageArgs();
        return $factory->make('Agent.reports.memberReports.layout', $pageArgs)
            ->render();
    }
        
    public static function agentReports()
    {
        $factory = View::getView();
        $pageArgs = AgentAPI::makeASPageArgs();
        $reportDatas = AgentAPI::getReportData();
        $rd = [];
        for ($x=0; $x<count($reportDatas); $x++) {
            $_report = $reportDatas[$x];
           array_push(
                $rd, [
                    "id" => $x + 1,
                    "account" => $_report["account"],
                    "name" => $_report["name"],
                    "time" => parseDate($_report["joinTime"]),
                    "layer" => $_report["layerName"],
                    "roleId" => $_report["roleId"],
                    "memberCount" => \getArrayValue("memberCount", "", $_report),
                    "checkStatus" => Config::statusMap[\getArrayValue("status", "", $_report)]
                ]
           ); 
        }

        $pageArgs["agentReportsData"] = $rd;
        return $factory->make('Agent.reports.agentReports.layout', $pageArgs)
            ->render();
    }

    public static function benifitReports()
    {
        $factory = View::getView();
        $pageArgs = AgentAPI::makeASPageArgs();
        return $factory->make('Agent.reports.benifitReports.layout', $pageArgs)
            ->render();
    }
}
