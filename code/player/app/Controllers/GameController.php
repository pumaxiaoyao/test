<?php
namespace App\Controllers;
use App\Controllers\PlayerAPIController as PlayerAPI;
use App\Config\Config;
use App\Core\View;

class GameController extends BaseController{

    public static function sportsbook($request)
    {
        $factory = View::getView();
        $pageArgs = PlayerAPI::makePageArgs();
        return $factory->make('Game.sportsbook.layout', $pageArgs)
            ->render();
    }

    /**
     * 构建前往游戏时的跳转界面，用于查询余额、充值等操作提示
     */
    public static function jumpToGame($request)
    {
        $factory = View::getView();
        $pageArgs = PlayerAPI::makePageArgs();
        return $factory->make('Game.jumpToGame.layout', $pageArgs)
            ->render();
    }

    public static function lbcp($request)
    {
        $factory = View::getView();
        $pageArgs = PlayerAPI::makePageArgs();
        return $factory->make('Game.lbcp.layout', $pageArgs)
            ->render();
    }

    // 时时彩
    public static function iglottery($request)
    {
        $factory = View::getView();
        $pageArgs = PlayerAPI::makePageArgs();
        return $factory->make('Game.iglottery.layout', $pageArgs)
            ->render();
    }

    // 香港时时彩
    public static function iglotto($request)
    {
        $factory = View::getView();
        $pageArgs = PlayerAPI::makePageArgs();
        return $factory->make('Game.iglotto.layout', $pageArgs)
            ->render();
    }

    public static function aggame($request)
    {
        $factory = View::getView();
        $pageArgs = PlayerAPI::makePageArgs();
        return $factory->make('Game.aggame.layout', $pageArgs)
            ->render();
    }

    public static function bbgame($request)
    {
        $factory = View::getView();
        $pageArgs = PlayerAPI::makePageArgs();
        return $factory->make('Game.bbin.layout', $pageArgs)
            ->render();
    }
    

}