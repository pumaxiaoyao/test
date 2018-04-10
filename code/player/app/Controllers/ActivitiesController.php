<?php
namespace App\Controllers;

use App\Config\Config;
use App\Controllers\Def;
use App\Controllers\ActivitiesAPIController as ActivityAPI;
use App\Controllers\PlayerAPIController as PlayerAPI;
use App\Core\View;

class ActivitiesController extends BaseController
{
    public function activities($request)
    {
        $factory = View::getView();
        $pageArgs = PlayerAPI::makePageArgs();
        return $factory->make('Activity.common.layout', $pageArgs)
            ->render();
    }
}