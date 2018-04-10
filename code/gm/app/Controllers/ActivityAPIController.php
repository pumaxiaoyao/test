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
        $retJson = http::gmHttpCaller("GetActivities", [$s_args[2], $s_args[3]]);
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
        $reqArgs = [
            $request["actid"],
            urldecode($request["name"]),
            urldecode($request["desc"]),
            $request["lbtime"],
            urldecode($request["picUrl1"]),
            urldecode($request["picUrl2"]),
            $request["headActivity"],
            urldecode($request["agentcodes"]),
            urldecode($request["agentnamelist"]),
            urldecode($request["groupids"]),
            urldecode($request["groupnames"]),
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
}