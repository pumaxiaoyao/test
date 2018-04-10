<?php
namespace App\Controllers;

use App\Config\Config;
use App\Controllers\Def;
use App\Controllers\BankAPIController as BankAPI;
use App\Core\View;

class BankController extends BaseController
{
    public static function cardlist($request)
    {
        $factory = View::getView();
        $pageArgs = [
            "sysMessageList" => [],
        ];
        return $factory->make('Bank.cardlist.layout', $pageArgs)
            ->render();
    }

    public static function bankpayment($request)
    {
        $factory = View::getView();
        $pageArgs = [
            "sysMessageList" => [],
        ];
        return $factory->make('Bank.bankpayment.layout', $pageArgs)
            ->render();
    }
    
    public static function merchant($request)
    {
        $factory = View::getView();
        $pageArgs = [
            "sysMessageList" => [],
        ];
        return $factory->make('Bank.merchant.layout', $pageArgs)
            ->render();
    }
    
    public static function deposit($request)
    {
        $factory = View::getView();
        $pageArgs = [
            "sysMessageList" => [],
        ];
        return $factory->make('Bank.deposit.layout', $pageArgs)
            ->render();
    }
    
}