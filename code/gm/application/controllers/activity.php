<?php  
  
/** 
 * MVC路由功能简单实现 
 * @desc 简单实现MVC路由功能  
 */  
include "./application/utilities/utilities.php";

class Activity  
{  
    function activities()
    {  
        echo makePage("", "activity/activity", "");       
    }  

    function activityAjax(){
        $ret = array("sEcho"=>"1","iTotalRecords"=>"9","iTotalDisplayRecords"=>"9",
        "aaData"=>array(
            array(1,"\u7535\u8bdd\u56de\u8bbf","\u5176\u4ed6","<div  id=\"status_374335100697333760\">\u5df2\u4e0b\u67b6<\/div>","<div style=\"width:150px;word-break:break-all;word-wrap:break-word;\"><\/div>","\u6d4b\u8bd5\u5c42\u7ea7","\u4e0d\u9650","0","2017-08-27 14:34:46","<div class=\"btn-group\"><a class=\"btn btn-xs green\" href=\"#\" data-toggle=\"dropdown\"><i class=\"fa fa-user\"><\/i> \u64cd\u4f5c <i class=\"fa fa-angle-down\"><\/i><\/a><ul class=\"dropdown-menu\"><li><a href=\"\/activity\/editActivity?actid=374335100697333760\" ><i class=\"fa fa-edit\"><\/i> \u7f16\u8f91<\/a><\/li><li><a href=\"#\" onclick=\"changeStatus(this,'374335100697333760',22)\"><i class=\"fa fa-plus\"><\/i> \u4e0a\u67b6 <\/a><\/li><li><a href=\"#\" onclick=\"changeStatus(this,'374335100697333760',25)\"><i class=\"fa fa-trash-o\"><\/i> \u4e0b\u67b6 <\/a><\/li><li><a href=\"#\" onclick=\"changeStatus(this,'374335100697333760',32)\"><i class=\"fa fa-times\"><\/i> \u5220\u9664 <\/a><\/li><\/ul><\/div>"),
            array(2,"\u8bda\u62db\u4ee3\u7406\u5546","\u5176\u4ed6","<div  id=\"status_374336017039511552\">\u5df2\u4e0a\u67b6<\/div>","<div style=\"width:150px;word-break:break-all;word-wrap:break-word;\"><\/div>","\u9ad8\u7ea7\u4f1a\u5458|\u6d4b\u8bd5\u5c42\u7ea7|\u521d\u7ea7\u4f1a\u5458|\u4e2d\u7ea7\u4f1a\u5458|\u6ce8\u518c\u9ed8\u8ba4","\u4e0d\u9650","0","2017-08-27 14:38:24","<div class=\"btn-group\"><a class=\"btn btn-xs green\" href=\"#\" data-toggle=\"dropdown\"><i class=\"fa fa-user\"><\/i> \u64cd\u4f5c <i class=\"fa fa-angle-down\"><\/i><\/a><ul class=\"dropdown-menu\"><li><a href=\"\/activity\/editActivity?actid=374336017039511552\" ><i class=\"fa fa-edit\"><\/i> \u7f16\u8f91<\/a><\/li><li><a href=\"#\" onclick=\"changeStatus(this,'374336017039511552',22)\"><i class=\"fa fa-plus\"><\/i> \u4e0a\u67b6 <\/a><\/li><li><a href=\"#\" onclick=\"changeStatus(this,'374336017039511552',25)\"><i class=\"fa fa-trash-o\"><\/i> \u4e0b\u67b6 <\/a><\/li><li><a href=\"#\" onclick=\"changeStatus(this,'374336017039511552',32)\"><i class=\"fa fa-times\"><\/i> \u5220\u9664 <\/a><\/li><\/ul><\/div>"),
            array(3,"\u6b21\u6b21\u5b58\u6b21\u6b21\u9001","\u5b58\u9001","<div  id=\"status_374340225297965056\">\u5df2\u4e0a\u67b6<\/div>","<div style=\"width:150px;word-break:break-all;word-wrap:break-word;\"><\/div>","\u9ad8\u7ea7\u4f1a\u5458|\u6d4b\u8bd5\u5c42\u7ea7|\u521d\u7ea7\u4f1a\u5458|\u4e2d\u7ea7\u4f1a\u5458|\u6ce8\u518c\u9ed8\u8ba4","\u4e0d\u9650","0","2017-08-27 14:55:08","<div class=\"btn-group\"><a class=\"btn btn-xs green\" href=\"#\" data-toggle=\"dropdown\"><i class=\"fa fa-user\"><\/i> \u64cd\u4f5c <i class=\"fa fa-angle-down\"><\/i><\/a><ul class=\"dropdown-menu\"><li><a href=\"\/activity\/editActivity?actid=374340225297965056\" ><i class=\"fa fa-edit\"><\/i> \u7f16\u8f91<\/a><\/li><li><a href=\"#\" onclick=\"changeStatus(this,'374340225297965056',22)\"><i class=\"fa fa-plus\"><\/i> \u4e0a\u67b6 <\/a><\/li><li><a href=\"#\" onclick=\"changeStatus(this,'374340225297965056',25)\"><i class=\"fa fa-trash-o\"><\/i> \u4e0b\u67b6 <\/a><\/li><li><a href=\"#\" onclick=\"changeStatus(this,'374340225297965056',32)\"><i class=\"fa fa-times\"><\/i> \u5220\u9664 <\/a><\/li><\/ul><\/div>"),
            array(4,"\u5929\u5929\u8fd4\u70b9\u65e0\u4e0a\u9650 ","\u8fd4\u6c34\u9001","<div  id=\"status_374339692424224768\">\u5df2\u4e0a\u67b6<\/div>","<div style=\"width:150px;word-break:break-all;word-wrap:break-word;\"><\/div>","\u9ad8\u7ea7\u4f1a\u5458|\u6d4b\u8bd5\u5c42\u7ea7|\u521d\u7ea7\u4f1a\u5458|\u4e2d\u7ea7\u4f1a\u5458|\u6ce8\u518c\u9ed8\u8ba4","\u4e0d\u9650","0","2017-08-27 14:53:00","<div class=\"btn-group\"><a class=\"btn btn-xs green\" href=\"#\" data-toggle=\"dropdown\"><i class=\"fa fa-user\"><\/i> \u64cd\u4f5c <i class=\"fa fa-angle-down\"><\/i><\/a><ul class=\"dropdown-menu\"><li><a href=\"\/activity\/editActivity?actid=374339692424224768\" ><i class=\"fa fa-edit\"><\/i> \u7f16\u8f91<\/a><\/li><li><a href=\"#\" onclick=\"changeStatus(this,'374339692424224768',22)\"><i class=\"fa fa-plus\"><\/i> \u4e0a\u67b6 <\/a><\/li><li><a href=\"#\" onclick=\"changeStatus(this,'374339692424224768',25)\"><i class=\"fa fa-trash-o\"><\/i> \u4e0b\u67b6 <\/a><\/li><li><a href=\"#\" onclick=\"changeStatus(this,'374339692424224768',32)\"><i class=\"fa fa-times\"><\/i> \u5220\u9664 <\/a><\/li><\/ul><\/div>"),
            array(5,"\u9996\u5b58\u5373\u9001\uff01\u4e13\u5c5e\u4f18\u60e0~","\u5b58\u9001","<div  id=\"status_378395958440255488\">\u5df2\u4e0a\u67b6<\/div>","<div style=\"width:150px;word-break:break-all;word-wrap:break-word;\">ly13800|ly138001|ly138002<\/div>","","1","0","2017-09-07 19:31:10","<div class=\"btn-group\"><a class=\"btn btn-xs green\" href=\"#\" data-toggle=\"dropdown\"><i class=\"fa fa-user\"><\/i> \u64cd\u4f5c <i class=\"fa fa-angle-down\"><\/i><\/a><ul class=\"dropdown-menu\"><li><a href=\"\/activity\/editActivity?actid=378395958440255488\" ><i class=\"fa fa-edit\"><\/i> \u7f16\u8f91<\/a><\/li><li><a href=\"#\" onclick=\"changeStatus(this,'378395958440255488',22)\"><i class=\"fa fa-plus\"><\/i> \u4e0a\u67b6 <\/a><\/li><li><a href=\"#\" onclick=\"changeStatus(this,'378395958440255488',25)\"><i class=\"fa fa-trash-o\"><\/i> \u4e0b\u67b6 <\/a><\/li><li><a href=\"#\" onclick=\"changeStatus(this,'378395958440255488',32)\"><i class=\"fa fa-times\"><\/i> \u5220\u9664 <\/a><\/li><\/ul><\/div>"),
            array(6,"\u767e\u5bb6\u4e50 \u8001K\u9001\u5927\u5956","\u5176\u4ed6","<div  id=\"status_374338615729610752\">\u5df2\u4e0a\u67b6<\/div>","<div style=\"width:150px;word-break:break-all;word-wrap:break-word;\"><\/div>","\u9ad8\u7ea7\u4f1a\u5458|\u6d4b\u8bd5\u5c42\u7ea7|\u521d\u7ea7\u4f1a\u5458|\u4e2d\u7ea7\u4f1a\u5458|\u6ce8\u518c\u9ed8\u8ba4","\u4e0d\u9650","0","2017-08-27 14:48:44","<div class=\"btn-group\"><a class=\"btn btn-xs green\" href=\"#\" data-toggle=\"dropdown\"><i class=\"fa fa-user\"><\/i> \u64cd\u4f5c <i class=\"fa fa-angle-down\"><\/i><\/a><ul class=\"dropdown-menu\"><li><a href=\"\/activity\/editActivity?actid=374338615729610752\" ><i class=\"fa fa-edit\"><\/i> \u7f16\u8f91<\/a><\/li><li><a href=\"#\" onclick=\"changeStatus(this,'374338615729610752',22)\"><i class=\"fa fa-plus\"><\/i> \u4e0a\u67b6 <\/a><\/li><li><a href=\"#\" onclick=\"changeStatus(this,'374338615729610752',25)\"><i class=\"fa fa-trash-o\"><\/i> \u4e0b\u67b6 <\/a><\/li><li><a href=\"#\" onclick=\"changeStatus(this,'374338615729610752',32)\"><i class=\"fa fa-times\"><\/i> \u5220\u9664 <\/a><\/li><\/ul><\/div>"),
            array(7,"\u5929\u5929\u7b7e\u5230","\u5b58\u9001","<div  id=\"status_374334587268390912\">\u5df2\u4e0a\u67b6<\/div>","<div style=\"width:150px;word-break:break-all;word-wrap:break-word;\"><\/div>","\u9ad8\u7ea7\u4f1a\u5458|\u6d4b\u8bd5\u5c42\u7ea7|\u521d\u7ea7\u4f1a\u5458|\u4e2d\u7ea7\u4f1a\u5458|\u6ce8\u518c\u9ed8\u8ba4","\u4e0d\u9650","0","2017-08-27 14:32:43","<div class=\"btn-group\"><a class=\"btn btn-xs green\" href=\"#\" data-toggle=\"dropdown\"><i class=\"fa fa-user\"><\/i> \u64cd\u4f5c <i class=\"fa fa-angle-down\"><\/i><\/a><ul class=\"dropdown-menu\"><li><a href=\"\/activity\/editActivity?actid=374334587268390912\" ><i class=\"fa fa-edit\"><\/i> \u7f16\u8f91<\/a><\/li><li><a href=\"#\" onclick=\"changeStatus(this,'374334587268390912',22)\"><i class=\"fa fa-plus\"><\/i> \u4e0a\u67b6 <\/a><\/li><li><a href=\"#\" onclick=\"changeStatus(this,'374334587268390912',25)\"><i class=\"fa fa-trash-o\"><\/i> \u4e0b\u67b6 <\/a><\/li><li><a href=\"#\" onclick=\"changeStatus(this,'374334587268390912',32)\"><i class=\"fa fa-times\"><\/i> \u5220\u9664 <\/a><\/li><\/ul><\/div>"),
            array(8,"\u52a0\u5165VIP\u4ff1\u4e50\u90e8","\u5b58\u9001","<div  id=\"status_374340639737143296\">\u5df2\u4e0a\u67b6<\/div>","<div style=\"width:150px;word-break:break-all;word-wrap:break-word;\"><\/div>","\u9ad8\u7ea7\u4f1a\u5458|\u6d4b\u8bd5\u5c42\u7ea7|\u521d\u7ea7\u4f1a\u5458|\u4e2d\u7ea7\u4f1a\u5458|\u6ce8\u518c\u9ed8\u8ba4","\u4e0d\u9650","0","2017-08-27 14:56:46","<div class=\"btn-group\"><a class=\"btn btn-xs green\" href=\"#\" data-toggle=\"dropdown\"><i class=\"fa fa-user\"><\/i> \u64cd\u4f5c <i class=\"fa fa-angle-down\"><\/i><\/a><ul class=\"dropdown-menu\"><li><a href=\"\/activity\/editActivity?actid=374340639737143296\" ><i class=\"fa fa-edit\"><\/i> \u7f16\u8f91<\/a><\/li><li><a href=\"#\" onclick=\"changeStatus(this,'374340639737143296',22)\"><i class=\"fa fa-plus\"><\/i> \u4e0a\u67b6 <\/a><\/li><li><a href=\"#\" onclick=\"changeStatus(this,'374340639737143296',25)\"><i class=\"fa fa-trash-o\"><\/i> \u4e0b\u67b6 <\/a><\/li><li><a href=\"#\" onclick=\"changeStatus(this,'374340639737143296',32)\"><i class=\"fa fa-times\"><\/i> \u5220\u9664 <\/a><\/li><\/ul><\/div>"),
            array(9,"\u9996\u5b58\u8d60\u9001100% \u8d85\u503c\u8c6a\u793c\u7b49\u60a8\u62ff","\u5b58\u9001","<div  id=\"status_374339313854734336\">\u5df2\u4e0a\u67b6<\/div>","<div style=\"width:150px;word-break:break-all;word-wrap:break-word;\">defaultagent|taizi168|huoqing|dlha8348|liang168<\/div>","\u9ad8\u7ea7\u4f1a\u5458|\u6d4b\u8bd5\u5c42\u7ea7|\u521d\u7ea7\u4f1a\u5458|\u4e2d\u7ea7\u4f1a\u5458|\u6ce8\u518c\u9ed8\u8ba4","1","0","2017-08-27 14:51:30","<div class=\"btn-group\"><a class=\"btn btn-xs green\" href=\"#\" data-toggle=\"dropdown\"><i class=\"fa fa-user\"><\/i> \u64cd\u4f5c <i class=\"fa fa-angle-down\"><\/i><\/a><ul class=\"dropdown-menu\"><li><a href=\"\/activity\/editActivity?actid=374339313854734336\" ><i class=\"fa fa-edit\"><\/i> \u7f16\u8f91<\/a><\/li><li><a href=\"#\" onclick=\"changeStatus(this,'374339313854734336',22)\"><i class=\"fa fa-plus\"><\/i> \u4e0a\u67b6 <\/a><\/li><li><a href=\"#\" onclick=\"changeStatus(this,'374339313854734336',25)\"><i class=\"fa fa-trash-o\"><\/i> \u4e0b\u67b6 <\/a><\/li><li><a href=\"#\" onclick=\"changeStatus(this,'374339313854734336',32)\"><i class=\"fa fa-times\"><\/i> \u5220\u9664 <\/a><\/li><\/ul><\/div>"))
    );
        echo json_encode($ret);
    }

    function actCateList(){
        echo makePage("", "activity/actCateList", ""); 
    }

    function activityVerify(){
        echo makePage("", "activity/activityVerify", "activityVerify_footer"); 
    }

    function activityVerifyAjax(){
        $ret = array("sEcho"=>"1","iTotalRecords"=>"0","iTotalDisplayRecords"=>"0","aaData"=>array()
        );
        echo json_encode($ret );
    }
    function activityHistory(){
        echo makePage("", "activity/activityHistory", "activityHistory_footer"); 
    }

    function activityHistoryAjax(){
        $ret = array(
            "sEcho"=>"1","iTotalRecords"=>"154","iTotalDisplayRecords"=>"154",
            "aaData"=>array(array(1,"zhangsong19","\u5f20\u677e\u677e","ly13800","\u9996\u5b58\u5373\u9001\uff01\u4e13\u5c5e\u4f18\u60e0~","2017-10-12 15:27:17","\u901a\u8fc7<br>\u9996\u5b58\u5f69\u91d1\uff0c\u5b58\u6b3e200\u5143\uff0c\u8d60\u900118\u5143","\u5b58\u6b3e\u91d1\u989d\uff1a200.00<br>\u7ea2\u5229\u91d1\u989d\uff1a18.00<br>\u53d6\u6b3e\u6d41\u6c34\uff1a\u7ea2\u5229\uff1a+18.00,\u53d6\u6b3e\u6d41\u6c34\uff1a+1544.00"),array(2,"jin0614","\u8d56\u91d1\u6c34","defaultagent","\u9996\u5b58\u8d60\u9001100% \u8d85\u503c\u8c6a\u793c\u7b49\u60a8\u62ff","2017-10-12 15:21:24","\u62d2\u7edd<br>\u4e0d\u7b26\u5408\u4f18\u60e0\u6761\u4ef6","\u5b58\u6b3e\u91d1\u989d\uff1a0.00<br>\u7ea2\u5229\u91d1\u989d\uff1a0.00<br>\u53d6\u6b3e\u6d41\u6c34\uff1a"),array(3,"gtl1314","\u5173\u6cf0\u9f99","huoqing","\u5929\u5929\u7b7e\u5230","2017-10-12 07:41:56","\u62d2\u7edd<br>\u7533\u8bf7\u4f18\u60e0\u671f\u5df2\u7ed3\u675f","\u5b58\u6b3e\u91d1\u989d\uff1a0.00<br>\u7ea2\u5229\u91d1\u989d\uff1a0.00<br>\u53d6\u6b3e\u6d41\u6c34\uff1a"),array(4,"jimmy4848","\u6f58\u6cfd\u6c49","ly13800","\u5929\u5929\u7b7e\u5230","2017-10-12 00:20:43","\u62d2\u7edd<br>\u4f1a\u5458\u903e\u671f\u7533\u8bf7\u4f18\u60e0","\u5b58\u6b3e\u91d1\u989d\uff1a0.00<br>\u7ea2\u5229\u91d1\u989d\uff1a0.00<br>\u53d6\u6b3e\u6d41\u6c34\uff1a"),array(5,"934897994","\u9ec4\u51ef","ly13800","\u5929\u5929\u7b7e\u5230","2017-10-09 17:33:14","\u62d2\u7edd<br>\u672a\u8fbe\u5230\u6d3b\u52a8\u8981\u6c42","\u5b58\u6b3e\u91d1\u989d\uff1a0.00<br>\u7ea2\u5229\u91d1\u989d\uff1a0.00<br>\u53d6\u6b3e\u6d41\u6c34\uff1a"),array(6,"llikllik","\u8d75\u8d35\u6625","defaultagent","\u9996\u5b58\u8d60\u9001100% \u8d85\u503c\u8c6a\u793c\u7b49\u60a8\u62ff","2017-10-09 15:19:20","\u62d2\u7edd<br>\u5ba2\u670d\u62d2\u7edd-\u6d4b\u8bd5","\u5b58\u6b3e\u91d1\u989d\uff1a0.00<br>\u7ea2\u5229\u91d1\u989d\uff1a0.00<br>\u53d6\u6b3e\u6d41\u6c34\uff1a"),array(7,"taizi","\u803f\u5f6c","ly13800","\u5929\u5929\u7b7e\u5230","2017-10-08 18:26:12","\u62d2\u7edd<br>\u672a\u8fbe\u5230\u6d3b\u52a8\u6761\u4ef6~","\u5b58\u6b3e\u91d1\u989d\uff1a0.00<br>\u7ea2\u5229\u91d1\u989d\uff1a0.00<br>\u53d6\u6b3e\u6d41\u6c34\uff1a"),array(8,"15998729905","\u968f\u5b8f\u7965","ly13800","\u9996\u5b58\u5373\u9001\uff01\u4e13\u5c5e\u4f18\u60e0~","2017-10-07 17:29:57","\u62d2\u7edd<br>\u4e0d\u7b26\u5408\u6d3b\u52a8\u8981\u6c42","\u5b58\u6b3e\u91d1\u989d\uff1a0.00<br>\u7ea2\u5229\u91d1\u989d\uff1a0.00<br>\u53d6\u6b3e\u6d41\u6c34\uff1a"),array(9,"15998729905","\u968f\u5b8f\u7965","ly13800","\u5929\u5929\u7b7e\u5230","2017-10-07 17:29:26","\u62d2\u7edd<br>\u672a\u8fbe\u5230\u6d3b\u52a8\u8981\u6c42","\u5b58\u6b3e\u91d1\u989d\uff1a0.00<br>\u7ea2\u5229\u91d1\u989d\uff1a0.00<br>\u53d6\u6b3e\u6d41\u6c34\uff1a"),array(10,"jijingtai","\u5d47\u666f\u6cf0","defaultagent","\u9996\u5b58\u8d60\u9001100% \u8d85\u503c\u8c6a\u793c\u7b49\u60a8\u62ff","2017-10-07 17:26:23","\u901a\u8fc7<br>\u9996\u5b58\u4f18\u60e0\u5f69\u91d1100\u5143\uff0c\u5b58\u6b3e\u91d1\u989d100\u5143\uff0c\u6240\u9700\u7684\u6253\u7801\u91cf\u4e3a6000\u5143\u3002","\u5b58\u6b3e\u91d1\u989d\uff1a100.00<br>\u7ea2\u5229\u91d1\u989d\uff1a100.00<br>\u53d6\u6b3e\u6d41\u6c34\uff1a\u7ea2\u5229\uff1a+100.00,\u53d6\u6b3e\u6d41\u6c34\uff1a+5900.00"),array(11,"zhaishasha","\u7fdf\u4e39\u838e","defaultagent","\u9996\u5b58\u8d60\u9001100% \u8d85\u503c\u8c6a\u793c\u7b49\u60a8\u62ff","2017-10-07 09:44:48","\u901a\u8fc7<br>\u9996\u5b58\u4f18\u60e0\u5f69\u91d1100\u5143\uff0c\u5b58\u6b3e\u91d1\u989d100\u5143\uff0c\u6240\u9700\u7684\u6253\u7801\u91cf\u4e3a6000\u5143\u3002","\u5b58\u6b3e\u91d1\u989d\uff1a0.00<br>\u7ea2\u5229\u91d1\u989d\uff1a100.00<br>\u53d6\u6b3e\u6d41\u6c34\uff1a\u7ea2\u5229\uff1a+100.00,\u53d6\u6b3e\u6d41\u6c34\uff1a+6000.00"),array(12,"zhaishasha","\u7fdf\u4e39\u838e","defaultagent","\u5929\u5929\u7b7e\u5230","2017-10-07 09:44:35","\u62d2\u7edd<br>\u672a\u8fbe\u5230\u4f18\u60e0\u6761\u4ef6","\u5b58\u6b3e\u91d1\u989d\uff1a0.00<br>\u7ea2\u5229\u91d1\u989d\uff1a0.00<br>\u53d6\u6b3e\u6d41\u6c34\uff1a"),array(13,"8686866","\u7389\u82cf\u752b\u6c5f\u00b7\u6258\u5408\u63d0","dscheng","\u52a0\u5165VIP\u4ff1\u4e50\u90e8","2017-10-06 21:34:42","\u62d2\u7edd<br>\u672a\u8fbe\u5230\u6d3b\u52a8\u8981\u6c42~","\u5b58\u6b3e\u91d1\u989d\uff1a0.00<br>\u7ea2\u5229\u91d1\u989d\uff1a0.00<br>\u53d6\u6b3e\u6d41\u6c34\uff1a"),array(14,"8686866","\u7389\u82cf\u752b\u6c5f\u00b7\u6258\u5408\u63d0","dscheng","\u5929\u5929\u7b7e\u5230","2017-10-06 21:33:41","\u62d2\u7edd<br>\u672a\u8fbe\u5230\u4f18\u60e0\u6d3b\u52a8\u8981\u6c42~","\u5b58\u6b3e\u91d1\u989d\uff1a0.00<br>\u7ea2\u5229\u91d1\u989d\uff1a0.00<br>\u53d6\u6b3e\u6d41\u6c34\uff1a"),array(15,"x56860","\u8c22\u5b9d\u6c49","ly13800","\u5929\u5929\u7b7e\u5230","2017-10-06 18:37:04","\u62d2\u7edd<br>\u672a\u8fbe\u5230\u6d3b\u52a8\u4f18\u60e0\u6761\u4ef6~","\u5b58\u6b3e\u91d1\u989d\uff1a0.00<br>\u7ea2\u5229\u91d1\u989d\uff1a0.00<br>\u53d6\u6b3e\u6d41\u6c34\uff1a"),array(16,"liuhaijun","\u5218\u6d77\u519b","defaultagent","\u9996\u5b58\u8d60\u9001100% \u8d85\u503c\u8c6a\u793c\u7b49\u60a8\u62ff","2017-10-06 17:29:38","\u901a\u8fc7<br>\u9996\u5b58\u4f18\u60e0\u5f69\u91d1100\u5143\uff0c\u5b58\u6b3e\u91d1\u989d100\u5143\uff0c\u6240\u9700\u7684\u6253\u7801\u91cf\u4e3a6000\u5143\u3002","\u5b58\u6b3e\u91d1\u989d\uff1a100.00<br>\u7ea2\u5229\u91d1\u989d\uff1a100.00<br>\u53d6\u6b3e\u6d41\u6c34\uff1a\u7ea2\u5229\uff1a+100.00,\u53d6\u6b3e\u6d41\u6c34\uff1a+5900.00"),array(17,"baoying667","\u859b\u5b9d\u6cc9","defaultagent","\u9996\u5b58\u8d60\u9001100% \u8d85\u503c\u8c6a\u793c\u7b49\u60a8\u62ff","2017-10-06 17:02:35","\u901a\u8fc7<br>\u9996\u5b58\u4f18\u60e0\u5f69\u91d1100\u5143\uff0c\u5b58\u6b3e\u91d1\u989d100\u5143\uff0c\u6240\u9700\u7684\u6253\u7801\u91cf\u4e3a6000\u5143\u3002","\u5b58\u6b3e\u91d1\u989d\uff1a100.00<br>\u7ea2\u5229\u91d1\u989d\uff1a100.00<br>\u53d6\u6b3e\u6d41\u6c34\uff1a\u7ea2\u5229\uff1a+100.00,\u53d6\u6b3e\u6d41\u6c34\uff1a+5900.00"),array(18,"liu520728","\u5218\u6cfd\u7eac","taizi168","\u9996\u5b58\u8d60\u9001100% \u8d85\u503c\u8c6a\u793c\u7b49\u60a8\u62ff","2017-10-04 04:24:50","\u62d2\u7edd<br>\u4f1a\u5458\u4e0d\u7b26\u4f18\u60e0\u6d3b\u52a8\u6761\u4ef6","\u5b58\u6b3e\u91d1\u989d\uff1a0.00<br>\u7ea2\u5229\u91d1\u989d\uff1a0.00<br>\u53d6\u6b3e\u6d41\u6c34\uff1a"),array(19,"liu520728","\u5218\u6cfd\u7eac","taizi168","\u5929\u5929\u7b7e\u5230","2017-10-04 04:24:30","\u62d2\u7edd<br>\u4f1a\u5458\u4e0d\u7b26\u4f18\u60e0\u6761\u4ef6","\u5b58\u6b3e\u91d1\u989d\uff1a0.00<br>\u7ea2\u5229\u91d1\u989d\uff1a0.00<br>\u53d6\u6b3e\u6d41\u6c34\uff1a"),array(20,"1341566168","\u5f20\u6811\u5f3a","ly13800","\u5929\u5929\u7b7e\u5230","2017-10-03 18:56:34","\u62d2\u7edd<br>\u672a\u8fbe\u5230\u6d3b\u52a8\u8981\u6c42~","\u5b58\u6b3e\u91d1\u989d\uff1a0.00<br>\u7ea2\u5229\u91d1\u989d\uff1a0.00<br>\u53d6\u6b3e\u6d41\u6c34\uff1a"))
        );
        echo json_encode($ret);
    }

    function activityFund(){
        echo makePage("", "activity/activityFund", "activityFund_footer"); 
    }

    function activityFundAjax(){
        $ret = array(
            "sEcho"=>"1","iTotalRecords"=>"9","iTotalDisplayRecords"=>"9","aaData"=>array(array("<a href=\"\/activity\/activityHistory?actid=378395958440255488\">\u9996\u5b58\u5373\u9001\uff01\u4e13\u5c5e\u4f18\u60e0~<\/a>","4","4","0","72.00","\u5df2\u4e0a\u67b6","2017-09-07 19:31:10"),array("<a href=\"\/activity\/activityHistory?actid=374340639737143296\">\u52a0\u5165VIP\u4ff1\u4e50\u90e8<\/a>","0","0","0","0.00","\u5df2\u4e0a\u67b6","2017-08-27 14:56:46"),array("<a href=\"\/activity\/activityHistory?actid=374340225297965056\">\u6b21\u6b21\u5b58\u6b21\u6b21\u9001<\/a>","0","0","0","0.00","\u5df2\u4e0a\u67b6","2017-08-27 14:55:08"),array("<a href=\"\/activity\/activityHistory?actid=374339692424224768\">\u5929\u5929\u8fd4\u70b9\u65e0\u4e0a\u9650 <\/a>","0","0","0","0.00","\u5df2\u4e0a\u67b6","2017-08-27 14:53:00"),array("<a href=\"\/activity\/activityHistory?actid=374339313854734336\">\u9996\u5b58\u8d60\u9001100% \u8d85\u503c\u8c6a\u793c\u7b49\u60a8\u62ff<\/a>","18","18","0","1800.00","\u5df2\u4e0a\u67b6","2017-08-27 14:51:30"),array("<a href=\"\/activity\/activityHistory?actid=374338615729610752\">\u767e\u5bb6\u4e50 \u8001K\u9001\u5927\u5956<\/a>","0","0","0","0.00","\u5df2\u4e0a\u67b6","2017-08-27 14:48:44"),array("<a href=\"\/activity\/activityHistory?actid=374336017039511552\">\u8bda\u62db\u4ee3\u7406\u5546<\/a>","0","0","0","0.00","\u5df2\u4e0a\u67b6","2017-08-27 14:38:24"),array("<a href=\"\/activity\/activityHistory?actid=374335100697333760\">\u7535\u8bdd\u56de\u8bbf<\/a>","0","0","0","0.00","\u5df2\u4e0b\u67b6","2017-08-27 14:34:46"),array("<a href=\"\/activity\/activityHistory?actid=374334587268390912\">\u5929\u5929\u7b7e\u5230<\/a>","27","28","0","900.00","\u5df2\u4e0a\u67b6","2017-08-27 14:32:43"))
        );
        echo json_encode($ret);
    }


}  
  
  
?>  