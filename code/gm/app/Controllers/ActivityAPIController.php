<?php
namespace App\Controllers;

use App\Config\Config;
use App\Libs\HttpRequest as http;
use App\ViewHelper\ActivityViewHelper as viewHelper;


class ActivityAPIController extends BaseController
{
    /**
     * 获得活动数据
     */
    public static function activityAjax($request)
    {
        $s_args = parseCommonRequestArgus($request);
        $retJson = http::gmHttpCaller("GetActivities", [null, $s_args[2], $s_args[3]]);
        $retSize = count($retJson);
        $ret = [];
        foreach ($retJson as $_ret)
        {
            if ($_ret['status'] != 3) 
                $ret[] = $_ret;
        }
        return [
            "sEcho" => $s_args[4],
            "iTotalRecords" => $retSize,
            "iTotalDisplayRecords" => $retSize, //floor($sSize / $sCount), //取整，用于页数
            "aaData" => viewHelper::makeActivityHtml($ret), 
            "total" => 0
        ];
    }

    public static function uploadPic($request)
    {
        // Define a destination
        $targetFolder = '/static/uploads'; // Relative to the root
        
        $tempFile = $_FILES['Filedata']['tmp_name'];
        $targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
        $saveFileAs = strtolower(md5($_FILES['Filedata']['name']));
        $targetFile = rtrim($targetPath,'/') . '/' . $saveFileAs;
        $urlPath = $targetFolder . "/". $saveFileAs;
        // Validate the file type
        $fileTypes = array('jpg','jpeg','gif','png'); // File extensions
        $fileParts = pathinfo($_FILES['Filedata']['name']);

        if (in_array($fileParts['extension'],$fileTypes)) {
            move_uploaded_file($tempFile,$targetFile);
            
            return ["path" => $urlPath];
        } else {
            return ['Invalid file type.'];
        }
    }

    public static function edit($request)
    {
        error_reporting(~E_ALL);
        $reqArgs = [
            $request["actid"],
            urldecode($request["name"]),
            urldecode($request["desc"]),
            $request["lbtime"],
            urldecode($request["picUrl1"]),
            urldecode($request["picUrl2"]),
            $request["headActivity"],
            urldecode($request["agentcodes"]),
            urldecode($request["groupids"]),
            $request["status_list"],
            $request["type_list"],
            $request["redirect_to"],
            urldecode($request["redirect_url"]),
            $request["order"],
            $request["peru"],
            $request["initiative"],
            urldecode($request["content"])
        ];
        return http::gmHttpCaller("CreateOrEditActivity", $reqArgs);
    }

    public static function editCate($request)
    {
        $reqArgs = [
            $request["cateId"],
            urldecode($request["name"]),
            urldecode($request["desc"]),
            $request["status"]
        ];
        return http::gmHttpCaller("CreateOrEditActivityType", $reqArgs);
    }

    public static function changeStatus($request)
    {
        $t = [
            $request['actid'],
            $request['status']
        ];
        return http::gmHttpCaller('SetActivityStatus', $t);
    }

    /** 
     * 构建活动参与审核
     */
    public static function activityVerifyAjax($request)
    {
        $s_args = parseCommonRequestArgus($request);
        $s_type = $request["type"];
        $s_actId = false;
        $retJson = http::gmHttpCaller("GetPlayerActivityCheck", [$s_type, "", $s_actId, $s_args[2], $s_args[3]]);
        if ($retJson) {
            $retSize = $retJson["size"];
            $retData = $retJson["data"];
        } else {
            $retSize = 0;
            $retData = [];
        }
        return [
            "sEcho" => $s_args[4],
            "iTotalRecords" => $retSize,
            "iTotalDisplayRecords" => $retSize, //floor($sSize / $sCount), //取整，用于页数
            "aaData" => viewHelper::makeActivityVerifyHtml($retData), 
            "total" => 0
        ];
    }

    /**
     * 批量通过活动审核
     */
    public static function batchActVerityPass($request)
    {
        $dnos = $request["dnos"];
        foreach (explode(",", $dnos) as $dno) {
            $request["dno"] = $dno;
            $ret = self::actVerityPass($request);
            if (!$ret[0]){
                return [false, "failed with dno " . $dno];
            }
        }
        return [true];
    }


    /**
     * 通过活动审核
     */
    public static function actVerityPass($request)
    {
        $t = [
            $request["dno"],
            $request["amount"], //红利
            $request["flows"], // 流水 
            $request["gpid"],
            urldecode($request["remark"])
        ];

        return http::gmHttpCaller("PlayerActivityAgree", $t);

    }

    /**
     * 拒绝活动审核
     */
    public static function actVerityRefuse($request)
    {
        $t = [
            $request["dno"],
            urldecode($request["remark"])
        ];
        return http::gmHttpCaller("PlayerActivityRefuse", $t);
    }

    /**
     * 获取活动审核历史
     */
    public static function activityHistoryAjax($request)
    {
        $s_args = parseCommonRequestArgus($request);
        $t = [
            $request["status"],
            $request["s_type"],
            $request["s_keyword"],
            $s_args[2],
            $s_args[3]
        ];
        $retJson = http::gmHttpCaller("GetPlayerActivityRecord", $t);
        if ($retJson) {
            $retSize = $retJson["size"];
            $retData = $retJson["data"];
        } else {
            $retSize = 0;
            $retData = [];
        }
        return [
            "sEcho" => $s_args[4],
            "iTotalRecords" => $retSize,
            "iTotalDisplayRecords" => $retSize, //floor($sSize / $sCount), //取整，用于页数
            "aaData" => viewHelper::makeActivityVerifyHistoryHtml($retData), 
            "total" => 0
        ];
    }

    public static function activityFundAjax($request)
    {
        $s_args = parseCommonRequestArgus($request);
        $t = [
            $s_args[0],
            $s_args[1],
            $s_args[2],
            $s_args[3]
        ];
        $retJson = http::gmHttpCaller("GetPlayerActivityStatisticsData", $t);
        if ($retJson) {
            $retSize = count($retJson);
            $retData = $retJson;
        } else {
            $retSize = 0;
            $retData = [];
        }
        return [
            "sEcho" => $s_args[4],
            "iTotalRecords" => $retSize,
            "iTotalDisplayRecords" => $retSize, //floor($sSize / $sCount), //取整，用于页数
            "aaData" => viewHelper::makeActivityFundHtml($retData), 
            "total" => 0
        ];
    }
}