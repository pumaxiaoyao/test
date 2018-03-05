<?php  
  
/** 
 * MVC路由功能简单实现 
 * @desc 简单实现MVC路由功能  
 */  
registerDataHelper(array("protoHelper", "dataHelper"));
registerViewHelper(array("GmViewHelper", "flow/flowViewHelper"));
registerCtrlHelper(array("flow/flowTrait"));

/**
 * 流水功能API
 */
class Flow
{
    use FlowTrait;
    
    /**
     * 流水
     *
     * @return void
     */
    static function wagered()
    {  
        showWagered(__CLASS__);     
    }  

    // function grant(){
    //     // ShowGrant(__CLASS__);     
    // }

    /**
     * 获取返水历史
     *
     * @return void
     */
    function history()
    {
        ShowHistory(__CLASS__);     
    }


    // function grantAjax(){
    //     $ret = array("count"=>"20","proc"=>"60","date"=>"2017-10-12 13:00:44","max"=>"60","pect"=>"100");
    //     echo json_encode($ret);
    // }


    // function getRakeBackHistory(){
    //     $ret = array("sEcho"=>"1",
    //     "iTotalRecords"=>"598","iTotalDisplayRecords"=>"598",
    //     "aaData"=>array(array("20171011","<span class=\"label label-info\">chen1996<\/span>","\u9648\u709c","\u6ce8\u518c\u9ed8\u8ba4","ly13800","\u53cc\u8d62\u5f69\u7968","108","2130.0000","2499.0000","4.26","\u5df2\u7ed3\u7b97"),
    //     array("20171011","<span class=\"label label-info\">li5324658<\/span>","\u674e\u4ece\u6587","\u6ce8\u518c\u9ed8\u8ba4","ly13800","\u53cc\u8d62\u5f69\u7968","96","680.0000","715.4000","1.36","\u5df2\u7ed3\u7b97"),array("20171011","<span class=\"label label-info\">3206713320a<\/span>","\u949f\u660c\u6797","\u6ce8\u518c\u9ed8\u8ba4","ly13800","\u53cc\u8d62\u5f69\u7968","125","864.0000","666.4000","1.73","\u5df2\u7ed3\u7b97"),array("20171011","<span class=\"label label-info\">13612793002<\/span>","\u6797\u52a0\u8d24","\u6ce8\u518c\u9ed8\u8ba4","ly13800","\u53cc\u8d62\u5f69\u7968","171","953.0000","754.6000","1.91","\u5df2\u7ed3\u7b97"),array("20171011","<span class=\"label label-info\">q914432380<\/span>","\u95fb\u5fb7\u8c6a","\u6ce8\u518c\u9ed8\u8ba4","ly13800","\u53cc\u8d62\u5f69\u7968","113","288.0000","362.6000","0.58","\u5df2\u7ed3\u7b97"),array("20171011","<span class=\"label label-info\">wifi<\/span>","\u9ec4\u8fdc\u950b","\u6ce8\u518c\u9ed8\u8ba4","ly13800","\u53cc\u8d62\u5f69\u7968","131","3090.0000","2744.0000","6.18","\u5df2\u7ed3\u7b97"),array("20171011","<span class=\"label label-info\">wzh222<\/span>","\u738b\u667a\u8f89","\u6ce8\u518c\u9ed8\u8ba4","ly13800","\u53cc\u8d62\u5f69\u7968","5","5.0000","9.8000","0.01","\u5df2\u7ed3\u7b97"),array("20171011","<span class=\"label label-info\">kkkk02<\/span>","\u9648\u5b50\u743c","\u6ce8\u518c\u9ed8\u8ba4","ly13800","\u53cc\u8d62\u5f69\u7968","422","12476.0000","13976.8000","24.95","\u5df2\u7ed3\u7b97"),array("20171011","<span class=\"label label-info\">zzj116630<\/span>","\u90d1\u5fe0\u5c06","\u6ce8\u518c\u9ed8\u8ba4","ly13800","\u53cc\u8d62\u5f69\u7968","19","298.0000","137.6000","0.60","\u5df2\u7ed3\u7b97"),array("20171011","<span class=\"label label-info\">chenjinta<\/span>","\u9648\u91d1\u5854","\u6ce8\u518c\u9ed8\u8ba4","ly13800","\u53cc\u8d62\u5f69\u7968","535","8820.0000","9634.8000","17.64","\u5df2\u7ed3\u7b97"),array("20171011","<span class=\"label label-info\">ngf218<\/span>","\u5b81\u521a\u950b","\u6ce8\u518c\u9ed8\u8ba4","ly13800","\u53cc\u8d62\u5f69\u7968","157","1003.0000","874.6100","2.01","\u5df2\u7ed3\u7b97"),array("20171011","<span class=\"label label-info\">firsthjw<\/span>","\u4f55\u5251\u4f1f","\u6ce8\u518c\u9ed8\u8ba4","taizi168","\u6c99\u5df4\u4f53\u80b2","5","7082.0000","1991.0000","35.41","\u5df2\u7ed3\u7b97"),array("20171011","<span class=\"label label-info\">a251377305<\/span>","\u5f20\u5e05","\u6ce8\u518c\u9ed8\u8ba4","ly13800","\u53cc\u8d62\u5f69\u7968","5","5.0000","0.0000","0.01","\u5df2\u7ed3\u7b97"),array("20171011","<span class=\"label label-info\">hawking<\/span>","\u859b\u6210\u519b","\u6ce8\u518c\u9ed8\u8ba4","ly13800","\u53cc\u8d62\u5f69\u7968","16","135.0000","147.0000","0.27","\u5df2\u7ed3\u7b97"),array("20171011","<span class=\"label label-info\">liu80523<\/span>","\u5218\u8d35\u661f","\u4e0d\u9001\u8fd4\u6c34\u4f18\u60e0","taizi168","\u6c99\u5df4\u4f53\u80b2","1","100.0000","0.0000","0.00","\u5df2\u7ed3\u7b97"),array("20171011","<span class=\"label label-info\">kkkk01<\/span>","\u6f58\u57f9\u5065","\u6ce8\u518c\u9ed8\u8ba4","ly13800","\u53cc\u8d62\u5f69\u7968","17","29.0000","19.6000","0.06","\u5df2\u7ed3\u7b97"),array("20171011","<span class=\"label label-info\">1743<\/span>","\u674e\u8f89","\u6ce8\u518c\u9ed8\u8ba4","ly13800","\u53cc\u8d62\u5f69\u7968","231","392.0000","480.2000","0.78","\u5df2\u7ed3\u7b97"),array("20171011","<span class=\"label label-info\">kk258<\/span>","\u5434\u5c0f\u7fe0","\u521d\u7ea7\u4f1a\u5458","dscheng","\u53cc\u8d62\u5f69\u7968","2","5298.0000","0.0000","10.60","\u5df2\u7ed3\u7b97"),array("20171011","<span class=\"label label-info\">wu0826<\/span>","\u6797\u5148\u82d7","\u521d\u7ea7\u4f1a\u5458","dscheng","\u53cc\u8d62\u5f69\u7968","3","5311.0000","0.0000","10.62","\u5df2\u7ed3\u7b97"),array("20171011","<span class=\"label label-info\">l1688<\/span>",
    //     "\u6797\u8273","\u521d\u7ea7\u4f1a\u5458","dscheng","\u53cc\u8d62\u5f69\u7968","26","21795.0000","19168.3800","43.59","\u5df2\u7ed3\u7b97")));
    //     echo json_encode($ret);

    // }
}  
  
  
?>  