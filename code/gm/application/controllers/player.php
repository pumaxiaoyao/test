<?php  
  
/** 
 * MVC路由功能简单实现 
 * @desc 简单实现MVC路由功能  
 */  
session_start();
include "./application/utilities/utilities.php";

$_SESSION["Title"] = "Alien - 玩家管理";

class Player  
{  
    //玩家在线的功能接口
    
    function online(){  
        echo makePage("", "player/online", "");  
    }

    function onlineAjax(){
        $s_btype = $_POST["s_btype"];
        $s_type = $_POST["s_type"]; //查询类别，1-账号，2-姓名，3-IP，4-代理，默认为1
        $S_keyword = $_POST["s_keyword"];//查询关键字
        
        $s_datas = $_POST["data"];
        $sEcho = $s_datas[0]["value"];//疑似查询次数，界面的实际表现都是通过上、下或指定页面时会出现次数增加，其他时候都是1
        $iColumns = $s_datas[1]["value"];//显示的列数，共12列，实际显示11列，因为有一列为空
        $sColumns = $s_datas[2]["value"];
        $iDisplayStart = $s_datas[3]["value"];
        $iDisplayLength = $s_datas[4]["value"];

        if (isset($_SESSION["ONLINEPLAYERS"]) && ((int)$sEcho > 1)){
            // 连续翻页查询，数据源不用更新
            // $flag=1;
            $onlineDatas = $_SESSION["ONLINEPLAYERS"];
            $searchdatas = $_SESSION["searchdatas"];
        }else{
            // $flag=isset($_SESSION["ONLINEPLAYERS"]);
            $ret = getServerJSon("player/getonlineIDs", $_POST);
            $onlineDatas = json_decode($ret,true);
            $_SESSION["ONLINEPLAYERS"] = $onlineDatas;
            $searchdatas = array();
            //echo "S_keyword is [".$S_keyword.']<br/>';
            //过滤索引关键词
            if (count($onlineDatas)>0){
                foreach( $onlineDatas as $tmpID => $tmpplayer){
                    if ($S_keyword == ""){
                        $searchdatas[$tmpID] = $tmpplayer;//没有指定搜索关键词s_keyword
                    }else{
                        switch($s_type){
                            case 1:
                                //查询账号
                                if (count(explode($S_keyword, $tmpplayer["account"])) > 1){
                                    $searchdatas[$tmpID] = $tmpplayer;
                                }
                                break;
                            case 2:
                                //查询姓名
                                if(count(explode($S_keyword, $tmpplayer["nickname"])) > 1){
                                    $searchdatas[$tmpID] = $tmpplayer;
                                }
                                break;
                            case 3:
                                //查询IP
                                if(count(explode($S_keyword, $tmpplayer["currentLoginIP"])) > 1){
                                    $searchdatas[$tmpID] = $tmpplayer;
                                }
                                break;
                            case 4:
                                //查询代理
                                if(count(explode($S_keyword, $tmpplayer["agent"])) > 1){
                                    $searchdatas[$tmpID] = $tmpplayer;
                                }
                                break;
                            }
                        }
                    }
                }
            
            //按长度截取待显示的数据
            $_SESSION["searchdatas"] = $searchdatas;
        }
        
        if ((count($searchdatas) - $iDisplayStart)> $iDisplayLength){
            $retLength = $iDisplayLength;
        }else{
            $retLength = count($searchdatas) - $iDisplayStart;
        }
        $slicedatas = array_slice($searchdatas, $iDisplayStart, $retLength);
        $retdatas = array();
        for($x=0;$x<count($slicedatas);$x++){
            $tmpdata = array();
                
            $acc_html = "<span class='label label-info' style='cursor:pointer;' onclick='custom_getBalance(\"%UID%\", \"%ACCOUNT%\")'>%ACCOUNT%</span>";
            $acc_html = str_replace("%UID%", $slicedatas[$x]["uid"], $acc_html);
            $acc_html = str_replace("%ACCOUNT%", $slicedatas[$x]["account"], $acc_html);
            
            $currentIP_html = "%CurrentLoginTime%<br/><label attr='ip'>%CurrentLoginIP%</label><br /><label attr='addr'>&nbsp;</label>";
            $currentIP_html = str_replace("%CurrentLoginTime%", $slicedatas[$x]["currentLoginTime"], $currentIP_html);
            $currentIP_html = str_replace("%CurrentLoginIP%", $slicedatas[$x]["currentLoginIP"], $currentIP_html);

            $LastIP_html = "%lastLoginTime%<br/><label attr='ip'>%lastLoginIP%</label><br /><label attr='addr'>&nbsp;</label>";
            $LastIP_html = str_replace("%lastLoginTime%", $slicedatas[$x]["lastLoginTime"], $LastIP_html);
            $LastIP_html = str_replace("%lastLoginIP%", $slicedatas[$x]["lastLoginIP"], $LastIP_html);

            $Oper_html = "<a href='javascript:void(0)' onclick='playerkickdown(%UID%)'  class='btn mini green'><i class='icon-trash'></i>踢线</a>";
            $Oper_html = str_replace("%UID%", $slicedatas[$x]["uid"], $Oper_html);


            array_push($tmpdata, (string)($x+1));
            array_push($tmpdata, $acc_html);
            array_push($tmpdata, $slicedatas[$x]["nickname"]);
            array_push($tmpdata, $slicedatas[$x]["currency"]);
            array_push($tmpdata, "注册会员");
            array_push($tmpdata, $slicedatas[$x]["agent"]);
            array_push($tmpdata, $currentIP_html);
            array_push($tmpdata, $slicedatas[$x]["lastActiveTime"]);
            array_push($tmpdata, $slicedatas[$x]["onLineTime"]."（小时）");
            array_push($tmpdata, $LastIP_html);
            array_push($tmpdata, $slicedatas[$x]["loginDomain"]);
            array_push($tmpdata, $Oper_html);
        
            array_push($retdatas, $tmpdata);
        }

        $ret = array(
            //"flag"=>$flag,
            "retLength"=>$retLength,
            "iDisplayStart"=> $iDisplayStart,
            "sEcho"=>$sEcho,
            "iTotalRecords"=>count($searchdatas),
            "iTotalDisplayRecords"=>count($searchdatas),
            "aaData"=>$retdatas,
        );
        echo json_encode($ret);
    }
    
    function kickdown($kickID){
        echo getServerJSon("player/kickdown", array("kickID"=>$kickID));
    }

    function playerDetailBox($playerID){
       
        $ret = getServerJSon("player/playerDetailBox", array("playerID"=>$playerID));
        
        $playerdata = json_decode($ret, true);
        
        $playerDetailBoxHtml = file_get_contents("./application/controllers/playerdata/player_box_header.html");
        $palyerTabs_html = '';
        if (count($playerdata) > 0){
            for($i=1;$i<9;$i++){
                $palyerTabs_tpl = file_get_contents("./application/controllers/playerdata/player_box_tab".(string)$i.".html");
                switch($i){
                    case 1:
                        //个人详情界面
                        $replaceArray = array(
                            "account"=>"%ACCOUNT%",
                            "gameplatformID"=>"%GAMEPLATFORMID%",
                            "uid"=>"%UID%",
                            "nickname"=>"%NICKNAME%",
                            "playerlevel"=>"%PLAYERLEVEL%",
                            "status"=>"%STATUS%",
                            "agent"=>"%AGENT%",
                            "qq"=>"%QQ%",
                            "phone"=>"%PHONE%",
                            "birthday"=>"%BIRTHDAY%",
                            "email"=>"%EMAIL%",
                            "registerTime"=>"%REGISTERTIME%",
                            "registerIP"=>"%REGISTERIP%",
                            "lastLoginTime"=>"%LASTLOGINTIME%",
                            "currency"=>"%CURRENCY%",
                        );
                        foreach($replaceArray as $_key => $_vals){
                            $palyerTabs_tpl = str_replace($_vals,  $playerdata[$_key], $palyerTabs_tpl);
                        }
                        break;
                    case 2:
                        //登陆记录查询
                        $ret = json_decode(getServerJSon("player/loginRecord", array("playerID"=>$playerID)), true);
                        $_html = '';
                        if (count($ret)>0){
                            foreach($ret as $_record){
                                $id_html = "<td>".(string)$_record["id"]."</td>";
                                $ip_html = "<td>".(string)$_record["ip"]."</td>";
                                $time_html = "<td>".(string)$_record["time"]."</td>";
                                $status_html = "<td>".(string)$_record["status"]."</td>";
                                $_html = $_html."<tr>".$id_html.$ip_html.$time_html.$status_html."</tr>";
                            }
                        }
                        
                        $palyerTabs_tpl = str_replace("%LOGINDATA%", $_html, $palyerTabs_tpl);
                        break;
                    case 3:
                        //交易记录查询
                        $palyerTabs_tpl = str_replace("%UID%",  $playerdata["uid"], $palyerTabs_tpl);
                        $ret = json_decode(getServerJSon("player/transRecord", array("playerID"=>$playerID)), true);
                        $_html = "";
                        if(count($ret) > 0){
                            foreach($ret as $_record){
                                $_html = $_html."<tr>";
                                foreach($_record as $_val){
                                    $_html = $_html."<td>".(string)$_val."</td>";
                                }
                                $_html = $_html."</tr>";
                            }
                        }
    
                       
                        $palyerTabs_tpl = str_replace("%TRANSDATA%", $_html, $palyerTabs_tpl);
                        break;
                    case 4:
                        //防止套利界面，显示基本信息，重复IP用JS查询
                        $replaceArray = array(
                            "account"=>"%ACCOUNT%",
                            "password"=>"%PASSWORD%",
                            "birthday"=>"%BIRTHDAY%",
                            "uid"=>"%UID%",
                            "nickname"=>"%NICKNAME%",
                            "phone"=>"%PHONE%",
                            "registerTime"=>"%REGISTERTIME%",
                            "registerIP"=>"%REGISTERIP%",
                            "lastLoginIP"=>"%LASTLOGINIP%",
                            "lastLoginTime"=>"%LASTLOGINTIME%",
                        );
                        foreach($replaceArray as $_key => $_vals){
                            $palyerTabs_tpl = str_replace($_vals,  $playerdata[$_key], $palyerTabs_tpl);
                        }
                            break;
                    case 5:
                        //银行数据
                        $bankJson = getServerJSon("player/getBankInfo", array("playerID"=>$playerID));     
                        $ret = json_decode($bankJson, true);
                        //print_r($ret);
                        $_html = "";
                        if(count($ret)>0){
                            foreach($ret as $_record){
                                $_html = $_html."<tr id='_wdbandkid_".$_record[0]."'>";
                                $_html = $_html."<td bankcode='bankcode'>".$_record[1]."</td>";
                                $_html = $_html."<td bankname='bankname'>".$_record[2]."</td>";
                                $_html = $_html."<td account='account'>".$playerdata["nickname"]."</td>";
                                $_html = $_html."<td card='card'>".$_record[3]."</td>";
                                $_html = $_html."<td banknode='banknode'>".$_record[4]."</td>";
                                $_html = $_html."<td status='status'><span class='label label-success'>".$_record[5]."</span></td>";
                                $_html = $_html."<td><a href='javascript:void(0);' class='btn btn-xs green' onclick='edit_user_wd_card(".$_record[0].")'>编辑</a></td></tr>";
                            }
                        }
                        $palyerTabs_tpl = str_replace("%BANKINFO%", $_html, $palyerTabs_tpl);
                        break;
                    case 6:
                        //消息界面，JS处理数据，不用这里处理
                        break;
                    case 7:
                        //活跃界面，目前废弃
                        break;
                    case 8:
                        //CSLOG界面，JS单独处理
                        break;
                }
                $palyerTabs_html = $palyerTabs_html.$palyerTabs_tpl;
            }
            echo str_replace("%TABCONTENTS%", $palyerTabs_html, $playerDetailBoxHtml);
        }else{
            echo $ret."<br/>".$playerID;
            echo str_replace("%TABCONTENTS%", "found errors when search player data.", $playerDetailBoxHtml);
        }

        
        
       
    }

    function playerActiveTable($uid){
        $active_json = getServerJSon("player/playerActiveTable", array("uid"=>$uid));
        $active_data = json_decode($active_json, true);
        //echo $active_json;
        $page = file_get_contents("./application/controllers/playerdata/playerActiveTable.html");

        $info1_html = "<tr><td>";
        $info1_html = $info1_html.$active_data["fanshui"]."</td><td>";
        $info1_html = $info1_html.$active_data["hongli"]."</td><td>";
        $info1_html = $info1_html.$active_data["cunkuanyouhui"]."</td><td>";
        $info1_html = $info1_html.$active_data["touzhu"]."</td><td>";
        $info1_html = $info1_html.$active_data["paicai"]."</td>";
        $info1_html = $info1_html."<td style='color=red'>".$active_data["gongsishuying"]."</td><td>";
        $info1_html = $info1_html.$active_data["youxiaotouzhu"]."</td>";
        $info1_html = $info1_html."<td style='color=red'>".$active_data["gongsitouzhu"]."</td><td></tr>";
        
        $info2_html = "<tr><td>";
        $info2_html = $info2_html.$active_data["cunkuancishu"]."</td><td>";
        $info2_html = $info2_html.$active_data["cunkuanjine"]."</td><td>";
        $info2_html = $info2_html.$active_data["zuijincunkuan"]."</td><td>";
        $info2_html = $info2_html.$active_data["qukuancishu"]."</td><td>";
        $info2_html = $info2_html.$active_data["qukuanjine"]."</td><td>";
        $info2_html = $info2_html.$active_data["zuijinqukuan"]."</td><td>";

        $page = str_replace("%INFO1%", $info1_html, $page);
        $page = str_replace("%INFO2%", $info2_html, $page);
        echo $page;
    }

    function getCsLog(){
        //不知道需要返回数据不，未找到数据原型
        //暂时无时间去分析js逆推数据格式
    }

    function getSameIps($uid){
        $sameIps = json_decode(getServerJSon("player/getSameIps", array("playerID"=>$uid)), true);

        $page = file_get_contents("./application/controllers/playerdata/getSameIps.html");
        $sameips_html = "";
        if(count($sameIps)>0){
            foreach($sameIps as $_player){
                $_html = "<tr><td>";
                $_html = $_html.(string)$_player[0]."</td><td>";
                $_html = $_html.(string)$_player[1]."</td><td>";
                $_html = $_html.(string)$_player[2]."<br/><label ipTag='ipTag' ip='".(string)$_player[2]."'></label></td><td>";
                $_html = $_html.(string)$_player[3]."</td><td></tr>";
                $sameips_html = $sameips_html.$_html;
            }
        }
        $page = str_replace("%SAMEIPDATA%", $sameips_html, $page);
        echo $page;
    }

    function playerMessage($uid){
        echo getServerJSon("player/playerMessage", array("playerID"=>$uid));
    }
    
    function withdrawCard(){
        $page = file_get_contents("./application/controllers/playerdata/withdrawCard.html");
        echo $page;
    }

    function editWDCard(){
        $ret = array(
            "success"=>true,
            "response"=>array(
                    "status"=>1,
                    "wdbankid"=>"244",
                    "bankcode"=>"njcb",
                    "bankname"=>unicode_decode("\u5357\u4eac\u94f6\u884c"),
                    "card"=>"5187177532695326",
                    "account"=>unicode_decode("\u8d75\u8d35\u6625"),
                    "banknode"=>unicode_decode("\u6cb3\u5357\u5546\u4e18\u5de5\u5546\u94f6\u884c\u4e94\u4e00\u8def\u652f\u884c ")
                ),
            "msg"=>null
        );
        echo json_encode($ret);
    }

    function fundList(){
        $ret = array(
                    array("index"=>1,"amount"=>"1,238.70","created"=>"2017-10-11 14:11:25","remark"=>unicode_decode("MG\u8f6c\u51fa\uff0c\u4e3b\u8d26\u6237\u4f59\u989d: 1238.7000"),"sname"=>"","btype"=>unicode_decode(unicode_decode("\u8f6c\u8d26")),"dno"=>"390636679528337408","status"=>unicode_decode("\u6210\u529f")),
                    array("index"=>2,"amount"=>"1,238.70","created"=>"2017-10-11 14:11:25","remark"=>unicode_decode("\u8f6c\u51faMG"),"sname"=>"","btype"=>unicode_decode(unicode_decode("\u8f6c\u8d26")),"dno"=>"390636679528337409","status"=>unicode_decode("\u6210\u529f")),
                    array("index"=>3,"amount"=>"1,004.10","created"=>"2017-10-11 14:10:00","remark"=>unicode_decode("\u8f6c\u5165MG"),"sname"=>"","btype"=>unicode_decode(unicode_decode("\u8f6c\u8d26")),"dno"=>"390636320885985281","status"=>unicode_decode("\u6210\u529f")),
                    array("index"=>4,"amount"=>"1,004.10","created"=>"2017-10-11 14:09:59","remark"=>unicode_decode("\u8f6c\u5165MG\uff0c\u4e3b\u8d26\u6237\u4f59\u989d: 0.0000\uff0c\u5ba2\u670d\u8f6c\u5165"),"sname"=>"","btype"=>unicode_decode(unicode_decode("\u8f6c\u8d26")),"dno"=>"390636320885985281","status"=>unicode_decode("\u6210\u529f")),
                    array("index"=>5,"amount"=>"1,004.10","created"=>"2017-10-11 14:09:57","remark"=>unicode_decode("\u6c99\u5df4\u4f53\u80b2\u8f6c\u51fa\uff0c\u4e3b\u8d26\u6237\u4f59\u989d: 1004.1000"),"sname"=>"","btype"=>unicode_decode(unicode_decode("\u8f6c\u8d26")),"dno"=>"390636308672176128","status"=>unicode_decode("\u6210\u529f")),
                    array("index"=>6,"amount"=>"1,004.10","created"=>"2017-10-11 14:09:57","remark"=>unicode_decode("\u8f6c\u51fa\u6c99\u5df4\u4f53\u80b2"),"sname"=>"","btype"=>unicode_decode(unicode_decode("\u8f6c\u8d26")),"dno"=>"390636308672176129","status"=>unicode_decode("\u6210\u529f")),
                    array("index"=>7,"amount"=>"234.60","created"=>"2017-10-11 14:09:34","remark"=>unicode_decode("\u8f6c\u5165MG"),"sname"=>"","btype"=>unicode_decode(unicode_decode("\u8f6c\u8d26")),"dno"=>"390636213369200641","status"=>unicode_decode("\u6210\u529f")),
                    array("index"=>8,"amount"=>"234.60","created"=>"2017-10-11 14:09:34","remark"=>unicode_decode("\u8f6c\u5165MG\uff0c\u4e3b\u8d26\u6237\u4f59\u989d: 0.0000\uff0c\u5ba2\u670d\u8f6c\u5165"),"sname"=>"","btype"=>unicode_decode(unicode_decode("\u8f6c\u8d26")),"dno"=>"390636213369200641","status"=>unicode_decode("\u6210\u529f")),
                    
        );
        echo json_encode($ret);
        
    }

    
    function AllList(){
        echo makePage("", "player/list", "list_footer");  
    }

    function listAjax1(){
        $ret = array(
            "sEcho"=>"1",
            "iTotalRecords"=>"719",
            "iTotalDisplayRecords"=>"719",
            "limit"=>20,
            "offset"=>0,
            "aaData"=>array(
                array("<input type=\"checkbox\" layer=\"layer\" value=\"1597317437867593\" />",
                "<span class=\"label label-info\" style=\"cursor:pointer;\" onclick=\"custom_getBalance('1597317437867593','chen1996')\">chen1996</span><br />3072585",unicode_decode("\u9648\u709c"),"<label id=\"an_1597317437867593\">ly13800</label>\r\n                <a href=\"javascript:void(0);\" agent=agent uid=\"1597317437867593\" class=\"btn btn-xs\"><i class=\"fa fa-edit\"></i></a>\r\n                <br/><label id=\"ac_1597317437867593\">20124</label>","<label group=\"uGroup\" id=\"1597317437867593_group\">".unicode_decode(unicode_decode("\u6ce8\u518c\u9ed8\u8ba4"))."</label><a href=\"javascript:void(0);\" layer=layer uid=\"1597317437867593\" class=\"btn btn-xs\"><i class=\"fa fa-edit\"></i></a>","500.00&nbsp;<a href=\"#\" balance=\"balance\" uid=\"1597317437867593\"><i class=\"fa fa-edit\"></i></a>","<span  load=false uid=\"1597317437867593\">-</span>","0.00&nbsp;<a href=\"javascript:void(0);\" bonus=\"bonus\" uid=\"1597317437867593\"><i class=\"fa fa-edit\"></i></a>","500.00&nbsp;<a href=\"#\" water=\"water\" title=\"\u6d41\u6c34\u68c0\u67e5\" uid=\"1597317437867593\" name=\"chen1996\"><i class=\"fa fa-search\"></i></a>","<label remark=\"remark\" id=\"remark_1597317437867593\" title=\"\"></label><a href=\"javascript:void(0);\" remark=\"remark\" uid=\"1597317437867593\"><i class=\"fa fa-edit\"></i></a>","2017-10-11 20:38:38<br /><label style=\"cursor:pointer;\" attr=\"ip\">112.10.91.254</label><br /><label attr=\"addr\">&nbsp;</label>","2017-10-11<br>20:38:38","<span class=\"label label-success\">".unicode_decode("\u6b63\u5e38")."</span><a href=\"javascript:void(0);\" uid=\"1597317437867593\" lock=\"lock\" class=\"btn btn-xs\"><i class=\"fa fa-lock\"></i></a>","<div class=\"btn-group\"><a class=\"btn btn-xs green\" href=\"#\" data-toggle=\"dropdown\"><i class=\"fa fa-user\"></i> ".unicode_decode("\u64cd\u4f5c")." <i class=\"fa fa-angle-down\"></i></a><ul class=\"dropdown-menu\"><li><a href=\"javascript:void(0);\" onclick=\"editPlayerDetail('1597317437867593');\" ><i class=\"fa fa-edit\"></i>".unicode_decode("\u7f16\u8f91")."</a></li><li><a href=\"javascript:void(0);\" reset=reset uid=\"1597317437867593\" ><i class=\"fa fa-lock\"></i>".unicode_decode("\u4fee\u6539\u5bc6\u7801")."</a></li><li><a href=\"javascript:void(0);\" message=message uid=\"1597317437867593\" ><i class=\"fa fa-bell\"></i>".unicode_decode("\u53d1\u6d88\u606f")."</a></li></ul>"),
                array("<input type=\"checkbox\" layer=\"layer\" value=\"1597288920827361\" />",
                "<span class=\"label label-info\" style=\"cursor:pointer;\" onclick=\"custom_getBalance('1597288920827361','li5324658')\">li5324658</span><br />3072481",unicode_decode("\u674e\u4ece\u6587"),"<label id=\"an_1597288920827361\">ly13800</label>\r\n                <a href=\"javascript:void(0);\" agent=agent uid=\"1597288920827361\" class=\"btn btn-xs\"><i class=\"fa fa-edit\"></i></a>\r\n                <br/><label id=\"ac_1597288920827361\">20124</label>","<label group=\"uGroup\" id=\"1597288920827361_group\">".unicode_decode(unicode_decode("\u6ce8\u518c\u9ed8\u8ba4"))."</label><a href=\"javascript:void(0);\" layer=layer uid=\"1597288920827361\" class=\"btn btn-xs\"><i class=\"fa fa-edit\"></i></a>","0.00&nbsp;<a href=\"#\" balance=\"balance\" uid=\"1597288920827361\"><i class=\"fa fa-edit\"></i></a>","<span  load=false uid=\"1597288920827361\">-</span>","0.00&nbsp;<a href=\"javascript:void(0);\" bonus=\"bonus\" uid=\"1597288920827361\"><i class=\"fa fa-edit\"></i></a>","100.00&nbsp;<a href=\"#\" water=\"water\" title=\"\u6d41\u6c34\u68c0\u67e5\" uid=\"1597288920827361\" name=\"li5324658\"><i class=\"fa fa-search\"></i></a>","<label remark=\"remark\" id=\"remark_1597288920827361\" title=\"\"></label><a href=\"javascript:void(0);\" remark=\"remark\" uid=\"1597288920827361\"><i class=\"fa fa-edit\"></i></a>","2017-10-11 20:54:37<br /><label style=\"cursor:pointer;\" attr=\"ip\">14.25.80.170</label><br /><label attr=\"addr\">&nbsp;</label>","2017-10-11<br>20:09:37","<span class=\"label label-success\">".unicode_decode("\u6b63\u5e38")."</span><a href=\"javascript:void(0);\" uid=\"1597288920827361\" lock=\"lock\" class=\"btn btn-xs\"><i class=\"fa fa-lock\"></i></a>","<div class=\"btn-group\"><a class=\"btn btn-xs green\" href=\"#\" data-toggle=\"dropdown\"><i class=\"fa fa-user\"></i> ".unicode_decode("\u64cd\u4f5c")." <i class=\"fa fa-angle-down\"></i></a><ul class=\"dropdown-menu\"><li><a href=\"javascript:void(0);\" onclick=\"editPlayerDetail('1597288920827361');\" ><i class=\"fa fa-edit\"></i>".unicode_decode("\u7f16\u8f91")."</a></li><li><a href=\"javascript:void(0);\" reset=reset uid=\"1597288920827361\" ><i class=\"fa fa-lock\"></i>".unicode_decode("\u4fee\u6539\u5bc6\u7801")."</a></li><li><a href=\"javascript:void(0);\" message=message uid=\"1597288920827361\" ><i class=\"fa fa-bell\"></i>".unicode_decode("\u53d1\u6d88\u606f")."</a></li></ul>"),
                array("<input type=\"checkbox\" layer=\"layer\" value=\"1597269355070863\" />",
                "<span class=\"label label-info\" style=\"cursor:pointer;\" onclick=\"custom_getBalance('1597269355070863','a510708117')\">a510708117</span><br />3072399",unicode_decode("\u5f6d\u5efa\u6ce2"),"<label id=\"an_1597269355070863\">ly13800</label>\r\n                <a href=\"javascript:void(0);\" agent=agent uid=\"1597269355070863\" class=\"btn btn-xs\"><i class=\"fa fa-edit\"></i></a>\r\n                <br/><label id=\"ac_1597269355070863\">20124</label>","<label group=\"uGroup\" id=\"1597269355070863_group\">".unicode_decode(unicode_decode("\u6ce8\u518c\u9ed8\u8ba4"))."</label><a href=\"javascript:void(0);\" layer=layer uid=\"1597269355070863\" class=\"btn btn-xs\"><i class=\"fa fa-edit\"></i></a>","0.00&nbsp;<a href=\"#\" balance=\"balance\" uid=\"1597269355070863\"><i class=\"fa fa-edit\"></i></a>","<span  load=false uid=\"1597269355070863\">-</span>","0.00&nbsp;<a href=\"javascript:void(0);\" bonus=\"bonus\" uid=\"1597269355070863\"><i class=\"fa fa-edit\"></i></a>","0.00","<label remark=\"remark\" id=\"remark_1597269355070863\" title=\"\"></label><a href=\"javascript:void(0);\" remark=\"remark\" uid=\"1597269355070863\"><i class=\"fa fa-edit\"></i></a>","2017-10-11 20:08:57<br /><label style=\"cursor:pointer;\" attr=\"ip\">14.120.135.140</label><br /><label attr=\"addr\">&nbsp;</label>","2017-10-11<br>19:49:43","<span class=\"label label-success\">".unicode_decode("\u6b63\u5e38")."</span><a href=\"javascript:void(0);\" uid=\"1597269355070863\" lock=\"lock\" class=\"btn btn-xs\"><i class=\"fa fa-lock\"></i></a>","<div class=\"btn-group\"><a class=\"btn btn-xs green\" href=\"#\" data-toggle=\"dropdown\"><i class=\"fa fa-user\"></i> ".unicode_decode("\u64cd\u4f5c")." <i class=\"fa fa-angle-down\"></i></a><ul class=\"dropdown-menu\"><li><a href=\"javascript:void(0);\" onclick=\"editPlayerDetail('1597269355070863');\" ><i class=\"fa fa-edit\"></i>".unicode_decode("\u7f16\u8f91")."</a></li><li><a href=\"javascript:void(0);\" reset=reset uid=\"1597269355070863\" ><i class=\"fa fa-lock\"></i>".unicode_decode("\u4fee\u6539\u5bc6\u7801")."</a></li><li><a href=\"javascript:void(0);\" message=message uid=\"1597269355070863\" ><i class=\"fa fa-bell\"></i>".unicode_decode("\u53d1\u6d88\u606f")."</a></li></ul>"),
                array("<input type=\"checkbox\" layer=\"layer\" value=\"1597252043588933\" />",
                "<span class=\"label label-info\" style=\"cursor:pointer;\" onclick=\"custom_getBalance('1597252043588933','li229777548')\">li229777548</span><br />3072325",unicode_decode("\u674e\u4ece\u6587"),"<label id=\"an_1597252043588933\">ly13800</label>\r\n                <a href=\"javascript:void(0);\" agent=agent uid=\"1597252043588933\" class=\"btn btn-xs\"><i class=\"fa fa-edit\"></i></a>\r\n                <br/><label id=\"ac_1597252043588933\">20124</label>","<label group=\"uGroup\" id=\"1597252043588933_group\">".unicode_decode(unicode_decode("\u6ce8\u518c\u9ed8\u8ba4"))."</label><a href=\"javascript:void(0);\" layer=layer uid=\"1597252043588933\" class=\"btn btn-xs\"><i class=\"fa fa-edit\"></i></a>","0.00&nbsp;<a href=\"#\" balance=\"balance\" uid=\"1597252043588933\"><i class=\"fa fa-edit\"></i></a>","<span  load=false uid=\"1597252043588933\">-</span>","0.00&nbsp;<a href=\"javascript:void(0);\" bonus=\"bonus\" uid=\"1597252043588933\"><i class=\"fa fa-edit\"></i></a>","0.00","<label remark=\"remark\" id=\"remark_1597252043588933\" title=\"\"></label><a href=\"javascript:void(0);\" remark=\"remark\" uid=\"1597252043588933\"><i class=\"fa fa-edit\"></i></a>","2017-10-11 19:32:06<br /><label style=\"cursor:pointer;\" attr=\"ip\">14.25.253.25</label><br /><label attr=\"addr\">&nbsp;</label>","2017-10-11<br>19:32:06","<span class=\"label label-success\">".unicode_decode("\u6b63\u5e38")."</span><a href=\"javascript:void(0);\" uid=\"1597252043588933\" lock=\"lock\" class=\"btn btn-xs\"><i class=\"fa fa-lock\"></i></a>","<div class=\"btn-group\"><a class=\"btn btn-xs green\" href=\"#\" data-toggle=\"dropdown\"><i class=\"fa fa-user\"></i> ".unicode_decode("\u64cd\u4f5c")." <i class=\"fa fa-angle-down\"></i></a><ul class=\"dropdown-menu\"><li><a href=\"javascript:void(0);\" onclick=\"editPlayerDetail('1597252043588933');\" ><i class=\"fa fa-edit\"></i>".unicode_decode("\u7f16\u8f91")."</a></li><li><a href=\"javascript:void(0);\" reset=reset uid=\"1597252043588933\" ><i class=\"fa fa-lock\"></i>".unicode_decode("\u4fee\u6539\u5bc6\u7801")."</a></li><li><a href=\"javascript:void(0);\" message=message uid=\"1597252043588933\" ><i class=\"fa fa-bell\"></i>".unicode_decode("\u53d1\u6d88\u606f")."</a></li></ul>"),
                array("<input type=\"checkbox\" layer=\"layer\" value=\"1597248671663704\" />",
                "<span class=\"label label-info\" style=\"cursor:pointer;\" onclick=\"custom_getBalance('1597248671663704','abc1314')\">abc1314</span><br />3319384",unicode_decode("\u6768\u9526"),"<label id=\"an_1597248671663704\">ly13800</label>\r\n                <a href=\"javascript:void(0);\" agent=agent uid=\"1597248671663704\" class=\"btn btn-xs\"><i class=\"fa fa-edit\"></i></a>\r\n                <br/><label id=\"ac_1597248671663704\">20124</label>","<label group=\"uGroup\" id=\"1597248671663704_group\">".unicode_decode(unicode_decode("\u6ce8\u518c\u9ed8\u8ba4"))."</label><a href=\"javascript:void(0);\" layer=layer uid=\"1597248671663704\" class=\"btn btn-xs\"><i class=\"fa fa-edit\"></i></a>","0.00&nbsp;<a href=\"#\" balance=\"balance\" uid=\"1597248671663704\"><i class=\"fa fa-edit\"></i></a>","<span  load=false uid=\"1597248671663704\">-</span>","0.00&nbsp;<a href=\"javascript:void(0);\" bonus=\"bonus\" uid=\"1597248671663704\"><i class=\"fa fa-edit\"></i></a>","0.00","<label remark=\"remark\" id=\"remark_1597248671663704\" title=\"\"></label><a href=\"javascript:void(0);\" remark=\"remark\" uid=\"1597248671663704\"><i class=\"fa fa-edit\"></i></a>","2017-10-11 19:28:40<br /><label style=\"cursor:pointer;\" attr=\"ip\">221.13.63.157</label><br /><label attr=\"addr\">&nbsp;</label>","2017-10-11<br>19:28:40","<span class=\"label label-success\">".unicode_decode("\u6b63\u5e38")."</span><a href=\"javascript:void(0);\" uid=\"1597248671663704\" lock=\"lock\" class=\"btn btn-xs\"><i class=\"fa fa-lock\"></i></a>","<div class=\"btn-group\"><a class=\"btn btn-xs green\" href=\"#\" data-toggle=\"dropdown\"><i class=\"fa fa-user\"></i> ".unicode_decode("\u64cd\u4f5c")." <i class=\"fa fa-angle-down\"></i></a><ul class=\"dropdown-menu\"><li><a href=\"javascript:void(0);\" onclick=\"editPlayerDetail('1597248671663704');\" ><i class=\"fa fa-edit\"></i>".unicode_decode("\u7f16\u8f91")."</a></li><li><a href=\"javascript:void(0);\" reset=reset uid=\"1597248671663704\" ><i class=\"fa fa-lock\"></i>".unicode_decode("\u4fee\u6539\u5bc6\u7801")."</a></li><li><a href=\"javascript:void(0);\" message=message uid=\"1597248671663704\" ><i class=\"fa fa-bell\"></i>".unicode_decode("\u53d1\u6d88\u606f")."</a></li></ul>"),
                array("<input type=\"checkbox\" layer=\"layer\" value=\"1597224980645374\" />",
                "<span class=\"label label-info\" style=\"cursor:pointer;\" onclick=\"custom_getBalance('1597224980645374','1zz0')\">1zz0</span><br />3319294",unicode_decode("\u4e00\u9b3c\u9b3c"),"<label id=\"an_1597224980645374\">defaultagent</label>\r\n                <a href=\"javascript:void(0);\" agent=agent uid=\"1597224980645374\" class=\"btn btn-xs\"><i class=\"fa fa-edit\"></i></a>\r\n                <br/><label id=\"ac_1597224980645374\">10000</label>","<label group=\"uGroup\" id=\"1597224980645374_group\">".unicode_decode(unicode_decode("\u6ce8\u518c\u9ed8\u8ba4"))."</label><a href=\"javascript:void(0);\" layer=layer uid=\"1597224980645374\" class=\"btn btn-xs\"><i class=\"fa fa-edit\"></i></a>","0.00&nbsp;<a href=\"#\" balance=\"balance\" uid=\"1597224980645374\"><i class=\"fa fa-edit\"></i></a>","<span  load=false uid=\"1597224980645374\">-</span>","0.00&nbsp;<a href=\"javascript:void(0);\" bonus=\"bonus\" uid=\"1597224980645374\"><i class=\"fa fa-edit\"></i></a>","0.00","<label remark=\"remark\" id=\"remark_1597224980645374\" title=\"\"></label><a href=\"javascript:void(0);\" remark=\"remark\" uid=\"1597224980645374\"><i class=\"fa fa-edit\"></i></a>","2017-10-11 19:04:34<br /><label style=\"cursor:pointer;\" attr=\"ip\">139.162.102.61</label><br /><label attr=\"addr\">&nbsp;</label>","2017-10-11<br>19:04:34","<span class=\"label label-success\">".unicode_decode("\u6b63\u5e38")."</span><a href=\"javascript:void(0);\" uid=\"1597224980645374\" lock=\"lock\" class=\"btn btn-xs\"><i class=\"fa fa-lock\"></i></a>","<div class=\"btn-group\"><a class=\"btn btn-xs green\" href=\"#\" data-toggle=\"dropdown\"><i class=\"fa fa-user\"></i> ".unicode_decode("\u64cd\u4f5c")." <i class=\"fa fa-angle-down\"></i></a><ul class=\"dropdown-menu\"><li><a href=\"javascript:void(0);\" onclick=\"editPlayerDetail('1597224980645374');\" ><i class=\"fa fa-edit\"></i>".unicode_decode("\u7f16\u8f91")."</a></li><li><a href=\"javascript:void(0);\" reset=reset uid=\"1597224980645374\" ><i class=\"fa fa-lock\"></i>".unicode_decode("\u4fee\u6539\u5bc6\u7801")."</a></li><li><a href=\"javascript:void(0);\" message=message uid=\"1597224980645374\" ><i class=\"fa fa-bell\"></i>".unicode_decode("\u53d1\u6d88\u606f")."</a></li></ul>"),
                array("<input type=\"checkbox\" layer=\"layer\" value=\"1597207146890409\" />",
                "<span class=\"label label-info\" style=\"cursor:pointer;\" onclick=\"custom_getBalance('1597207146890409','3206713320a')\">3206713320a</span><br />3072169",unicode_decode("\u949f\u660c\u6797"),"<label id=\"an_1597207146890409\">ly13800</label>\r\n                <a href=\"javascript:void(0);\" agent=agent uid=\"1597207146890409\" class=\"btn btn-xs\"><i class=\"fa fa-edit\"></i></a>\r\n                <br/><label id=\"ac_1597207146890409\">20124</label>","<label group=\"uGroup\" id=\"1597207146890409_group\">".unicode_decode(unicode_decode("\u6ce8\u518c\u9ed8\u8ba4"))."</label><a href=\"javascript:void(0);\" layer=layer uid=\"1597207146890409\" class=\"btn btn-xs\"><i class=\"fa fa-edit\"></i></a>","0.00&nbsp;<a href=\"#\" balance=\"balance\" uid=\"1597207146890409\"><i class=\"fa fa-edit\"></i></a>","<span  load=false uid=\"1597207146890409\">-</span>","0.00&nbsp;<a href=\"javascript:void(0);\" bonus=\"bonus\" uid=\"1597207146890409\"><i class=\"fa fa-edit\"></i></a>","200.00&nbsp;<a href=\"#\" water=\"water\" title=\"\u6d41\u6c34\u68c0\u67e5\" uid=\"1597207146890409\" name=\"3206713320a\"><i class=\"fa fa-search\"></i></a>","<label remark=\"remark\" id=\"remark_1597207146890409\" title=\"\"></label><a href=\"javascript:void(0);\" remark=\"remark\" uid=\"1597207146890409\"><i class=\"fa fa-edit\"></i></a>","2017-10-11 20:19:28<br /><label style=\"cursor:pointer;\" attr=\"ip\">180.138.107.121</label><br /><label attr=\"addr\">&nbsp;</label>","2017-10-11<br>18:46:26","<span class=\"label label-success\">".unicode_decode("\u6b63\u5e38")."</span><a href=\"javascript:void(0);\" uid=\"1597207146890409\" lock=\"lock\" class=\"btn btn-xs\"><i class=\"fa fa-lock\"></i></a>","<div class=\"btn-group\"><a class=\"btn btn-xs green\" href=\"#\" data-toggle=\"dropdown\"><i class=\"fa fa-user\"></i> ".unicode_decode("\u64cd\u4f5c")." <i class=\"fa fa-angle-down\"></i></a><ul class=\"dropdown-menu\"><li><a href=\"javascript:void(0);\" onclick=\"editPlayerDetail('1597207146890409');\" ><i class=\"fa fa-edit\"></i>".unicode_decode("\u7f16\u8f91")."</a></li><li><a href=\"javascript:void(0);\" reset=reset uid=\"1597207146890409\" ><i class=\"fa fa-lock\"></i>".unicode_decode("\u4fee\u6539\u5bc6\u7801")."</a></li><li><a href=\"javascript:void(0);\" message=message uid=\"1597207146890409\" ><i class=\"fa fa-bell\"></i>".unicode_decode("\u53d1\u6d88\u606f")."</a></li></ul>"),
                array("<input type=\"checkbox\" layer=\"layer\" value=\"1597157243880782\" />",
                "<span class=\"label label-info\" style=\"cursor:pointer;\" onclick=\"custom_getBalance('1597157243880782','2841451239')\">2841451239</span><br />3319118",unicode_decode("\u9646\u5c0f\u9f99"),"<label id=\"an_1597157243880782\">ly13800</label>\r\n                <a href=\"javascript:void(0);\" agent=agent uid=\"1597157243880782\" class=\"btn btn-xs\"><i class=\"fa fa-edit\"></i></a>\r\n                <br/><label id=\"ac_1597157243880782\">20124</label>","<label group=\"uGroup\" id=\"1597157243880782_group\">".unicode_decode(unicode_decode("\u6ce8\u518c\u9ed8\u8ba4"))."</label><a href=\"javascript:void(0);\" layer=layer uid=\"1597157243880782\" class=\"btn btn-xs\"><i class=\"fa fa-edit\"></i></a>","0.00&nbsp;<a href=\"#\" balance=\"balance\" uid=\"1597157243880782\"><i class=\"fa fa-edit\"></i></a>","<span  load=false uid=\"1597157243880782\">-</span>","0.00&nbsp;<a href=\"javascript:void(0);\" bonus=\"bonus\" uid=\"1597157243880782\"><i class=\"fa fa-edit\"></i></a>","0.00","<label remark=\"remark\" id=\"remark_1597157243880782\" title=\"\"></label><a href=\"javascript:void(0);\" remark=\"remark\" uid=\"1597157243880782\"><i class=\"fa fa-edit\"></i></a>","2017-10-11 18:35:10<br /><label style=\"cursor:pointer;\" attr=\"ip\">180.138.107.121</label><br /><label attr=\"addr\">&nbsp;</label>","2017-10-11<br>17:55:40","<span class=\"label label-success\">".unicode_decode("\u6b63\u5e38")."</span><a href=\"javascript:void(0);\" uid=\"1597157243880782\" lock=\"lock\" class=\"btn btn-xs\"><i class=\"fa fa-lock\"></i></a>","<div class=\"btn-group\"><a class=\"btn btn-xs green\" href=\"#\" data-toggle=\"dropdown\"><i class=\"fa fa-user\"></i> ".unicode_decode("\u64cd\u4f5c")." <i class=\"fa fa-angle-down\"></i></a><ul class=\"dropdown-menu\"><li><a href=\"javascript:void(0);\" onclick=\"editPlayerDetail('1597157243880782');\" ><i class=\"fa fa-edit\"></i>".unicode_decode("\u7f16\u8f91")."</a></li><li><a href=\"javascript:void(0);\" reset=reset uid=\"1597157243880782\" ><i class=\"fa fa-lock\"></i>".unicode_decode("\u4fee\u6539\u5bc6\u7801")."</a></li><li><a href=\"javascript:void(0);\" message=message uid=\"1597157243880782\" ><i class=\"fa fa-bell\"></i>".unicode_decode("\u53d1\u6d88\u606f")."</a></li></ul>"),
                array("<input type=\"checkbox\" layer=\"layer\" value=\"1597151272338734\" />",
                "<span class=\"label label-info\" style=\"cursor:pointer;\" onclick=\"custom_getBalance('1597151272338734','a271517948')\">a271517948</span><br />3319086",unicode_decode("\u9ad8\u9759"),"<label id=\"an_1597151272338734\">ly13800</label>\r\n                <a href=\"javascript:void(0);\" agent=agent uid=\"1597151272338734\" class=\"btn btn-xs\"><i class=\"fa fa-edit\"></i></a>\r\n                <br/><label id=\"ac_1597151272338734\">20124</label>","<label group=\"uGroup\" id=\"1597151272338734_group\">".unicode_decode(unicode_decode("\u6ce8\u518c\u9ed8\u8ba4"))."</label><a href=\"javascript:void(0);\" layer=layer uid=\"1597151272338734\" class=\"btn btn-xs\"><i class=\"fa fa-edit\"></i></a>","0.00&nbsp;<a href=\"#\" balance=\"balance\" uid=\"1597151272338734\"><i class=\"fa fa-edit\"></i></a>","<span  load=false uid=\"1597151272338734\">-</span>","0.00&nbsp;<a href=\"javascript:void(0);\" bonus=\"bonus\" uid=\"1597151272338734\"><i class=\"fa fa-edit\"></i></a>","0.00","<label remark=\"remark\" id=\"remark_1597151272338734\" title=\"\"></label><a href=\"javascript:void(0);\" remark=\"remark\" uid=\"1597151272338734\"><i class=\"fa fa-edit\"></i></a>","2017-10-11 18:00:49<br /><label style=\"cursor:pointer;\" attr=\"ip\">183.208.210.117</label><br /><label attr=\"addr\">&nbsp;</label>","2017-10-11<br>17:49:36","<span class=\"label label-success\">".unicode_decode("\u6b63\u5e38")."</span><a href=\"javascript:void(0);\" uid=\"1597151272338734\" lock=\"lock\" class=\"btn btn-xs\"><i class=\"fa fa-lock\"></i></a>","<div class=\"btn-group\"><a class=\"btn btn-xs green\" href=\"#\" data-toggle=\"dropdown\"><i class=\"fa fa-user\"></i> ".unicode_decode("\u64cd\u4f5c")." <i class=\"fa fa-angle-down\"></i></a><ul class=\"dropdown-menu\"><li><a href=\"javascript:void(0);\" onclick=\"editPlayerDetail('1597151272338734');\" ><i class=\"fa fa-edit\"></i>".unicode_decode("\u7f16\u8f91")."</a></li><li><a href=\"javascript:void(0);\" reset=reset uid=\"1597151272338734\" ><i class=\"fa fa-lock\"></i>".unicode_decode("\u4fee\u6539\u5bc6\u7801")."</a></li><li><a href=\"javascript:void(0);\" message=message uid=\"1597151272338734\" ><i class=\"fa fa-bell\"></i>".unicode_decode("\u53d1\u6d88\u606f")."</a></li></ul>"),
                array("<input type=\"checkbox\" layer=\"layer\" value=\"1597148312799227\" />",
                "<span class=\"label label-info\" style=\"cursor:pointer;\" onclick=\"custom_getBalance('1597148312799227','a9627')\">a9627</span><br />3071995",unicode_decode("\u9ec4\u94c1\u5357"),"<label id=\"an_1597148312799227\">ly13800</label>\r\n                <a href=\"javascript:void(0);\" agent=agent uid=\"1597148312799227\" class=\"btn btn-xs\"><i class=\"fa fa-edit\"></i></a>\r\n                <br/><label id=\"ac_1597148312799227\">20124</label>","<label group=\"uGroup\" id=\"1597148312799227_group\">".unicode_decode(unicode_decode("\u6ce8\u518c\u9ed8\u8ba4"))."</label><a href=\"javascript:void(0);\" layer=layer uid=\"1597148312799227\" class=\"btn btn-xs\"><i class=\"fa fa-edit\"></i></a>","0.00&nbsp;<a href=\"#\" balance=\"balance\" uid=\"1597148312799227\"><i class=\"fa fa-edit\"></i></a>","<span  load=false uid=\"1597148312799227\">-</span>","0.00&nbsp;<a href=\"javascript:void(0);\" bonus=\"bonus\" uid=\"1597148312799227\"><i class=\"fa fa-edit\"></i></a>","0.00","<label remark=\"remark\" id=\"remark_1597148312799227\" title=\"\"></label><a href=\"javascript:void(0);\" remark=\"remark\" uid=\"1597148312799227\"><i class=\"fa fa-edit\"></i></a>","2017-10-11 17:46:35<br /><label style=\"cursor:pointer;\" attr=\"ip\">222.245.231.237</label><br /><label attr=\"addr\">&nbsp;</label>","2017-10-11<br>17:46:35","<span class=\"label label-success\">".unicode_decode("\u6b63\u5e38")."</span><a href=\"javascript:void(0);\" uid=\"1597148312799227\" lock=\"lock\" class=\"btn btn-xs\"><i class=\"fa fa-lock\"></i></a>","<div class=\"btn-group\"><a class=\"btn btn-xs green\" href=\"#\" data-toggle=\"dropdown\"><i class=\"fa fa-user\"></i> ".unicode_decode("\u64cd\u4f5c")." <i class=\"fa fa-angle-down\"></i></a><ul class=\"dropdown-menu\"><li><a href=\"javascript:void(0);\" onclick=\"editPlayerDetail('1597148312799227');\" ><i class=\"fa fa-edit\"></i>".unicode_decode("\u7f16\u8f91")."</a></li><li><a href=\"javascript:void(0);\" reset=reset uid=\"1597148312799227\" ><i class=\"fa fa-lock\"></i>".unicode_decode("\u4fee\u6539\u5bc6\u7801")."</a></li><li><a href=\"javascript:void(0);\" message=message uid=\"1597148312799227\" ><i class=\"fa fa-bell\"></i>".unicode_decode("\u53d1\u6d88\u606f")."</a></li></ul>"),
                array("<input type=\"checkbox\" layer=\"layer\" value=\"1597138651579658\" />",
                "<span class=\"label label-info\" style=\"cursor:pointer;\" onclick=\"custom_getBalance('1597138651579658','13612793002')\">13612793002</span><br />3319050",unicode_decode("\u6797\u52a0\u8d24"),"<label id=\"an_1597138651579658\">ly13800</label>\r\n                <a href=\"javascript:void(0);\" agent=agent uid=\"1597138651579658\" class=\"btn btn-xs\"><i class=\"fa fa-edit\"></i></a>\r\n                <br/><label id=\"ac_1597138651579658\">20124</label>","<label group=\"uGroup\" id=\"1597138651579658_group\">".unicode_decode(unicode_decode("\u6ce8\u518c\u9ed8\u8ba4"))."</label><a href=\"javascript:void(0);\" layer=layer uid=\"1597138651579658\" class=\"btn btn-xs\"><i class=\"fa fa-edit\"></i></a>","0.00&nbsp;<a href=\"#\" balance=\"balance\" uid=\"1597138651579658\"><i class=\"fa fa-edit\"></i></a>","<span  load=false uid=\"1597138651579658\">-</span>","0.00&nbsp;<a href=\"javascript:void(0);\" bonus=\"bonus\" uid=\"1597138651579658\"><i class=\"fa fa-edit\"></i></a>","200.00&nbsp;<a href=\"#\" water=\"water\" title=\"\u6d41\u6c34\u68c0\u67e5\" uid=\"1597138651579658\" name=\"13612793002\"><i class=\"fa fa-search\"></i></a>","<label remark=\"remark\" id=\"remark_1597138651579658\" title=\"\"></label><a href=\"javascript:void(0);\" remark=\"remark\" uid=\"1597138651579658\"><i class=\"fa fa-edit\"></i></a>","2017-10-11 19:26:49<br /><label style=\"cursor:pointer;\" attr=\"ip\">183.29.45.219</label><br /><label attr=\"addr\">&nbsp;</label>","2017-10-11<br>17:36:45","<span class=\"label label-success\">".unicode_decode("\u6b63\u5e38")."</span><a href=\"javascript:void(0);\" uid=\"1597138651579658\" lock=\"lock\" class=\"btn btn-xs\"><i class=\"fa fa-lock\"></i></a>","<div class=\"btn-group\"><a class=\"btn btn-xs green\" href=\"#\" data-toggle=\"dropdown\"><i class=\"fa fa-user\"></i> ".unicode_decode("\u64cd\u4f5c")." <i class=\"fa fa-angle-down\"></i></a><ul class=\"dropdown-menu\"><li><a href=\"javascript:void(0);\" onclick=\"editPlayerDetail('1597138651579658');\" ><i class=\"fa fa-edit\"></i>".unicode_decode("\u7f16\u8f91")."</a></li><li><a href=\"javascript:void(0);\" reset=reset uid=\"1597138651579658\" ><i class=\"fa fa-lock\"></i>".unicode_decode("\u4fee\u6539\u5bc6\u7801")."</a></li><li><a href=\"javascript:void(0);\" message=message uid=\"1597138651579658\" ><i class=\"fa fa-bell\"></i>".unicode_decode("\u53d1\u6d88\u606f")."</a></li></ul>"),
                array("<input type=\"checkbox\" layer=\"layer\" value=\"1597135213414355\" />",
                "<span class=\"label label-info\" style=\"cursor:pointer;\" onclick=\"custom_getBalance('1597135213414355','520lmh')\">520lmh</span><br />3071955",unicode_decode("\u6298\u5efa\u98de"),"<label id=\"an_1597135213414355\">ly13800</label>\r\n                <a href=\"javascript:void(0);\" agent=agent uid=\"1597135213414355\" class=\"btn btn-xs\"><i class=\"fa fa-edit\"></i></a>\r\n                <br/><label id=\"ac_1597135213414355\">20124</label>","<label group=\"uGroup\" id=\"1597135213414355_group\">".unicode_decode(unicode_decode("\u6ce8\u518c\u9ed8\u8ba4"))."</label><a href=\"javascript:void(0);\" layer=layer uid=\"1597135213414355\" class=\"btn btn-xs\"><i class=\"fa fa-edit\"></i></a>","0.00&nbsp;<a href=\"#\" balance=\"balance\" uid=\"1597135213414355\"><i class=\"fa fa-edit\"></i></a>","<span  load=false uid=\"1597135213414355\">-</span>","0.00&nbsp;<a href=\"javascript:void(0);\" bonus=\"bonus\" uid=\"1597135213414355\"><i class=\"fa fa-edit\"></i></a>","0.00","<label remark=\"remark\" id=\"remark_1597135213414355\" title=\"\"></label><a href=\"javascript:void(0);\" remark=\"remark\" uid=\"1597135213414355\"><i class=\"fa fa-edit\"></i></a>","2017-10-11 18:24:50<br /><label style=\"cursor:pointer;\" attr=\"ip\">223.104.11.182</label><br /><label attr=\"addr\">&nbsp;</label>","2017-10-11<br>17:33:16","<span class=\"label label-success\">".unicode_decode("\u6b63\u5e38")."</span><a href=\"javascript:void(0);\" uid=\"1597135213414355\" lock=\"lock\" class=\"btn btn-xs\"><i class=\"fa fa-lock\"></i></a>","<div class=\"btn-group\"><a class=\"btn btn-xs green\" href=\"#\" data-toggle=\"dropdown\"><i class=\"fa fa-user\"></i> ".unicode_decode("\u64cd\u4f5c")." <i class=\"fa fa-angle-down\"></i></a><ul class=\"dropdown-menu\"><li><a href=\"javascript:void(0);\" onclick=\"editPlayerDetail('1597135213414355');\" ><i class=\"fa fa-edit\"></i>".unicode_decode("\u7f16\u8f91")."</a></li><li><a href=\"javascript:void(0);\" reset=reset uid=\"1597135213414355\" ><i class=\"fa fa-lock\"></i>".unicode_decode("\u4fee\u6539\u5bc6\u7801")."</a></li><li><a href=\"javascript:void(0);\" message=message uid=\"1597135213414355\" ><i class=\"fa fa-bell\"></i>".unicode_decode("\u53d1\u6d88\u606f")."</a></li></ul>"),
                array("<input type=\"checkbox\" layer=\"layer\" value=\"1597090877425453\" />",
                "<span class=\"label label-info\" style=\"cursor:pointer;\" onclick=\"custom_getBalance('1597090877425453','1684290901')\">1684290901</span><br />3071789",unicode_decode("\u6587\u6728\u743c"),"<label id=\"an_1597090877425453\">taizi168</label>\r\n                <a href=\"javascript:void(0);\" agent=agent uid=\"1597090877425453\" class=\"btn btn-xs\"><i class=\"fa fa-edit\"></i></a>\r\n                <br/><label id=\"ac_1597090877425453\">20122</label>","<label group=\"uGroup\" id=\"1597090877425453_group\">".unicode_decode(unicode_decode("\u6ce8\u518c\u9ed8\u8ba4"))."</label><a href=\"javascript:void(0);\" layer=layer uid=\"1597090877425453\" class=\"btn btn-xs\"><i class=\"fa fa-edit\"></i></a>","0.00&nbsp;<a href=\"#\" balance=\"balance\" uid=\"1597090877425453\"><i class=\"fa fa-edit\"></i></a>","<span  load=false uid=\"1597090877425453\">-</span>","0.00&nbsp;<a href=\"javascript:void(0);\" bonus=\"bonus\" uid=\"1597090877425453\"><i class=\"fa fa-edit\"></i></a>","0.00","<label remark=\"remark\" id=\"remark_1597090877425453\" title=\"\"></label><a href=\"javascript:void(0);\" remark=\"remark\" uid=\"1597090877425453\"><i class=\"fa fa-edit\"></i></a>","2017-10-11 16:48:09<br /><label style=\"cursor:pointer;\" attr=\"ip\">139.207.192.137</label><br /><label attr=\"addr\">&nbsp;</label>","2017-10-11<br>16:48:09","<span class=\"label label-success\">".unicode_decode("\u6b63\u5e38")."</span><a href=\"javascript:void(0);\" uid=\"1597090877425453\" lock=\"lock\" class=\"btn btn-xs\"><i class=\"fa fa-lock\"></i></a>","<div class=\"btn-group\"><a class=\"btn btn-xs green\" href=\"#\" data-toggle=\"dropdown\"><i class=\"fa fa-user\"></i> ".unicode_decode("\u64cd\u4f5c")." <i class=\"fa fa-angle-down\"></i></a><ul class=\"dropdown-menu\"><li><a href=\"javascript:void(0);\" onclick=\"editPlayerDetail('1597090877425453');\" ><i class=\"fa fa-edit\"></i>".unicode_decode("\u7f16\u8f91")."</a></li><li><a href=\"javascript:void(0);\" reset=reset uid=\"1597090877425453\" ><i class=\"fa fa-lock\"></i>".unicode_decode("\u4fee\u6539\u5bc6\u7801")."</a></li><li><a href=\"javascript:void(0);\" message=message uid=\"1597090877425453\" ><i class=\"fa fa-bell\"></i>".unicode_decode("\u53d1\u6d88\u606f")."</a></li></ul>"),
                array("<input type=\"checkbox\" layer=\"layer\" value=\"1596199950452076\" />",
                "<span class=\"label label-info\" style=\"cursor:pointer;\" onclick=\"custom_getBalance('1596199950452076','haoyun520')\">haoyun520</span><br />3317100",unicode_decode("\u674e\u5cb8"),"<label id=\"an_1596199950452076\">ly13800</label>\r\n                <a href=\"javascript:void(0);\" agent=agent uid=\"1596199950452076\" class=\"btn btn-xs\"><i class=\"fa fa-edit\"></i></a>\r\n                <br/><label id=\"ac_1596199950452076\">20124</label>","<label group=\"uGroup\" id=\"1596199950452076_group\">".unicode_decode(unicode_decode("\u6ce8\u518c\u9ed8\u8ba4"))."</label><a href=\"javascript:void(0);\" layer=layer uid=\"1596199950452076\" class=\"btn btn-xs\"><i class=\"fa fa-edit\"></i></a>","0.00&nbsp;<a href=\"#\" balance=\"balance\" uid=\"1596199950452076\"><i class=\"fa fa-edit\"></i></a>","<span  load=false uid=\"1596199950452076\">-</span>","0.00&nbsp;<a href=\"javascript:void(0);\" bonus=\"bonus\" uid=\"1596199950452076\"><i class=\"fa fa-edit\"></i></a>","0.00","<label remark=\"remark\" id=\"remark_1596199950452076\" title=\"\"></label><a href=\"javascript:void(0);\" remark=\"remark\" uid=\"1596199950452076\"><i class=\"fa fa-edit\"></i></a>","2017-10-11 01:41:52<br /><label style=\"cursor:pointer;\" attr=\"ip\">14.25.55.248</label><br /><label attr=\"addr\">&nbsp;</label>","2017-10-11<br>01:41:52","<span class=\"label label-success\">".unicode_decode("\u6b63\u5e38")."</span><a href=\"javascript:void(0);\" uid=\"1596199950452076\" lock=\"lock\" class=\"btn btn-xs\"><i class=\"fa fa-lock\"></i></a>","<div class=\"btn-group\"><a class=\"btn btn-xs green\" href=\"#\" data-toggle=\"dropdown\"><i class=\"fa fa-user\"></i> ".unicode_decode("\u64cd\u4f5c")." <i class=\"fa fa-angle-down\"></i></a><ul class=\"dropdown-menu\"><li><a href=\"javascript:void(0);\" onclick=\"editPlayerDetail('1596199950452076');\" ><i class=\"fa fa-edit\"></i>".unicode_decode("\u7f16\u8f91")."</a></li><li><a href=\"javascript:void(0);\" reset=reset uid=\"1596199950452076\" ><i class=\"fa fa-lock\"></i>".unicode_decode("\u4fee\u6539\u5bc6\u7801")."</a></li><li><a href=\"javascript:void(0);\" message=message uid=\"1596199950452076\" ><i class=\"fa fa-bell\"></i>".unicode_decode("\u53d1\u6d88\u606f")."</a></li></ul>"),
                array("<input type=\"checkbox\" layer=\"layer\" value=\"1596160646726916\" />",
                "<span class=\"label label-info\" style=\"cursor:pointer;\" onclick=\"custom_getBalance('1596160646726916','xiang110')\">xiang110</span><br />3316996",unicode_decode("\u859b\u56fd\u5e86"),"<label id=\"an_1596160646726916\">ly138004</label>\r\n                <a href=\"javascript:void(0);\" agent=agent uid=\"1596160646726916\" class=\"btn btn-xs\"><i class=\"fa fa-edit\"></i></a>\r\n                <br/><label id=\"ac_1596160646726916\">20139</label>","<label group=\"uGroup\" id=\"1596160646726916_group\">".unicode_decode(unicode_decode("\u6ce8\u518c\u9ed8\u8ba4"))."</label><a href=\"javascript:void(0);\" layer=layer uid=\"1596160646726916\" class=\"btn btn-xs\"><i class=\"fa fa-edit\"></i></a>","0.00&nbsp;<a href=\"#\" balance=\"balance\" uid=\"1596160646726916\"><i class=\"fa fa-edit\"></i></a>","<span  load=false uid=\"1596160646726916\">-</span>","0.00&nbsp;<a href=\"javascript:void(0);\" bonus=\"bonus\" uid=\"1596160646726916\"><i class=\"fa fa-edit\"></i></a>","0.00","<label remark=\"remark\" id=\"remark_1596160646726916\" title=\"\"></label><a href=\"javascript:void(0);\" remark=\"remark\" uid=\"1596160646726916\"><i class=\"fa fa-edit\"></i></a>","2017-10-11 18:22:44<br /><label style=\"cursor:pointer;\" attr=\"ip\">119.29.205.58</label><br /><label attr=\"addr\">&nbsp;</label>","2017-10-11<br>01:01:53","<span class=\"label label-success\">".unicode_decode("\u6b63\u5e38")."</span><a href=\"javascript:void(0);\" uid=\"1596160646726916\" lock=\"lock\" class=\"btn btn-xs\"><i class=\"fa fa-lock\"></i></a>","<div class=\"btn-group\"><a class=\"btn btn-xs green\" href=\"#\" data-toggle=\"dropdown\"><i class=\"fa fa-user\"></i> ".unicode_decode("\u64cd\u4f5c")." <i class=\"fa fa-angle-down\"></i></a><ul class=\"dropdown-menu\"><li><a href=\"javascript:void(0);\" onclick=\"editPlayerDetail('1596160646726916');\" ><i class=\"fa fa-edit\"></i>".unicode_decode("\u7f16\u8f91")."</a></li><li><a href=\"javascript:void(0);\" reset=reset uid=\"1596160646726916\" ><i class=\"fa fa-lock\"></i>".unicode_decode("\u4fee\u6539\u5bc6\u7801")."</a></li><li><a href=\"javascript:void(0);\" message=message uid=\"1596160646726916\" ><i class=\"fa fa-bell\"></i>".unicode_decode("\u53d1\u6d88\u606f")."</a></li></ul>"),
                array("<input type=\"checkbox\" layer=\"layer\" value=\"1596068628661953\" />",
                "<span class=\"label label-info\" style=\"cursor:pointer;\" onclick=\"custom_getBalance('1596068628661953','18395910686')\">18395910686</span><br />3069633",unicode_decode("\u6768\u658c"),"<label id=\"an_1596068628661953\">ly13800</label>\r\n                <a href=\"javascript:void(0);\" agent=agent uid=\"1596068628661953\" class=\"btn btn-xs\"><i class=\"fa fa-edit\"></i></a>\r\n                <br/><label id=\"ac_1596068628661953\">20124</label>","<label group=\"uGroup\" id=\"1596068628661953_group\">".unicode_decode(unicode_decode("\u6ce8\u518c\u9ed8\u8ba4"))."</label><a href=\"javascript:void(0);\" layer=layer uid=\"1596068628661953\" class=\"btn btn-xs\"><i class=\"fa fa-edit\"></i></a>","0.00&nbsp;<a href=\"#\" balance=\"balance\" uid=\"1596068628661953\"><i class=\"fa fa-edit\"></i></a>","<span  load=false uid=\"1596068628661953\">-</span>","0.00&nbsp;<a href=\"javascript:void(0);\" bonus=\"bonus\" uid=\"1596068628661953\"><i class=\"fa fa-edit\"></i></a>","0.00","<label remark=\"remark\" id=\"remark_1596068628661953\" title=\"\"></label><a href=\"javascript:void(0);\" remark=\"remark\" uid=\"1596068628661953\"><i class=\"fa fa-edit\"></i></a>","2017-10-10 23:28:16<br /><label style=\"cursor:pointer;\" attr=\"ip\">112.17.243.157</label><br /><label attr=\"addr\">&nbsp;</label>","2017-10-10<br>23:28:16","<span class=\"label label-success\">".unicode_decode("\u6b63\u5e38")."</span><a href=\"javascript:void(0);\" uid=\"1596068628661953\" lock=\"lock\" class=\"btn btn-xs\"><i class=\"fa fa-lock\"></i></a>","<div class=\"btn-group\"><a class=\"btn btn-xs green\" href=\"#\" data-toggle=\"dropdown\"><i class=\"fa fa-user\"></i> ".unicode_decode("\u64cd\u4f5c")." <i class=\"fa fa-angle-down\"></i></a><ul class=\"dropdown-menu\"><li><a href=\"javascript:void(0);\" onclick=\"editPlayerDetail('1596068628661953');\" ><i class=\"fa fa-edit\"></i>".unicode_decode("\u7f16\u8f91")."</a></li><li><a href=\"javascript:void(0);\" reset=reset uid=\"1596068628661953\" ><i class=\"fa fa-lock\"></i>".unicode_decode("\u4fee\u6539\u5bc6\u7801")."</a></li><li><a href=\"javascript:void(0);\" message=message uid=\"1596068628661953\" ><i class=\"fa fa-bell\"></i>".unicode_decode("\u53d1\u6d88\u606f")."</a></li></ul>"),
                array("<input type=\"checkbox\" layer=\"layer\" value=\"1595978348807645\" />",
                "<span class=\"label label-info\" style=\"cursor:pointer;\" onclick=\"custom_getBalance('1595978348807645','7373966a')\">7373966a</span><br />3069405",unicode_decode("\u6731\u5c0f\u5170"),"<label id=\"an_1595978348807645\">ly13800</label>\r\n                <a href=\"javascript:void(0);\" agent=agent uid=\"1595978348807645\" class=\"btn btn-xs\"><i class=\"fa fa-edit\"></i></a>\r\n                <br/><label id=\"ac_1595978348807645\">20124</label>","<label group=\"uGroup\" id=\"1595978348807645_group\">".unicode_decode(unicode_decode("\u6ce8\u518c\u9ed8\u8ba4"))."</label><a href=\"javascript:void(0);\" layer=layer uid=\"1595978348807645\" class=\"btn btn-xs\"><i class=\"fa fa-edit\"></i></a>","0.00&nbsp;<a href=\"#\" balance=\"balance\" uid=\"1595978348807645\"><i class=\"fa fa-edit\"></i></a>","<span  load=false uid=\"1595978348807645\">-</span>","0.00&nbsp;<a href=\"javascript:void(0);\" bonus=\"bonus\" uid=\"1595978348807645\"><i class=\"fa fa-edit\"></i></a>","0.00","<label remark=\"remark\" id=\"remark_1595978348807645\" title=\"\"></label><a href=\"javascript:void(0);\" remark=\"remark\" uid=\"1595978348807645\"><i class=\"fa fa-edit\"></i></a>","2017-10-10 21:56:26<br /><label style=\"cursor:pointer;\" attr=\"ip\">171.108.65.180</label><br /><label attr=\"addr\">&nbsp;</label>","2017-10-10<br>21:56:26","<span class=\"label label-success\">".unicode_decode("\u6b63\u5e38")."</span><a href=\"javascript:void(0);\" uid=\"1595978348807645\" lock=\"lock\" class=\"btn btn-xs\"><i class=\"fa fa-lock\"></i></a>","<div class=\"btn-group\"><a class=\"btn btn-xs green\" href=\"#\" data-toggle=\"dropdown\"><i class=\"fa fa-user\"></i> ".unicode_decode("\u64cd\u4f5c")." <i class=\"fa fa-angle-down\"></i></a><ul class=\"dropdown-menu\"><li><a href=\"javascript:void(0);\" onclick=\"editPlayerDetail('1595978348807645');\" ><i class=\"fa fa-edit\"></i>".unicode_decode("\u7f16\u8f91")."</a></li><li><a href=\"javascript:void(0);\" reset=reset uid=\"1595978348807645\" ><i class=\"fa fa-lock\"></i>".unicode_decode("\u4fee\u6539\u5bc6\u7801")."</a></li><li><a href=\"javascript:void(0);\" message=message uid=\"1595978348807645\" ><i class=\"fa fa-bell\"></i>".unicode_decode("\u53d1\u6d88\u606f")."</a></li></ul>"),
                array("<input type=\"checkbox\" layer=\"layer\" value=\"1595953119839627\" />",
                "<span class=\"label label-info\" style=\"cursor:pointer;\" onclick=\"custom_getBalance('1595953119839627','q914432380')\">q914432380</span><br />3069323",unicode_decode("\u95fb\u5fb7\u8c6a"),"<label id=\"an_1595953119839627\">ly13800</label>\r\n                <a href=\"javascript:void(0);\" agent=agent uid=\"1595953119839627\" class=\"btn btn-xs\"><i class=\"fa fa-edit\"></i></a>\r\n                <br/><label id=\"ac_1595953119839627\">20124</label>","<label group=\"uGroup\" id=\"1595953119839627_group\">".unicode_decode(unicode_decode("\u6ce8\u518c\u9ed8\u8ba4"))."</label><a href=\"javascript:void(0);\" layer=layer uid=\"1595953119839627\" class=\"btn btn-xs\"><i class=\"fa fa-edit\"></i></a>","0.02&nbsp;<a href=\"#\" balance=\"balance\" uid=\"1595953119839627\"><i class=\"fa fa-edit\"></i></a>","<span  load=false uid=\"1595953119839627\">-</span>","0.02&nbsp;<a href=\"javascript:void(0);\" bonus=\"bonus\" uid=\"1595953119839627\"><i class=\"fa fa-edit\"></i></a>","200.02&nbsp;<a href=\"#\" water=\"water\" title=\"\u6d41\u6c34\u68c0\u67e5\" uid=\"1595953119839627\" name=\"q914432380\"><i class=\"fa fa-search\"></i></a>","<label remark=\"remark\" id=\"remark_1595953119839627\" title=\"\"></label><a href=\"javascript:void(0);\" remark=\"remark\" uid=\"1595953119839627\"><i class=\"fa fa-edit\"></i></a>","2017-10-11 18:55:27<br /><label style=\"cursor:pointer;\" attr=\"ip\">117.136.79.123</label><br /><label attr=\"addr\">&nbsp;</label>","2017-10-10<br>21:30:46","<span class=\"label label-success\">".unicode_decode("\u6b63\u5e38")."</span><a href=\"javascript:void(0);\" uid=\"1595953119839627\" lock=\"lock\" class=\"btn btn-xs\"><i class=\"fa fa-lock\"></i></a>","<div class=\"btn-group\"><a class=\"btn btn-xs green\" href=\"#\" data-toggle=\"dropdown\"><i class=\"fa fa-user\"></i> ".unicode_decode("\u64cd\u4f5c")." <i class=\"fa fa-angle-down\"></i></a><ul class=\"dropdown-menu\"><li><a href=\"javascript:void(0);\" onclick=\"editPlayerDetail('1595953119839627');\" ><i class=\"fa fa-edit\"></i>".unicode_decode("\u7f16\u8f91")."</a></li><li><a href=\"javascript:void(0);\" reset=reset uid=\"1595953119839627\" ><i class=\"fa fa-lock\"></i>".unicode_decode("\u4fee\u6539\u5bc6\u7801")."</a></li><li><a href=\"javascript:void(0);\" message=message uid=\"1595953119839627\" ><i class=\"fa fa-bell\"></i>".unicode_decode("\u53d1\u6d88\u606f")."</a></li></ul>"),
                array("<input type=\"checkbox\" layer=\"layer\" value=\"1595932177254060\" />",
                "<span class=\"label label-info\" style=\"cursor:pointer;\" onclick=\"custom_getBalance('1595932177254060','wifi')\">wifi</span><br />3316396",unicode_decode("\u9ec4\u8fdc\u950b"),"<label id=\"an_1595932177254060\">ly13800</label>\r\n                <a href=\"javascript:void(0);\" agent=agent uid=\"1595932177254060\" class=\"btn btn-xs\"><i class=\"fa fa-edit\"></i></a>\r\n                <br/><label id=\"ac_1595932177254060\">20124</label>","<label group=\"uGroup\" id=\"1595932177254060_group\">".unicode_decode(unicode_decode("\u6ce8\u518c\u9ed8\u8ba4"))."</label><a href=\"javascript:void(0);\" layer=layer uid=\"1595932177254060\" class=\"btn btn-xs\"><i class=\"fa fa-edit\"></i></a>","5.52&nbsp;<a href=\"#\" balance=\"balance\" uid=\"1595932177254060\"><i class=\"fa fa-edit\"></i></a>","<span  load=false uid=\"1595932177254060\">-</span>","5.52&nbsp;<a href=\"javascript:void(0);\" bonus=\"bonus\" uid=\"1595932177254060\"><i class=\"fa fa-edit\"></i></a>","505.52&nbsp;<a href=\"#\" water=\"water\" title=\"\u6d41\u6c34\u68c0\u67e5\" uid=\"1595932177254060\" name=\"wifi\"><i class=\"fa fa-search\"></i></a>","<label remark=\"remark\" id=\"remark_1595932177254060\" title=\"\"></label><a href=\"javascript:void(0);\" remark=\"remark\" uid=\"1595932177254060\"><i class=\"fa fa-edit\"></i></a>","2017-10-10 21:09:28<br /><label style=\"cursor:pointer;\" attr=\"ip\">183.63.90.154</label><br /><label attr=\"addr\">&nbsp;</label>","2017-10-10<br>21:09:28","<span class=\"label label-success\">".unicode_decode("\u6b63\u5e38")."</span><a href=\"javascript:void(0);\" uid=\"1595932177254060\" lock=\"lock\" class=\"btn btn-xs\"><i class=\"fa fa-lock\"></i></a>","<div class=\"btn-group\"><a class=\"btn btn-xs green\" href=\"#\" data-toggle=\"dropdown\"><i class=\"fa fa-user\"></i> ".unicode_decode("\u64cd\u4f5c")." <i class=\"fa fa-angle-down\"></i></a><ul class=\"dropdown-menu\"><li><a href=\"javascript:void(0);\" onclick=\"editPlayerDetail('1595932177254060');\" ><i class=\"fa fa-edit\"></i>".unicode_decode("\u7f16\u8f91")."</a></li><li><a href=\"javascript:void(0);\" reset=reset uid=\"1595932177254060\" ><i class=\"fa fa-lock\"></i>".unicode_decode("\u4fee\u6539\u5bc6\u7801")."</a></li><li><a href=\"javascript:void(0);\" message=message uid=\"1595932177254060\" ><i class=\"fa fa-bell\"></i>".unicode_decode("\u53d1\u6d88\u606f")."</a></li></ul>"),
                array("<input type=\"checkbox\" layer=\"layer\" value=\"1595827551372644\" />",
                "<span class=\"label label-info\" style=\"cursor:pointer;\" onclick=\"custom_getBalance('1595827551372644','a3749939')\">a3749939</span><br />3316068",unicode_decode("\u9648\u5fd7\u5764"),"<label id=\"an_1595827551372644\">ly13800</label>\r\n                <a href=\"javascript:void(0);\" agent=agent uid=\"1595827551372644\" class=\"btn btn-xs\"><i class=\"fa fa-edit\"></i></a>\r\n                <br/><label id=\"ac_1595827551372644\">20124</label>","<label group=\"uGroup\" id=\"1595827551372644_group\">".unicode_decode(unicode_decode("\u6ce8\u518c\u9ed8\u8ba4"))."</label><a href=\"javascript:void(0);\" layer=layer uid=\"1595827551372644\" class=\"btn btn-xs\"><i class=\"fa fa-edit\"></i></a>","0.99&nbsp;<a href=\"#\" balance=\"balance\" uid=\"1595827551372644\"><i class=\"fa fa-edit\"></i></a>","<span  load=false uid=\"1595827551372644\">-</span>","0.99&nbsp;<a href=\"javascript:void(0);\" bonus=\"bonus\" uid=\"1595827551372644\"><i class=\"fa fa-edit\"></i></a>","200.99&nbsp;<a href=\"#\" water=\"water\" title=\"\u6d41\u6c34\u68c0\u67e5\" uid=\"1595827551372644\" name=\"a3749939\"><i class=\"fa fa-search\"></i></a>","<label remark=\"remark\" id=\"remark_1595827551372644\" title=\"\"></label><a href=\"javascript:void(0);\" remark=\"remark\" uid=\"1595827551372644\"><i class=\"fa fa-edit\"></i></a>","2017-10-10 20:21:06<br /><label style=\"cursor:pointer;\" attr=\"ip\">146.88.205.18</label><br /><label attr=\"addr\">&nbsp;</label>","2017-10-10<br>19:23:02","<span class=\"label label-success\">".unicode_decode("\u6b63\u5e38")."</span><a href=\"javascript:void(0);\" uid=\"1595827551372644\" lock=\"lock\" class=\"btn btn-xs\"><i class=\"fa fa-lock\"></i></a>","<div class=\"btn-group\"><a class=\"btn btn-xs green\" href=\"#\" data-toggle=\"dropdown\"><i class=\"fa fa-user\"></i> ".unicode_decode("\u64cd\u4f5c")." <i class=\"fa fa-angle-down\"></i></a><ul class=\"dropdown-menu\"><li><a href=\"javascript:void(0);\" onclick=\"editPlayerDetail('1595827551372644');\" ><i class=\"fa fa-edit\"></i>".unicode_decode("\u7f16\u8f91")."</a></li><li><a href=\"javascript:void(0);\" reset=reset uid=\"1595827551372644\" ><i class=\"fa fa-lock\"></i>".unicode_decode("\u4fee\u6539\u5bc6\u7801")."</a></li><li><a href=\"javascript:void(0);\" message=message uid=\"1595827551372644\" ><i class=\"fa fa-bell\"></i>".unicode_decode("\u53d1\u6d88\u606f")."</a></li></ul>")
                )
            );

        echo json_encode($ret);
    }

    function playerWinloss(){
        $randNum = rand(1, 100);
        if ($randNum < 35){
            $ret = array("betamt"=>0,"payout"=>0,"winloss"=>0,"validamt"=>0);
        }elseif ($randNum < 70){
            $ret = array("uid"=>"1597207146890409","betamt"=>"864.0000","payout"=>"666.4000","winloss"=>"-197.6000","validamt"=>"864.0000");
        }else{
            $ret = array("uid"=>"1597288920827361","betamt"=>"680.0000","payout"=>"715.4000","winloss"=>"35.4000","validamt"=>"680.0000");
        };

        echo json_encode($ret);
    }

    function playerDetail(){
        echo makePage("", "player/playerDetail", "playerDetail_footer");
    }

    function editProf(){
        $randNum = rand(1, 100);
        if ($randNum < 50){
            $ret = array("success"=>false,"msg"=>unicode_decode("\u73a9\u5bb6\u771f\u5b9e\u59d3\u540d\u683c\u5f0f\u6709\u8bef\uff01"));
        }else{
            $ret = array("success"=>true,"response"=>null,"msg"=>unicode_decode("\u64cd\u4f5c\u6210\u529f"));
        };

        echo json_encode($ret);
    }

    function regDaily(){
        echo makePage("", "player/regDaily", "");
    }
    
    function regDailyAjax(){
        $ret = array(
            "sEcho"=>"1",
            "iTotalRecords"=>"3",
            "iTotalDisplayRecords"=>"3",
            "aaData"=>array(
                array(1,"<span class=\"label label-info\" style=\"cursor:pointer;\" onclick=\"custom_getBalance('1598004738639705','say123456')\">say123456</span>",
                    unicode_decode("\u9ec4\u6210"),unicode_decode("\u6ce8\u518c\u9ed8\u8ba4"),"2017-10-12 08:17:47","<label attr=\"ip\">113.57.250.161</label><br /><label attr=\"addr\">&nbsp;</label>","dscheng",
                        unicode_decode("\u672a\u6821\u9a8c"),"<a href=\"javascript:void(0)\" onclick=\"checkPlayer(1598004738639705)\" class=\"btn mini green\"><i class=\"icon-trash\"></i>".unicode_decode("\u6821\u9a8c")."</a> <a href=\"javascript:void(0)\" onclick=\"lockPlayer(this,1598004738639705)\" class=\"btn mini red\"><i class=\"icon-trash\"></i>".unicode_decode("\u9501\u5b9a")."</a>"),
                array(2,"<span class=\"label label-info\" style=\"cursor:pointer;\" onclick=\"custom_getBalance('1597967855371434','gtl1314')\">gtl1314</span>",
                    unicode_decode("\u5173\u6cf0\u9f99"),unicode_decode("\u6ce8\u518c\u9ed8\u8ba4"),"2017-10-12 07:40:16","<label attr=\"ip\">118.81.100.103</label><br /><label attr=\"addr\">&nbsp;</label>","huoqing",
                    unicode_decode("\u672a\u6821\u9a8c"),"<a href=\"javascript:void(0)\" onclick=\"checkPlayer(1597967855371434)\" class=\"btn mini green\"><i class=\"icon-trash\"></i>".unicode_decode("\u6821\u9a8c")."</a> <a href=\"javascript:void(0)\" onclick=\"lockPlayer(this,1597967855371434)\" class=\"btn mini red\"><i class=\"icon-trash\"></i>".unicode_decode("\u9501\u5b9a")."</a>"),
                array(3,"<span class=\"label label-info\" style=\"cursor:pointer;\" onclick=\"custom_getBalance('1597556181632217','zhangsong19')\">zhangsong19</span>",
                    unicode_decode("\u5f20\u677e\u677e"),unicode_decode("\u6ce8\u518c\u9ed8\u8ba4"),"2017-10-12 00:41:29","<label attr=\"ip\">117.136.79.156</label><br /><label attr=\"addr\">&nbsp;</label>","ly13800",
                                unicode_decode("\u672a\u6821\u9a8c"),"<a href=\"javascript:void(0)\" onclick=\"checkPlayer(1597556181632217)\" class=\"btn mini green\"><i class=\"icon-trash\"></i>".unicode_decode("\u6821\u9a8c")."</a> <a href=\"javascript:void(0)\" onclick=\"lockPlayer(this,1597556181632217)\" class=\"btn mini red\"><i class=\"icon-trash\"></i>".unicode_decode("\u9501\u5b9a")."</a>")
                            )
        );
        echo json_encode($ret);
    }

    function checkPlayer(){

    }
    
    function fundFlow(){
        echo makePage("", "player/fundFlow", "fundFlow_footer");
    }

    function fundFlowAjax(){
        $ret = array(
                "sEcho"=>"1",
                "iTotalRecords"=>"288",
                "iTotalDisplayRecords"=>"288",
                "dpt"=>"98,495.20",
                "wtd"=>"-32,252.00",
                "bonus"=>"704.73",
                "rakeback"=>"0.00",
                "trans"=>"786,847.50",
                "pdpt"=>"497.00",
                "pwtd"=>"0.00",
                "pbonus"=>"4.97",
                "prakeback"=>"0.00",
                "ptrans"=>"71,311.22",
                "aaData"=>array(
                    array(1,"<span class=\"label label-info\" style=\"cursor:pointer;\" onclick=\"custom_getBalance('1547748720068149','987654321')\">987654321</span>","540.00",unicode_decode("\u8f6c\u8d26"),unicode_decode("\u73a9\u5bb6\u8f6c\u5165\u6e38\u620f"),"2017-10-12<br>10:58:17","",unicode_decode("\u8f6c\u5165\u53cc\u8d62\u5f69\u7968")),
                    array(2,"<span class=\"label label-info\" style=\"cursor:pointer;\" onclick=\"custom_getBalance('1547748720068149','987654321')\">987654321</span>","540.00",unicode_decode("\u8f6c\u8d26"),unicode_decode("\u73a9\u5bb6\u4e3b\u8d26\u6237\u8f6c\u51fa\uff08\u5230\u6e38\u620f\uff09"),"2017-10-12<br>10:58:16","",unicode_decode("\u8f6c\u5165\u53cc\u8d62\u5f69\u7968\uff0c\u4e3b\u8d26\u6237\u4f59\u989d: 0.5000")),
                    array(3,"<span class=\"label label-info\" style=\"cursor:pointer;\" onclick=\"custom_getBalance('1547748720068149','987654321')\">987654321</span>","540.00",unicode_decode("\u8f6c\u8d26"),unicode_decode("\u73a9\u5bb6\u4e3b\u8d26\u6237\u8f6c\u5165\uff08\u4ece\u6e38\u620f\uff09"),"2017-10-12<br>10:58:15","",unicode_decode("\u53cc\u8d62\u5f69\u7968\u8f6c\u51fa\uff0c\u4e3b\u8d26\u6237\u4f59\u989d: 540.5000")),
                    array(4,"<span class=\"label label-info\" style=\"cursor:pointer;\" onclick=\"custom_getBalance('1547748720068149','987654321')\">987654321</span>","540.00",unicode_decode("\u8f6c\u8d26"),unicode_decode("\u73a9\u5bb6\u8f6c\u51fa\u6e38\u620f"),"2017-10-12<br>10:58:15","",unicode_decode("\u8f6c\u51fa\u53cc\u8d62\u5f69\u7968")),
                    array(5,"<span class=\"label label-info\" style=\"cursor:pointer;\" onclick=\"custom_getBalance('1563214170293657','ljn0324')\">ljn0324</span>","16,031.00",unicode_decode("\u8f6c\u8d26"),unicode_decode("\u73a9\u5bb6\u8f6c\u5165\u6e38\u620f"),"2017-10-12<br>10:57:15","",unicode_decode("\u8f6c\u5165\u53cc\u8d62\u5f69\u7968")),
                    array(6,"<span class=\"label label-info\" style=\"cursor:pointer;\" onclick=\"custom_getBalance('1563214170293657','ljn0324')\">ljn0324</span>","16,031.00",unicode_decode("\u8f6c\u8d26"),unicode_decode("\u73a9\u5bb6\u4e3b\u8d26\u6237\u8f6c\u51fa\uff08\u5230\u6e38\u620f\uff09"),"2017-10-12<br>10:57:15","",unicode_decode("\u8f6c\u5165\u53cc\u8d62\u5f69\u7968\uff0c\u4e3b\u8d26\u6237\u4f59\u989d: 0.3000")),
                    array(7,"<span class=\"label label-info\" style=\"cursor:pointer;\" onclick=\"custom_getBalance('1563214170293657','ljn0324')\">ljn0324</span>","16,031.00",unicode_decode("\u8f6c\u8d26"),unicode_decode("\u73a9\u5bb6\u4e3b\u8d26\u6237\u8f6c\u5165\uff08\u4ece\u6e38\u620f\uff09"),"2017-10-12<br>10:57:13","",unicode_decode("\u53cc\u8d62\u5f69\u7968\u8f6c\u51fa\uff0c\u4e3b\u8d26\u6237\u4f59\u989d: 16031.3000")),
                    array(8,"<span class=\"label label-info\" style=\"cursor:pointer;\" onclick=\"custom_getBalance('1563214170293657','ljn0324')\">ljn0324</span>","16,031.00",unicode_decode("\u8f6c\u8d26"),unicode_decode("\u73a9\u5bb6\u8f6c\u51fa\u6e38\u620f"),"2017-10-12<br>10:57:13","",unicode_decode("\u8f6c\u51fa\u53cc\u8d62\u5f69\u7968")),
                    array(9,"<span class=\"label label-info\" style=\"cursor:pointer;\" onclick=\"custom_getBalance('1579885256869415','8686866')\">8686866</span>","502.91",unicode_decode("\u8f6c\u8d26"),unicode_decode("\u73a9\u5bb6\u8f6c\u5165\u6e38\u620f"),"2017-10-12<br>10:53:54","",unicode_decode("\u8f6c\u5165AG")),
                    array(10,"<span class=\"label label-info\" style=\"cursor:pointer;\" onclick=\"custom_getBalance('1579885256869415','8686866')\">8686866</span>","502.91",unicode_decode("\u8f6c\u8d26"),unicode_decode("\u73a9\u5bb6\u4e3b\u8d26\u6237\u8f6c\u51fa\uff08\u5230\u6e38\u620f\uff09"),"2017-10-12<br>10:53:54","",unicode_decode("\u8f6c\u5165AG\uff0c\u4e3b\u8d26\u6237\u4f59\u989d: 0.0000")),
                    array(11,"<span class=\"label label-info\" style=\"cursor:pointer;\" onclick=\"custom_getBalance('1579885256869415','8686866')\">8686866</span>","502.91",unicode_decode("\u8f6c\u8d26"),unicode_decode("\u73a9\u5bb6\u4e3b\u8d26\u6237\u8f6c\u5165\uff08\u4ece\u6e38\u620f\uff09"),"2017-10-12<br>10:53:53","",unicode_decode("\u7533\u535a138\u8f6c\u51fa\uff0c\u4e3b\u8d26\u6237\u4f59\u989d: 502.9100")),
                    array(12,"<span class=\"label label-info\" style=\"cursor:pointer;\" onclick=\"custom_getBalance('1579885256869415','8686866')\">8686866</span>","502.91",unicode_decode("\u8f6c\u8d26"),unicode_decode("\u73a9\u5bb6\u8f6c\u51fa\u6e38\u620f"),"2017-10-12<br>10:53:53","",unicode_decode("\u8f6c\u51fa\u7533\u535a138")),
                    array(13,"<span class=\"label label-info\" style=\"cursor:pointer;\" onclick=\"custom_getBalance('1579885256869415','8686866')\">8686866</span>","502.91",unicode_decode("\u8f6c\u8d26"),unicode_decode("\u73a9\u5bb6\u8f6c\u5165\u6e38\u620f"),"2017-10-12<br>10:53:49","",unicode_decode("\u8f6c\u5165\u7533\u535a138")),
                    array(14,"<span class=\"label label-info\" style=\"cursor:pointer;\" onclick=\"custom_getBalance('1579885256869415','8686866')\">8686866</span>","502.91",unicode_decode("\u8f6c\u8d26"),unicode_decode("\u73a9\u5bb6\u4e3b\u8d26\u6237\u8f6c\u51fa\uff08\u5230\u6e38\u620f\uff09"),"2017-10-12<br>10:53:49","",unicode_decode("\u8f6c\u5165\u7533\u535a138\uff0c\u4e3b\u8d26\u6237\u4f59\u989d: 0.0000")),
                    array(15,"<span class=\"label label-info\" style=\"cursor:pointer;\" onclick=\"custom_getBalance('1579885256869415','8686866')\">8686866</span>","502.91",unicode_decode("\u8f6c\u8d26"),unicode_decode("\u73a9\u5bb6\u4e3b\u8d26\u6237\u8f6c\u5165\uff08\u4ece\u6e38\u620f\uff09"),"2017-10-12<br>10:53:49","",unicode_decode("AG\u8f6c\u51fa\uff0c\u4e3b\u8d26\u6237\u4f59\u989d: 502.9100")),
                    array(16,"<span class=\"label label-info\" style=\"cursor:pointer;\" onclick=\"custom_getBalance('1579885256869415','8686866')\">8686866</span>","502.91",unicode_decode("\u8f6c\u8d26"),unicode_decode("\u73a9\u5bb6\u8f6c\u51fa\u6e38\u620f"),"2017-10-12<br>10:53:49","",unicode_decode("\u8f6c\u51faAG")),
                    array(17,"<span class=\"label label-info\" style=\"cursor:pointer;\" onclick=\"custom_getBalance('1579885256869415','8686866')\">8686866</span>","501.97",unicode_decode("\u8f6c\u8d26"),unicode_decode("\u73a9\u5bb6\u8f6c\u5165\u6e38\u620f"),"2017-10-12<br>10:53:43","",unicode_decode("\u8f6c\u5165AG")),
                    array(18,"<span class=\"label label-info\" style=\"cursor:pointer;\" onclick=\"custom_getBalance('1579885256869415','8686866')\">8686866</span>","501.97",unicode_decode("\u8f6c\u8d26"),unicode_decode("\u73a9\u5bb6\u4e3b\u8d26\u6237\u8f6c\u51fa\uff08\u5230\u6e38\u620f\uff09"),"2017-10-12<br>10:53:43","",unicode_decode("\u8f6c\u5165AG\uff0c\u4e3b\u8d26\u6237\u4f59\u989d: 0.0000")),
                    array(19,"<span class=\"label label-info\" style=\"cursor:pointer;\" onclick=\"custom_getBalance('1579885256869415','8686866')\">8686866</span>","4.97",unicode_decode("\u7ea2\u5229"),unicode_decode("\u73a9\u5bb6\u5b58\u6b3e\u4f18\u60e0\uff08\u5b58\u6b3e\u624b\u7eed\u8d39\uff09"),"2017-10-12<br>10:52:22","li002",unicode_decode("\u73a9\u5bb6\u5b58\u6b3e\uff1a497.00,\u5b9e\u9645\u5230\u8d26\uff1a497.00,\u4f18\u60e0\uff1a4.97")),
                    
                )
                );
        echo json_encode($ret);
    }

    function setGroup(){

    }

    function batchSetGroup(){

    }

    function exportmember(){
        echo makePage(null, "player/exportmember", null);
    }

    function exportexcel(){
        echo "you will download a excel file in 5 seconds. but actually ,the function is not completely yet, so the file downloading is never appear to you.";
    }
}
?>