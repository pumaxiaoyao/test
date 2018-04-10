<?php
namespace App\Route;

use App\Core\Router as Route;
use App\Controllers as Controllers;
use App\Libs\HttpResponse as resp;

// 定义路由的controller跳转
const CallToController = [
    "game" => "Game",
    "agent" => "Agent",
    "common" => "Common",
    "player" => "Player",
    "help" => "Help",
    "activity" => "Activities"
];

// 错误跳转首页
Route::error(function(){
    resp::render(Controllers\PlayerController::index());
});


// 界面
Route::get('/(:any)/(:any)', function($controller, $toMethod){
    
    $toController = 'App\Controllers\\' . CallToController[$controller]. 'Controller';

    $ret = call_user_func_array([
        $toController,
        $toMethod
    ],[parseRequest()]);
    resp::render($ret);
});
// 公共接口
Route::post('/(:any)/(:any)', function($controller, $toMethod){

    $toController = 'App\Controllers\\' . CallToController[$controller]. 'APIController';

    $ret = call_user_func_array([
        $toController,
        $toMethod
    ],[parseRequest()]);
    resp::render($ret, "json");
});

