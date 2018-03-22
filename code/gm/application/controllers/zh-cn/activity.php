<?php  
  
/** 
 * MVC路由功能简单实现 
 * @desc 简单实现MVC路由功能  
 */  

registerDataHelper(array("protoHelper", "dataHelper"));
registerViewHelper(array("GmViewHelper", "activity/ActivityViewHelper"));
// registerCtrlHelper(array("player/playertrait"));

class Activity  
{  
    function activities()
    {  
        showActivity(__CLASS__); 
    }  

    function activityAjax($request){
        /**
         * 活动数据获取接口
         */
        $s_args = parseCommonRequestArgus($request);
        //$retJson = gmServerCaller("GetAllPlayerBalanceRecord", array($_btype, $s_args[0], $s_args[1], $s_type, $s_key, $s_args[2], $s_args[3]));
        $retJson = array(array(array()));
        $retJson = getArrayValue(0, array(), $retJson);
        $retSize = (int)getArrayValue("size", 0, $retJson);
        $retData = getArrayValue("data", array(), $retJson);
        $pageData = self::makeActivityHtml($retData);
        $ret = outputSearchData($retSize, $s_args[4], $s_args[3], $pageData);
        return output($ret, "json");
    }

    function makeActivityHtml($datas){
        /**
         * 构建活动数据界面
         */
        $retdatas = array();
        for($x=0;$x<count($datas);$x++){
            $account = getArrayValue("account", "", $datas[$x]);
            $actName = getArrayValue("actName", "TODO：活动名", $datas[$x]);
            $actStatus = getArrayValue("actStatus", "TODO：活动状态", $datas[$x]);
            $agentName = getArrayValue("agentName", "TODO：代理", $datas[$x]);
            $groupName = getArrayValue("groupName", "TODO：玩家组", $datas[$x]);
            $limitCount = getArrayValue("limitCount", "TODO：限次", $datas[$x]);
            $actIndex = getArrayValue("actIndex", "TODO：排序", $datas[$x]);
            $acttime = getArrayValue("time", "TODO：时间", $datas[$x]);
            $actOper = "";
            $tmpdata = array(
                $x+1,
                $actName,
                '<div  id=\"status_374335100697333760\">'.$actStatus .'</div>',
                "<div style=\"width:150px;word-break:break-all;word-wrap:break-word;\">".$agentName."</div>",
                $groupName,
                $limitCount,
                $actIndex,
                $acttime,
                $actOper,
            );
            
            for($y=0;$y<count($tmpdata);$y++){
                $tmpdata[$y] = str_replace("%ACCOUNT%", $account, $tmpdata[$y]);
            }
            array_push($retdatas, $tmpdata);
        }
    
        return $retdatas;
    }

    function actCateList(){
        showActCateList(__CLASS__);
    }

    function activityVerify(){
        showActVerify(__CLASS__);
    }

    function activityVerifyAjax(){
        $ret = array("sEcho"=>"1","iTotalRecords"=>"0","iTotalDisplayRecords"=>"0","aaData"=>array()
        );
        echo json_encode($ret );
    }
    function activityHistory(){
        showActHistory(__CLASS__);
    }

    function activityHistoryAjax(){
        $ret = array(
            "sEcho"=>"1","iTotalRecords"=>"154","iTotalDisplayRecords"=>"154",
            "aaData"=>array()
        );
        echo json_encode($ret);
    }

    function activityFund(){
        showActFund(__CLASS__);
    }

    function activityFundAjax(){
        $ret = array(
            "sEcho"=>"1","iTotalRecords"=>"9","iTotalDisplayRecords"=>"9","aaData"=>array(array("<a href=\"\/activity\/activityHistory?actid=378395958440255488\">\u9996\u5b58\u5373\u9001\uff01\u4e13\u5c5e\u4f18\u60e0~<\/a>","4","4","0","72.00","\u5df2\u4e0a\u67b6","2017-09-07 19:31:10"),array("<a href=\"\/activity\/activityHistory?actid=374340639737143296\">\u52a0\u5165VIP\u4ff1\u4e50\u90e8<\/a>","0","0","0","0.00","\u5df2\u4e0a\u67b6","2017-08-27 14:56:46"),array("<a href=\"\/activity\/activityHistory?actid=374340225297965056\">\u6b21\u6b21\u5b58\u6b21\u6b21\u9001<\/a>","0","0","0","0.00","\u5df2\u4e0a\u67b6","2017-08-27 14:55:08"),array("<a href=\"\/activity\/activityHistory?actid=374339692424224768\">\u5929\u5929\u8fd4\u70b9\u65e0\u4e0a\u9650 <\/a>","0","0","0","0.00","\u5df2\u4e0a\u67b6","2017-08-27 14:53:00"),array("<a href=\"\/activity\/activityHistory?actid=374339313854734336\">\u9996\u5b58\u8d60\u9001100% \u8d85\u503c\u8c6a\u793c\u7b49\u60a8\u62ff<\/a>","18","18","0","1800.00","\u5df2\u4e0a\u67b6","2017-08-27 14:51:30"),array("<a href=\"\/activity\/activityHistory?actid=374338615729610752\">\u767e\u5bb6\u4e50 \u8001K\u9001\u5927\u5956<\/a>","0","0","0","0.00","\u5df2\u4e0a\u67b6","2017-08-27 14:48:44"),array("<a href=\"\/activity\/activityHistory?actid=374336017039511552\">\u8bda\u62db\u4ee3\u7406\u5546<\/a>","0","0","0","0.00","\u5df2\u4e0a\u67b6","2017-08-27 14:38:24"),array("<a href=\"\/activity\/activityHistory?actid=374335100697333760\">\u7535\u8bdd\u56de\u8bbf<\/a>","0","0","0","0.00","\u5df2\u4e0b\u67b6","2017-08-27 14:34:46"),array("<a href=\"\/activity\/activityHistory?actid=374334587268390912\">\u5929\u5929\u7b7e\u5230<\/a>","27","28","0","900.00","\u5df2\u4e0a\u67b6","2017-08-27 14:32:43"))
        );
        echo json_encode($ret);
    }


}  
  
  
?>  