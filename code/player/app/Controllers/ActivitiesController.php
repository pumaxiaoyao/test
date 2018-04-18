<?php
namespace App\Controllers;

use App\Config\Config;
use App\Controllers\Def;
use App\Controllers\ActivitiesAPIController as ActivityAPI;
use App\Libs\HttpRequest as http;
use App\Controllers\PlayerAPIController as PlayerAPI;
use App\Core\View;

class ActivitiesController extends BaseController
{
    public function activities($request)
    {
        $loginSession = getSessionValue("PlayerSessionID", "");
        $acts = http::playerHttpCaller('GetActivities', [$loginSession]);
        // var_dump( $acts);die;
        $headActs = [];
        $normalActs = [];
        // Todo：默认的CDN资源下载配置根路径
        // GM后台上传后的预览地址，以及前台的下载地址都是此路径
        // 稍后拆分
        // $downLoadUrl = "http://47.91.199.24:8080";
        $downLoadUrl = "http://localhost:8080"; 
        foreach( $acts[0] as $act) {
            $act["listTime"] = date("Y-m月d日 ", strtotime($act["labelTime"]));
            $act["listTime"] = str_replace("-", "<br/>", $act["listTime"]);
            if ($act["picUrl1"])
                $act["picUrl1"] = $downLoadUrl . $act["picUrl1"];
            if ($act["picUrl2"])
                $act["picUrl2"] = $downLoadUrl . $act["picUrl2"];

            if ((string)$act["status"] === "1") {
                $normalActs[] = $act;
                if ((string)$act["isHeadAct"] === "1") {
                    $headActs[] = $act;
                }
            } 
        }
        $factory = View::getView();
        $pageArgs = PlayerAPI::makePageArgs();
        $pageArgs["headActs"] = $headActs;
        $pageArgs["nomarlActs"] = $normalActs;
        return $factory->make('Activity.common.layout', $pageArgs)
            ->render();
    }

    /**
     * 获取活动详情配置内容
     */
    public static function showDetail($request)
    {
        $loginSession = getSessionValue("PlayerSessionID", "");
        $actId = $request["actId"];
        $acts = http::playerHttpCaller('GetActivity', [$loginSession,$actId]);
        $act = (count($acts)>0)?$acts[0]:[];
        $factory = View::getView();
        return $factory->make('Activity.showDetail.layout', ["content" => $act["content"]])
            ->render();

    }
}