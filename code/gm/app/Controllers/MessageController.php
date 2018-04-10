<?php
namespace App\Controllers;

use App\Config\Config;
use App\Controllers\Def;
use App\Core\View;

class MessageController extends BaseController
{
    public static function platform()
    {
        $factory = View::getView();
        // $pageArgs = AgentAPI::makeASPageArgs();
        $pageArgs = [
            "sysMessageList" => [],
        ];
        return $factory->make('Message.platform.layout', $pageArgs)
            ->render();
    }

    public static function agent()
    {
        $factory = View::getView();
        // $pageArgs = AgentAPI::makeASPageArgs();
        $pageArgs = [
            "sysMessageList" => [],
        ];
        return $factory->make('Message.agent.layout', $pageArgs)
            ->render();
    }

    public static function player()
    {
        $factory = View::getView();
        // $pageArgs = AgentAPI::makeASPageArgs();
        $pageArgs = [
            "sysMessageList" => [],
        ];
        return $factory->make('Message.player.layout', $pageArgs)
            ->render();
    }
}