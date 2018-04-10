<?php
namespace App\Route;

use App\Core\Router as Route;
use App\Controllers as Controllers;
use App\Libs\HttpResponse as resp;

// 定义路由的controller跳转
const CallToController = [
    "home" => "Home",
    "message" => "Message",
    "player" => "Player",
    "settings" => "Setting",
    "playerfund" => "PlayerFund",
    "flow" => "Flow",
    "agent" => "Agent",
    "agentfund" => "AgentFund",
    "activity" => "Activity",
    "bank" => "Bank"
];
// 错误跳转首页
Route::error(function(){
    $ret = call_user_func_array([
        'App\Controllers\HomeController',
        "login"
    ],[parseRequest()]);
    resp::render($ret);
});

// 首页
Route::get('/', function(){
    $ret = call_user_func_array([
        'App\Controllers\HomeController',
        "login"
    ],[parseRequest()]);
    resp::render($ret);
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
// 登录 & 公共接口
Route::post('/(:any)/(:any)', function($controller, $toMethod){

    $toController = 'App\Controllers\\' . CallToController[$controller]. 'APIController';

    $ret = call_user_func_array([
        $toController,
        $toMethod
    ],[parseRequest()]);
    resp::render($ret, "json");
});
